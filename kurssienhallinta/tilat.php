<?php
require_once 'db.php';
$pdo = getPDO();
$tilat = $pdo->query("SELECT tila_id, tila_nimi, paikkoja FROM tilat ORDER BY tila_nimi")->fetchAll();
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title>Tilat</title>
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

    <a class="back" href="index.php">← Takaisin</a>
    <h1 class="page-title">Tilat</h1>

    <div class="card table-wrap">
      <table>
        <thead>
          <tr>
            <th>Tila</th>
            <th>Kapasiteetti</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$tilat): ?>
            <tr><td colspan="2" class="muted">Ei tiloja.</td></tr>
          <?php else: ?>
            <?php foreach($tilat as $t): ?>
            <tr>
              <td>
                <a href="tila.php?id=<?= (int)$t['tila_id'] ?>">
                  <?= htmlspecialchars($t['tila_nimi']) ?>
                </a>
              </td>
              <td><?= htmlspecialchars($t['paikkoja']) ?> paikkaa</td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
