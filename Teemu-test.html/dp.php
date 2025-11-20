<?php
$mysqli = new mysqli("localhost", "root", "", "kurssienhallinta");

if ($mysqli->connect_error) {
    die("Yhteysvirhe: " . $mysqli->connect_error);
}
?>
