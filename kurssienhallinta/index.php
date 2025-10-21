<?php
require_once 'db.php';

$pdo = getPDO();
$stmt = $pdo->query("SELECT k.kurssi_id, k.kurssin_tunnus, k.kurssi_nimi, k.aloituspaiva, k.lopetuspaiva, o.etunimi AS op_etunimi, o.sukunimi AS op_sukunimi, t.tila_nimi
    FROM kurssit k
    JOIN opettajat o ON k.opettaja_id = o.opettaja_id
    JOIN tilat t ON k.tila_id = t.tila_id
    ORDER BY k.aloituspaiva ASC");
$kurssit = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title>Kurssien hallinta</title>
  <style>body{font-family:Arial;max-width:900px;margin:20px auto} table{width:100%;border-collapse:collapse} th,td{padding:8px;border:1px solid #ddd}</style>
</head>
<body>
  <h1>Kurssit</h1>
  <p><a href="oppilaat.php">Oppilaat</a> | <a href="opettajat.php">Opettajat</a> | <a href="tilat.php">Tilat</a></p>

  <table>
    <thead>
      <tr><th>Tunnus</th><th>Nimi</th><th>Opettaja</th><th>Tila</th><th>Alkaa</th><th>Loppuu</th><th>Toiminnot</th></tr>
    </thead>
    <tbody>
      <?php foreach($kurssit as $k): ?>
      <tr>
        <td><?=htmlspecialchars($k['kurssin_tunnus'])?></td>
        <td><?=htmlspecialchars($k['kurssi_nimi'])?></td>
        <td><?=htmlspecialchars($k['op_etunimi'] . ' ' . $k['op_sukunimi'])?></td>
        <td><?=htmlspecialchars($k['tila_nimi'] ?? $k['tila_nimi'])?></td>
        <td><?=htmlspecialchars($k['aloituspaiva'])?></td>
        <td><?=htmlspecialchars($k['lopetuspaiva'])?></td>
        <td><a href="kurssi.php?id=<?= $k['kurssi_id'] ?>">Näytä</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
