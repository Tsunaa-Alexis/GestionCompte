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
$transaction = $transactionManager->getTransaction($_POST['idTransaction']);

if($transaction->getUser()->getId() != $_SESSION['idUser']){ exit; }

$transaction->setPrix($_POST['prix']);
$transaction->setCommentaire($_POST['commentaire']);
$transaction->setCategorie($categorie);
$transaction->setDateAjout(strtotime($_POST['date']));

$retour = $transactionManager->editTransaction($transaction);

header('Content-Type: application/json');
echo json_encode($retour);
?>