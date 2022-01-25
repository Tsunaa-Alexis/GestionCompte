<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
if(!isset($_GET['action'])){ include('home.php'); }
if($_GET['action'] === 'inscription'){ include('inscription.php'); }
if($_GET['action'] === 'login'){ include('login.php'); }
if($_GET['action'] === 'categorie'){ include('./modules/categories/categories.php'); }
if($_GET['action'] === 'depenses'){ include('./modules/transactions/depenses.php'); }
?>