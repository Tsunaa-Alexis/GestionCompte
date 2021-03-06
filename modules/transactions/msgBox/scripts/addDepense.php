<?php

session_start();
if(!isset($_SESSION['idUser'])){ exit; }

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");
function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$transactionManager = new TransactionManager($db);
$categorieManager = new CategorieManager($db);

$categorie = $categorieManager->getCategorie($_POST['idCategorie']);

$transaction = new Transaction(['prix' => $_POST['prix'], 'commentaire' => $_POST['commentaire'], 'type' => '1', 'categorie' => $categorie, 'dateAjout' => strtotime($_POST['date']), 'user' => $categorie->getUser()]); 
$retour = $transactionManager->addTransaction($transaction);

header('Content-Type: application/json');
echo json_encode($retour);
?>