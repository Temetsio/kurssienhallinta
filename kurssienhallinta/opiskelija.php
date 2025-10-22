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
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title><?=htmlspecialchars($student['sukunimi'].' '.$student['etunimi'])?></title>
<style>body{font-family:Arial;max-width:900px;margin:20px auto}table{width:100%;border-collapse:collapse}th,td{padding:8px;border:1px solid #ddd}</style></head>
<body>
  <a href="oppilaat.php">← Takaisin</a>
  <h1><?=htmlspecialchars($student['sukunimi'].' '.$student['etunimi'])?></h1>
  <p><strong>Syntymäaika:</strong> <?=htmlspecialchars($student['syntymaaika'])?><br>
     <strong>Vuosikurssi:</strong> <?=htmlspecialchars($student['vuosikurssi'])?></p>

  <h2>Opiskelijan kurssit</h2>
  <table>
    <thead><tr><th>Kurssi</th><th>Aloituspäivä</th><th>Opettaja</th></tr></thead>
    <tbody>
      <?php if (!$kurssit): ?><tr><td colspan="3">Ei kursseja.</td></tr>
      <?php else: foreach($kurssit as $k): ?>
        <tr>
          <td><a href="kurssi.php?id=<?= (int)$k['kurssi_id'] ?>"><?=htmlspecialchars($k['kurssi_nimi'])?></a></td>
          <td><?=htmlspecialchars($k['aloituspaiva'])?></td>
          <td><?=htmlspecialchars(trim(($k['op_etunimi']??'').' '.($k['op_sukunimi']??''))) ?: '—'?></td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</body></html>
