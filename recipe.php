<?php
session_start();
require_once("includes/dbh.inc.php");

if(!isset($_GET["idRep"])){header("Location: /");die();}
$idRep=$_GET["idRep"];

$query="SELECT * FROM recipes WHERE id=:idRep";
$stmt=$pdo->prepare($query);
$stmt->bindParam("idRep", $idRep);
$stmt->execute();
$recipe=$stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_SESSION["user"])){
    $idUser=$_SESSION["user"]["id"];
}else{
    $idUser=-1;
}

if($recipe["privacy"]==0 and $recipe["idUser"]!=$idUser){
    $link = !empty($_SESSION["pages"]) ? end($_SESSION["pages"]) : null;
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Ricetta Privata", "testo"=>"Non è possibile visualizzare questa ricetta in quanto sia privata e tu non ne sia il proprietario", "link"=>$link, "cta"=>"Torna Indietro"];
    header("Location: /avviso");
    die();
}

$query = "SELECT i.name, ri.quantity FROM recipe_ingredients ri JOIN ingredients i ON ri.idIng = i.id WHERE ri.idRep = :idRep";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":idRep", $idRep, PDO::PARAM_INT);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);


$_SESSION["pages"][]=$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || ".$recipe["name"], "recipe") ?>
    <body>
        <?php require_once("base/navbar.php") ?>
        <main>
            <div class="tit-cont">
                <img src="assets/NXTCHEFLogo.png" alt="Recipe IMG" class="tit-img">
                <h1 class="tit-tit"><?php echo htmlspecialchars($recipe["name"]) ?></h1>
                <a href="/recipeSave/<?php echo htmlspecialchars($recipe["id"]) ?>" class="save">+</a>
                <a href="/share/<?php echo htmlspecialchars($recipe["id"]) ?>" class="save">🔗</a>
            </div>
            <div class="distancer"></div>
            <div class="desc-cont">
                <p class="desc-desc"><?php echo htmlspecialchars($recipe["descrizione"]) ?></p>
            </div>
            <div class="ings-cont">
                <h2 class="ings-tit">Ingredienti:</h2>
                <ul class="ings-list">
                    <?php foreach($ingredients as $ingredient=>$quantity){ ?>
                        <li class="ing"><p class="ing-name"><?php echo htmlspecialchars($ingredient) ?></p><p class="ing-quantity"><b><?php echo htmlspecialchars($quantity) ?></b></p></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="distancer"></div>
        </main>
        <?php require_once("base/footer.php") ?>
    </body>
</html>