<?php
require_once 'db.php';
$pdo = getPDO();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  header('Location: tilat.php'); exit;
}
$tila_id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT tila_id, tila_nimi, paikkoja FROM tilat WHERE tila_id=?");
$stmt->execute([$tila_id]);
$tila = $stmt->fetch();
if(!$tila) die('Tilaa ei löytynyt.');

$sql = "
  SELECT k.kurssi_id, k.kurssi_nimi, k.aloituspaiva, k.lopetuspaiva,
         CONCAT(o.etunimi,' ',o.sukunimi) AS opettaja_nimi,
         COUNT(i.opiskelija_id) AS osallistujia
  FROM kurssit k
  LEFT JOIN opettajat o ON o.opettaja_id=k.opettaja_id
  LEFT JOIN ilmoittautuminen i ON i.kurssi_id=k.kurssi_id
  WHERE k.tila_id=?
  GROUP BY k.kurssi_id, opettaja_nimi, k.aloituspaiva, k.lopetuspaiva, k.kurssi_nimi
  ORDER BY k.aloituspaiva
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$tila_id]);
$kurssit = $stmt->fetchAll();

$cap = (int)$tila['paikkoja'];
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($tila['tila_nimi']) ?></title>
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

    <a class="back" href="tilat.php">← Takaisin</a>
    <h1 class="page-title"><?= htmlspecialchars($tila['tila_nimi']) ?></h1>

    <div class="card">
      <div class="meta">
        <div><strong>Kapasiteetti:</strong> <span class="badge"><?= $cap ?> paikkaa</span></div>
      </div>
    </div>

    <h2 style="margin:22px 0 10px">Tilassa pidettävät kurssit</h2>
    <div class="card table-wrap">
      <table>
        <thead><tr><th>Kurssi</th><th>Opettaja</th><th>Alku</th><th>Loppu</th><th>Osallistujia</th><th></th></tr></thead>
        <tbody>
          <?php if (!$kurssit): ?>
            <tr><td colspan="6" class="muted">Ei kursseja.</td></tr>
          <?php else: foreach($kurssit as $k): $over = (int)$k['osallistujia'] > $cap; ?>
            <tr class="<?= $over ? 'warn' : '' ?>">
              <td><a href="kurssi.php?id=<?= (int)$k['kurssi_id'] ?>"><?= htmlspecialchars($k['kurssi_nimi']) ?></a></td>
              <td><?= htmlspecialchars($k['opettaja_nimi'] ?? '—') ?></td>
              <td><?= htmlspecialchars($k['aloituspaiva']) ?></td>
              <td><?= htmlspecialchars($k['lopetuspaiva']) ?></td>
              <td><?= (int)$k['osallistujia'] ?> / <?= $cap ?></td>
              <td><?= $over ? '<span class="badge">⚠️</span>' : '' ?></td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
