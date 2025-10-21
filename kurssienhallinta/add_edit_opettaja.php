<?php
require_once 'db.php';
$pdo = getPDO();

$opettaja = [
  'opettaja_id' => null,
  'etunimi' => '',
  'sukunimi' => '',
  'aine' => ''
];

if (isset($_GET['id'])) {
  $stmt = $pdo->prepare("SELECT * FROM opettajat WHERE opettaja_id=?");
  $stmt->execute([$_GET['id']]);
  $opettaja = $stmt->fetch() ?: $opettaja;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $data = [$_POST['etunimi'], $_POST['sukunimi'], $_POST['aine']];
  if (!empty($_POST['opettaja_id'])) {
    $data[] = $_POST['opettaja_id'];
    $stmt = $pdo->prepare("UPDATE opettajat SET etunimi=?, sukunimi=?, aine=? WHERE opettaja_id=?");
  } else {
    $stmt = $pdo->prepare("INSERT INTO opettajat (etunimi, sukunimi, aine) VALUES (?,?,?)");
  }
  $stmt->execute($data);
  header("Location: opettajat.php");
  exit;
}
?>
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title>Opettaja</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<a href="opettajat.php" class="btn btn-secondary mb-3">← Takaisin</a>
<h1><?= $opettaja['opettaja_id'] ? 'Muokkaa opettajaa' : 'Lisää opettaja' ?></h1>
<form method="post">
  <input type="hidden" name="opettaja_id" value="<?= htmlspecialchars($opettaja['opettaja_id']) ?>">
  <div class="mb-3">
    <label class="form-label">Etunimi</label>
    <input type="text" name="etunimi" class="form-control" value="<?= htmlspecialchars($opettaja['etunimi']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Sukunimi</label>
    <input type="text" name="sukunimi" class="form-control" value="<?= htmlspecialchars($opettaja['sukunimi']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Aine</label>
    <input type="text" name="aine" class="form-control" value="<?= htmlspecialchars($opettaja['aine']) ?>" required>
  </div>
  <button class="btn btn-primary">Tallenna</button>
</form>
</body></html>
