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
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($op['sukunimi'].' '.$op['etunimi']) ?></title>
  <link rel="stylesheet" href="styles.css">
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
  </div>
</body>
</html>
