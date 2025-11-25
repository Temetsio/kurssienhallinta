<?php
require_once 'db.php';
$pdo = getPDO();

$successMessage = "";
$errorMessage = "";

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

    $opettaja_id = $_POST['opettaja_id'] ?? null;
    $etunimi     = trim($_POST['etunimi']);
    $sukunimi    = trim($_POST['sukunimi']);
    $aine        = trim($_POST['aine']);

    $opettaja = [
        'opettaja_id' => $opettaja_id,
        'etunimi' => $etunimi,
        'sukunimi' => $sukunimi,
        'aine' => $aine
    ];

    if ($etunimi === "" || $sukunimi === "" || $aine === "") {
        $errorMessage = "Kaikki kentät ovat pakollisia.";
    } else {
        try {
            if (!empty($opettaja_id)) {
                $stmt = $pdo->prepare("
                    UPDATE opettajat 
                    SET etunimi=?, sukunimi=?, aine=? 
                    WHERE opettaja_id=?
                ");
                $stmt->execute([$etunimi, $sukunimi, $aine, $opettaja_id]);
                $successMessage = "Opettaja päivitettiin onnistuneesti!";
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO opettajat (etunimi, sukunimi, aine)
                    VALUES (?,?,?)
                ");
                $stmt->execute([$etunimi, $sukunimi, $aine]);
                $successMessage = "Uusi opettaja lisättiin onnistuneesti!";

                $opettaja = [
                    'opettaja_id' => null,
                    'etunimi' => '',
                    'sukunimi' => '',
                    'aine' => ''
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
  <title><?= $opettaja['opettaja_id'] ? 'Muokkaa opettajaa' : 'Lisää opettaja' ?></title>
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
      <a href="opettajat.php" class="active">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php">Hallinta</a>
    </div>

    <a href="opettajat.php" class="back">← Takaisin</a>
    <h1 class="page-title">
      <?= $opettaja['opettaja_id'] ? 'Muokkaa opettajaa' : 'Lisää uusi opettaja' ?>
    </h1>

    <?php if (!empty($successMessage)): ?>
      <div class="msg msg-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
      <div class="msg msg-error"><?= $errorMessage ?></div>
    <?php endif; ?>

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
