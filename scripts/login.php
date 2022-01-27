<?php

include_once("./connectBDD.php");
include_once("../classes/class.UserManager.php");
include_once("../classes/class.User.php");

$userManager = new UserManager($db);

$retour = $userManager->verifLoginInfos($_POST['mail'], $_POST['mdp']);
if($retour){

    $utilisateur = $userManager->getUser($_POST['mail']);
    session_start ();
    $_SESSION['login'] = true;
    $_SESSION['userSurname'] = $utilisateur->getNom();
    $_SESSION['userName'] = $utilisateur->getPrenom();
    $_SESSION['Type'] = $utilisateur->getType();
    $_SESSION['Mail'] = $utilisateur->getMail();
    $_SESSION['NumTel'] = $utilisateur->getNumTel();
    $_SESSION['idUser'] = $utilisateur->getId();
}  

header('Content-Type: application/json');
echo json_encode($retour);
?>