<?php
require_once 'db.php';

function finDate($date) {
    if (!$date) return '';
    return date("d.m.Y", strtotime($date));
}

$pdo = getPDO();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Kurssi-id puuttuu.');
}
$kurssi_id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT k.*, o.etunimi AS op_etunimi, o.sukunimi AS op_sukunimi, 
    t.tila_nimi, t.paikkoja
    FROM kurssit k
    JOIN opettajat o ON k.opettaja_id = o.opettaja_id
    JOIN tilat t ON k.tila_id = t.tila_id
    WHERE k.kurssi_id = ?");
$stmt->execute([$kurssi_id]);
$kurssi = $stmt->fetch();
if (!$kurssi) die('Kurssia ei löytynyt.');

$stmt = $pdo->prepare("SELECT i.ilmoittautuminen_id, o.oppilas_id, o.etunimi, o.sukunimi, i.ilmoittautumispaiva
    FROM ilmoittautuminen i
    JOIN oppilaat o ON i.opiskelija_id = o.oppilas_id
    WHERE i.kurssi_id = ?
    ORDER BY i.ilmoittautumispaiva ASC");
$stmt->execute([$kurssi_id]);
$ilmo = $stmt->fetchAll();

$osallistujia = count($ilmo);
$cap = (int)$kurssi['paikkoja'];
$over = $osallistujia > $cap;

$opp = $pdo->query("SELECT oppilas_id, etunimi, sukunimi FROM oppilaat ORDER BY sukunimi")->fetchAll();

$week = isset($_GET['week']) ? (int)$_GET['week'] : date("W");
$year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");

$dt = new DateTime();
$dt->setISODate($year, $week);
$weekStart = $dt->format("Y-m-d");

$dt->modify("+6 days");
$weekEnd = $dt->format("Y-m-d");

$sql = "
SELECT *
FROM nakyma_kurssin_aikataulu
WHERE kurssi_id = ?
AND aloituspaiva <= ?
AND lopetuspaiva >= ?
ORDER BY FIELD(viikonpaiva,'Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai'), alkuaika
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$kurssi_id, $weekEnd, $weekStart]);
$sessiot = $stmt->fetchAll();

$paivat = ["Maanantai","Tiistai","Keskiviikko","Torstai","Perjantai"];
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($kurssi['kurssi_nimi']) ?></title>
  <link rel="stylesheet" href="styles.css">

<style>
.calendar-grid {
    display: grid;
    grid-template-columns: 80px repeat(5, 1fr);
    border: 1px solid #ccc;
    margin-top: 25px;
    background: #fff;
    color: #007cb5ff;
}
.time-cell {
    border-bottom: 1px solid #eee;
    height: 60px;
    padding: 4px;
    font-size: 12px;
    color: #007cb5ff;
}
.day-column {
    position: relative;
    border-left: 1px solid #ddd;
    border-bottom: 1px solid #eee;
}
.session-box {
    position: absolute;
    left: 4%;
    width: 92%;
    background: #d7e3ff;
    border: 1px solid #6a93ff;
    border-radius: 6px;
    padding: 4px;
    box-sizing: border-box;
    font-size: 13px;
    overflow: hidden;
}
.session-box:hover {
    background: #c7d7ff;
}
.session-title {
    font-weight: bold;
    color: #fbbf24;
}
.session-room {
    font-size: 11px;
    color: #007cb5ff;
}
.warn {
    border: 2px solid #ff4d4d;
    background: #ffe8e8;
}

.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 180px;
    background-color: #444;
    color: #fff;
    text-align: center;
    padding: 6px;
    border-radius: 6px;
    position: absolute;
    z-index: 10;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity .25s ease;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

</style>

</head>
<body>
  <div class="container">
    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php">Hallinta</a>
    </div>

    <a class="back" href="index.php">← Takaisin</a>
    <h1 class="page-title"><?= htmlspecialchars($kurssi['kurssi_nimi']) ?></h1>

    <div class="card">
      <div class="meta">
        <div><strong>Tunnus:</strong> <?= htmlspecialchars($kurssi['kurssin_tunnus']) ?></div>
        <div><strong>Opettaja:</strong> <?= htmlspecialchars($kurssi['op_etunimi'].' '.$kurssi['op_sukunimi']) ?></div>
        <div><strong>Tila:</strong> <?= htmlspecialchars($kurssi['tila_nimi']) ?></div>
        <div><strong>Kapasiteetti:</strong> <?= $cap ?> paikkaa</div>
        <div><strong>Ajanjakso:</strong> <?= finDate($kurssi['aloituspaiva']) ?> — <?= finDate($kurssi['lopetuspaiva']) ?></div>
      </div>
    </div>

    <?php if (!empty($kurssi['kurssikuvaus'])): ?>
      <h2 style="margin:22px 0 10px">Kurssikuvaus</h2>
      <div class="card">
        <p><?= nl2br(htmlspecialchars($kurssi['kurssikuvaus'])) ?></p>
      </div>
    <?php endif; ?>

    <h2 style="margin:22px 0 10px">
      Ilmoittautuneet (<?= $osallistujia ?> / <?= $cap ?>)
      <?php if ($over): ?>
    <span class="tooltip" style="color:red; font-weight:bold; margin-left:6px; cursor:help;">
        ⚠️ Tilaa ei riitä!
        <span class="tooltiptext">Osallistujia on enemmän kuin tilassa on paikkoja.</span>
    </span>
<?php endif; ?>

    </h2>

    <div class="card table-wrap <?= $over ? 'warn' : '' ?>">
      <?php if (count($ilmo) === 0): ?>
        <p class="muted">Ei ilmoittautuneita.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Oppilas</th>
              <th>Ilmoittautunut</th>
              <th>Toiminnot</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($ilmo as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['etunimi'].' '.$r['sukunimi']) ?></td>
              <td><?= finDate($r['ilmoittautumispaiva']) ?></td>
              <td>
                <form method="post" action="poista_ilmo.php" style="display:inline">
                  <input type="hidden" name="id" value="<?= $r['ilmoittautuminen_id'] ?>">
                  <button class="btn btn-danger" type="submit" onclick="return confirm('Poistetaanko ilmoittautuminen?')">Poista</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <h3 style="margin:22px 0 10px">Lisää ilmoittautuminen</h3>
    <div class="card">
      <form method="post" action="ilmoittaudu.php">
        <input type="hidden" name="kurssi_id" value="<?= $kurssi_id ?>">
        <label>Oppilas:
          <select name="oppilas_id" required>
            <option value="">-- valitse --</option>
            <?php foreach($opp as $o): ?>
            <option value="<?= $o['oppilas_id'] ?>"><?= htmlspecialchars($o['etunimi'].' '.$o['sukunimi']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <button class="btn" type="submit">Ilmoittaudu</button>
      </form>
    </div>


<h2 style="margin-top:40px;">Kurssin viikkokalenteri</h2>

<p>
  <a href="kurssi.php?id=<?= $kurssi_id ?>&week=<?= $week-1 ?>&year=<?= $year ?>">← Edellinen viikko</a>
   |
  <a href="kurssi.php?id=<?= $kurssi_id ?>&week=<?= $week+1 ?>&year=<?= $year ?>">Seuraava viikko →</a>
</p>

<p>Viikko <?= $week ?> (<?= finDate($weekStart) ?> – <?= finDate($weekEnd) ?>)</p>

<div class="calendar-grid">

    <?php
    $startHour = 8;
    $endHour = 17;
    ?>

    <div></div>

    <?php foreach ($paivat as $pv): ?>
        <div style="text-align:center; padding:5px; font-weight:bold; border-bottom:1px solid #ccc;">
            <?= $pv ?>
        </div>
    <?php endforeach; ?>

    <?php for ($h = $startHour; $h <= $endHour; $h++): ?>
        <div class="time-cell"><?= sprintf("%02d:00", $h) ?></div>
        <?php foreach ($paivat as $pv): ?>
            <div class="day-column" data-day="<?= $pv ?>"></div>
        <?php endforeach; ?>
    <?php endfor; ?>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const cellHeight = 60;
    const startHour = <?= $startHour ?>;

    const sessions = <?= json_encode($sessiot, JSON_UNESCAPED_UNICODE) ?>;

    const byDay = {};
    sessions.forEach(s => {
        if (!byDay[s.viikonpaiva]) byDay[s.viikonpaiva] = [];
        byDay[s.viikonpaiva].push(s);
    });

    Object.keys(byDay).forEach(day => {
        let daySessions = byDay[day];

        daySessions = daySessions.map(s => {
            const [sh, sm] = (s.alkuaika || "00:00").split(":").map(Number);
            const [eh, em] = (s.loppuaika || "00:00").split(":").map(Number);
            return Object.assign({}, s, {
                start: (sh || 0) * 60 + (sm || 0),
                end: (eh || 0) * 60 + (em || 0)
            });
        });

        daySessions.sort((a, b) => a.start - b.start);

        const lanes = [];

        daySessions.forEach(s => {
            let placed = false;

            for (let i = 0; i < lanes.length; i++) {
                const last = lanes[i][lanes[i].length - 1];
                if (last.end <= s.start) {
                    lanes[i].push(s);
                    s.lane = i;
                    placed = true;
                    break;
                }
            }

            if (!placed) {
                s.lane = lanes.length;
                lanes.push([s]);
            }
        });

        const totalLanes = Math.max(1, lanes.length);

        const column = document.querySelector('.day-column[data-day="' + day + '"]');
        if (!column) return;

        daySessions.forEach(s => {
            let start = s.start;
            let end = s.end;
            if (end <= start) end = start + 30;

            const top = ((start - startHour * 60) / 60) * cellHeight;
            const height = Math.max(20, ((end - start) / 60) * cellHeight);

            const width = 100 / totalLanes;
            const left = width * (s.lane || 0);

            let box = document.createElement("div");
            box.className = "session-box";
            box.style.cursor = "pointer";
            box.onclick = () => {window.location.href = "kurssi.php?id=" + s.kurssi_id;};
            box.style.top = top + "px";
            box.style.height = height + "px";
            box.style.width = `calc(${width}% - 6px)`;
            box.style.left = `calc(${left}% + 3px)`;
            box.style.zIndex = 100 + (s.lane || 0);

            box.innerHTML = `
                <div class="session-title"><?= htmlspecialchars($kurssi['kurssi_nimi']) ?></div>
                <div>${(s.alkuaika||'').substring(0,5)}–${(s.loppuaika||'').substring(0,5)}</div>
                <div class="session-room">${escapeHtml(s.tila_nimi || '')}</div>
            `;

            column.appendChild(box);
        });
    });

    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
</script>

  </div>
</body>
</html>
