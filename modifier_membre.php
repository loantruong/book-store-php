<?php
    $titrePage = "Modifier mon compte";
    require_once "includes/header_membre.php";
    
?>

<!-- Afficher les msg de succès et d'erreur -->
<?php
    messageErreur("erreurRequete", "Oups, problème de requête/contactez-nous");
    messageErreur("erreurType", "Oups, problème de fichier (fichier accepté JPEG ou PNG)");
    messageErreur("erreurTaille", "Oups, votre fichier est trop grand. (Il doit faire max 500x500px)");
    messageErreur("erreurDeplacer", "Oups, Impossible de récupérer votre image ....snif");
    messageErreur("erreurLourd", "Oups, image trop lourde ....snif");
    messageErreur("erreurSupAvatar", "OUps, problème avec la suppression de l'avatar");
    messageSucces("SupAvatar", "votre avatar a bien été supprimé");
?>

<!-- Boutons supprimer des livres -->
<div>
    <a href="login.php">retour</a>
</div>

<!-- Récupérer les informations du membre -->
<?php
    $select = "SELECT * FROM membres WHERE login_membre = '$sessionLogin'";
    $exec = mysqli_query($co, $select);
    $membre = mysqli_fetch_array($exec);

    $prenom = $membre["prenom_membre"];
    $nom = $membre["nom_membre"];
    $mail = $membre["mail_membre"];
    $avatar = $membre["avatar_membre"];

    
?>


<!-- Forumulaire de modification du membre - Affichage -->
<form method="post" action="" enctype="multipart/form-data">
    <div>
        <label for="prenom">Prénom* : </label>
        <input type="text" name="prenom" id="prenom" value="<?php echo $prenom ?>">
    </div>
    <div>
        <label for="nom">Nom* : </label>
        <input type="text" name="nom" id="nom" value="<?php echo $nom ?>">
    </div>
    <div>
        <label for="mail">Mail* : </label>
        <input type="text" name="mail" id="mail" value="<?php echo $mail ?>">
    </div>
    <div>
        <label for="login">Login : </label>
        <input type="date" name="login" id="login" value="<?php echo $sessionLogin ?>" disabled>
    </div>
  
    <div>
        <label for="avatar">Avatar : </label>
        
        <?php
            echo $avatarMembre;
        ?>
        
        <input type="hidden" name="MAX_FILE_SIZE" value="10000">
        <input type="file" name="avatar" id="avatar">
        
        <a href="supprimer_avatar">Supprimer Avatar</a>
    </div>

    <div>
        <input type="submit" value="Enregistrer" name="envoyer">
    </div>
</form>

<!-- Forumulaire de modification du membre - Traitement -->
<?php
    if(isset($_POST["envoyer"])){
        //Récupérer les infos du formulaire
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $mail = $_POST["mail"];
        
        //créer le chemin du dossier img au cas où pb
        $chemin = $avatar;
        
        //changer la casse
        $prenom = ucfirst($prenom); // 1ère lettre en Majuscule
        $nom = strtoupper($nom);// tout en MAJ
        
        
        //si Avatar il y a, alors vérification à faire
        //voir comment est le tbl
        //var_dump($_FILES);
        //exit();
        if($_FILES["avatar"]["error"] == 0){
            //vérifier si image (.jpg .png)
            //créer un tbl avec la liste de toutes les extensions qu'on accepte
            $extensions = array(".jpg", ".jpeg", ".png");
            //récupère la fin du nom fichier
            $ext = strrchr($_FILES["avatar"]["name"], ".");
            
            //chercher une fonction ds un tbl
            if(in_array($ext, $extensions)){
                //vérifier la résolution de l'image
                $taille = getimagesize($_FILES["avatar"]["tmp_name"]);
                
                //limiter la taille
                if(($taille[0] <= 500) && ($taille[1] <= 500)){
                    //Renommer et déplacer le fichier dans le bon dossier
                    //définir le chemin d'enregistrement
                    $chemin = "img/avatars/avatar_$sessionLogin" . "$ext";
                    //déplacer le fichier
                    $deplacer = move_uploaded_file($_FILES["avatar"]["tmp_name"], $chemin);
                    //test pour savoir si ça à marché
                    if(!$deplacer){
                        header("location:ajouter_membre.php?erreurDeplacer&prenom=$prenom&nom=$nom&mail=$mail");
                        exit();
                    }
                    
                }else{
                    header("location:ajouter_membre.php?erreurTaille&prenom=$prenom&nom=$nom&mail=$mail");
                    exit();
                }
            }else{
                header("location:ajouter_membre.php?erreurType&prenom=$prenom&nom=$nom&mail=$mail");
                exit();
            }
        }elseif(($_FILES["avatar"]["error"] == 1) || ($_FILES["avatar"]["error"] == 2)){
            //si image trop lourde
            header("location:ajouter_membre.php?erreurLourd&prenom=$prenom&nom=$nom&mail=$mail");
            exit();
        }
        
        //requêter pour modifer le membre dans la bdd
        $update = "UPDATE membres SET prenom_membre = '$prenom', nom_membre = '$nom', mail_membre = '$mail', avatar_membre = '$chemin'  WHERE login_membre = '$sessionLogin'";
        
        $exec = mysqli_query($co, $update);
        
        if(!exec){
            //tester si ça marche pas
            //echo mysqli_error($co);
            header("location:modifier_membre.php?erreurRequete&prenom=$prenom&nom=$nom&mail=$mail");
            exit();
        }else{
            
            header("location:admin_livres.php?modifierMembre");
            exit();
        }
        
    }
?>


<?php
    require_once "includes/footer.php"
?>