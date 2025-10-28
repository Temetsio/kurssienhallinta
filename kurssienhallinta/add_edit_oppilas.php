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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= $oppilas['oppilas_id'] ? 'Muokkaa oppilasta' : 'Lisää oppilas' ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php">Admin</a>
    </div>

    <a href="oppilaat.php" class="back">← Takaisin</a>
    <h1 class="page-title">
      <?= $oppilas['oppilas_id'] ? 'Muokkaa oppilasta' : 'Lisää uusi oppilas' ?>
    </h1>

    <form method="post" class="card form">
      <input type="hidden" name="oppilas_id" value="<?= htmlspecialchars($oppilas['oppilas_id']) ?>">

      <label>Etunimi
        <input type="text" name="etunimi" value="<?= htmlspecialchars($oppilas['etunimi']) ?>" required>
      </label>

      <label>Sukunimi
        <input type="text" name="sukunimi" value="<?= htmlspecialchars($oppilas['sukunimi']) ?>" required>
      </label>

      <label>Syntymäaika
        <input type="date" name="syntymaaika" value="<?= htmlspecialchars($oppilas['syntymaaika']) ?>" required>
      </label>

      <label>Vuosikurssi
        <input type="number" name="vuosikurssi" min="1" max="3" value="<?= htmlspecialchars($oppilas['vuosikurssi']) ?>" required>
      </label>

      <button class="button">💾 Tallenna</button>
    </form>
  </div>
</body>
</html>
