<?php
session_start();
include "../Module/modul-functii.php";
include "../Module/modul-db.php";

if (
  isset($_POST['accountName']) && isset($_POST['accountType'])
  && isset($_POST['accountCurrency']) && isset($_POST['accountBalance'])
) {
  $accountName = $_POST['accountName'];
  $accountType = $_POST['accountType'];
  $accountCurrency = $_POST['accountCurrency'];
  $accountBalance = $_POST['accountBalance'];



  $currency = '';
  switch ($accountCurrency) {
    case 'EUR':
      $currency = "amountEUR";
      break;
    case 'USD':
      $currency = "amountUSD";
      break;
    case 'RON':
      $currency = "amountRON";
      break;
  }

  $query = "INSERT INTO accounts (accountId, usersId, accountName, accountType, {$currency}, creationDate, accountCurrency)
            VALUES(NULL, ?, ?, ?, ?, NOW(), ?);";
  $values[] = $_SESSION['userId'];
  $values[] = $accountName;
  $values[] = $accountType;
  $values[] = $accountBalance;
  $values[] = $accountCurrency;

  if (QueryDatabase($conn, $query, $values)) {
    AddMessage("Contul a fost adăugat cu succes!", "success");
  } else {
    AddMessage("Eroare!", "danger");
  }

} else {
  AddMessage("A apărut o eroare la adăugarea contului!", "danger");
}
header('Location: ../');
die();
