<?php
    $titrePage = "Bienvenue dans la bibliothèque";
    require_once "includes/header_public.php";
?>


<!-- créer une cookie de bienvenue -->
<?php
    //cookie se créant sur la page d'accueil et durant 1 heure
    setcookie("bienvenue", "Bienvenue sur mon super site.", time()+3600);
    
?>


<!-- Bouton d'achat -->
<p>
    <a href="buy_book.php">acheter des livres</a>
</p>

<!-- Afficher un message de succès ou erreur -->
<?php 
    sucessMsg("deconnexion", "vous êtes maintenant déconnecté !");
?>

<table id="liste_bibliotheque">
    <tr>
        <th>titre du livre</th>
        <th>auteur</th>
        <th>catégorie</th>
        <th>date et édition</th>
        <th>résumé</th>
    </tr>
    <!-- récupérer les données de la table 'livres' -->
    <?php
            // prépare la requête SQL
            $select = "SELECT * FROM livres";
            //exécute la requête
            $exec = mysqli_query($co, $select);

            //affiche un msg si erreur de requête
            if(!$exec){
                echo "<p>problème de requête : <br>";
                echo msqli_error($co) . "</p>";
                exit();
            }else{ 
                // version pas très lisible
                /*while($livre = mysqli_fetch_assoc($exec)){
                    echo "<tr> <td>" . $livre["titre_livre"] . "</td>" . "<td>" . $livre["auteur_livre"] . "</td>" . "<td>" . $livre["categorie_livre"] . "</td>" . "<td>" . $livre["date_edition_livre"] . "</td>" . "<td>" . $livre["resume_livre"] . "</td> </tr>";
                }*/
                
                //avec variable, plus lisible
                while($livres = mysqli_fetch_array($exec)){
                    
                    // définition variable par rapport bdd
                    $titre = $livres["titre_livre"];
                    $auteur = $livres["auteur_livre"];
                    $categorie = $livres["categorie_livre"];
                    $date_edition = $livres["date_edition_livre"];
                    $resume = $livres["resume_livre"];
                    
                    //transformer la date AAAA-MM-JJ en JJ/MM/AAAA
                    $date_edition = strftime("%d/%m/%Y", strtotime($date_edition));
                    
                    //récupérer les prénoms et noms des auteurs via leur id
                    $selectAuteurs = "SELECT * FROM auteurs WHERE id_auteur=$auteur";
                    $execAuteurs = mysqli_query($co, $selectAuteurs);
                    $auteurs = mysqli_fetch_array($execAuteurs);
                    $auteur = $auteurs["prenom_auteur"] . " " . $auteurs["nom_auteur"];
                    
                    //création du tbl
                    echo "<tr>";
                    echo "<td>$titre</td>";
                    echo "<td>$auteur</td>";
                    echo "<td>$categorie</td>";
                    echo "<td>$date_edition</td>";
                    echo "<td>$resume</td>";
                    echo "</tr>";
                }
            }
    ?>
     
</table>

   
<?php
    require_once "includes/footer.php"
?>

