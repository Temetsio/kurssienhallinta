<?php
require_once 'db.php';
$pdo = getPDO();

$successMessage = "";
$errorMessage = "";

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

  $tila_id  = $_POST['tila_id'] ?? null;
  $nimi     = trim($_POST['tila_nimi']);
  $paikat   = trim($_POST['paikkoja']);

  if ($nimi === "" || $paikat === "") {
      $errorMessage = "Kaikki kentät ovat pakollisia.";
  } else {
      try {
          if (!empty($tila_id)) {
              // Päivitä
              $stmt = $pdo->prepare("UPDATE tilat SET tila_nimi=?, paikkoja=? WHERE tila_id=?");
              $stmt->execute([$nimi, $paikat, $tila_id]);
              $successMessage = "Tila päivitettiin onnistuneesti!";
          } else {
              // Lisää uusi
              $stmt = $pdo->prepare("INSERT INTO tilat (tila_nimi, paikkoja) VALUES (?,?)");
              $stmt->execute([$nimi, $paikat]);
              $successMessage = "Uusi tila lisättiin onnistuneesti!";
              $tila = ['tila_id'=>null, 'tila_nimi'=>'', 'paikkoja'=>''];
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
  <title><?= $tila['tila_id'] ? 'Muokkaa tilaa' : 'Lisää tila' ?></title>
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
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php" class="active">Tilat</a>
      <a href="admin.php">Hallinta</a>
    </div>

    <a href="tilat.php" class="back">← Takaisin</a>
    <h1 class="page-title">
      <?= $tila['tila_id'] ? 'Muokkaa tilaa' : 'Lisää uusi tila' ?>
    </h1>

    <?php if (!empty($successMessage)): ?>
      <div class="msg msg-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
      <div class="msg msg-error"><?= $errorMessage ?></div>
    <?php endif; ?>

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
