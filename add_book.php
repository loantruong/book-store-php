<?php
    $titrePage = "Ajouter un nouveau libre à la bibliothèque";
    require_once "includes/header_editor.php";
?>

<!-- Message d'erreur -->
<?php
    messageErreur("erreur", "ATTENTION le titre est obligatoire !");
    messageErreur("erreurSQL", "Problème SQL");
    messageErreur("erreurDate", "Le format de date incorrect : ");

?>

<!--Création du formulaire -->
<form method="post" action="">
    <div>
        <label for="titre">Titre* : </label>
        <input type="text" name="titre" id="titre" value="<?php ecrireGet("titre") ?>">
    </div>
    <div>
        <label for="auteur">Auteur : </label>
        <!--<input type="text" name="auteur" id="auteur">-->
        <!-- afficher option de la liste -->
        <select name="auteur" id="auteur">
            <?php
                //récupérer les catégories de la bdd
                $select = "SELECT * FROM auteurs";
                $exec = mysqli_query($co, $select);
                while($auteurs = mysqli_fetch_array($exec)){
                    echo "<option value='" . $auteurs[0] . "'>" . $auteurs[1] . $auteurs[2] . "</option>";
                }   
            ?>
        </select>
    </div>
    <div>
        <label for="categorie">Catégorie : </label>
        <!--<input type="text" name="categorie" id="categorie">-->
        <!-- afficher option de la liste -->
        <select name="categorie" id="categorie">
            <?php
                //récupérer les catégories de la bdd
                $select = "SELECT * FROM categories";
                $exec = mysqli_query($co, $select);
                while($categories = mysqli_fetch_array($exec)){
                    echo "<option>" . $categories[0] . "</option>";
                }   
            ?>
        </select>
        
    </div>
    <div>
        <label for="date">Date et Edition : </label>
        <input type="date" name="date" id="date" placeholder="JJ/MM/AAAA">
    </div>
    <div>
        <label for="resume">Résumé : </label>
        <textarea name="resume" id="resume"></textarea>
    </div>
    <div>
        <input type="submit" value="Ajouter" name="envoyer">
    </div>
</form>

<!-- traitement du formulaire -->
<?php
    //si on clique sur envoyer
    if(isset($_POST["envoyer"])){
        //si on clique sur "envoyer sans remplir le 'titre' 
        if(empty($_POST["titre"])){
            header("location:add_book.php?titre=" .$_POST["titre"] . "&erreur");
            exit();
        }
        
        //récupération des infos du formulaire
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
                header("location:ajouter_livre.php?erreurDate&titre=$titre");
                exit();
            }
        }else{
                //pour firefox : ajout de la valeur par défaut
                $date = "2017-02-02";
            }

        //préparer la requête SQL d'ajout
        $insert = "INSERT INTO livres(titre_livre, auteur_livre, categorie_livre, date_edition_livre, resume_livre) VALUES('$titre', '$auteur', '$categorie', '$date', '$resume')";

        //exécuter la requête
        $exec = mysqli_query($co, $insert);
        
        
        //Afficher un message si erreur de requête
        if(!$exec){
            echo "<p>Problème de requête : <br>";
            //msg d'erreur pour mysql
            echo mysqli_error($co) . "</p>";
            
            
            //si problème la valeur du titre est réécrit dans la zone du titre
            //header("location:ajouter_livre.php?erreurSQL&titre=$titre");
            //exit();
        }else{
            
            //Remplir le fichier de log d'ajout de livre
            $log = fopen("logs/ajout_livre.txt", "a+");
            fwrite($log, "Nouveau livre ($titre) ajouté par " . $_SESSION["login"] . " le " . strftime("%d/%m/%Y à %H:%M", time()).
            "\r\n") ;
            fclose($log);
            
            header("location:admin_books.php?ajout");
            exit();
        }
        
                //vérifier si correctement récupéré
        //echo "<p>$titre $auteur $categorie $date $resume</p>";
    }
    
?>


<?php
    require_once "includes/footer.php"
?>
