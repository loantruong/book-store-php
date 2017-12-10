<?php
    $titrePage = "Création d'un nouveau membre";
    require_once "includes/header_public.php";
    
?>

<!-- Afficher les msg de succès et d'erreur -->
<?php
    messageErreur("erreurLogin", "Oups, le login existe déjà, veuillez en choisir un autre");
    messageErreur("erreurMdp", "Oups, les mots de passe sont différents");
    messageErreur("erreurRequete", "Oups, problème de requête/contactez-nous");
    messageErreur("erreurType", "Oups, problème de fichier (fichier accepté JPEG ou PNG)");
    messageErreur("erreurTaille", "Oups, votre fichier est trop grand. (Il doit faire max 500x500px)");
    messageErreur("erreurDeplacer", "Oups, Impossible de récupérer votre image ....snif");
    messageErreur("erreurLourd", "Oups, image trop lourde ....snif");
?>

<!-- Boutons supprimer des livres -->
<div>
    <a href="login.php">retour</a>
</div>

<!--Création du formulaire -->
<form method="post" action="" enctype="multipart/form-data">
    <div>
        <label for="prenom">Prénom* : </label>
        <input type="text" name="prenom" id="prenom" value="<?php ecrireGet("prenom")?>">
    </div>
    <div>
        <label for="nom">Nom* : </label>
        <input type="text" name="nom" id="nom" value="<?php ecrireGet("nom")?>">
    </div>
    <div>
        <label for="mail">Mail* : </label>
        <input type="text" name="mail" id="mail" value="<?php ecrireGet("mail")?>">
    </div>
    <div>
        <label for="login">Login : </label>
        <input type="date" name="login" id="login" value="<?php ecrireGet("login")?>">
    </div>
    <div>
        <label for="mdp1">Mot de passe : </label>
        <input type="password" name="mdp1" id="mdp1">
    </div>
    <div>
        <label for="mdp2">Confirmation Mot de passe : </label>
        <input type="password" name="mdp2" id="mdp2">
    </div>
    <div>
        <label for="avatar">Avatar : </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="10000">
        <input type="file" name="avatar" id="avatar">
    </div>

    <div>
        <input type="submit" value="Créer un compte" name="envoyer">
    </div>
</form>

<?php
    if(isset($_POST["envoyer"])){
        //Récupérer les infos du formulaire
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $mail = $_POST["mail"];
        $login = $_POST["login"];
        $mdp1 = $_POST["mdp1"];
        $mdp2 = $_POST["mdp2"];
        //créer le chemin du dossier img au cas où pb
        $chemin = "";
        
        //changer la casse
        $prenom = ucfirst($prenom); // 1ère lettre en Majuscule
        $nom = strtoupper($nom);// tout en MAJ
        $login = strtolower($login); // tout en minuscule
        
        
        //Vérifier si login déjà existant
            //faire une requête : vérifier si login déjà existant
            $select = "SELECT count(*) FROM membres WHERE login_membre='$login'";
            //exécute la requête
            $exec = mysqli_query($co, $select);
            $membre = mysqli_fetch_array($exec);
            
            //afficher le tbl pour voir les indexs
            //var_dump($membre);
            //si erreur (1= existe)
            if($membre[0] == 1){
                header("location:add_member.php?erreurLogin&prenom=$prenom&nom=$nom&mail=$mail");
                exit();
            }
        
        //Vérifier si mdp1 est identique à mdp2
        if($mdp1 != $mdp2){
            header("location:add_member.php?erreurMdp&prenom=$prenom&nom=$nom&mail=$mail&login=$login");
            exit();
        }
        
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
                    $chemin = "img/avatars/avatar_$login" . "$ext";
                    //déplacer le fichier
                    $deplacer = move_uploaded_file($_FILES["avatar"]["tmp_name"], $chemin);
                    //test pour savoir si ça à marché
                    if(!$deplacer){
                        header("location:add_member.php?erreurDeplacer&prenom=$prenom&nom=$nom&mail=$mail&login=$login");
                        exit();
                    }
                    
                }else{
                    header("location:add_member.php?erreurTaille&prenom=$prenom&nom=$nom&mail=$mail&login=$login");
                    exit();
                }
            }else{
                header("location:add_member.php?erreurType&prenom=$prenom&nom=$nom&mail=$mail&login=$login");
                exit();
            }
        }elseif(($_FILES["avatar"]["error"] == 1) || ($_FILES["avatar"]["error"] == 2)){
            //si image trop lourde
            header("location:add_member.php?erreurLourd&prenom=$prenom&nom=$nom&mail=$mail&login=$login");
            exit();
        }
        
        //requêter pour ajouter le membre à la bdd
        $insert = "INSERT INTO membres(
            prenom_membre, 
            nom_membre, 
            mail_membre, 
            role_membre, 
            login_membre, 
            mdp_membre,
            avatar_membre
            ) VALUES(
                '$prenom', 
                '$nom', 
                '$mail', 
                'Membre', 
                '$login', 
                PASSWORD('$mdp1'),
                '$chemin'
            )";
        
        $exec = mysqli_query($co, $insert);
        
        if(!exec){
            //tester si ça marche pas
            //echo mysqli_error($co);
            header("location:add_member.php?erreurRequete&prenom=$prenom&nom=$nom&mail=$mail&login=$login");
            exit();
        }else{
            //connecté la personne pour ne pas à avoir à entrer de nouveau ses id
            $_SESSION["login"] = $login;
            $_SESSION["role"] = "Membre";
            header("location:admin_books.php?nouveauMembre");
            exit();
        }
        
    }
?>


<?php
    require_once "includes/footer.php"
?>