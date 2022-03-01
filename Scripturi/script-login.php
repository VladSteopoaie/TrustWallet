<?php
session_start();
include_once "../Module/modul-db.php";
include_once "../Module/modul-functii.php";


if (isset($_POST['username']) && isset($_POST['password'])) {
  $password = $_POST['password']; //for verification
  $username = $_POST['username']; //for verification

  SetOldValues($username);

  $data = UserExists($conn, $username);
 
   if ($data) {
    if (password_verify($password, $data['usersPassword'])) {
      //success
      $_SESSION['userId'] = $data['usersId'];
      header("Location: ../");
      DeleteOldValues();
      die();
    } else {

      //error
      header("Location: ../?pagina=login");
      $_SESSION['error'] = 'incorrectPassword';
      die();
    }
  } else {
    //error
    header("Location: ../?pagina=login");
    $_SESSION['error'] = 'incorrectUser';
    die();
  }
} else {
  //error
?>
  <div>eroare</div>
<?php
}
