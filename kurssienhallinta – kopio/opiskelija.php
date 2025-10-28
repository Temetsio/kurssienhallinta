<?php
require_once 'db.php';
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
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($student['sukunimi'].' '.$student['etunimi']) ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
    </div>

    <a class="back" href="oppilaat.php">← Takaisin</a>
    <h1 class="page-title"><?= htmlspecialchars($student['sukunimi'].' '.$student['etunimi']) ?></h1>

    <div class="card">
      <div class="meta">
        <div><strong>Syntymäaika:</strong> <span class="badge"><?= htmlspecialchars($student['syntymaaika']) ?></span></div>
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
              <td><?= htmlspecialchars($k['aloituspaiva']) ?></td>
              <td><?= htmlspecialchars(trim(($k['op_etunimi']??'').' '.($k['op_sukunimi']??''))) ?: '—' ?></td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
