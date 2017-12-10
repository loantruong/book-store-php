<?php
    //fonction qui affiche un msg de succès
    function sucessMsg($index, $msg){
        if(isset($_GET[$index])){
            echo "<p class='succes'>$msg</p>";
        }
    }
    
    //fonction qui affiche un message d'erreur
    function errorMsg($index, $msg){
        if(isset($_GET[$index])){
            echo "<p class='erreur'>$msg</p>";
        }
    }

    //function qui récupère la valeur du GET
    function getWrite($index){
        if(isset($_GET[$index])){
            echo $_GET[$index];
        }
    }

    
?>