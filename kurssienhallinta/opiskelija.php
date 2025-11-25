<?php
require_once 'db.php';

function finDate($date) {
    if (!$date) return '';
    return date("d.m.Y", strtotime($date));
}

$pdo = getPDO();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  header('Location: oppilaat.php'); exit;
}
$oppilas_id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT oppilas_id, etunimi, sukunimi, syntymaaika, vuosikurssi FROM oppilaat WHERE oppilas_id=?");
$stmt->execute([$oppilas_id]);
$student = $stmt->fetch();
if (!$student) die('Opiskelijaa ei löytynyt.');

$sql = "
  SELECT k.kurssi_id, k.kurssi_nimi, k.aloituspaiva,
         o.etunimi AS op_etunimi, o.sukunimi AS op_sukunimi
  FROM ilmoittautuminen i
  JOIN kurssit k ON k.kurssi_id=i.kurssi_id
  LEFT JOIN opettajat o ON o.opettaja_id=k.opettaja_id
  WHERE i.opiskelija_id=?
  ORDER BY k.aloituspaiva
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$oppilas_id]);
$kurssit = $stmt->fetchAll();

$week = isset($_GET['week']) ? (int)$_GET['week'] : date("W");
$year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");

$dt = new DateTime();
$dt->setISODate($year, $week);
$weekStart = $dt->format("Y-m-d");

$dt->modify("+6 days");
$weekEnd = $dt->format("Y-m-d");

$sql = "
SELECT *
FROM nakyma_opiskelijan_aikataulu
WHERE opiskelija_id = ?
AND aloituspaiva <= ?
AND lopetuspaiva >= ?
ORDER BY FIELD(viikonpaiva,'Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai'), alkuaika
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$oppilas_id, $weekEnd, $weekStart]);
$sessiot = $stmt->fetchAll();

$paivat = ["Maanantai","Tiistai","Keskiviikko","Torstai","Perjantai"];
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($student['sukunimi'].' '.$student['etunimi']) ?></title>
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
    cursor: pointer;
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

  <a class="back" href="oppilaat.php">← Takaisin</a>
  <h1 class="page-title"><?= htmlspecialchars($student['sukunimi'].' '.$student['etunimi']) ?></h1>

  <div class="card">
    <div class="meta">
      <div><strong>Syntymäaika:</strong> <span class="badge"><?= finDate($student['syntymaaika']) ?></span></div>
      <div><strong>Vuosikurssi:</strong> <span class="badge"><?= htmlspecialchars($student['vuosikurssi']) ?></span></div>
    </div>
  </div>

  <h2 style="margin:22px 0 10px">Opiskelijan kurssit</h2>
  <div class="card table-wrap">
    <table>
      <thead><tr><th>Kurssi</th><th>Aloituspäivä</th><th>Opettaja</th></tr></thead>
      <tbody>
        <?php if (!$kurssit): ?>
          <tr><td colspan="3" class="muted">Ei kursseja.</td></tr>
        <?php else: foreach($kurssit as $k): ?>
          <tr>
            <td><a href="kurssi.php?id=<?= (int)$k['kurssi_id'] ?>"><?= htmlspecialchars($k['kurssi_nimi']) ?></a></td>
            <td><?= finDate($k['aloituspaiva']) ?></td>
            <td><?= htmlspecialchars(trim(($k['op_etunimi']??'').' '.($k['op_sukunimi']??''))) ?: '—' ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>


<h2 style="margin-top:40px;">Viikkokalenteri</h2>

<p>
  <a href="opiskelija.php?id=<?= $oppilas_id ?>&week=<?= $week-1 ?>&year=<?= $year ?>">← Edellinen viikko</a>
  |
  <a href="opiskelija.php?id=<?= $oppilas_id ?>&week=<?= $week+1 ?>&year=<?= $year ?>">Seuraava viikko →</a>
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
                start: (isFinite(sh) ? sh : 0) * 60 + (isFinite(sm) ? sm : 0),
                end: (isFinite(eh) ? eh : 0) * 60 + (isFinite(em) ? em : 0)
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
            if (end <= start) {
                end = start + 30;
            }

            const top = ((start - startHour * 60) / 60) * cellHeight;
            const height = Math.max(20, ((end - start) / 60) * cellHeight);

            const width = 100 / totalLanes;
            const left = width * (s.lane || 0);

            let box = document.createElement("div");
            box.className = "session-box";

            box.onclick = () => {
                if (s.kurssi_id) {
                    window.location.href = "kurssi.php?id=" + s.kurssi_id;
                }
            };

            box.style.top = top + "px";
            box.style.height = height + "px";
            box.style.width = `calc(${width}% - 6px)`;
            box.style.left = `calc(${left}% + 3px)`;
            box.style.zIndex = 100 + (s.lane || 0);

            box.innerHTML = `
                <div class="session-title">${escapeHtml(s.kurssi_nimi)}</div>
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
