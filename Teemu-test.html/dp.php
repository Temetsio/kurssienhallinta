<?php
$mysqli = new mysqli("localhost", "root", "", "kurssinhallinta");

if ($mysqli->connect_error) {
    die("Yhteysvirhe: " . $mysqli->connect_error);
}
?>
