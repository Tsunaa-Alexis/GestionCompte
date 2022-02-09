<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include('fonctions/main.php');

//CONFIGURATION LISTING RESULTATS
$config_resultsParPageDefaut = 20;
$config_resultsParPage = array(10,20,30,50,100,150,1000);

if(!isset($_GET['action'])){ $_GET['action'] = ""; include('home.php'); }
if($_GET['action'] === 'inscription'){ include('inscription.php'); }
if($_GET['action'] === 'login'){ include('login.php'); }
if($_GET['action'] === 'categorie'){ include('./modules/categories/categories.php'); }
if($_GET['action'] === 'depenses'){ include('./modules/transactions/depenses.php'); }
if($_GET['action'] === 'revenus'){ include('./modules/transactions/revenus.php'); }
if($_GET['action'] === 'statistiques'){ include('./modules/statistiques/statistiques.php'); }

?>