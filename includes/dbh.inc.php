<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "psw";
$dBName = "dbchef";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dBName", $dBUsername, $dBPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}