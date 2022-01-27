<!DOCTYPE html>
<html>
    <head>
        <title>Revenus</title>
        <?php include ("header.php"); ?>
        <link rel="stylesheet" href="./modules/transactions/css/depenses.min.css">
        <script language="javascript" type="text/javascript" src="./modules/transactions/js/transactions.min.js"></script>
    </head>
    <body>  
        <?php 
            $transactionManager = new TransactionManager($db);
            $categorieManager = new CategorieManager($db);
        ?>
        <div class="main">
            <?php include ("sideBar.php"); ?>
            <div class="container">
                <div class="header">
                    <button onclick="msgBoxAddRevenus(<?=$_SESSION['idUser']?>)">Ajouter</button>
                </div>
                <div class="results">
                    <?php 
                    
                    $arrayRevenus = $transactionManager->getAllRevenusFromUser($_SESSION['idUser']);
                    
                    if(!empty($arrayRevenus)){

                        foreach($arrayRevenus as $revenus){ ?>
                            <div id="ligne-<?=$revenus->getId()?>" class="ligne">
                                <div class="prix"><?=$revenus->getPrix()?></div>
                                <div class="categorie"><?=$revenus->getCategorie()->getIntitule()?></div>
                                <div class="commentaire"><?=$revenus->getCommentaire()?></div>
                                <div class="date"><?=date('d/m/Y',$revenus->getdateAjout())?></div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-mini" title="Supprimer" onclick="suppTransaction(<?=$revenus->getId()?>)">Supprimer</button>
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