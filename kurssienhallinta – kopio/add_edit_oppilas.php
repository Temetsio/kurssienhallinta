<?php
require_once 'db.php';
$pdo = getPDO();

$oppilas = [
  'oppilas_id' => null,
  'etunimi' => '',
  'sukunimi' => '',
  'syntymaaika' => '',
  'vuosikurssi' => ''
];

if (isset($_GET['id'])) {
  $stmt = $pdo->prepare("SELECT * FROM oppilaat WHERE oppilas_id=?");
  $stmt->execute([$_GET['id']]);
  $oppilas = $stmt->fetch() ?: $oppilas;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $data = [$_POST['etunimi'], $_POST['sukunimi'], $_POST['syntymaaika'], $_POST['vuosikurssi']];
  if (!empty($_POST['oppilas_id'])) {
    $data[] = $_POST['oppilas_id'];
    $stmt = $pdo->prepare("UPDATE oppilaat SET etunimi=?, sukunimi=?, syntymaaika=?, vuosikurssi=? WHERE oppilas_id=?");
  } else {
    $stmt = $pdo->prepare("INSERT INTO oppilaat (etunimi, sukunimi, syntymaaika, vuosikurssi) VALUES (?,?,?,?)");
  }
  $stmt->execute($data);
  header("Location: oppilaat.php");
  exit;
}
?>
<!doctype html><html lang="fi"><head><meta charset="utf-8">
<title>Oppilas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<a href="oppilaat.php" class="btn btn-secondary mb-3">← Takaisin</a>
<h1><?= $oppilas['oppilas_id'] ? 'Muokkaa oppilasta' : 'Lisää oppilas' ?></h1>
<form method="post">
  <input type="hidden" name="oppilas_id" value="<?= htmlspecialchars($oppilas['oppilas_id']) ?>">
  <div class="mb-3">
    <label class="form-label">Etunimi</label>
    <input type="text" name="etunimi" class="form-control" value="<?= htmlspecialchars($oppilas['etunimi']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Sukunimi</label>
    <input type="text" name="sukunimi" class="form-control" value="<?= htmlspecialchars($oppilas['sukunimi']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Syntymäaika</label>
    <input type="date" name="syntymaaika" class="form-control" value="<?= htmlspecialchars($oppilas['syntymaaika']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Vuosikurssi</label>
    <input type="number" name="vuosikurssi" min="1" max="3" class="form-control" value="<?= htmlspecialchars($oppilas['vuosikurssi']) ?>" required>
  </div>
  <button class="btn btn-primary">Tallenna</button>
</form>
</body></html>
