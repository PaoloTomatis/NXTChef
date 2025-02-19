<?php
session_start();
require_once("includes/dbh.inc.php");
require_once("base/recipes.php");

if(isset($_GET["idUser"])){
    $idUser=$_GET["idUser"];
    $query="SELECT username, email, privacy, date FROM users WHERE id=:idUser";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam("idUser", $idUser);
    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    if($user["privacy"]==0){
        $link = !empty($_SESSION["pages"]) ? end($_SESSION["pages"]) : null;
        $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Account Privato", "testo"=>"Non è possibile visualizzare le informazioni di questo account in quanto sia privato e tu non ne sia il proprietario", "link"=>$link, "cta"=>"Torna Indietro"];
        header("Location: /avviso");
        die();
    }
}elseif (isset($_SESSION["user"])) {
    $idUser=$_SESSION["user"]["id"];
    $query="SELECT username, email, privacy, date FROM users WHERE id=:idUser";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam("idUser", $idUser);
    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
}else{
    header("Location: /login");
    die();
}

$date=date("d/m/Y", strtotime($user["date"]));

$query = "SELECT recipes.* FROM recipes JOIN saved ON recipes.id = saved.idRep WHERE saved.idUser = :idUser";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!empty($recipes)){
    $recipes = array_chunk($recipes, ceil(count($recipes) / 3));
}

$query = "SELECT * FROM saved WHERE idUser = :idUser";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":idUser", $idUser);
$stmt->execute();
$saved = $stmt->fetchAll(PDO::FETCH_ASSOC);


$_SESSION["pages"][]=$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || Account", "account") ?>
    <body>
        <?php require_once("base/navbar.php") ?>
        <main>
            <div class="profile-cont">
                <div class="profile-img-cont">
                    <img src="assets/account.png" alt="Profile Image" class="profile-img img">
                </div>
                <h1 class="profile-txt"><?php echo htmlspecialchars($user["username"]) ?></h1>
            </div>
            <div class="info-cont grid">
                <div class="col-50">
                    <p class="info-txt"><b>Email:</b> <?php echo htmlspecialchars($user["email"]) ?></p>
                    <p class="info-txt"><b>Data di Creazione</b>: <?php echo htmlspecialchars($date) ?></p>
                </div>
                <div class="col-50">
                    <?php $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Eliminazione Account", "testo"=>"Sei sicuro di voler eliminare il tuo account? Tutti i tuoi dati verranno cancellati e saranno irrecuperabili", "link"=>"/actions/accountDelete.inc.php", "cta"=>"Conferma"]; ?>
                    <a href="/avviso" class="cta">Elimina Account</a>
                    <a href="/actions/logout.inc.php" class="cta">Logout</a>
                </div>
            </div>
            <div class="distancer"></div>
            <?php if (!empty($recipes)){ ?>
                <?php recipe($recipes, $saved, 0); ?>
                <?php recipe($recipes, $saved, 1); ?>
                <?php recipe($recipes, $saved, 2); ?>
            <?php }else{ ?>
            <p class="desc">Non hai salvato alcuna ricetta! <a href="/" class="link">Scoprine di nuove</a></p>
            <?php } ?>
        </main>
        <?php require_once("base/footer.php") ?>
    </body>
</html>