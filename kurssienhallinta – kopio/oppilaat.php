<?php
require_once 'db.php';
$pdo = getPDO();
$opp = $pdo->query("SELECT oppilas_id, etunimi, sukunimi, syntymaaika, vuosikurssi FROM oppilaat ORDER BY sukunimi")->fetchAll();
?>
<!doctype html><html lang="fi"><head><meta charset="utf-8"><title>Oppilaat</title></head><body>
  <a href="index.php">← Kurssit</a>
  <h1>Oppilaat</h1>
  <table>
    <thead><tr><th>Nimi</th><th>Syntymäaika</th><th>Vuosikurssi</th></tr></thead>
    <tbody>
<?php foreach($opp as $o): ?>
      <tr>
        <td>
          <a href="opiskelija.php?id=<?= (int)$o['oppilas_id'] ?>">
            <?= htmlspecialchars($o['etunimi'].' '.$o['sukunimi']) ?>
          </a>
        </td>
        <td><?= htmlspecialchars($o['syntymaaika']) ?></td>
        <td><?= htmlspecialchars($o['vuosikurssi']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>