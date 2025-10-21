<?php
require_once 'db.php';
$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
$kurssi_id = (int)($_POST['kurssi_id'] ?? 0);
$oppilas_id = (int)($_POST['oppilas_id'] ?? 0);

if ($kurssi_id <= 0 || $oppilas_id <= 0) {
    die('Virheelliset tiedot.');
}

try {
    $stmt = $pdo->prepare("INSERT INTO ilmoittautuminen (opiskelija_id, kurssi_id, ilmoittautumispaiva) VALUES (?, ?, NOW())");
    $stmt->execute([$oppilas_id, $kurssi_id]);
    header("Location: kurssi.php?id={$kurssi_id}");
    exit;
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        die('Oppilas on jo ilmoittautunut tälle kurssille.');
    }
    throw $e;
}
