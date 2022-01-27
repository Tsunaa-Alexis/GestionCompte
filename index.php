<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";

//CONFIGURATION LISTING RESULTATS
$config_resultsParPageDefaut = 20;
$config_resultsParPage = array(10,20,30,50,100,150,1000);

function recupGetVars($elementsExclus = array(), $elementsRemplacement = array()){
	
	$url = explode("/",$_SERVER['SCRIPT_FILENAME']);
	$url = $url[sizeof($url) - 1];
	$newVars = array();
	
	foreach($_GET as $key => $value){
		
		if(!in_array($key,$elementsExclus)){
			if(array_key_exists($key,$elementsRemplacement)){
				$newVars[] = $key."=".urlencode(html_entity_decode($elementsRemplacement[$key],ENT_QUOTES));
			}else{
				$newVars[] = $key."=".urlencode(html_entity_decode($value,ENT_QUOTES));
			}
		}
		
	}
	
	return $url."?".implode('&',$newVars);
}

function generationPagination($nbrElements,$nbrResultatsParPage,$actualPage,$pagesAAfficher = 10){

    //définition du nombre total de pages
    $nbrTotaleDePages = ceil($nbrElements / $nbrResultatsParPage);
    if($nbrTotaleDePages == 0){ $nbrTotaleDePages = 1; }

    //page suivante & précédente en fonction de la page acutelle
    $pagePrecedente = $actualPage - 1;
    $pageSuivante = $actualPage + 1;
    if($pagePrecedente < 1){ $pagePrecedente = 1; }
    if($pageSuivante > $nbrTotaleDePages){ $pageSuivante = $nbrTotaleDePages; }
    
    //définition des pages min & max à afficher autours de la page en cours
    if($pagesAAfficher % 2 == 0){ $pageAutourPageEnCours = $pagesAAfficher / 2; }
    if($pagesAAfficher % 2 != 0){ $pageAutourPageEnCours = ($pagesAAfficher -1 )/ 2; }

    $pageMaxAffichee = $actualPage + $pageAutourPageEnCours;
    if($pageMaxAffichee > $nbrTotaleDePages){ $pageMaxAffichee = $nbrTotaleDePages; }
    
    $pageMinAffichee = $actualPage - ($pagesAAfficher - 1 - ($pageMaxAffichee - $actualPage));
    if($pageMinAffichee <= 1){ $pageMinAffichee = 1; }

    if(($pageMaxAffichee - $pageMinAffichee + 1) != $pagesAAfficher){
        $pageMaxAffichee = $pageMaxAffichee + ($pagesAAfficher - 1 - ($pageMaxAffichee - $pageMinAffichee));
        if($pageMaxAffichee > $nbrTotaleDePages){ $pageMaxAffichee = $nbrTotaleDePages; }
    }

    $retour = array();
    $retour['nbrTotaleDePages'] = $nbrTotaleDePages;
    $retour['pagePrecedente'] = $pagePrecedente;
    $retour['pageSuivante'] = $pageSuivante;
    $retour['pageMinAffichee'] = $pageMinAffichee;
    $retour['pageMaxAffichee'] = $pageMaxAffichee;

    return $retour;

}

function genTri($tri){
	$paramsTri = "";
	if($_GET['tri'] == $tri){
		if($_GET['sensTri'] == "ASC"){ $paramsTri = "&tri=".$tri."&sensTri="."DESC"; }
		if($_GET['sensTri'] == "DESC"){ $paramsTri = "&tri=".$tri."&sensTri="."ASC"; }
	}else{
		$paramsTri = "&tri=".$tri."&sensTri="."ASC";
	}
	return $paramsTri;
}

function genLienTri($tri){
	$lienTri = recupGetVars(array('page','tri','sensTri')).genTri($tri);
	return $lienTri;
}

function genIconeTri($tri){
	$class = "";
	if($_GET['tri'] == $tri){
		if($_GET['sensTri'] == "ASC"){ $class = "fas fa-chevron-down"; }
		if($_GET['sensTri'] == "DESC"){ $class = "fas fa-chevron-up"; }
	}else{
		$class = "icon-tri-off";
	}
	return $class;
}

if(!isset($_GET['action'])){ $_GET['action'] = ""; include('home.php'); }
if($_GET['action'] === 'inscription'){ include('inscription.php'); }
if($_GET['action'] === 'login'){ include('login.php'); }
if($_GET['action'] === 'categorie'){ include('./modules/categories/categories.php'); }
if($_GET['action'] === 'depenses'){ include('./modules/transactions/depenses.php'); }
if($_GET['action'] === 'revenus'){ include('./modules/transactions/revenus.php'); }
?>