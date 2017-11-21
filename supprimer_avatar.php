<?php
    $titrePage = "Supprimer votre avatar";
    require_once "includes/header_membre.php";
    
?>

<?php 
    $update = "UPDATE membres SET avatar_membre='' WHERE login_membre='$sessionLogin'";
    $exec = mysqli_query($co, $update);
    
    
    //pour afficher erreur ou renvoie personne vers admini livre
    if(!$exec){
        
        echo mysqli_error($co);
        //header("location:modifier_membre.php?erreurSupAvatar");
        exit();
    }else{
        header("location:modifier_membre.php?SupAvatar");
        exit();
    }
?>