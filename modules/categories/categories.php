<!DOCTYPE html>
<html>
    <head>
        <title>Catégories</title>
        <?php include ("header.php"); ?>
        <link rel="stylesheet" href="./modules/categories/css/listingCategories.min.css">
        <script language="javascript" type="text/javascript" src="./modules/categories/js/categories.min.js"></script>
    </head>
    <body>  
        <?php $categorieManager = new CategorieManager($db) ?>
        <div class="main">
            <?php include ("sideBar.php"); ?>
            <div class="container">
                <div class="header">
                    <button onclick="msgBoxAddCategorie(<?=$_SESSION['idUser']?>)">Ajouter</button>
                </div>
                <div class="results">
                    <?php 
                    
                    $arrayCategories = $categorieManager->getAllCategoriesFromUser($_SESSION['idUser']);
                    
                    if(!empty($arrayCategories)){
                        foreach($arrayCategories as $categorie){ ?>

                            <div id="ligne-<?=$categorie->getId()?>" class="ligne">
                                <div class="intitule"><?=$categorie->getIntitule()?></div>
                                <div class="description"><?=$categorie->getDescription()?></div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-mini" title="Supprimer" onclick="suppCategorie(<?=$categorie->getId()?>)">Supprimer</button>
                                </div>
                            </div>
                            
                        <?php }
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>