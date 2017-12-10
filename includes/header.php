<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $titrePage; ?></title>
        <link rel="stylesheet" href="css/perso.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div id="global">
            <header>
                <img src="img/banniere.jpg" alt="banniere" class="banniere">
                
                <?php
                    //avant afficher cookie test si existe
                    if(isset($_COOKIE["bienvenue"])){
                        echo $_COOKIE["bienvenue"];
                    }
                    
                ?>
                
            </header>
            <nav>
                <div>
                    <a href="index.php">Accueil</a>
                    <a href="admin_books.php">Administration livres</a>
                </div>
                <div>
                    <?php
                            //récupère si le tableau '$_SESSION' et le 'login' => $_SESSION["login"];

                            //affiche le login
                            if(isset($_SESSION["login"])){
                            //création d'une variable session login
                            $sessionLogin = $_SESSION["login"];
                                
                            //on récupère l'avatar s'il y en a un 
                            $select = "SELECT avatar_membre FROM membres WHERE login_membre='$sessionLogin'";
                            $exec = mysqli_query($co, $select);
                            $membre = mysqli_fetch_array($exec);
                            //créer variable éviter concaténer
                            //vérifier si img existe
                            if(!empty($membre["avatar_membre"])){
                                $avatarMembre = "<img src='" . $membre["avatar_membre"] . "' alt='Avatar de $sessionLogin' width='50'>";
                            }else{
                                 $avatarMembre = "";
                            }
                                
                            
                            //créer les liens d'admin du site pour les admins
                            if($_SESSION["role"] == "admin"){
                                $liensAdmin = "<a href='admin_site.php'>Admin du site</a> |";
                            }else{
                                $liensAdmin = "";
                            }
                            
                                
                            //afficher l'avatar
                            // echo "<img src='" . $membre['avatar_membre'] . "'>"; // ou avec la variable $avatarMembre
                                
                            echo "<p>
                                Bonjour $sessionLogin
                                $avatarMembre
                                |
                                <a href='update_member.php'>Mon compte</a>
                                |
                                $liensAdmin
                                
                                <a href='includes/logout.php'>Me deconnecter</a>
                                
                            </p>";
                            }

                    ?>
                </div>
            </nav>
            <main>
                <h1><?php echo $titrePage ?></h1>