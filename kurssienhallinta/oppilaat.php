<?php
require_once 'db.php';

function finDate($date) {
    if (!$date) return '';
    return date("d.m.Y", strtotime($date));
}

$pdo = getPDO();
$opp = $pdo->query("SELECT oppilas_id, etunimi, sukunimi, syntymaaika, vuosikurssi FROM oppilaat ORDER BY sukunimi")->fetchAll();
?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <title>Oppilaat</title>
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
    <h1 class="page-title">Oppilaat</h1>

    <div class="card table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nimi</th>
            <th>Syntymäaika</th>
            <th>Vuosikurssi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$opp): ?>
            <tr><td colspan="3" class="muted">Ei oppilaita.</td></tr>
          <?php else: ?>
            <?php foreach($opp as $o): ?>
            <tr>
              <td>
                <a href="opiskelija.php?id=<?= (int)$o['oppilas_id'] ?>">
                  <?= htmlspecialchars($o['etunimi'].' '.$o['sukunimi']) ?>
                </a>
              </td>
              <td><?= finDate($o['syntymaaika']) ?></td>
              <td><?= htmlspecialchars($o['vuosikurssi']) ?></td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
