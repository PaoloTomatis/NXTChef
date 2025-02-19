<?php
session_start();
require_once("includes/dbh.inc.php");
// require_once("includes/checkLogin.inc.php");
if (!isset($_SESSION["avviso"])){header("Location: /");die();}
$_SESSION["pages"][]=$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || Avviso", "avviso") ?>
    <body>
        <?php require_once("base/navbar.php") ?>
    <main>
        <?php if ($_SESSION["avviso"]["tipo"]=="errore"){ ?>
            <div class="blocco-1">
                <div class="visual visual-error">
                    <h2 class="sign">!</h2>
                </div>
                <h1 class="tit tit-error"><?php echo $_SESSION["avviso"]["titolo"] ?></h1>
            </div>

        <?php } elseif($_SESSION["avviso"]["tipo"]=="info") { ?>
            <div class="blocco-1">
                <div class="visual visual-info">
                    <h2 class="sign">?</h2>
                </div>
                <h1 class="tit tit-info"><?php echo $_SESSION["avviso"]["titolo"] ?></h1>
            </div>
        <?php } ?>
        <p class="desc"><?php echo $_SESSION["avviso"]["testo"] ?></p>
        <a href="<?php echo $_SESSION["avviso"]["link"] ?>" class="cta"><?php echo $_SESSION["avviso"]["cta"] ?></a>
    </main>
    <?php require_once("base/footer.php") ?>
    </body>
</html>