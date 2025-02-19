<?php

session_start();
require_once("../includes/dbh.inc.php");

if($_SERVER["REQUEST_METHOD"]!="GET"){
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Codice non Valido", "testo"=>"Questo codice è errato o non è presente", "link"=>"login", "cta"=>"Prova Login"];
    header("Location: /avviso");
    die();
}
$code=$_GET["code"];

$query="SELECT * FROM verifications WHERE code=:code";
$stmt=$pdo->prepare($query);
$stmt->bindParam("code", $code);
$stmt->execute();
$verifications=$stmt->fetch(PDO::FETCH_ASSOC);

if(empty($verifications)){
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Codice non Valido", "testo"=>"Questo codice è errato o non è presente", "link"=>"login", "cta"=>"Prova Login"];
    header("Location: /avviso");
    die();
}

$query="UPDATE users SET verified=1 WHERE id=:idUser";
$stmt=$pdo->prepare($query);
$stmt->bindParam("idUser", $verifications["idUser"]);
$stmt->execute();

$query="DELETE FROM verifications WHERE id=:idVer";
$stmt=$pdo->prepare($query);
$stmt->bindParam("idVer", $verifications["id"]);
$stmt->execute();

$_SESSION["avviso"]=["tipo"=>"info", "titolo"=>"Account Verificato", "testo"=>"L'account è stato verificato. Effettua il login e sarai pronto per gustarti le tue nuove ricette!", "link"=>"login", "cta"=>"Effettua Login"];
header("Location: /avviso");
die();