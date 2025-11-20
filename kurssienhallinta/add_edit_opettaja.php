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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= $opettaja['opettaja_id'] ? 'Muokkaa opettajaa' : 'Lisää opettaja' ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php">Hallinta</a>
    </div>

    <a href="opettajat.php" class="back">← Takaisin</a>
    <h1 class="page-title">
      <?= $opettaja['opettaja_id'] ? 'Muokkaa opettajaa' : 'Lisää uusi opettaja' ?>
    </h1>

    <form method="post" class="card form">
      <input type="hidden" name="opettaja_id" value="<?= htmlspecialchars($opettaja['opettaja_id']) ?>">

      <label>Etunimi
        <input type="text" name="etunimi" value="<?= htmlspecialchars($opettaja['etunimi']) ?>" required>
      </label>

      <label>Sukunimi
        <input type="text" name="sukunimi" value="<?= htmlspecialchars($opettaja['sukunimi']) ?>" required>
      </label>

      <label>Aine
        <input type="text" name="aine" value="<?= htmlspecialchars($opettaja['aine']) ?>" required>
      </label>

      <button class="button">💾 Tallenna</button>
    </form>
  </div>
</body>
</html>
