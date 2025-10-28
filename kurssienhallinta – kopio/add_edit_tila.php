<?php
require_once 'db.php';
$pdo = getPDO();

$tila = [
  'tila_id' => null,
  'tila_nimi' => '',
  'paikkoja' => ''
];

if (isset($_GET['id'])) {
  $stmt = $pdo->prepare("SELECT * FROM tilat WHERE tila_id=?");
  $stmt->execute([$_GET['id']]);
  $tila = $stmt->fetch() ?: $tila;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $data = [$_POST['tila_nimi'], $_POST['paikkoja']];
  if (!empty($_POST['tila_id'])) {
    $data[] = $_POST['tila_id'];
    $stmt = $pdo->prepare("UPDATE tilat SET tila_nimi=?, paikkoja=? WHERE tila_id=?");
  } else {
    $stmt = $pdo->prepare("INSERT INTO tilat (tila_nimi, paikkoja) VALUES (?,?)");
  }
  $stmt->execute($data);
  header("Location: tilat.php");
  exit;
}
?>
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title>Tila</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<a href="tilat.php" class="btn btn-secondary mb-3">← Takaisin</a>
<h1><?= $tila['tila_id'] ? 'Muokkaa tilaa' : 'Lisää tila' ?></h1>
<form method="post">
  <input type="hidden" name="tila_id" value="<?= htmlspecialchars($tila['tila_id']) ?>">
  <div class="mb-3">
    <label class="form-label">Tilan nimi</label>
    <input type="text" name="tila_nimi" class="form-control" value="<?= htmlspecialchars($tila['tila_nimi']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Kapasiteetti (paikkoja)</label>
    <input type="number" name="paikkoja" class="form-control" value="<?= htmlspecialchars($tila['paikkoja']) ?>" required>
  </div>
  <button class="btn btn-primary">Tallenna</button>
</form>
</body></html>
