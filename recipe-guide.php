<?php
session_start();
require_once("includes/dbh.inc.php");
require_once("includes/checkLogin.inc.php");
$_SESSION["pages"][]=$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || Guida $nome", "recipe-guide") ?>
    <body>
        <?php require_once("base/navbar.php") ?>
        <main>

        </main>
        <?php require_once("base/footer.php") ?>
    </body>
</html>