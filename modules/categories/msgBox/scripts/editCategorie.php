<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");
function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

session_start();

$categorieManager = new CategorieManager($db);

$categorie = $categorieManager->getCategorie($_POST['idCategorie']);

if(!isset($_SESSION['idUser']) || $categorie->getUser()->getId() != $_SESSION['idUser']){ exit; }

$categorie->setIntitule($_POST['intitule']);
$categorie->setDescription($_POST['description']);

$retour = $categorieManager->editCategorie($categorie);

header('Content-Type: application/json');
echo json_encode($retour);
?>