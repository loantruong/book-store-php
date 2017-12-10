<?php
    $titrePage = "Logs";
    require_once "includes/header_admin.php";
    
?>

<?php
    messageSucces ("modifierMembreAdmin", "rôle modifé");
    messageSucces ("suppressionMembre", "membre supprimé");
?>

<table id="liste_bibliotheque">
    <tr>
        <th>prénom</th>
        <th>nom</th>
        <th>Email</th>
        <th>login</th>
        <th>rôle</th>
        <th>avatar</th>
        <th class="space_tbl">modifier</th>
        <th class="space_tbl">supprimer</th>
    </tr>
    <!-- récupérer les données de la table 'membre' -->
    <?php
            // prépare la requête SQL
            $select = "SELECT * FROM membres";
            //exécute la requête
            $exec = mysqli_query($co, $select);

            //affiche un msg si erreur de requête
            if(!$exec){
                echo "<p>problème de requête : <br>";
                echo msqli_error($co) . "</p>";
                exit();
            }else{
                

                while($membres = mysqli_fetch_array($exec)){
                    
                    // définition variable par rapport bdd
                    $id = $membres["id_membre"];
                    $prenom = $membres["prenom_membre"];
                    $nom = $membres["nom_membre"];
                    $mail = $membres["mail_membre"];
                    $login = $membres["login_membre"];
                    $role = $membres["role_membre"];
                    $avatar = $membres["avatar_membre"];
                 
                     //vérifier si img existe
                    if(!empty($avatar)){
                        $avatar = "<img src='" . $avatar . "' alt='Avatar de $login' width='50'>";
                     }else{
                         $avatar = "";
                     }
                    
                    //création du tbl
                    echo "<tr>";
                    echo "<td>$prenom</td>";
                    echo "<td>$nom</td>";
                    echo "<td>$mail</td>";
                    echo "<td>$login</td>";
                    echo "<td>$role</td>";
                    echo "<td>$avatar</td>";
                    echo "<td class='text_center'>
                            <a href='update_member_admin.php?id=$id'>
                                <img src='img/modifier.png' alt='modifier'>
                            </a>
                        </td>";
                    echo "<td class='text_center'>
                            <a href='delete_member_admin.php?id=$id'>
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