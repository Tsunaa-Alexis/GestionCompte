<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");
function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$transactionManager = new TransactionManager($db);
$categorieManager = new CategorieManager($db);

$categorie = $categorieManager->getCategorie($_POST['idCategorie']);
$transaction = $transactionManager->getTransaction($_POST['idTransaction']);
$transaction->setPrix($_POST['prix']);
$transaction->setCommentaire($_POST['commentaire']);
$transaction->setCategorie($categorie);

$retour = $transactionManager->editTransaction($transaction);

header('Content-Type: application/json');
echo json_encode($retour);
?>