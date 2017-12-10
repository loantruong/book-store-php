<?php
    //démarrer les sessions
    session_start();

    //vider les sessions
    session_unset();

    //supprimer les sessions
    session_destroy();

    //rediriger vers la page d'accueil
    header("location:../index.php?deconnexion");
    exit();

?>