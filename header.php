<?php

  session_start();
  
  function chargerClasse($classname){ require 'classes/class.'.$classname.'.php'; }
  spl_autoload_register('chargerClasse');

  include_once("./scripts/connectBDD.php");

  $userManager = new UserManager($db);

  if (isset($_POST['deconnexion'])){
    session_unset ();
    session_destroy ();
    header('Location: ./index.php');
  }

?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta charset="utf-8">
<script src="https://kit.fontawesome.com/768b55194c.js" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
<a class="navbar-brand" href="index.php">Acceuil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="credit.php">Crédits</a>
            </li>
        </ul>   
        <form class="form-inline my-2 my-lg-0" method="POST">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            <?php if(!isset($_SESSION['login'])){ ?>
                <ul class="navbar-nav mr-right">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-dark" href="inscription.php">S'inscrire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-dark"   href="login.php">S'identifier</a>
                    </li>
                </ul>
            <?php } ?>
            <?php if(isset($_SESSION['login'])){ ?>
                <ul class="navbar-nav mr-right">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-dark" href="inscription.php">Profil</a>
                    </li>
                </ul>
            <?php } ?>
        </form>
    </div>
</nav>