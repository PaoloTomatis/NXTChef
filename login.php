<?php
session_start();
require_once("includes/dbh.inc.php");
$_SESSION["pages"][]=$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || Login", "login") ?>
    <body>
        <?php require_once("base/navbar.php") ?>
        <main>
            <div class="cont">
                <form action="actions/login.inc.php" method="post" class="login">
                    <input name="email" id="email" type="email" placeholder="Email">
                    <input name="psw" id="psw" type="password" placeholder="Password">
                    <button id="submit" type="submit">Accedi</button>
                </form>
                <form action="actions/signup.inc.php" method="post" class="signup">
                    <input name="username" id="username" type="text" placeholder="Username">
                    <input name="email" id="email" type="email" placeholder="Email">
                    <input name="psw" id="psw" type="password" placeholder="Password">
                    <button id="submit" type="submit">Registrati</button>
                </form>
            </div>
        </main>
        <?php require_once("base/footer.php") ?>
    </body>
</html>