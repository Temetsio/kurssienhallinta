<?php
require_once 'db.php';
$pdo = getPDO();

$kurssit = $pdo->query("SELECT kurssi_id, kurssi_nimi FROM kurssit ORDER BY kurssi_nimi")->fetchAll();
$tilat = $pdo->query("SELECT tila_id, tila_nimi FROM tilat ORDER BY tila_nimi")->fetchAll();

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM kurssisessiot WHERE sessio_id = ?");
    $stmt->execute([$id]);
    $sessio = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kurssi_id   = $_POST['kurssi_id'];
    $viikonpaiva = $_POST['viikonpaiva'];
    $alkuaika    = $_POST['alkuaika'];
    $loppuaika   = $_POST['loppuaika'];
    $tila_id     = $_POST['tila_id'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE kurssisessiot SET kurssi_id=?, viikonpaiva=?, alkuaika=?, loppuaika=?, tila_id=? WHERE sessio_id=?");
        $stmt->execute([$kurssi_id, $viikonpaiva, $alkuaika, $loppuaika, $tila_id, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO kurssisessiot (kurssi_id, viikonpaiva, alkuaika, loppuaika, tila_id) VALUES (?,?,?,?,?)");
        $stmt->execute([$kurssi_id, $viikonpaiva, $alkuaika, $loppuaika, $tila_id]);
    }

    header("Location: admin.php");
    exit;
}
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= $id ? "Muokkaa sessiota" : "Lisää sessio" ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <a class="back" href="admin.php">← Takaisin</a>
  <h1 class="page-title"><?= $id ? "✏️ Muokkaa sessiota" : "➕ Lisää uusi sessio" ?></h1>

  <form method="post" class="form">

    <label>Kurssi:</label>
    <select name="kurssi_id" required>
      <?php foreach ($kurssit as $k): ?>
        <option value="<?= $k['kurssi_id'] ?>"
          <?= isset($sessio) && $sessio['kurssi_id']==$k['kurssi_id'] ? "selected" : "" ?>>
          <?= htmlspecialchars($k['kurssi_nimi']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Viikonpäivä:</label>
    <select name="viikonpaiva" required>
      <?php foreach (['Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai'] as $vp): ?>
        <option value="<?= $vp ?>" <?= isset($sessio)&&$sessio['viikonpaiva']==$vp ? "selected":"" ?>>
          <?= $vp ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Alkuaika:</label>
    <input type="time" name="alkuaika" required value="<?= $sessio['alkuaika'] ?? '' ?>">

    <label>Loppuaika:</label>
    <input type="time" name="loppuaika" required value="<?= $sessio['loppuaika'] ?? '' ?>">

    <label>Tila:</label>
    <select name="tila_id" required>
      <?php foreach ($tilat as $t): ?>
        <option value="<?= $t['tila_id'] ?>" 
          <?= isset($sessio)&&$sessio['tila_id']==$t['tila_id'] ? "selected":"" ?>>
          <?= htmlspecialchars($t['tila_nimi']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button class="button" type="submit">💾 Tallenna</button>
  </form>
</div>
</body>
</html>
