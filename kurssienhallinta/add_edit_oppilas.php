<?php
require_once 'db.php';

function finDate($date) {
    if (!$date) return '';
    return date("d.m.Y", strtotime($date));
}

function dateForInput($date) {
    if (!$date) return '';
    return date("Y-m-d", strtotime($date));
}

$pdo = getPDO();

$successMessage = "";
$errorMessage = "";

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

  $oppilas_id  = $_POST['oppilas_id'] ?? null;
  $etunimi     = trim($_POST['etunimi']);
  $sukunimi    = trim($_POST['sukunimi']);
  $syntymaaika = trim($_POST['syntymaaika']);
  $vuosikurssi = trim($_POST['vuosikurssi']);

  $oppilas = [
      'oppilas_id' => $oppilas_id,
      'etunimi' => $etunimi,
      'sukunimi' => $sukunimi,
      'syntymaaika' => $syntymaaika,
      'vuosikurssi' => $vuosikurssi
  ];

  if ($etunimi === "" || $sukunimi === "" || $syntymaaika === "" || $vuosikurssi === "") {
      $errorMessage = "Kaikki kentät ovat pakollisia.";
  } else {
      try {
          if (!empty($oppilas_id)) {
              $stmt = $pdo->prepare("
                  UPDATE oppilaat 
                  SET etunimi=?, sukunimi=?, syntymaaika=?, vuosikurssi=? 
                  WHERE oppilas_id=?
              ");
              $stmt->execute([$etunimi, $sukunimi, $syntymaaika, $vuosikurssi, $oppilas_id]);
              $successMessage = "Oppilas päivitettiin onnistuneesti!";
          } else {
              $stmt = $pdo->prepare("
                  INSERT INTO oppilaat (etunimi, sukunimi, syntymaaika, vuosikurssi)
                  VALUES (?,?,?,?)
              ");
              $stmt->execute([$etunimi, $sukunimi, $syntymaaika, $vuosikurssi]);
              $successMessage = "Uusi oppilas lisättiin onnistuneesti!";

              $oppilas = [
                  'oppilas_id' => null,
                  'etunimi' => '',
                  'sukunimi' => '',
                  'syntymaaika' => '',
                  'vuosikurssi' => ''
              ];
          }
      } catch (Exception $e) {
          $errorMessage = "Tallennus epäonnistui: " . $e->getMessage();
      }
  }
}
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= $oppilas['oppilas_id'] ? 'Muokkaa oppilasta' : 'Lisää oppilas' ?></title>
  <link rel="stylesheet" href="styles.css">

  <style>
    .msg {
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 13px;
        margin-bottom: 15px;
        opacity: 1;
        transition: opacity 1s ease-out;
        max-width: 350px;
    }
    .msg-success {
        background: #e7ffe7;
        border: 1px solid #67c567;
        color: #2d662d;
    }
    .msg-error {
        background: #ffe5e5;
        border: 1px solid #d9534f;
        color: #b32424;
    }
    .fade-out {
        opacity: 0 !important;
    }
  </style>
</head>
<body>
  <div class="container">

    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php" class="active">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php">Hallinta</a>
    </div>

    <a href="oppilaat.php" class="back">← Takaisin</a>
    <h1 class="page-title">
      <?= $oppilas['oppilas_id'] ? 'Muokkaa oppilasta' : 'Lisää uusi oppilas' ?>
    </h1>

    <?php if (!empty($successMessage)): ?>
      <div class="msg msg-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
      <div class="msg msg-error"><?= $errorMessage ?></div>
    <?php endif; ?>

    <form method="post" class="card form">
      <input type="hidden" name="oppilas_id" value="<?= htmlspecialchars($oppilas['oppilas_id']) ?>">

      <label>Etunimi
        <input type="text" name="etunimi" value="<?= htmlspecialchars($oppilas['etunimi']) ?>" required>
      </label>

      <label>Sukunimi
        <input type="text" name="sukunimi" value="<?= htmlspecialchars($oppilas['sukunimi']) ?>" required>
      </label>

      <label>Syntymäaika
        <input type="date" name="syntymaaika" value="<?= dateForInput($oppilas['syntymaaika']) ?>" required>
      </label>

      <label>Vuosikurssi
        <input type="number" min="1" max="3" name="vuosikurssi" value="<?= htmlspecialchars($oppilas['vuosikurssi']) ?>" required>
      </label>

      <button class="button">💾 Tallenna</button>
    </form>
  </div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const msg = document.querySelector(".msg-success, .msg-error");
    if (msg) {
        setTimeout(() => {
            msg.classList.add("fade-out");
        }, 3000);
    }
});
</script>

</body>
</html>
