<?php

    $categorie = $_POST["categorie"];

    $titrePage = "Filtre $categorie";
    require_once "includes/header_membre.php";
    
?>

<!-- Afficher les msg de succès et d'erreur -->
<?php
        //livre supprimé ok 
        messageSucces("suppression", "votre livre a bien été supprimé !");
        //livre modification ok 
        messageSucces("modification", "votre livre a bien été modifié !");
?>


<?php
    include_once "filtre_option.php";
?>

<div>
    <a href="admin_livres.php">retour à la liste</a>
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
    
    <!-- récupérer les infos du formulaire de filtre -->
<?php
        
        //prépare la requête
        $select = "SELECT * FROM livres WHERE categorie_livre = '$categorie'";
        $exec = mysqli_query($co, $select);
    
        //pour récupérer *livre catégorie
    
        while($filtre = mysqli_fetch_array($exec)){
         //afficher la requête
        // définition variable par rapport bdd
                    $id = $filtre["id_livre"];
                    $titre = $filtre["titre_livre"];
                    $auteur = $filtre["auteur_livre"];
                    $categorie = $filtre["categorie_livre"];
                    $date_edition = $filtre["date_edition_livre"];
                    $resume = $filtre["resume_livre"];
                    
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
    
        

?>
    
    
     
</table>

   
<?php
    require_once "includes/footer.php"
?>

