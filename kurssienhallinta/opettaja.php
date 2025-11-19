<?php
require_once 'db.php';
$pdo = getPDO();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  header('Location: opettajat.php'); exit;
}
$opettaja_id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT opettaja_id, etunimi, sukunimi, aine FROM opettajat WHERE opettaja_id=?");
$stmt->execute([$opettaja_id]);
$op = $stmt->fetch();
if (!$op) die('Opettajaa ei löytynyt.');

$sql = "
  SELECT k.kurssi_id, k.kurssi_nimi, k.aloituspaiva, k.lopetuspaiva, t.tila_nimi
  FROM kurssit k
  LEFT JOIN tilat t ON t.tila_id=k.tila_id
  WHERE k.opettaja_id=?
  ORDER BY k.aloituspaiva
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$opettaja_id]);
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
FROM nakyma_opettajan_aikataulu
WHERE opettaja_id = ?
AND aloituspaiva <= ?
AND lopetuspaiva >= ?
ORDER BY FIELD(viikonpaiva,'Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai'), alkuaika
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$opettaja_id, $weekEnd, $weekStart]);
$sessiot = $stmt->fetchAll();

$paivat = ["Maanantai","Tiistai","Keskiviikko","Torstai","Perjantai"];
$kalenteri = [];
foreach ($paivat as $pv) $kalenteri[$pv] = [];

foreach ($sessiot as $s) {
    $kalenteri[$s['viikonpaiva']][] = $s;
}

?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($op['sukunimi'].' '.$op['etunimi']) ?></title>
  <link rel="stylesheet" href="styles.css">
  <style>
.calendar-grid {
    display: grid;
    grid-template-columns: 80px repeat(5, 1fr);
    border: 1px solid #ccc;
    margin-top: 25px;
    background: #fff;
}

.time-cell {
    border-bottom: 1px solid #eee;
    height: 60px;
    padding: 4px;
    font-size: 12px;
    color: #666;
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
}

.session-room {
    font-size: 11px;
    color: #555;
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
      <a href="admin.php">Admin</a>
    </div>

    <a class="back" href="opettajat.php">← Takaisin</a>
    <h1 class="page-title"><?= htmlspecialchars($op['sukunimi'].' '.$op['etunimi']) ?></h1>

    <div class="card">
      <div class="meta">
        <div><strong>Aine:</strong> <span class="badge"><?= htmlspecialchars($op['aine']) ?></span></div>
      </div>
    </div>

    <h2 style="margin:22px 0 10px">Opettajan kurssit</h2>
    <div class="card table-wrap">
      <table>
        <thead><tr><th>Kurssi</th><th>Alku</th><th>Loppu</th><th>Tila</th></tr></thead>
        <tbody>
          <?php if (!$kurssit): ?>
            <tr><td colspan="4" class="muted">Ei kursseja.</td></tr>
          <?php else: foreach($kurssit as $k): ?>
            <tr>
              <td><a href="kurssi.php?id=<?= (int)$k['kurssi_id'] ?>"><?= htmlspecialchars($k['kurssi_nimi']) ?></a></td>
              <td><?= htmlspecialchars($k['aloituspaiva']) ?></td>
              <td><?= htmlspecialchars($k['lopetuspaiva']) ?></td>
              <td><?= htmlspecialchars($k['tila_nimi'] ?? '—') ?></td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
<h2 style="margin-top:40px;">Viikkokalenteri</h2>

<p>
    <a href="opettaja.php?id=<?= $opettaja_id ?>&week=<?= $week-1 ?>&year=<?= $year ?>">← Edellinen viikko</a>
    |
    <a href="opettaja.php?id=<?= $opettaja_id ?>&week=<?= $week+1 ?>&year=<?= $year ?>">Seuraava viikko →</a>
</p>

<p>Viikko <?= $week ?> (<?= $weekStart ?> – <?= $weekEnd ?>)</p>

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
            const [sh, sm] = s.alkuaika.split(":").map(Number);
            const [eh, em] = s.loppuaika.split(":").map(Number);
            s.start = sh * 60 + sm;
            s.end = eh * 60 + em;
            return s;
        });

        daySessions.sort((a, b) => a.start - b.start);

        const lanes = [];

        daySessions.forEach(s => {
            let placed = false;

            for (let i = 0; i < lanes; i++) {
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

        const totalLanes = lanes.length;

        const column = document.querySelector('.day-column[data-day="' + day + '"]');

        daySessions.forEach(s => {
            const top = ((s.start - startHour * 60) / 60) * cellHeight;
            const height = ((s.end - s.start) / 60) * cellHeight;

            const width = 100 / totalLanes;
            const left = width * s.lane;

            let div = document.createElement("a");
            div.href = "kurssi.php?id=" + s.kurssi_id;
            div.className = "session-box";
            div.style.top = top + "px";
            div.style.height = height + "px";
            div.style.width = `calc(${width}% - 6px)`;
            div.style.left = `calc(${left}% + 3px)`;

            div.innerHTML = `
                <div class="session-title">${s.kurssi_nimi}</div>
                <div>${s.alkuaika.substring(0,5)}–${s.loppuaika.substring(0,5)}</div>
                <div class="session-room">${s.tila_nimi}</div>
            `;

            column.appendChild(div);
        });
    });
});
</script>

  </div>
</body>
</html>
