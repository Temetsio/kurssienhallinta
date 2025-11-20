<?php
require_once 'db.php';
$pdo = getPDO();

$kurssit = $pdo->query("SELECT kurssi_id, kurssi_nimi FROM kurssit ORDER BY kurssi_nimi")->fetchAll();
$tilat = $pdo->query("SELECT tila_id, tila_nimi FROM tilat ORDER BY tila_nimi")->fetchAll();

$id = $_GET['id'] ?? null;
$successMessage = "";
$errorMessage = "";

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

    $sessio = [
        'kurssi_id' => $kurssi_id,
        'viikonpaiva' => $viikonpaiva,
        'alkuaika' => $alkuaika,
        'loppuaika' => $loppuaika,
        'tila_id' => $tila_id
    ];

    $stmt = $pdo->prepare("
        SELECT 
            s.sessio_id,
            k.kurssi_nimi,
            t.tila_nimi,
            o.etunimi AS opettaja_etunimi,
            o.sukunimi AS opettaja_sukunimi,
            s.alkuaika,
            s.loppuaika,
            s.viikonpaiva
        FROM kurssisessiot s
        JOIN kurssit k ON k.kurssi_id = s.kurssi_id
        JOIN tilat t ON t.tila_id = s.tila_id
        JOIN opettajat o ON o.opettaja_id = k.opettaja_id
        WHERE s.viikonpaiva = ?
          AND s.sessio_id != ?
          AND (? < s.loppuaika AND ? > s.alkuaika)
          AND (
                s.tila_id = ? 
             OR k.opettaja_id = (SELECT opettaja_id FROM kurssit WHERE kurssi_id = ?) 
             OR s.kurssi_id = ?
          )
    ");

    $stmt->execute([
        $viikonpaiva,
        $id ?? 0,
        $alkuaika,
        $loppuaika,
        $tila_id,
        $kurssi_id,
        $kurssi_id
    ]);

    $conflicts = $stmt->fetchAll();

    if ($conflicts) {
        $errorMessage = "<h3>⚠ Aikataulukonflikti</h3>";
        foreach ($conflicts as $c) {
            $errorMessage .= "
                <p><strong>{$c['kurssi_nimi']}</strong><br>
                Opettaja: {$c['opettaja_etunimi']} {$c['opettaja_sukunimi']}<br>
                Tila: {$c['tila_nimi']}<br>
                Aika: {$c['viikonpaiva']} {$c['alkuaika']}–{$c['loppuaika']}</p>";
        }
    } 
    else {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE kurssisessiot 
                                   SET kurssi_id=?, viikonpaiva=?, alkuaika=?, loppuaika=?, tila_id=? 
                                   WHERE sessio_id=?");
            $stmt->execute([$kurssi_id, $viikonpaiva, $alkuaika, $loppuaika, $tila_id, $id]);

            $successMessage = "Sessio päivitettiin onnistuneesti!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO kurssisessiot 
                (kurssi_id, viikonpaiva, alkuaika, loppuaika, tila_id) 
                VALUES (?,?,?,?,?)");
            $stmt->execute([$kurssi_id, $viikonpaiva, $alkuaika, $loppuaika, $tila_id]);

            $successMessage = "Uusi sessio lisättiin onnistuneesti!";
            
            $sessio = null;
        }
    }
}
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= $id ? "Muokkaa sessiota" : "Lisää sessio" ?></title>
  <link rel="stylesheet" href="styles.css">

  <style>
    .msg-success {
        background: #d4f8d4;
        border: 2px solid #5cb85c;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 6px;
        color: #2d662d;
    }
    .msg-error {
        background: #ffe5e5;
        border: 2px solid #d9534f;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 6px;
    }
  </style>
</head>
<body>
<div class="container">
  <a class="back" href="admin.php">← Takaisin</a>
  <h1 class="page-title"><?= $id ? "✏️ Muokkaa sessiota" : "➕ Lisää uusi sessio" ?></h1>

  <?php if (!empty($successMessage)): ?>
      <div class="msg-success"><?= $successMessage ?></div>
  <?php endif; ?>

  <?php if (!empty($errorMessage)): ?>
      <div class="msg-error"><?= $errorMessage ?></div>
  <?php endif; ?>


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
        <option value="<?= $vp ?>" 
            <?= isset($sessio)&&$sessio['viikonpaiva']==$vp ? "selected":"" ?>>
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
