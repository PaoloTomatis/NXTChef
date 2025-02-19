<?php
session_start();
require_once("includes/dbh.inc.php");
require_once("base/recipes.php");

// Memorizza l'ultima pagina visitata nella sessione
$_SESSION["pages"][] = $_SERVER['REQUEST_URI'];

// Se l'utente ha premuto "Carica altre Ricette", resetta le ricette in sessione
if (isset($_GET["reload"])) {
    unset($_SESSION["recipes"]);
    header("Location: /");
    die();
}

// Se ci sono già ricette in sessione e non è stata richiesta una ricarica, usale
if (isset($_SESSION["recipes"]) && !isset($_GET["search"])) {
    $recipes = $_SESSION["recipes"];
} else {
    if (isset($_GET["search"])) {
        // Query per la ricerca con SOUNDEX
        $search = strtolower($_GET["search"]);
        $query = "SELECT * FROM recipes 
                  WHERE SOUNDEX(name) = SOUNDEX(:search) 
                  OR SOUNDEX(descrizione) = SOUNDEX(:search) 
                  OR SOUNDEX(tipo) = SOUNDEX(:search) 
                  LIMIT 30";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->execute();
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Se non c'è ricerca o se è stata richiesta una ricarica, prendi nuove ricette casuali
        $query = "SELECT * FROM recipes ORDER BY RAND() LIMIT 30";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Se ci sono ricette, suddividile in 3 colonne e salvale in sessione
    if (!empty($recipes)) {
        $recipes = array_chunk($recipes, ceil(count($recipes) / 3));
        $_SESSION["recipes"] = $recipes;
    }
}

// Recupera le ricette salvate dall'utente
$saved = [];

if (isset($_SESSION["user"])) {
    $idUser = $_SESSION["user"]["id"];
    $query = "SELECT * FROM saved WHERE idUser = :idUser";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":idUser", $idUser);
    $stmt->execute();
    $saved = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || Ricerca", "search"); ?>
    <body>
        <?php require_once("base/navbar.php"); ?>
        <main>
            <?php if (!empty($recipes)) { ?>
                <div class="grid recipe-grid">
                    <?php recipe($recipes, $saved, 0); ?>
                    <?php recipe($recipes, $saved, 1); ?>
                    <?php recipe($recipes, $saved, 2); ?>
                </div>
                <a href="/search?reload=1" class="cta carica">Carica altre Ricette</a>
            <?php } else { ?>
                <p class="desc">La ricerca non ha prodotto risultati! 
                   <a href="/create-recipe" class="link">Crea tu la tua nuova ricetta</a>
                </p>
            <?php } ?>
        </main>
        <?php require_once("base/footer.php"); ?>
    </body>
</html>
