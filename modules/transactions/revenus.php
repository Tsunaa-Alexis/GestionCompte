<!DOCTYPE html>
<html>
    <head>
        <title>Revenus</title>
        <?php include ("header.php"); ?>
        <link rel="stylesheet" href="./modules/transactions/css/transactions.min.css">
        <link rel="stylesheet" href="./css/listing.min.css">
        <script language="javascript" type="text/javascript" src="./modules/transactions/js/transactions.min.js"></script>
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

        $transactionManager = new TransactionManager($db);

        //init vars pagination
        if(!isset($_GET['nbResultats'])){ $_GET['nbResultats'] = $config_resultsParPageDefaut; }
        if(!isset($_GET['page'])){ $_GET['page'] = 1; }

        // TRI
        if(!isset($_GET['tri'])){ 
            $_GET['tri'] = 'dateAjout'; 
            $_GET['sensTri'] = 'DESC';
        }

        if($_GET['tri'] == 'dateAjout'){ $order = "ORDER BY t.dateAjout"; }
        if($_GET['tri'] == 'prix'){ $order = "ORDER BY t.prix"; }
        if($_GET['tri'] == 'categorie'){ $order = "ORDER BY c.intitule"; }
        $order.= " ".$_GET['sensTri']." ";

        $nbrResultatsParPage = $_GET['nbResultats'];
        $debut = ($_GET['page'] - 1) * $nbrResultatsParPage;
        $limite = $nbrResultatsParPage;   

        $arrayDepenses = $transactionManager->getAllTransactionsFromUser($_SESSION['idUser'], 2, $debut, $limite, $order);

        //définition des pages pour l'affichage
        $nbrTotaleDePages = $arrayDepenses['numRows'];
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
                            <div class="sectionTitle" style="float:left; padding-top:5px; font-size:25px;"><strong>Liste des Revenus</strong></div>
                                <div class="sectionAddAction" style="float:left; padding-left:20px;"><button type="button" onclick="msgBoxAddRevenus(<?=$_SESSION['idUser']?>);" class="btn btn-info btn-sm" title="Ajouter une dépense"><i class="fas fa-plus"></i> Revenus</button></div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div style="height:39px;">
                        <div style="float:left; line-height:29px;"><i class="fas fa-list-ul"></i>&nbsp;<?=$arrayDepenses['numRows']?> Résultat(s)</div>
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
                        <div class="prix hoverAction" onclick="document.location.href='<?=genLienTri('prix'); ?>'">Prix<i class="<?=genIconeTri('prix'); ?>"></i></div>
                        <div class="categorie hoverAction" onclick="document.location.href='<?=genLienTri('categorie'); ?>'">Catégorie<i class="<?=genIconeTri('categorie'); ?>"></i></div>
                        <div class="commentaire">Commentaire</div>
                        <div class="dateAjout hoverAction" onclick="document.location.href='<?=genLienTri('dateAjout'); ?>'">Date d'ajout<i class="<?=genIconeTri('dateAjout'); ?>"></i></div>
                        <div class="action"></div>
                    </div>
                    <?php 
                    if(!empty($arrayDepenses['result'])){
                        foreach($arrayDepenses['result'] as $depense){ ?>
                            <div id="ligne-<?=$depense->getId()?>" class="ligne">
                                <div class="prix"><?=$depense->getPrix()?></div>
                                <div class="categorie"><?=$depense->getCategorie()->getIntitule()?></div>
                                <div class="commentaire"><?=$depense->getCommentaire()?></div>
                                <div class="dateAjout"><?=date('d/m/Y',$depense->getdateAjout())?></div>
                                <div class="action">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-secondary" title="modifier" onclick="msgBoxEditTransaction(<?=$depense->getId()?>, <?=$_SESSION['idUser']?>)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" title="Supprimer" onclick="suppTransaction(<?=$depense->getId()?>)"><i class="fas fa-times-circle"></i></button>
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