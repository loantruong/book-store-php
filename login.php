<?php
    $titrePage = "Administration des livres";
    require_once "includes/header_public.php";
?>

<!-- Afficher message d'erreur -->
<?php
    //login ou mdp incorrect
    errorMsg("erreur", "OUPS, votre identifiant ou votre mot de passe n'est pas valide.");
    
    //login ou mdp incorrect // identifiant GET 'interdit'
    errorMsg("interdit", "Vous devez être connecté pour accéder à cette page");
?>


<p>
    <a href="add_member.php">Créer un compte</a>
</p>

<!-- Forumlaire de connexion - Affichage -->
<form method="post" action="">
    <div>
        <label for="login">Login : </label>
        <input type="text" name="login" id="login" value="<?php getWrite("login") ?>" required>
    </div>
    <div>
        <label for="mdp">Mot de passe : </label>
        <input type="password" name="mdp" id="mdp" required>
    </div>
    <div>
        <input type="submit" name="envoyer" value="Me connecter">
    </div>
</form>


<!-- Forumlaire de connexion -- Traitement -->
<?php
        if(isset($_POST["envoyer"])){
            //récupérer les infos du formulaire
            $login = $_POST["login"];
            $mdp = $_POST["mdp"];

            // requête pour vérifier si login et mdp existe dans la table membres
            //compter le nbr de personne qui ont le mm login 
            //SQL 'WHERE' => ajouter une condition /ce champs est égal à tel valeur // PASSWORD => cripter le mdp
            $select = "SELECT count(*) FROM membres WHERE login_membre='$login' AND mdp_membre=PASSWORD('$mdp')";

            //exécute la requête
            $exec = mysqli_query($co, $select);

            //traduire en PHP
            $compter = mysqli_fetch_array($exec);

            //tester pour afficher un tableau 
            var_dump($compter);

            //vérifier le résultat dans un tableau (0 ou 1)
            if($compter[0] == 1){
                //créer une session de connexion
                $_SESSION["login"] = $login;
                
                //Récupérer le rôle dans la bdd et créer une session avec ce rôle de l'utilisateur
                $select = "SELECT role_membre FROM membres WHERE login_membre='$login'";
                $exec = mysqli_query($co, $select);
                $membre = mysqli_fetch_array($exec);
                
                $_SESSION["role"] = $membre[0];
                //ou $_SESSION["role] = $membre["role_membre"]; (le nom du champs, si plusieurs champs)
                
                //Remplir le fichier de log de connexion utilisateur
                $log = fopen("logs/connexions.txt", "a+");
                fwrite($log, "Connexion de $login le " . strftime("%d/%m/%Y", time()) . "\r\n");
                fclose();
                
                //redirirger vers la page d'admin des livres + ajout du GET pour afficher un msg sur la page (?connexion)
                header("location:admin_books.php?connexion");
                exit();
            }else{
                //rediriger vers la page de login avec le login et l'erreur en GET
                header("location:login.php?login=$login&erreur");
                exit();
                
            }
        }
?>


<?php
    require_once "includes/footer.php"
?>
