<?php
    $titrePage = "Modifier un livre";
    require_once "includes/header_editor.php";
    
?>

<!-- Afficher les msg de succès et d'erreur -->
<?php
    messageErreur("erreur", "petit problème avec la suppression");
    messageErreur("erreurModification", "petit problème avec la modification");
    messageErreur("erreurDate", "problème avec le format de la date");
?>

<!-- Boutons supprimer des livres -->
<div>
    <a href="update_book.php">Modifier un livre</a>
</div>

<!-- Récupération des infos de l'id du livre à modifier -->
<?php
    //requête SQL
    $id = $_GET["id"];
    $select = "SELECT * FROM livres WHERE id_livre=$id";
    //exécute
    $exec = mysqli_query($co, $select);  

    //msg erreur si pb (pas nécessaire ici que quand il peut y avoir un problème de requête)
    if(!$exec){
        echo "<p>problème de requête : <br>";
        echo mysqli_error($co) . "</p>";
        exit();
    }else{
    // Récap des infos du livre 
        $livre = mysqli_fetch_array($exec);
        $titre = $livre["titre_livre"];
        $auteur = $livre["auteur_livre"];
        $categorie = $livre["categorie_livre"];
        $date_edition = $livre["date_edition_livre"];
        $resume = $livre["resume_livre"];
}
?>

<!--création d'un formulaire avec les données existantes-->
<form method="post" action="">
    <div>
        <label for="titre">Titre* : </label>
        <input type="text" name="titre" id="titre" value="<?php echo $titre ?>">
    </div>
    <div>
        <label for="auteur">Auteur : </label>
        <!--<input type="text" name="auteur" id="auteur" value="<?php echo $auteur?>">-->
        <!-- afficher option de la liste -->
        <select name="auteur" id="auteur">
            <?php
                //récupérer les catégories de la bdd
                $select = "SELECT * FROM auteurs";
                $exec = mysqli_query($co, $select);
                
                while($auteurs = mysqli_fetch_array($exec)){
                    $auteurNom = $auteurs["prenom_auteur"] . " " . $auteurs["nom_auteur"];
                    
                    if($auteurs[0] == $auteur){
                         echo "<option selected value='" . $auteurs["id_auteur"] . "'> $auteurNom </option>";
                    }else{
                         echo "<option value='" . $auteurs["id_auteur"] . "'> $auteurNom </option>";
                    }
                }   
            ?>
        </select>
    </div>
    <div>
        <label for="categorie">Catégorie : </label>
        
         <!-- afficher option de la liste -->
        <select name="categorie" id="categorie">
            <?php
                //récupérer les catégories de la bdd
                $select = "SELECT * FROM categories";
                $exec = mysqli_query($co, $select);
            
                while($categories = mysqli_fetch_array($exec)){
                    if($categories[0] == $categorie){
                         echo "<option selected>" . $categories[0] . "</option>";
                    }else{
                         echo "<option>" . $categories[0] . "</option>";
                    }
                }   
            ?>
        </select>
        
    </div>
    <div>
        <label for="date">Date et Edition : </label>
        <input type="date" name="date" id="date" placeholder="JJ/MM/AAAA" value="<?php echo $date_edition ?>">
    </div>
    <div>
        <label for="resume">Résumé : </label>
        <textarea name="resume" id="resume"><?php echo $resume ?></textarea>
    </div>
    <div>
        <input type="submit" value="Modifier" name="envoyer" value="confirmer la modification">
    </div>

</form>

<!--envoie du formulaire de modification-->
<?php 
    if(isset($_POST["envoyer"])){
        //récupérer info du nouveau formulaire
        $titre = addslashes($_POST["titre"]);
        $auteur = $_POST["auteur"];
        $categorie = $_POST["categorie"];
        $date = $_POST["date"];
        $resume = addslashes($_POST["resume"]);
        
        //transformer la date (si saisie sous format JJ/MM/AAAA, alors transfromation en AAAA/MM/JJ)
        if(strpos($date, "/") != 0){
            list($jour, $mois, $annee) = explode("/", $date);
            //check si les 3 peuvent former une date : checkdate (version attendu pour le PHP)
            if(checkdate($mois, $jour, $annee)){
                //si ok, transforme la date d'édition tel que le veut SQL
                $date = "$annee-$mois-$jour";
            }else{
                header("location:update_book.php?erreurDate");
                exit();
            }
        }
        
        //envoie requête
        $update = "UPDATE livres SET titre_livre = '$titre', auteur_livre = '$auteur', categorie_livre = '$categorie', date_edition_livre = '$date', resume_livre = '$resume' WHERE id_livre=$id";
        
        //execute
        $exec = mysqli_query($co, $update);
        
        //
        
        //pour prévenir l'utilisateur si son action a fonctionné
        if(!$exec){
        //ajouter l'id pour récupérer le bon lien
        header("location:update_book.php?erreurModification&id=$id");
            //en mode dev : pour tester et cacher le header
            //echo mysqli_error($co);
        exit();
        }else{
            header("location:admin_books.php?modification");
            exit();
        }
    }
?>


<?php
    require_once "includes/footer.php"
?>
