<?php
require_once 'db.php';
$pdo = getPDO();

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM kurssisessiot WHERE sessio_id = ?");
    $stmt->execute([$id]);
}

header("Location: admin.php");
exit;
?>
