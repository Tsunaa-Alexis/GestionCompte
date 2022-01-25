<!DOCTYPE html>
<html>
    <head>
        <title>Dépenses</title>
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
                    <button onclick="msgBoxAddDepense(<?=$_SESSION['idUser']?>)">Ajouter</button>
                </div>
                <div class="results">
                    <?php 
                    
                    $arrayDepenses = $transactionManager->getAllDepensesFromUser($_SESSION['idUser']);
                    
                    if(!empty($arrayDepenses)){

                        foreach($arrayDepenses as $depense){ ?>
                            <div id="ligne-<?=$depense->getId()?>" class="ligne">
                                <div class="prix"><?=$depense->getPrix()?></div>
                                <div class="categorie"><?=$depense->getCategorie()->getIntitule()?></div>
                                <div class="commentaire"><?=$depense->getCommentaire()?></div>
                                <div class="date"><?=date('d/m/Y',$depense->getdateAjout())?></div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-mini" title="Supprimer" onclick="suppTransaction(<?=$depense->getId()?>)">Supprimer</button>
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