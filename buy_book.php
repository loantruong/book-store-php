<?php
    $titrePage = "Administration des livres";
    require_once "includes/header_member.php";
    
?>


<!-- Bouton d'achat -->
<p>
    <a href="buy_book.php">acheter des livres</a>
</p>


<!-- Afficher les msg de succès et d'erreur -->
<?php

?>

<!-- Boutons d'administration des livres -->
<div>
    <a href="add_book.php">Ajouter un livre</a>
</div>

<?php
//cookie livre ajout ou supp
                    
     if(isset($_GET["id"])){
         $id = $_GET["id"];
     }
    //enlève un livre            
     if(isset($_GET["soustrerLivre"])){
         if($_COOKIE[$id] > 0){
         //récupération de la valeur, moins 1, temps
         setcookie($id, --$_COOKIE[$id], time()+3600);
        }
     }
        
    //ajout un livre
     if(isset($_GET["ajouterLivre"])){ 
        setcookie($id, ++$_COOKIE[$id], time()+3600);
     }

?>

<table id="liste_bibliotheque">
    <tr>
        <th>titre du livre</th>
        <th>auteur</th>
        <th>catégorie</th>
        <th>date et édition</th>
        <th>résumé</th>
        <th class="space_tbl">quantité</th>
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

                while($livres = mysqli_fetch_array($exec)){
                    
                    // définition variable par rapport bdd
                    $id = $livres["id_livre"];
                    $titre = $livres["titre_livre"];
                    $auteur = $livres["auteur_livre"];
                    $categorie = $livres["categorie_livre"];
                    $date_edition = $livres["date_edition_livre"];
                    $resume = $livres["resume_livre"];
                    
                    
                    //si le livre non-présent dans cookies alors on le crée et on le met à 0
                    if(!empty($_COOKIE[$id])){
                        $qte = $_COOKIE[$id];
                    }else{
                        $qte = 0;
                    }
                    
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
                    echo "<td class='min_width_quantite'>              
                                <a href='buy_book.php?soustrerLivre&id=$id'>
                                    <img src='img/moins.png' alt='supprimer un'>
                                </a>
                                " . $qte ."
                                <a href='buy_book.php?ajouterLivre&id=$id'>
                                    <img src='img/plus.png' alt='ajouter un'>
                                </a>
                        </td>";
                    echo "</tr>";
                }
            }
    ?>
     
</table>

<p>
    <a href="panier.php">
        <img src="img/bouton_achat.png" width="150px">
    </a>
</p>

   
<?php
    require_once "includes/footer.php"
?>

