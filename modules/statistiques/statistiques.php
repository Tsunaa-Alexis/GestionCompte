<!DOCTYPE html>
<html>
    <head>
        <title>Dépenses</title>
        <?php include ("header.php"); ?>
        <link rel="stylesheet" href="./modules/statistiques/css/statistiques.min.css">
        <script type="text/javascript">
            var idUser = <?=$_SESSION['idUser']?>
        </script>
        <script language="javascript" type="text/javascript" src="./modules/transactions/js/transactions.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script language="javascript" type="text/javascript" src="./modules/statistiques/js/statistiques.min.js"></script>
    </head>
    <body>  
        <div class="main">
            <?php include ("sideBar.php"); ?>
            <div class="container">
            <div class="header">
                    <div class="sectionHeader" style="width:100%; height:40px;">
                        <div style="width:100%; height:40px;">
                            <div class="sectionTitle" style="float:left; padding-top:5px; font-size:25px;"><strong>Statistiques</strong></div>
                        </div>
                    </div>
                    <div class="divider"></div>
                </div>
                <div class="results">
                    <div class="chartGlobal">
                        <div id="chart_DepensesRevenues" style="width: 100%; height: 500px;"></div>
                    </div>
                    <div class="chartIndividuel">
                        <div class="chartDepenses">
                            <div id="chart_depenses" style="width: 100%; height: 500px;"></div>
                        </div>
                        <div class="chartRevenus">
                            <div id="chart_revenus" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>