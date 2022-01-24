<?php

include_once("./connectBDD.php");
include_once("../classes/class.UserManager.php");
include_once("../classes/class.User.php");

$userManager = new UserManager($db);

$retour['emailPresent'] = $userManager->mailExists($_POST['mail']);

if(!$retour['emailPresent']){
    $user = new User(['nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'mail' => $_POST['mail'], 'mdp' => password_hash($_POST['mdp'], PASSWORD_BCRYPT), 'type' => "USER", 'numTel' => $_POST['numTel']]); 
    $userManager->add($user);
}

header('Content-Type: application/json');
echo json_encode($retour);
?>