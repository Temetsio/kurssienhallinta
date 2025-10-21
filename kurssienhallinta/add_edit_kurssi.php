<?php
require_once 'db.php';
$pdo = getPDO();

$opettajat = $pdo->query("SELECT opettaja_id, etunimi, sukunimi FROM opettajat ORDER BY sukunimi")->fetchAll();
$tilat = $pdo->query("SELECT tila_id, tila_nimi FROM tilat ORDER BY tila_nimi")->fetchAll();

$kurssi = [
  'kurssi_id' => null,
  'kurssin_tunnus' => '',
  'kurssi_nimi' => '',
  'kuvaus' => '',
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
    $_POST['kuvaus'],
    $_POST['aloituspaiva'],
    $_POST['lopetuspaiva'],
    $_POST['opettaja_id'],
    $_POST['tila_id']
  ];
  if (!empty($_POST['kurssi_id'])) {
    $data[] = $_POST['kurssi_id'];
    $stmt = $pdo->prepare("UPDATE kurssit SET kurssin_tunnus=?, kurssi_nimi=?, kuvaus=?, aloituspaiva=?, lopetuspaiva=?, opettaja_id=?, tila_id=? WHERE kurssi_id=?");
  } else {
    $stmt = $pdo->prepare("INSERT INTO kurssit (kurssin_tunnus, kurssi_nimi, kuvaus, aloituspaiva, lopetuspaiva, opettaja_id, tila_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<a href="index.php" class="btn btn-secondary mb-3">← Takaisin</a>
<h1><?= $kurssi['kurssi_id'] ? 'Muokkaa kurssia' : 'Lisää uusi kurssi' ?></h1>

<form method="post">
  <input type="hidden" name="kurssi_id" value="<?= htmlspecialchars($kurssi['kurssi_id']) ?>">
  
  <div class="mb-3">
    <label class="form-label">Kurssin tunnus</label>
    <input type="text" name="kurssin_tunnus" class="form-control" value="<?= htmlspecialchars($kurssi['kurssin_tunnus']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Kurssin nimi</label>
    <input type="text" name="kurssi_nimi" class="form-control" value="<?= htmlspecialchars($kurssi['kurssi_nimi']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Kuvaus</label>
    <textarea name="kuvaus" class="form-control"><?= htmlspecialchars($kurssi['kuvaus']) ?></textarea>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Alkaa</label>
      <input type="date" name="aloituspaiva" class="form-control" value="<?= htmlspecialchars($kurssi['aloituspaiva']) ?>" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Loppuu</label>
      <input type="date" name="lopetuspaiva" class="form-control" value="<?= htmlspecialchars($kurssi['lopetuspaiva']) ?>" required>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Opettaja</label>
    <select name="opettaja_id" class="form-select" required>
      <option value="">-- Valitse opettaja --</option>
      <?php foreach ($opettajat as $o): ?>
        <option value="<?= $o['opettaja_id'] ?>" <?= $kurssi['opettaja_id']==$o['opettaja_id']?'selected':'' ?>>
          <?= htmlspecialchars($o['etunimi'].' '.$o['sukunimi']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Tila</label>
    <select name="tila_id" class="form-select" required>
      <option value="">-- Valitse tila --</option>
      <?php foreach ($tilat as $t): ?>
        <option value="<?= $t['tila_id'] ?>" <?= $kurssi['tila_id']==$t['tila_id']?'selected':'' ?>>
          <?= htmlspecialchars($t['tila_nimi']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <button class="btn btn-primary">Tallenna</button>
</form>
</body>
</html>
