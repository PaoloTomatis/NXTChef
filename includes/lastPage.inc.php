<?php

function lastPage(){
    $link=$_SESSION["page"];
    header("Location: $link");
    die();
}