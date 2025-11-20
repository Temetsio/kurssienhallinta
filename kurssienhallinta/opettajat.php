<?php
require_once 'db.php';
$pdo = getPDO();
$op = $pdo->query("SELECT opettaja_id, etunimi, sukunimi, aine FROM opettajat ORDER BY sukunimi")->fetchAll();
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title>Opettajat</title>
  <link rel="stylesheet" href="styles.css">
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
    <h1 class="page-title">Opettajat</h1>

    <div class="card table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nimi</th>
            <th>Aine</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$op): ?>
            <tr><td colspan="2" class="muted">Ei opettajia.</td></tr>
          <?php else: ?>
            <?php foreach($op as $o): ?>
            <tr>
              <td>
                <a href="opettaja.php?id=<?= (int)$o['opettaja_id'] ?>">
                  <?= htmlspecialchars($o['etunimi'].' '.$o['sukunimi']) ?>
                </a>
              </td>
              <td><?= htmlspecialchars($o['aine']) ?></td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
