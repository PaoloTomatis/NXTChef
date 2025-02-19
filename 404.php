<?php
session_start();
require_once("includes/dbh.inc.php");
// require_once("includes/checkLogin.inc.php");
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || Errore 404", "404") ?>
    <body>
        <?php require_once("base/navbar.php") ?>
        <main>
            <h1 class="tit">404</h1>
            <p class="desc">Oops! Sembra che questa pagina abbia preso una strada sbagliata. <a class="link" href="/">Torna sulla retta via!</a></p>
        </main>
        <?php require_once("base/footer.php") ?>
    </body>
</html>