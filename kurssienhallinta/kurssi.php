<?php
require_once 'db.php';
$pdo = getPDO();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Kurssi-id puuttuu.');
}
$kurssi_id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT k.*, o.etunimi AS op_etunimi, o.sukunimi AS op_sukunimi, t.tila_nimi
    FROM kurssit k
    JOIN opettajat o ON k.opettaja_id = o.opettaja_id
    JOIN tilat t ON k.tila_id = t.tila_id
    WHERE k.kurssi_id = ?");
$stmt->execute([$kurssi_id]);
$kurssi = $stmt->fetch();
if (!$kurssi) die('Kurssia ei löytynyt.');

$stmt = $pdo->prepare("SELECT i.ilmoittautuminen_id, o.oppilas_id, o.etunimi, o.sukunimi, i.ilmoittautumispaiva
    FROM ilmoittautuminen i
    JOIN oppilaat o ON i.opiskelija_id = o.oppilas_id
    WHERE i.kurssi_id = ?
    ORDER BY i.ilmoittautumispaiva ASC");
$stmt->execute([$kurssi_id]);
$ilmo = $stmt->fetchAll();

$opp = $pdo->query("SELECT oppilas_id, etunimi, sukunimi FROM oppilaat ORDER BY sukunimi")->fetchAll();
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($kurssi['kurssi_nimi']) ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="nav">
      <a href="index.php">Kurssit</a>
      <a href="oppilaat.php">Oppilaat</a>
      <a href="opettajat.php">Opettajat</a>
      <a href="tilat.php">Tilat</a>
      <a href="admin.php">Hallinta</a>
    </div>

    <a class="back" href="index.php">← Takaisin</a>
    <h1 class="page-title"><?= htmlspecialchars($kurssi['kurssi_nimi']) ?></h1>

    <div class="card">
      <div class="meta">
        <div><strong>Tunnus:</strong> <?= htmlspecialchars($kurssi['kurssin_tunnus']) ?></div>
        <div><strong>Opettaja:</strong> <?= htmlspecialchars($kurssi['op_etunimi'].' '.$kurssi['op_sukunimi']) ?></div>
        <div><strong>Tila:</strong> <?= htmlspecialchars($kurssi['tila_nimi']) ?></div>
        <div><strong>Ajanjakso:</strong> <?= htmlspecialchars($kurssi['aloituspaiva']) ?> — <?= htmlspecialchars($kurssi['lopetuspaiva']) ?></div>
      </div>
    </div>

    <?php if (!empty($kurssi['kurssikuvaus'])): ?>
      <h2 style="margin:22px 0 10px">Kurssikuvaus</h2>
      <div class="card">
        <p><?= nl2br(htmlspecialchars($kurssi['kurssikuvaus'])) ?></p>
      </div>
    <?php endif; ?>

    <h2 style="margin:22px 0 10px">Ilmoittautuneet</h2>
    <div class="card table-wrap">
      <?php if (count($ilmo) === 0): ?>
        <p class="muted">Ei ilmoittautuneita.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Oppilas</th>
              <th>Ilmoittautunut</th>
              <th>Toiminnot</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($ilmo as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['etunimi'].' '.$r['sukunimi']) ?></td>
              <td><?= htmlspecialchars($r['ilmoittautumispaiva']) ?></td>
              <td>
                <form method="post" action="poista_ilmo.php" style="display:inline">
                  <input type="hidden" name="id" value="<?= $r['ilmoittautuminen_id'] ?>">
                  <button class="btn btn-danger" type="submit" onclick="return confirm('Poistetaanko ilmoittautuminen?')">Poista</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <h3 style="margin:22px 0 10px">Lisää ilmoittautuminen</h3>
    <div class="card">
      <form method="post" action="ilmoittaudu.php">
        <input type="hidden" name="kurssi_id" value="<?= $kurssi_id ?>">
        <label>Oppilas:
          <select name="oppilas_id" required>
            <option value="">-- valitse --</option>
            <?php foreach($opp as $o): ?>
            <option value="<?= $o['oppilas_id'] ?>"><?= htmlspecialchars($o['etunimi'].' '.$o['sukunimi']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <button class="btn" type="submit">Ilmoittaudu</button>
      </form>
    </div>
  </div>
</body>
</html>
