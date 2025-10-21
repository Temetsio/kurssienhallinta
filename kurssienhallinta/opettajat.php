<?php
require_once 'db.php';
$pdo = getPDO();
$op = $pdo->query("SELECT opettaja_id, etunimi, sukunimi, aine FROM opettajat ORDER BY sukunimi")->fetchAll();
?>
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title>Opettajat</title></head><body>
  <a href="index.php">← Kurssit</a><h1>Opettajat</h1>
  <ul>
  <?php foreach($op as $o): ?>
    <li><?=htmlspecialchars($o['etunimi'].' '.$o['sukunimi'].' — '.$o['aine'])?></li>
  <?php endforeach; ?>
  </ul>
</body></html>
