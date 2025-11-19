<?php
include 'db.php';
include 'header.php';

// Lisää opettaja
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = $_POST['nimi'];
    $stmt = $mysqli->prepare("INSERT INTO opettajat (nimi) VALUES (?)");
    $stmt->bind_param("s", $nimi);
    $stmt->execute();
    $stmt->close();
}

// Hae opettajat
$opettajat = $mysqli->query("SELECT * FROM opettajat");
?>
<main>
    <h2>Lisää opettaja</h2>
    <form method="POST">
        <label>Nimi: <input name="nimi" required></label>
        <button type="submit">Lisää</button>
    </form>

    <h2>Opettajat</h2>
    <table border="1">
        <tr><th>Nimi</th></tr>
        <?php while($r = $opettajat->fetch_assoc()): ?>
            <tr><td><?= $r['nimi'] ?></td></tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include 'footer.php'; ?>
