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
<title>Admin - Kurssienhallinta</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { padding: 2rem; }
section { margin-bottom: 2rem; }
h2 { border-bottom: 2px solid #ddd; padding-bottom: .5rem; margin-bottom: 1rem; }
</style>
<script>
function confirmDelete(url) {
  if (confirm("Haluatko varmasti poistaa tämän tietueen?")) {
    window.location = url;
  }
}
</script>
</head>
<body>

<h1>📚 Hallintapaneeli</h1>
<p>Täältä voit hallita kursseja, oppilaita, opettajia ja tiloja.</p>

<section class="border rounded p-3">
  <h2>Kurssit</h2>
  <a href="add_edit_kurssi.php" class="btn btn-primary mb-3">➕ Lisää uusi kurssi</a>

  <form class="row g-2" action="add_edit_kurssi.php" method="get">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse muokattava kurssi --</option>
        <?php foreach($kurssit as $k): ?>
          <option value="<?= $k['kurssi_id'] ?>"><?= htmlspecialchars($k['kurssi_nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-warning">✏️ Muokkaa</button>
    </div>
  </form>

  <form class="row g-2 mt-2" onsubmit="event.preventDefault(); confirmDelete('delete_kurssi.php?id=' + this.id.value);">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse poistettava kurssi --</option>
        <?php foreach($kurssit as $k): ?>
          <option value="<?= $k['kurssi_id'] ?>"><?= htmlspecialchars($k['kurssi_nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-danger">🗑️ Poista</button>
    </div>
  </form>
</section>

<section class="border rounded p-3">
  <h2>Oppilaat</h2>
  <a href="add_edit_oppilas.php" class="btn btn-primary mb-3">➕ Lisää uusi oppilas</a>

  <form class="row g-2" action="add_edit_oppilas.php" method="get">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse muokattava oppilas --</option>
        <?php foreach($oppilaat as $o): ?>
          <option value="<?= $o['oppilas_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-warning">✏️ Muokkaa</button>
    </div>
  </form>

  <form class="row g-2 mt-2" onsubmit="event.preventDefault(); confirmDelete('delete_oppilas.php?id=' + this.id.value);">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse poistettava oppilas --</option>
        <?php foreach($oppilaat as $o): ?>
          <option value="<?= $o['oppilas_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-danger">🗑️ Poista</button>
    </div>
  </form>
</section>

<section class="border rounded p-3">
  <h2>Opettajat</h2>
  <a href="add_edit_opettaja.php" class="btn btn-primary mb-3">➕ Lisää uusi opettaja</a>

  <form class="row g-2" action="add_edit_opettaja.php" method="get">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse muokattava opettaja --</option>
        <?php foreach($opettajat as $o): ?>
          <option value="<?= $o['opettaja_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-warning">✏️ Muokkaa</button>
    </div>
  </form>

  <form class="row g-2 mt-2" onsubmit="event.preventDefault(); confirmDelete('delete_opettaja.php?id=' + this.id.value);">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse poistettava opettaja --</option>
        <?php foreach($opettajat as $o): ?>
          <option value="<?= $o['opettaja_id'] ?>"><?= htmlspecialchars($o['nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-danger">🗑️ Poista</button>
    </div>
  </form>
</section>

<section class="border rounded p-3">
  <h2>Tilat</h2>
  <a href="add_edit_tila.php" class="btn btn-primary mb-3">➕ Lisää uusi tila</a>

  <form class="row g-2" action="add_edit_tila.php" method="get">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse muokattava tila --</option>
        <?php foreach($tilat as $t): ?>
          <option value="<?= $t['tila_id'] ?>"><?= htmlspecialchars($t['tila_nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-warning">✏️ Muokkaa</button>
    </div>
  </form>

  <form class="row g-2 mt-2" onsubmit="event.preventDefault(); confirmDelete('delete_tila.php?id=' + this.id.value);">
    <div class="col-md-6">
      <select name="id" class="form-select" required>
        <option value="">-- Valitse poistettava tila --</option>
        <?php foreach($tilat as $t): ?>
          <option value="<?= $t['tila_id'] ?>"><?= htmlspecialchars($t['tila_nimi']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-danger">🗑️ Poista</button>
    </div>
  </form>
</section>

</body>
</html>
