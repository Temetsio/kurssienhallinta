<?php
include 'db.php';
include 'header.php';

$tilat = $mysqli->query("SELECT * FROM tilat");
if (!$tilat) {
    echo "<p>Virhe tietokantakyselyssä: " . $mysqli->error . "</p>";
}
?>
<main>
    <h2>Tilojen hallinta</h2>

    <table border="1">
        <tr><th>Tilan nimi</th><th>Kuvaus</th></tr>
        <?php if ($tilat): ?>
            <?php while($r = $tilat->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($r['tila_nimi']) ?></td>
                    <td><?= htmlspecialchars($r['kuvaus']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>
</main>
<?php include 'footer.php'; ?>
