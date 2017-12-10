<?php
    $titrePage = "Logs";
    require_once "includes/header_admin.php";
    
?>

<!-- Bouton d'admin du site -->
<div>
    <a href="admin_site.php">retour</a>
</div>

<!-- Lecture des logs txt -->
<?php
    //ajouts de livres
    echo "<h2>Ajout de livre</h2>";
    $log = fopen("logs/add_book.txt", "r");
    $lecture = fread($log, filesize("logs/add_book.txt"));
    
    //pour faire des sauts à la ligne
    $lecture = str_replace("\r\n", "<br>", $lecture);

    echo $lecture;
    fclose($log);


    //connexions
    echo "<h2>Logs -Connexions</h2>";
    $log = file("logs/connexions.txt");
    //Afficher toutes les lignes
    /*
        avec foreach
        foreach($log as $valeur){
        echo $valeur . "<br>";
    }*/

    //avec un FOR
    for($i=0; $i<count($log); $i++){
        echo $log[$i] . "<br>";
    }
    
    echo "<br>";

    //Afficher les 2 dernières lignes en partant de la fin
    for($i=count($log)-1; $i>=count($log)-2; $i--){
        echo $log[$i] . "<br>";
    }
    
?>



   
<?php
    require_once "includes/footer.php"
?>

