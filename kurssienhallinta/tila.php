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
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title><?=htmlspecialchars($tila['tila_nimi'])?></title>
<style>
  body{font-family:Arial;max-width:900px;margin:20px auto}
  table{width:100%;border-collapse:collapse}
  th,td{padding:8px;border:1px solid #ddd}
  .warn{background:#fff3cd}
  .badge{display:inline-block;padding:2px 6px;border-radius:4px;background:#ffe08a}
</style></head>
<body>
  <a href="tilat.php">← Takaisin</a>
  <h1><?=htmlspecialchars($tila['tila_nimi'])?></h1>
  <p><strong>Kapasiteetti:</strong> <?=$cap?></p>

  <h2>Tilassa pidettävät kurssit</h2>
  <table>
    <thead><tr><th>Kurssi</th><th>Opettaja</th><th>Alku</th><th>Loppu</th><th>Osallistujia</th><th></th></tr></thead>
    <tbody>
      <?php if (!$kurssit): ?><tr><td colspan="6">Ei kursseja.</td></tr>
      <?php else: foreach($kurssit as $k): $over = (int)$k['osallistujia'] > $cap; ?>
        <tr class="<?= $over ? 'warn' : '' ?>">
          <td><a href="kurssi.php?id=<?= (int)$k['kurssi_id'] ?>"><?=htmlspecialchars($k['kurssi_nimi'])?></a></td>
          <td><?=htmlspecialchars($k['opettaja_nimi'] ?? '—')?></td>
          <td><?=htmlspecialchars($k['aloituspaiva'])?></td>
          <td><?=htmlspecialchars($k['lopetuspaiva'])?></td>
          <td><?= (int)$k['osallistujia'] ?> / <?=$cap?></td>
          <td><?= $over ? '<span class="badge">⚠️</span>' : '' ?></td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</body></html>