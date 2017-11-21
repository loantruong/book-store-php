<?php
    $titrePage = "Modifier mon compte";
    require_once "includes/header_admin.php";
    
?>

<!-- Afficher les msg de succès et d'erreur -->
<?php
   messageErreur("modifier_membre_admin", "problème avec le changement de rôle");
    
?>

<!-- Boutons supprimer des livres -->
<div>
    <a href="liste_membre.php">retour</a>
</div>

<!-- Récupération des infos de l'id du livre à modifier -->
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
    // Récap des infos du livre 
        $membres = mysqli_fetch_array($exec);
        $prenom = $membres["prenom_membre"];
        $nom = $membres["nom_membre"];
        $mail = $membres["mail_membre"];
        $login = $membres["login_membre"];
        $role = $membres["role_membre"];
        $avatar = $membres["avatar_membre"];
    }
?>

<!-- Forumulaire de modification du membre - Affichage -->
<form method="post" action="" enctype="multipart/form-data">
    <div>
        <label for="prenom">Prénom : </label>
        <input type="text" name="prenom" id="prenom" value="<?php echo $prenom ?>" disabled>
    </div>
    <div>
        <label for="nom">Nom* : </label>
        <input type="text" name="nom" id="nom" value="<?php echo $nom ?>" disabled>
    </div>
    <div>
        <label for="mail">Mail* : </label>
        <input type="text" name="mail" id="mail" value="<?php echo $mail ?>" disabled>
    </div>
    <div>
        <label for="login">Login : </label>
        <input type="date" name="login" id="login" value="<?php echo $login ?>" disabled>
    </div>
    <div>
        <select name="role" id="role">
            <?php
                //récupérer les catégories de la bdd
                $select = "SELECT * FROM roles";
                $exec = mysqli_query($co, $select);
            
                while($roles = mysqli_fetch_array($exec)){
                    if($roles[0] == $role){
                         echo "<option selected>" . $roles[0] . "</option>";
                    }else{
                         echo "<option>" . $roles[0] . "</option>";
                    }
                }   
            ?>
        </select>
    </div>
  
    <div>
        <label for="avatar">Avatar : </label > 
        <?php 
            if(!empty($avatar)){
              $avatar = "<img src='" . $avatar . "' alt='Avatar de $login' width='50'>";
            }else{
              $avatar = "";
            }
        
            echo $avatar;
        ?>
    </div>

    <div>
        <input type="submit" value="Enregistrer" name="envoyer">
    </div>
</form>

<!-- Forumulaire de modification du membre - Traitement -->
<?php
    if(isset($_POST["envoyer"])){
        //Récupérer les infos du formulaire
        $role = $_POST["role"];
        
        //requêter pour modifer le membre dans la bdd
        $update = "UPDATE membres SET role_membre = '$role' WHERE login_membre = '$login'";
        
        $exec = mysqli_query($co, $update);
        
        if(!exec){
            //tester si ça marche pas
            //echo mysqli_error($co);
            header("location:modifier_membre_admin.php?erreurRequete&role=$role");
            exit();
        }else{
            
            header("location:liste_membre.php?modifierMembreAdmin");
            exit();
        }
        
    }
?>


<?php
    require_once "includes/footer.php"
?>