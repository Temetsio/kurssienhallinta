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
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title><?=htmlspecialchars($op['sukunimi'].' '.$op['etunimi'])?></title>
<style>body{font-family:Arial;max-width:900px;margin:20px auto}table{width:100%;border-collapse:collapse}th,td{padding:8px;border:1px solid #ddd}</style></head>
<body>
  <a href="opettajat.php">← Takaisin</a>
  <h1><?=htmlspecialchars($op['sukunimi'].' '.$op['etunimi'])?></h1>
  <p><strong>Aine:</strong> <?=htmlspecialchars($op['aine'])?></p>

  <h2>Opettajan kurssit</h2>
  <table>
    <thead><tr><th>Kurssi</th><th>Alku</th><th>Loppu</th><th>Tila</th></tr></thead>
    <tbody>
      <?php if (!$kurssit): ?><tr><td colspan="4">Ei kursseja.</td></tr>
      <?php else: foreach($kurssit as $k): ?>
        <tr>
          <td><a href="kurssi.php?id=<?= (int)$k['kurssi_id'] ?>"><?=htmlspecialchars($k['kurssi_nimi'])?></a></td>
          <td><?=htmlspecialchars($k['aloituspaiva'])?></td>
          <td><?=htmlspecialchars($k['lopetuspaiva'])?></td>
          <td><?=htmlspecialchars($k['tila_nimi'] ?? '—')?></td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</body></html>
