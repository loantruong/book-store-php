<!-- Filtrer les categories des livres -->
<p>Filtrer la liste des livres par catégories</p>

<!-- Affiche la liste des catégories -->
<form method="post" action="filtrer_categorie.php" >
    
    <div>
        <select name="categorie" id="categorie">
            
            <!-- Récupérer la liste des catégories -->
            <?php
                $select = "SELECT * FROM categories";
                $exec = mysqli_query($co, $select);
                
                //montre la catégorie qui a été sélectionné
                while($categories = mysqli_fetch_array($exec)){
                    if($categories[0] == $_POST["categorie"]){
                        echo "<option selected>" . $categories[0] . "</option>";                            
                    }else{
                        echo "<option>" . $categories[0] . "</option>";
                    }  
                }
            
            ?>
        
        </select>
    </div>
    
    <div>
        <input type="submit" value="Filtrer" name="envoyer">
    </div>
    
</form>