<?php
require_once 'db.php';
$pdo = getPDO();

$kurssit = $pdo->query("SELECT kurssi_id, kurssi_nimi FROM kurssit ORDER BY kurssi_nimi")->fetchAll();
$oppilaat = $pdo->query("SELECT oppilas_id, CONCAT(etunimi, ' ', sukunimi) AS nimi FROM oppilaat ORDER BY sukunimi")->fetchAll();
$opettajat = $pdo->query("SELECT opettaja_id, CONCAT(etunimi, ' ', sukunimi) AS nimi FROM opettajat ORDER BY sukunimi")->fetchAll();
$tilat = $pdo->query("SELECT tila_id, tila_nimi FROM tilat ORDER BY tila_nimi")->fetchAll();
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title>Hallintapaneeli</title>
  <link rel="stylesheet" href="styles.css">
  <script>
  function confirmDelete(url) {
    if (confirm("Haluatko varmasti poistaa tämän tietueen?")) {
      window.location = url;
    }
  }
  </script>
</head>
<body>
  <div class="container">
    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php" class="active">Hallinta</a>
    </div>

    <a class="back" href="index.php">← Takaisin</a>
    <h1 class="page-title">📚 Hallintapaneeli</h1>
    <p>Täältä voit hallita kursseja, oppilaita, opettajia ja tiloja.</p>

    <!-- Kurssit -->
    <section class="card">
      <h2>Kurssit</h2>
      <a href="add_edit_kurssi.php" class="button">➕ Lisää uusi kurssi</a>

      <form class="form-row" action="add_edit_kurssi.php" method="get">
        <select name="id" required>
          <option value="">-- Valitse muokattava kurssi --</option>
          <?php foreach($kurssit as $k): ?>
            <option value="<?= $k['kurssi_id'] ?>"><?= htmlspecialchars($k['kurssi_nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button warn">✏️ Muokkaa</button>
      </form>

      <form class="form-row" onsubmit="event.preventDefault(); confirmDelete('delete_kurssi.php?id=' + this.id.value);">
        <select name="id" required>
          <option value="">-- Valitse poistettava kurssi --</option>
          <?php foreach($kurssit as $k): ?>
            <option value="<?= $k['kurssi_id'] ?>"><?= htmlspecialchars($k['kurssi_nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button danger">🗑️ Poista</button>
      </form>
    </section><br>

    <!-- Oppilaat -->
    <section class="card">
      <h2>Oppilaat</h2>
      <a href="add_edit_oppilas.php" class="button">➕ Lisää uusi oppilas</a>

      <form class="form-row" action="add_edit_oppilas.php" method="get">
        <select name="id" required>
          <option value="">-- Valitse muokattava oppilas --</option>
          <?php foreach($oppilaat as $o): ?>
            <option value="<?= $o['oppilas_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button warn">✏️ Muokkaa</button>
      </form>

      <form class="form-row" onsubmit="event.preventDefault(); confirmDelete('delete_oppilas.php?id=' + this.id.value);">
        <select name="id" required>
          <option value="">-- Valitse poistettava oppilas --</option>
          <?php foreach($oppilaat as $o): ?>
            <option value="<?= $o['oppilas_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button danger">🗑️ Poista</button>
      </form>
    </section><br>

    <!-- Opettajat -->
    <section class="card">
      <h2>Opettajat</h2>
      <a href="add_edit_opettaja.php" class="button">➕ Lisää uusi opettaja</a>

      <form class="form-row" action="add_edit_opettaja.php" method="get">
        <select name="id" required>
          <option value="">-- Valitse muokattava opettaja --</option>
          <?php foreach($opettajat as $o): ?>
            <option value="<?= $o['opettaja_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button warn">✏️ Muokkaa</button>
      </form>

      <form class="form-row" onsubmit="event.preventDefault(); confirmDelete('delete_opettaja.php?id=' + this.id.value);">
        <select name="id" required>
          <option value="">-- Valitse poistettava opettaja --</option>
          <?php foreach($opettajat as $o): ?>
            <option value="<?= $o['opettaja_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button danger">🗑️ Poista</button>
      </form>
    </section><br>

    <!-- Tilat -->
    <section class="card">
      <h2>Tilat</h2>
      <a href="add_edit_tila.php" class="button">➕ Lisää uusi tila</a>

      <form class="form-row" action="add_edit_tila.php" method="get">
        <select name="id" required>
          <option value="">-- Valitse muokattava tila --</option>
          <?php foreach($tilat as $t): ?>
            <option value="<?= $t['tila_id'] ?>"><?= htmlspecialchars($t['tila_nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button warn">✏️ Muokkaa</button>
      </form>

      <form class="form-row" onsubmit="event.preventDefault(); confirmDelete('delete_tila.php?id=' + this.id.value);">
        <select name="id" required>
          <option value="">-- Valitse poistettava tila --</option>
          <?php foreach($tilat as $t): ?>
            <option value="<?= $t['tila_id'] ?>"><?= htmlspecialchars($t['tila_nimi']) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button danger">🗑️ Poista</button>
      </form>
    </section><br>

    <!-- Kurssisessiot -->
<section class="card">
  <h2>Kurssisessiot</h2>
  <a href="add_edit_sessio.php" class="button">➕ Lisää uusi sessio</a>

  <form class="form-row" action="add_edit_sessio.php" method="get">
    <select name="id" required>
      <option value="">-- Valitse muokattava sessio --</option>
      <?php
      $sessiot = $pdo->query("
        SELECT s.sessio_id,
               k.kurssi_nimi,
               s.viikonpaiva,
               s.alkuaika,
               s.loppuaika
        FROM kurssisessiot s
        JOIN kurssit k ON s.kurssi_id = k.kurssi_id
        ORDER BY k.kurssi_nimi, FIELD(viikonpaiva,'Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai'), alkuaika
      ")->fetchAll();

      foreach($sessiot as $s):
      ?>
        <option value="<?= $s['sessio_id'] ?>">
          <?= htmlspecialchars($s['kurssi_nimi']." – ".$s['viikonpaiva']." ".$s['alkuaika']."–".$s['loppuaika']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="button warn">✏️ Muokkaa</button>
  </form>

  <form class="form-row" onsubmit="event.preventDefault(); confirmDelete('delete_sessio.php?id=' + this.id.value);">
    <select name="id" required>
      <option value="">-- Valitse poistettava sessio --</option>
      <?php foreach($sessiot as $s): ?>
        <option value="<?= $s['sessio_id'] ?>">
          <?= htmlspecialchars($s['kurssi_nimi']." – ".$s['viikonpaiva']." ".$s['alkuaika']."–".$s['loppuaika']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="button danger">🗑️ Poista</button>
  </form>
</section><br>


  </div>
</body>
</html>
