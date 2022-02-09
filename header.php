<?php

  session_start();
  
  function chargerClasse($classname){ require 'classes/class.'.$classname.'.php'; }
  spl_autoload_register('chargerClasse');

  include_once("./scripts/connectBDD.php");

  $userManager = new UserManager($db);
  
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="./css/main.min.css">
<script src="https://kit.fontawesome.com/768b55194c.js" crossorigin="anonymous"></script>
<link href="./js/fancybox/jquery.fancybox.min.css" rel="stylesheet" type="text/css" media="screen" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="./js/fancybox/jquery.fancybox.pack.js"></script>
<script language="javascript" type="text/javascript" src="./js/main.min.js"></script>
<meta charset="utf-8">
<script src="https://kit.fontawesome.com/768b55194c.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>