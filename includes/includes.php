<?php
    session_start();

    ob_start();
    
    //heure france
    date_default_timezone_set("Europe/Paris");
    
    require_once "connexion.php";
    require_once "functions.php";
?>
