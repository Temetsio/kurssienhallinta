<?php 
include 'db.php';
include 'header.php';

// Hae ilmoittautumiset
$ilmoittautumiset = $mysqli->query("
    SELECT o.nimi AS opiskelija, k.kurssi_nimi AS kurssi
    FROM opiskelijat o
    JOIN kurssit k ON o.kurssi_id = k.kurssi_id
");
?>
<main>
    <h2>Kurssi-ilmoittautumiset</h2>
    <table border="1">
        <tr><th>Opiskelija</th><th>Kurssi</th></tr>
        <?php while($r = $ilmoittautumiset->fetch_assoc()): ?>
            <tr><td><?= $r['opiskelija'] ?></td><td><?= $r['kurssi'] ?></td></tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include 'footer.php'; ?>
