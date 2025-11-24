<?php
require_once 'db.php';

function finDate($date) {
    if (!$date) return '';
    return date("d.m.Y", strtotime($date)); // Suomalainen formaatti näyttöön
}

function dateForInput($date) {
    if (!$date) return '';
    return date("Y-m-d", strtotime($date)); // date-input vaatii tämän
}

$pdo = getPDO();

$successMessage = "";
$errorMessage = "";

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

  $kurssi_id     = $_POST['kurssi_id'] ?? null;
  $tunnus        = trim($_POST['kurssin_tunnus']);
  $nimi          = trim($_POST['kurssi_nimi']);
  $kuvaus        = trim($_POST['kurssikuvaus']);
  $aloitus       = trim($_POST['aloituspaiva']);
  $lopetus       = trim($_POST['lopetuspaiva']);
  $opettaja_id   = trim($_POST['opettaja_id']);
  $tila_id       = trim($_POST['tila_id']);

  // Palautetaan lomakkeen tiedot takaisin näkymään
  $kurssi = [
      'kurssi_id' => $kurssi_id,
      'kurssin_tunnus' => $tunnus,
      'kurssi_nimi' => $nimi,
      'kurssikuvaus' => $kuvaus,
      'aloituspaiva' => $aloitus,
      'lopetuspaiva' => $lopetus,
      'opettaja_id' => $opettaja_id,
      'tila_id' => $tila_id
  ];

  if ($tunnus === "" || $nimi === "" || $aloitus === "" || $lopetus === "" || $opettaja_id === "" || $tila_id === "") {
      $errorMessage = "Kaikki pakolliset kentät tulee täyttää.";
  } else {
      try {
          if (!empty($kurssi_id)) {
              $stmt = $pdo->prepare("
                  UPDATE kurssit
                  SET kurssin_tunnus=?, kurssi_nimi=?, kurssikuvaus=?, aloituspaiva=?, lopetuspaiva=?, opettaja_id=?, tila_id=?
                  WHERE kurssi_id=?
              ");
              $stmt->execute([$tunnus, $nimi, $kuvaus, $aloitus, $lopetus, $opettaja_id, $tila_id, $kurssi_id]);

              $successMessage = "Kurssi päivitettiin onnistuneesti!";
          } else {
              $stmt = $pdo->prepare("
                  INSERT INTO kurssit (kurssin_tunnus, kurssi_nimi, kurssikuvaus, aloituspaiva, lopetuspaiva, opettaja_id, tila_id)
                  VALUES (?, ?, ?, ?, ?, ?, ?)
              ");
              $stmt->execute([$tunnus, $nimi, $kuvaus, $aloitus, $lopetus, $opettaja_id, $tila_id]);

              $successMessage = "Uusi kurssi lisättiin onnistuneesti!";

              // Tyhjennä lomake lisäyksen jälkeen
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
  <title><?= $kurssi['kurssi_id'] ? 'Muokkaa kurssia' : 'Lisää kurssi' ?></title>
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
      <a href="index.php" class="active">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php">Hallinta</a>
    </div>

    <a class="back" href="index.php">← Takaisin</a>
    <h1 class="page-title">
      <?= $kurssi['kurssi_id'] ? 'Muokkaa kurssia' : 'Lisää uusi kurssi' ?>
    </h1>

    <?php if (!empty($successMessage)): ?>
      <div class="msg msg-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
      <div class="msg msg-error"><?= $errorMessage ?></div>
    <?php endif; ?>


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
          <input type="date" name="aloituspaiva" value="<?= dateForInput($kurssi['aloituspaiva']) ?>" required>
        </label>

        <label>Loppuu
          <input type="date" name="lopetuspaiva" value="<?= dateForInput($kurssi['lopetuspaiva']) ?>" required>
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
