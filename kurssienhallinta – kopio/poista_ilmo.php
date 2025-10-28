<?php
require_once 'db.php';
$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php'); exit;
}
$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) die('Virheellinen id.');

$stmt = $pdo->prepare("DELETE FROM ilmoittautuminen WHERE ilmoittautuminen_id = ?");
$stmt->execute([$id]);
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
exit;
