<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");
function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$transactionManager = new TransactionManager($db);

$retour = $transactionManager->removeTransaction($_POST['idTransaction']);

header('Content-Type: application/json');
echo json_encode($retour);
?>