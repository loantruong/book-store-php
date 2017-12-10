<?php
    require_once "includes.php";
?>

<!--Vérifier si connecté-->
<?php 
    //on check si elle est pas connecté si on la redirige vers le login
    if(!isset($_SESSION["login"])){
        header ("location:login.php?interdit");
        exit();
    }
?>

<!-- Vérifier le rôle editeur -->
<?php
    //on check si l'utilisateur à le bon rôle
    if($_SESSION["role"] != "admin"){
        header("location:insufficient_role.php");
        exit();
    }
?>


<?php
    // fait appel au fichier 'header.php'
    require_once "header.php";
?>