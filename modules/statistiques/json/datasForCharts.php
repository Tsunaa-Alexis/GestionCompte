<?php

session_start();
if(!isset($_SESSION['idUser'])){ exit; }

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");
function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$transactionManager = new TransactionManager($db);

$retour = $transactionManager->recupDatasJsonForChartsDepensesRevenus($_SESSION['idUser'] ,1642929562, 1643361562);

header('Content-Type: application/json');
echo json_encode($retour);
?>