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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= $tila['tila_id'] ? 'Muokkaa tilaa' : 'Lisää tila' ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php" class="active">Tilat</a>
      <a href="admin.php">Admin</a>
    </div>

    <a href="tilat.php" class="back">← Takaisin</a>
    <h1 class="page-title">
      <?= $tila['tila_id'] ? 'Muokkaa tilaa' : 'Lisää uusi tila' ?>
    </h1>

    <form method="post" class="card form">
      <input type="hidden" name="tila_id" value="<?= htmlspecialchars($tila['tila_id']) ?>">

      <label>Tilan nimi
        <input type="text" name="tila_nimi" value="<?= htmlspecialchars($tila['tila_nimi']) ?>" required>
      </label>

      <label>Kapasiteetti (paikkoja)
        <input type="number" name="paikkoja" value="<?= htmlspecialchars($tila['paikkoja']) ?>" required>
      </label>

      <button class="button">💾 Tallenna</button>
    </form>
  </div>
</body>
</html>
