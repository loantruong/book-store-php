n<?php
    $titrePage = "Panier";
    require_once "includes/header_member.php";
    
?>


<!-- Bouton retour -->
<p>
    <a href="buy_book.php">retour</a>
</p>




<!-- Récap commande - Calculs -->
<?php
    $qte = 0;
    $prix = 25;
    $ht = 0;
    $ttc = 0;
    
    //parcourir tous les cookies du nom de domaine
    foreach($_COOKIE as $index=>$valeur){
        
        //récupérer le type de l'index
        $type = getType($index);
        
        //vérifier si index numérique 
        if($type == "integer"){
            $qte += $valeur;
        }
    }

    $ht = $qte*$prix;
    $ttc = $ht*1.2;
?>

<p>1 livre => <?php echo $prix?>€ HT</p>

<!-- Récap commande - Affichage -->
<section>
    <p>nombre de livre commandé : <?php echo $qte ?><br>
        coût HT : <?php echo $ht ?>€<br>
        coût TTC : <?php echo $ttc ?>€
</section>
   
<?php
    require_once "includes/footer.php"
?>

