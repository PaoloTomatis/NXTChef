<?php

session_start();
require_once("../includes/dbh.inc.php");

if ($_SERVER["REQUEST_METHOD"]!="POST"){header("Location: /login");die();}
$email=$_POST["email"];
$psw=$_POST["psw"];

$query="SELECT * FROM users WHERE email=:email";
$stmt=$pdo->prepare($query);
$stmt->bindParam("email", $email);
$stmt->execute();
$user=$stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_SESSION["tryPsw"])){
    if($_SESSION["tryPsw"]>5){
        $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Tentativi Finiti", "testo"=>"Hai tentato troppe volte di accedere da questo dispositivo senza successo, riprova più tardi!", "link"=>"login", "cta"=>"Riprova"];
        header("Location: /avviso");
        die();
    }
}else{
    $_SESSION["tryPsw"]=0;
}

if(empty($user)){
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Errore Login", "testo"=>"Email o password errata, riprova!", "link"=>"login", "cta"=>"Riprova"];
    header("Location: /avviso");
    die();
}

if(!password_verify($psw, $user["psw"])){
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Errore Login", "testo"=>"Email o password errata, riprova!", "link"=>"login", "cta"=>"Riprova"];
    header("Location: /avviso");
    die();
    if(!isset($_SESSION["tryPsw"])){$_SESSION["tryPsw"]=1;}else{$_SESSION["tryPsw"]+=1;}
}

$_SESSION["user"]=[];
$_SESSION["user"]["id"]=$user["id"];
$_SESSION["user"]["username"]=$user["username"];
$_SESSION["user"]["email"]=$user["email"];
$_SESSION["user"]["verified"]=$user["verified"];
$_SESSION["user"]["privacy"]=$user["privacy"];
$_SESSION["user"]["date"]=$user["date"];


header("Location: /");
die();