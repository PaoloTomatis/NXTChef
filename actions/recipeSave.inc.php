<?php

session_start();
require_once("../includes/dbh.inc.php");
require_once("../includes/checkLogin.inc.php");

$idUser=$_SESSION["user"]["id"];

if (!isset($_GET["idRep"])){header("Location: /");die();}
$idRep=$_GET["idRep"];

$query="SELECT * FROM saved WHERE idRep=:idRep";
$stmt=$pdo->prepare($query);
$stmt->bindParam("idRep", $idRep);
$stmt->execute();
$saved=$stmt->fetch(PDO::FETCH_ASSOC);

$query="SELECT * FROM recipes WHERE id=:idRep";
$stmt=$pdo->prepare($query);
$stmt->bindParam("idRep", $idRep);
$stmt->execute();
$recipe=$stmt->fetch(PDO::FETCH_ASSOC);

if($recipe["privacy"]==0 and $recipe["idUser"]!=$idUser){
    $link = !empty($_SESSION["pages"]) ? end($_SESSION["pages"]) : null;
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Ricetta Privata", "testo"=>"Non è possibile salvare questa ricetta in quanto sia privata e tu non ne sia il proprietario", "link"=>$link, "cta"=>"Torna Indietro"];
    header("Location: /avviso");
    die();
}

if(!empty($saved)){
    $idSaved=$saved["id"];
    $query="DELETE FROM saved WHERE id=:idSaved";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam("idSaved", $idSaved);
    $stmt->execute();
}else{
    $query="INSERT INTO saved (idUser, idRep) VALUES (:idUser, :idRep)";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam("idUser", $idUser);
    $stmt->bindParam("idRep", $idRep);
    $stmt->execute();
}

$link = !empty($_SESSION["pages"]) ? end($_SESSION["pages"]) : null;
header("Location: $link");