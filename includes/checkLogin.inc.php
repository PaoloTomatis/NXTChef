<?php

if (!isset($_SESSION["user"])){
    header("Location: /login");
    die();
}