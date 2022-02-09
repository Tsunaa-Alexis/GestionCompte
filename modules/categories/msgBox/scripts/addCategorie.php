<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";

session_start();
if(!isset($_SESSION['idUser'])){ exit; }

include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");
function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');



$categorieManager = new CategorieManager($db);
$userManager = new UserManager($db);
$user = $userManager->getUserbyid($_SESSION['idUser']);

$categorie = new Categorie(['intitule' => $_POST['intitule'], 'description' => $_POST['description'], 'user' => $user]); 
$retour = $categorieManager->addCategorie($categorie);

header('Content-Type: application/json');
echo json_encode($retour);
?>