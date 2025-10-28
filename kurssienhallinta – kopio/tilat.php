<?php
require_once 'db.php';
$pdo = getPDO();
$tilat = $pdo->query("SELECT tila_id, tila_nimi, paikkoja FROM tilat ORDER BY tila_nimi")->fetchAll();
?>
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title>Tilat</title></head><body>
  <a href="index.php">← Kurssit</a><h1>Tilat</h1>
  <ul>
  <?php foreach($tilat as $t): ?>
      <li>
        <a href="tila.php?id=<?= (int)$t['tila_id'] ?>">
          <?= htmlspecialchars($t['tila_nimi']) ?>
        </a>
        — <?= htmlspecialchars($t['paikkoja']) ?> paikkaa
      </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>