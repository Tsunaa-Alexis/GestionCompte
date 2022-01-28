<!DOCTYPE html>
<html>
    <head>
        <title>Catégories</title>
        <?php include ("header.php"); ?>
        <link rel="stylesheet" href="./modules/categories/css/listingCategories.min.css">
        <link rel="stylesheet" href="./css/listing.min.css">
        <script language="javascript" type="text/javascript" src="./modules/categories/js/categories.min.js"></script>
        <script type="text/javascript">
            function changeResultatsParPage(){
                var url = '<?php echo recupGetVars(array('nbResultats','page')); ?>'
                url+= '&nbResultats='+document.forms.formChangeResultsParPage['nbResultats'].value
                window.location = url
            }
        </script>
    </head>
    <body>  
        <?php

        $categorieManager = new CategorieManager($db) ;

        //init vars pagination
        if(!isset($_GET['nbResultats'])){ $_GET['nbResultats'] = $config_resultsParPageDefaut; }
        if(!isset($_GET['page'])){ $_GET['page'] = 1; }
        
        // TRI
        if(!isset($_GET['tri'])){ 
            $_GET['tri'] = 'intitule'; 
            $_GET['sensTri'] = 'ASC';
        }

        if($_GET['tri'] == 'intitule'){ $order = "ORDER BY intitule"; }
        $order.= " ".$_GET['sensTri']." ";

        $nbrResultatsParPage = $_GET['nbResultats'];
        $debut = ($_GET['page'] - 1) * $nbrResultatsParPage;
        $limite = $nbrResultatsParPage;   
        
        $arrayCategories = $categorieManager->getAllCategoriesFromUser($_SESSION['idUser'], $debut, $limite, $order);
        
        //définition des pages pour l'affichage
        $nbrTotaleDePages = $arrayCategories['numRows'];
        $infosPagination = generationPagination($nbrTotaleDePages,$nbrResultatsParPage,$_GET['page'],10);
        $nbrTotaleDePages = $infosPagination['nbrTotaleDePages'];
        $pagePrecedente = $infosPagination['pagePrecedente'];
        $pageSuivante = $infosPagination['pageSuivante'];
        $pageMinAffichee = $infosPagination['pageMinAffichee'];
        $pageMaxAffichee = $infosPagination['pageMaxAffichee'];
        
        ?>
        <div class="main">
            <?php include ("sideBar.php"); ?>
            <div class="container">
                <div class="header">
                    <div class="sectionHeader" style="width:100%; height:40px;">
                        <div style="width:100%; height:40px;">
                            <div class="sectionTitle" style="float:left; padding-top:5px; font-size:25px;"><strong>Liste des Catégories</strong></div>
                                <div class="sectionAddAction" style="float:left; padding-left:20px;"><button type="button" onclick="msgBoxAddCategorie(<?=$_SESSION['idUser']?>);" class="btn btn-info btn-sm" title="Ajouter une catégorie"><i class="fas fa-plus"></i> Catégorie</button></div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div style="height:39px;">
                        <div style="float:left; line-height:29px;"><i class="fas fa-list-ul"></i>&nbsp;<?=$arrayCategories['numRows']?> Résultat(s)</div>
                        <div style="float:right;">
                            <form name="formChangeResultsParPage">
                                <label class="control-label" for="nbResultats" style="float:left; padding-top:5px; text-align:right; padding-right:10px;">Résultats / page</label>
                                <select name="nbResultats" style="width:65px; float:right;" onchange="changeResultatsParPage();">
                                <?php
                                    foreach($config_resultsParPage as $resultsParPage){
                                        $selected = "";
                                        if(isset($_GET['nbResultats']) && $resultsParPage == $_GET['nbResultats']){ $selected = "selected"; }
                                        if(!isset($_GET['nbResultats']) && $resultsParPage == $config_resultsParPageDefaut){ $selected = "selected"; }
                                        echo '<option value="'.$resultsParPage.'" '.$selected.'>'.$resultsParPage.'</option> ';	 
                                    }
                                ?> 				
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="results">
                    <div class="entetes">
                        <div class="intitule hoverAction" onclick="document.location.href='<?=genLienTri('intitule'); ?>'">Intitule<i class="<?=genIconeTri('intitule'); ?>"></i></div>
                        <div class="description">Description</div>
                        <div class="action"></div>
                    </div>
                    <?php 
                    if(!empty($arrayCategories['result'])){
                        foreach($arrayCategories['result'] as $categorie){ ?>

                            <div id="ligne-<?=$categorie->getId()?>" class="ligne">
                                <div class="intitule"><?=$categorie->getIntitule()?></div>
                                <div class="description"><?=$categorie->getDescription()?></div>
                                <div class="action">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-secondary" title="modifier" onclick="msgBoxEditCategorie(<?=$categorie->getId()?>, <?=$_SESSION['idUser']?>)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" title="Supprimer" onclick="suppCategorie(<?=$categorie->getId()?>)"><i class="fas fa-times-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                            
                        <?php }
                    }
                    ?>
                </div>
                <?php if($nbrTotaleDePages > 1){ ?>
                    <nav style="align-self: self-end;">
                        <ul class="pagination">
                            <!-- page précédente et première page -->
                            <li class="page-item  <?=($_GET['page'] > 1)?:'hide'; ?>"><a class="page-link" href="<?=recupGetVars(array('page')); ?>&page=1"><i class="fas fa-angle-double-left"></i></a></li>
                            <li class="page-item <?=($_GET['page'] > 1)?:'hide'; ?>"><a class="page-link" href="<?=recupGetVars(array('page')); ?>&page=<?=$pagePrecedente; ?>"><i class="fas fa-angle-left"></i></a></li>
                            <!-- pages centrales -->
                            <?php
                            $i = $pageMinAffichee;
                            while ($i <= $pageMaxAffichee){
                            ?>
                                <li <?=($_GET['page'] == $i)?'class="active page-item"':''; ?>><a class="page-link" <?=($_GET['page'] != $i)?'href="'.recupGetVars(array('page')).'&page='.$i.'"':''; ?>><?=$i; ?></a></li>
                            <?php
                                $i++;
                            } ?>
                            <!-- page suivante et dernière page -->
                            <li class="page-item <?=($_GET['page'] < $nbrTotaleDePages)?:'hide'; ?>"><a class="page-link" href="<?=recupGetVars(array('page')); ?>&page=<?=$pageSuivante; ?>"><i class="fas fa-angle-right"></i></a></li>
                            <li class="page-item <?=($_GET['page'] < $nbrTotaleDePages)?:'hide'; ?>"><a class="page-link" href="<?=recupGetVars(array('page')); ?>&page=<?=$nbrTotaleDePages; ?>"><i class="fas fa-angle-double-right"></i></a></li>
                        </ul>
                        </nav>
                <?php } ?>
            </div>
        </div>
    </body>
</html>