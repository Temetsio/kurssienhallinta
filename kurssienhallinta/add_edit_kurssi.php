<?php
require_once 'db.php';
$pdo = getPDO();

$opettajat = $pdo->query("SELECT opettaja_id, etunimi, sukunimi FROM opettajat ORDER BY sukunimi")->fetchAll();
$tilat = $pdo->query("SELECT tila_id, tila_nimi FROM tilat ORDER BY tila_nimi")->fetchAll();

$kurssi = [
  'kurssi_id' => null,
  'kurssin_tunnus' => '',
  'kurssi_nimi' => '',
  'kurssikuvaus' => '',
  'aloituspaiva' => '',
  'lopetuspaiva' => '',
  'opettaja_id' => '',
  'tila_id' => ''
];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $stmt = $pdo->prepare("SELECT * FROM kurssit WHERE kurssi_id = ?");
  $stmt->execute([$_GET['id']]);
  $kurssi = $stmt->fetch() ?: $kurssi;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    $_POST['kurssin_tunnus'],
    $_POST['kurssi_nimi'],
    $_POST['kurssikuvaus'],
    $_POST['aloituspaiva'],
    $_POST['lopetuspaiva'],
    $_POST['opettaja_id'],
    $_POST['tila_id']
  ];
  if (!empty($_POST['kurssi_id'])) {
    $data[] = $_POST['kurssi_id'];
    $stmt = $pdo->prepare("UPDATE kurssit SET kurssin_tunnus=?, kurssi_nimi=?, kurssikuvaus=?, aloituspaiva=?, lopetuspaiva=?, opettaja_id=?, tila_id=? WHERE kurssi_id=?");
  } else {
    $stmt = $pdo->prepare("INSERT INTO kurssit (kurssin_tunnus, kurssi_nimi, kurssikuvaus, aloituspaiva, lopetuspaiva, opettaja_id, tila_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
  }
  $stmt->execute($data);
  header("Location: index.php");
  exit;
}
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= $kurssi['kurssi_id'] ? 'Muokkaa kurssia' : 'Lisää kurssi' ?></title>
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

    <a class="back" href="index.php">← Takaisin</a>
    <h1 class="page-title">
      <?= $kurssi['kurssi_id'] ? 'Muokkaa kurssia' : 'Lisää uusi kurssi' ?>
    </h1>

    <form method="post" class="card form">
      <input type="hidden" name="kurssi_id" value="<?= htmlspecialchars($kurssi['kurssi_id']) ?>">

      <label>Kurssin tunnus
        <input type="text" name="kurssin_tunnus" value="<?= htmlspecialchars($kurssi['kurssin_tunnus']) ?>" required>
      </label>

      <label>Kurssin nimi
        <input type="text" name="kurssi_nimi" value="<?= htmlspecialchars($kurssi['kurssi_nimi']) ?>" required>
      </label>

      <label>Kuvaus
        <textarea name="kurssikuvaus" rows="4"><?= htmlspecialchars($kurssi['kurssikuvaus']) ?></textarea>
      </label>

      <div class="form-row">
        <label>Alkaa
          <input type="date" name="aloituspaiva" value="<?= htmlspecialchars($kurssi['aloituspaiva']) ?>" required>
        </label>

        <label>Loppuu
          <input type="date" name="lopetuspaiva" value="<?= htmlspecialchars($kurssi['lopetuspaiva']) ?>" required>
        </label>
      </div>

      <label>Opettaja
        <select name="opettaja_id" required>
          <option value="">-- Valitse opettaja --</option>
          <?php foreach ($opettajat as $o): ?>
            <option value="<?= $o['opettaja_id'] ?>" <?= $kurssi['opettaja_id']==$o['opettaja_id']?'selected':'' ?>>
              <?= htmlspecialchars($o['etunimi'].' '.$o['sukunimi']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>

      <label>Tila
        <select name="tila_id" required>
          <option value="">-- Valitse tila --</option>
          <?php foreach ($tilat as $t): ?>
            <option value="<?= $t['tila_id'] ?>" <?= $kurssi['tila_id']==$t['tila_id']?'selected':'' ?>>
              <?= htmlspecialchars($t['tila_nimi']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>

      <button class="button">💾 Tallenna</button>
    </form>
  </div>
</body>
</html>
