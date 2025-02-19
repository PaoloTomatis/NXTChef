<?php

session_start();
require_once("../includes/dbh.inc.php");
require_once("../includes/checkLogin.inc.php");

$idUser=$_SESSION["user"]["id"];

$query="DELETE FROM users WHERE id=:idUser";
$stmt=$pdo->prepare($query);
$stmt->bindParam("idUser", $idUser);
$stmt->execute();

unset($_SESSION["user"]);

header("Location: /login");
die();