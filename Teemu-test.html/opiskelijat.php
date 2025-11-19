<?php include 'db.php'; ?>
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
                <?= $row['kurssi_nimi'] ?>
            </option>
        <?php endwhile; ?>

    </select>
    <br><br>

    <button type="submit">Lisää opiskelija</button>
</form>

</body>
</html>
