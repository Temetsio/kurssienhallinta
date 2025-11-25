<?php 
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = trim($_POST['kurssi_nimi']);
    $kuvaus = trim($_POST['kurssikuvaus']);

    if (!empty($nimi)) {
        if ($stmt = $mysqli->prepare("INSERT INTO kurssit (kurssi_nimi, kurssikuvaus) VALUES (?, ?)")) {
            $stmt->bind_param("ss", $nimi, $kuvaus);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Virhe: " . $mysqli->error;
        }
    }
}

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
            <tr>
                <td><?= htmlspecialchars($r['kurssi_nimi']) ?></td>
                <td><?= htmlspecialchars($r['kurssikuvaus']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include 'footer.php'; ?>
