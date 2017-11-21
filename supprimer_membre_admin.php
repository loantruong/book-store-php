<?php
    $titrePage = "Supprimer un membre";
    require_once "includes/header_editeur.php";
    
?>

<!-- Afficher les msg de succès et d'erreur -->
<?php
    messageErreur("erreurSupMembre", "petit problème avec la suppression du membre");
?>

<!-- Boutons supprimer des livres -->
<div>
    <a href="liste_membre.php">retour</a>
</div>

<?php
    //requête SQL
    $id = $_GET["id"];
    $select = "SELECT * FROM membres WHERE id_membre=$id";
    //exécute
    $exec = mysqli_query($co, $select);  

    //msg erreur si pb (pas nécessaire ici que quand il peut y avoir un problème de requête)
    if(!$exec){
        echo "<p>problème de requête : <br>";
        echo mysqli_error($co) . "</p>";
        exit();
    }else{
    // Récap des infos du membre
        $membres = mysqli_fetch_array($exec);
        $prenom = $membres["prenom_membre"];
        $nom = $membres["nom_membre"];
        $mail = $membres["mail_membre"];
        $login = $membres["login_membre"];
        $role = $membres["role_membre"];
        $avatar = $membres["avatar_membre"];
        
    }

    echo "<ul>";
            echo "<li>$prenom</li>";
            echo "<li>$nom</li>";
            echo "<li>$mail</li>";
            echo "<li>$login</li>";
            echo "<li>$role</li>";
        echo "</ul>";
?>

    <form method="post" action="">
        <input type="submit" name="envoyer" value="Confirmer la suppression">
    </form>
    
    <!-- quand on clique sur 'confirmer' -->
    
    <?php 
    if(isset($_POST["envoyer"])){
        $delete = "DELETE FROM membres WHERE id_membre=$id";
        $exec = mysqli_query($co, $delete);
        
        //pour prévenir l'utilisateur si son action a fonctionné
        if(!$exec){
        header("location:supprimer_membre_admin.php?erreurSupMembre");
        exit();
        }else{
            header("location:liste_membre.php?suppressionMembre");
            exit();
        }
    }
    
    ?>

<?php
    require_once "includes/footer.php"
?>
