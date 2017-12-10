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


<?php
    // fait appel au fichier 'header.php'
    require_once "header.php";
?>