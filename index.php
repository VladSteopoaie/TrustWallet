<?php
session_start();

require_once "Module/modul-functii.php";
require_once "Module/modul-db.php";

$pagina = '';
$numePagina = '';
if (isset($_GET['pagina'])) {
  if (in_array($_GET['pagina'], ['login', 'signup', 'lobby'])) {
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
      default:
        $numePagina = 'Ce ma?';
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


$fisier = "Pagini/pagina-{$pagina}.php";

if(!file_exists($fisier))
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
  ?>
  <title><?= htmlspecialchars($numePagina) ?></title>

</head>

<body>  
  <?php
  ShowMessages();
  //include 'Module/modul-loadingscreen.php';
  include $fisier;

  include_once "Module/modul-js.php";
  ?>
</body>

</html>