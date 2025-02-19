<?php

session_start();
require_once("../includes/dbh.inc.php");

function generatorCode(int $length): string {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomCode;
}

if ($_SERVER["REQUEST_METHOD"]!="POST"){header("Location: /login");die();}
$username=$_POST["username"];
$email=$_POST["email"];
$psw=password_hash($_POST["psw"], PASSWORD_DEFAULT);

$query="SELECT * FROM users WHERE email=:email";
$stmt=$pdo->prepare($query);
$stmt->bindParam("email", $email);
$stmt->execute();
$user1=$stmt->fetch(PDO::FETCH_ASSOC);

$query="SELECT * FROM users WHERE email=:email";
$stmt=$pdo->prepare($query);
$stmt->bindParam("email", $email);
$stmt->execute();
$user2=$stmt->fetch(PDO::FETCH_ASSOC);

if (!empty($user1)){
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Email Registrata", "testo"=>"Email già registrata, prova ad effettuare il login", "link"=>"login", "cta"=>"Prova Login"];
    header("Location: /avviso");
    die();
}

if (!empty($user2)){
    $_SESSION["avviso"]=["tipo"=>"errore", "titolo"=>"Username non Disponibile", "testo"=>"Questo username è già stato scelto da qualcun'altro. Sfoggia la tua creatività e scegline un'altro!", "link"=>"login", "cta"=>"Prova Login"];
    header("Location: /avviso");
    die();
}

$query="INSERT INTO users (username, email, psw) VALUES (:username, :email, :psw)";
$stmt=$pdo->prepare($query);
$stmt->bindParam("username", $username);
$stmt->bindParam("email", $email);
$stmt->bindParam("psw", $psw);
$stmt->execute();

$query="SELECT * FROM users WHERE username=:username AND email=:email";
$stmt=$pdo->prepare($query);
$stmt->bindParam("username", $username);
$stmt->bindParam("email", $email);
$stmt->execute();
$user=$stmt->fetch(PDO::FETCH_ASSOC);

$code=generatorCode(15);

$query="INSERT INTO verifications (idUser, code) VALUES (:idUser, :code)";
$stmt=$pdo->prepare($query);
$stmt->bindParam("idUser", $user["id"]);
$stmt->bindParam(":code", $code);
$stmt->execute();

$link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/verify.inc.php?code=" . $code;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$message = "Verifica il tuo account NXTCHEF premendo su questo link e inizia a divertiti in cucina: <a href='$link'>$link</a>";

mail($email, "Verifica Account NXTCHEF", $message, $headers);

$_SESSION["avviso"]=["tipo"=>"info", "titolo"=>"Verifica Account", "testo"=>"E' stata inviata un'email all'indirizzo specificato con le istruzioni per completare la registrazione. (puoi chiudere questa pagina)", "link"=>"", "cta"=>"Home"];
header("Location: /avviso");