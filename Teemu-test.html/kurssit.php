<?php 
include 'db.php';
include 'header.php';

// Lisää kurssi lomakkeelta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = $_POST['kurssi_nimi'];
    $kuvaus = $_POST['kurssikuvaus'];
    $stmt = $mysqli->prepare("INSERT INTO kurssit (kurssi_nimi, kurssikuvaus) VALUES (?, ?)");
    $stmt->bind_param("ss", $nimi, $kuvaus);
    $stmt->execute();
    $stmt->close();
}

// Hae kurssit
$kurssit = $mysqli->query("SELECT * FROM kurssit");
?>
<main>
    <h2>Lisää kurssi</h2>
    <form method="POST">
        <label>Nimi: <input name="kurssi_nimi" required></label><br>
        <label>Kuvaus: <input name="kurssikuvaus"></label><br>
        <button type="submit">Lisää kurssi</button>
    </form>

    <h2>Kurssit</h2>
    <table border="1">
        <tr><th>Nimi</th><th>Kuvaus</th></tr>
        <?php while ($r = $kurssit->fetch_assoc()): ?>
            <tr><td><?= $r['kurssi_nimi'] ?></td><td><?= $r['kurssikuvaus'] ?></td></tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include 'footer.php'; ?>
