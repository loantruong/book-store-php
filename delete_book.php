<?php
    $titrePage = "Supprimer un livre";
    require_once "includes/header_editor.php";
    
?>

<!-- Afficher les msg de succès et d'erreur -->
<?php
    errorMsg("erreur", "petit problème avec la suppression");
?>

<!-- Boutons supprimer des livres -->
<div>
    <a href="delete_book.php">Supprimer un livre</a>
</div>

<!-- Récupérer les informations de l'id livre que je souhaite supprimer -->
<?php 
    
    //requête SQL
    $id = $_GET["id"];
    $select = "SELECT * FROM livres WHERE id_livre=$id";
    //exécute
    $exec = mysqli_query($co, $select);

    //msg erreur si pb (pas nécessaire ici que quand il peut y avoir un problème de requête)
    /*if(!$exec){
        echo "<p>problème de requête : <br>";
        echo mysqli_error($co) . "</p>";
        exit();
    }else{*/
        //créer le récap des infos du livre
        $livre = mysqli_fetch_array($exec);
            $titre = $livre["titre_livre"];
            $auteur = $livre["auteur_livre"];
            $categorie = $livre["categorie_livre"];
            $date_edition = $livre["date_edition_livre"];
            $resume = $livre["resume_livre"];
            
            
            echo "<ol>";
            echo "<li>$titre</li>";
            echo "<li>$auteur</li>";
            echo "<li>$categorie</li>";
            echo "<li>$date_edition</li>";
            echo "<li>$resume</li>";
            echo "</ol>";
    /*}*/

?>

    <form method="post" action="">
        <input type="submit" name="envoyer" value="Confirmer la suppression">
    </form>
    
    <!-- quand on clique sur 'confirmer' -->
    
    <?php 
    if(isset($_POST["envoyer"])){
        $delete = "DELETE FROM livres WHERE id_livre=$id";
        $exec = mysqli_query($co, $delete);
        
        //pour prévenir l'utilisateur si son action a fonctionné
        if(!$exec){
        header("location:delete_book.php?erreur&id=$id");
        exit();
        }else{
            header("location:admin_books.php?suppression");
            exit();
        }
    }
    
    ?>

<?php
    require_once "includes/footer.php"
?>
