<?php
session_start();

require_once "Module/modul-functii.php";
require_once "Module/modul-db.php";

$pagina = '';
$numePagina = '';

if (isset($_GET['pagina'])) {
  if (in_array($_GET['pagina'], ['login', 'signup', 'lobby', 'account', 'noaccess', 'dberror'])) {
    $pagina = $_GET['pagina'];
    switch ($pagina) {
      case 'login':
        $numePagina = 'Autentificare';
        break;
      case 'signup':
        $numePagina = 'Înregistrare';
        break;
      case 'lobby':
        $numePagina = 'Acasă';
        break;
      case 'account':
        $fisier = "Pagini/pagina-lobby.php";
        $numePagina = "Cont";
        break;
    };
  } else {
    $pagina = '404';
    $numePagina = '404';
  }
}


if ($pagina == '') {
  if (!Loggedin()) {
    $pagina = 'login';
    $numePagina = 'Autentificare';
  } else {
    $pagina = 'lobby';
    $numePagina = 'Acasă';
  }
}

if (!isset($fisier))
  $fisier = "Pagini/pagina-{$pagina}.php";

if (!file_exists($fisier))
  $fisier = "Pagini/pagina-404.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
  include_once "Module/modul-css.php";
  include_once "Module/modul-js.php";
  ?>
  <title><?= htmlspecialchars($numePagina) ?></title>

</head>

<body>
  <?php

  //include 'Module/modul-loadingscreen.php';
  include $fisier;

  ?>
  <div id="messages" class="toast-container position-fixed m-3 top-0 end-0">
    <?php
    ShowMessages();
    ?>
  </div>
  <div class="bg-primary text-info d-flex justify-content-center align-items-center" style="height: 100px;">
    © - 2022 Șteopoaie Vlad - 
  </div>
</body>

</html>