<?php

session_start();
if(!isset($_SESSION['idUser'])){ exit; }

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");
function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$categorieManager = new CategorieManager($db);

$retour = $categorieManager->removeCategorie($_POST['idCategorie'], $_SESSION['idUser']);

header('Content-Type: application/json');
echo json_encode($retour);
?>