<?php
require_once 'db.php';
$pdo = getPDO();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("Virheellinen ID.");
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("DELETE FROM tilat WHERE tila_id = ?");
$stmt->execute([$id]);

header("Location: admin.php");
exit;
?>
