<?php
    $titrePage = "Administration des livres";
    require_once "includes/header_membre.php";
    
?>


<!-- Bouton d'achat -->
<p>
    <a href="acheter_livre.php">acheter des livres</a>
</p>


<!-- Afficher les msg de succès et d'erreur -->
<?php
        //message de connexion réussi
        messageSucces("connexion", "vous voilà connecté !");
        //ajout livre ok
        messageSucces("ajout", "votre livre a bien été ajouté !");
        //livre supprimé ok 
        messageSucces("suppression", "votre livre a bien été supprimé !");
        //livre modification ok 
        messageSucces("modification", "votre livre a bien été modifié !");
        //nouveau membre
        messageSucces("nouveauMembre", "Bienvenue ! ");
        //modifcation membre ok
        messageSucces("modifierMembre", "Modification ok");
?>


<?php
    include_once "filtre_option.php";
?>

<!-- Boutons d'administration des livres -->
<div>
    <a href="ajouter_livre.php">Ajouter un livre</a>
</div>

<table id="liste_bibliotheque">
    <tr>
        <th>titre du livre</th>
        <th>auteur</th>
        <th>catégorie</th>
        <th>date et édition</th>
        <th>résumé</th>
        <th class="space_tbl">modifier</th>
        <th class="space_tbl">supprimer</th>
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
                
                //avec variable, plus lisible
                while($livres = mysqli_fetch_array($exec)){
                    
                    // définition variable par rapport bdd
                    $id = $livres["id_livre"];
                    $titre = $livres["titre_livre"];
                    $auteur = $livres["auteur_livre"];
                    $categorie = $livres["categorie_livre"];
                    $date_edition = $livres["date_edition_livre"];
                    $resume = $livres["resume_livre"];
                    
                    //transformer la date AAAA-MM-JJ en JJ/MM/AAAA
                    $date_edition = strftime("%d/%m/%Y", strtotime($date_edition));
                    
                    //récupérer les prénoms et noms des auteurs via leur id
                    $selectAuteurs = "SELECT * FROM auteurs INNER JOIN livres ON auteurs.id_auteur=livres.auteur_livre WHERE id_auteur=$auteur";
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
                    echo "<td class='text_center'>
                            <a href='modifier_livre.php?id=$id'>
                                <img src='img/modifier.png' alt='modifier'>
                            </a>
                        </td>";
                    echo "<td class='text_center'>
                            <a href='supprimer_livre.php?id=$id'>
                                <img src='img/supprimer.png' alt='supprimer'>
                            </a>
                        </td>";
                    echo "</tr>";
                }
            }
    ?>
     
</table>

   
<?php
    require_once "includes/footer.php"
?>

