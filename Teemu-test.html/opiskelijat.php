<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = trim($_POST['nimi']);
    $kurssi_id = intval($_POST['kurssi_id']);

    if ($nimi !== '' && $kurssi_id > 0) {

        if ($stmt = $mysqli->prepare("INSERT INTO opiskelijat (nimi, kurssi_id) VALUES (?, ?)")) {
            $stmt->bind_param("si", $nimi, $kurssi_id);
            $stmt->execute();
            $stmt->close();
            echo "<p>Opiskelija lisätty onnistuneesti!</p>";
        } else {
            echo "<p>SQL-virhe: " . $mysqli->error . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="utf-8">
    <title>Opiskelijat</title>
</head>
<body>

<h1>Lisää opiskelija</h1>

<form method="POST">
    <label>Nimi:
        <input name="nimi" required>
    </label><br>

    <label>Kurssi:</label>
    <select name="kurssi_id" required>
        <option value="">Valitse kurssi</option>

        <?php
        $result = $mysqli->query("SELECT kurssi_id, kurssi_nimi FROM kurssit ORDER BY kurssi_nimi");

        while ($row = $result->fetch_assoc()):
        ?>
            <option value="<?= $row['kurssi_id'] ?>">
                <?= htmlspecialchars($row['kurssi_nimi']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <button type="submit">Lisää opiskelija</button>
</form>

</body>
</html>
