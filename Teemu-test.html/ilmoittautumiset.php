<?php 
include 'db.php';
include 'header.php';

if (!isset($mysqli) || !$mysqli) {
    die('Database connection failed. Check db.php');
}

$ilmoittautumiset = $mysqli->query("
    SELECT o.nimi AS opiskelija, k.kurssi_nimi AS kurssi
    FROM opiskelijat o
    JOIN ilmoittatuminen i ON o.opiskelija_id = i.opiskelija_id
    JOIN kurssit k ON o.kurssi_id = k.kurssi_id
");
if (!$ilmoittautumiset) {
    die('Query failed: ' . $mysqli->error);
}
?>
<main>
    <h2>Kurssi-ilmoittautumiset</h2>
    <table border="1">
        <tr><th>Opiskelijat</th><th>Kurssit</th></tr>
        <?php while($r = $ilmoittautumiset->fetch_assoc()): ?>
            <tr><td><?= htmlspecialchars($r['opiskelijat'] ?></td><td><?= htmlspecialchars($r['kurssit'] ?></td></tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include 'footer.php'; ?>

