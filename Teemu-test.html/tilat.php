<?php
include 'db.php';
include 'header.php';

// Hae tilat
$tilat = $mysqli->query("SELECT * FROM tilat");
?>
<main>
    <h2>Tilojen hallinta</h2>
    <table border="1">
        <tr><th>Tilan nimi</th><th>Kuvaus</th></tr>
        <?php while($r = $tilat->fetch_assoc()): ?>
            <tr><td><?= $r['tila_nimi'] ?></td><td><?= $r['kuvaus'] ?></td></tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include 'footer.php'; ?>
