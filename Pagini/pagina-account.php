<?php

include "Module/modul-userAccounts.php";

if (!Loggedin()) {
  header("Location: ./?pagina=login");
  die();
}

$result = false;
if (isset($_GET['accountId'])) {
  $accountId = $_GET['accountId'];
  $query = "SELECT * FROM accounts WHERE accountId = ?;";
  $values = array();
  $values[] = $accountId;
  if ($result = QueryDatabase($conn, $query, $values)) {
    $accountData = mysqli_fetch_assoc($result);
    AddMessage($accountData['accountId'], "success");
  } else {
    AddMessage("Eroare", "danger");
    header("Location: ./");
    die();
  }
} else {
  AddMessage("Nu-i", "warning");
  header("Location: ./");
  die();
}


if ($accountData['usersId'] != $_SESSION['userId']) {
  header("Location: ./?pagina=noaccess");
  die();
}

?>
<div class="container-fluid bg-primary h-auto min-vh-100">

  <!-- Header -->
  <nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <a class="navbar-brand ms-2" href="./">
        <img src="Imagini/logo-full.png" width="240" height="60">
      </a>
      <a class="nav-link fw-normal fs-5" href="Scripturi/script-logout.php">Deconectare <i class="bi bi-box-arrow-right"></i></a>
    </div>
  </nav>


  <!-- Side nav -->

  <div class="row w-100 h-100">


    <div class="col-2">
      <div class="text-secondary fs-5 mt-2 mb-4">Cont personal</div>
      <ul class="nav nav-tabs flex-column fs-5">
        <li class="nav-item">
          <a class="nav-link <?= $pagina == 'lobby' ? 'active' : '' ?>" aria-current="page" href="Scripturi/script-mesaj.php"><i class="bi bi-speedometer2"></i> Acasă</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            <i class="bi bi-bank2"></i> Conturi
          </a>
          <div class="collapse bg-dark show" id="collapseExample">
            <div class="card card-body">
              <?php
              while ($data = mysqli_fetch_assoc($userAccounts)) {
              ?>
                <a class="nav-link <?= $pagina == 'account' ? ($accountData['accountId'] == $data['accountId'] ? 'active' : '') : '' ?>" href="./?pagina=account&accountId=<?= htmlspecialchars($data['accountId']) ?>">
                  <?php
                  switch ($data['accountType']) {
                    case "Economie":
                  ?>
                      <i class="bi bi-piggy-bank"></i>
                    <?php
                      break;
                    case "Salariu":
                    ?>
                      <i class="bi bi-cash"></i>
                    <?php
                      break;
                    case "Credit":
                    ?>
                      <i class="bi bi-wallet2"></i>
                  <?php
                      break;
                  }
                  ?> <?= htmlspecialchars($data['accountName']) ?>
                </a>
              <?php
              }
              ?>

              <a style="cursor: pointer;" class="nav-link fs-5" data-bs-toggle="modal" data-bs-target="#createAccountModal">
                <i class="bi bi-plus-lg fw-bold"></i> Adaugă cont
              </a>
            </div>
          </div>
        </li>

      </ul>

    </div>
    <!-- MAIN -->
    <div class="col w-100 h-100">
      <div class="text-secondary fs-5 mt-2 mb-5"><?= htmlspecialchars($pagina == 'account' ? "Conturi > {$accountData['accountName']}" : 'Acasă') ?></div>

      <div class="shadow bg-dark rounded-3 pb-3">
        <div class="row row-cols-1 row-cols-md-3 g-4 p-4">
          <div class="col">
            <div class="card mx-2 bg-primary rounded-3">
              <div class="card-body">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createAccountModal">
                  <p class="card-text text-center text-success" style="font-size: 8rem;"><i class="bi bi-bank2"></i></p>

                  <h5 class="card-title text-info text-center pb-3">Adaugă un cont</h5>
                </button>
              </div>
            </div>



          </div>
          <div class="col">
            <div class="card mx-2 bg-primary rounded-3">
              <div class="card-body">
                <button class="btn btn-primary w-100">
                  <p class="card-text text-center text-success" style="font-size: 8rem;"><i class="bi bi-bank"></i></p>

                  <h5 class="card-title text-info  text-center pb-3">Crează un cont comun</h5>
                </button>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card mx-2 bg-primary rounded-3">
              <div class="card-body">
                <button class="btn btn-primary w-100">
                  <p class="card-text text-center text-success" style="font-size: 8rem;"><i class="bi bi-door-open-fill"></i></p>

                  <h5 class="card-title text-info text-center pb-3">Alătură-te unui cont comun</h5>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Create account modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content text-info bg-dark">
      <div class="modal-header ">
        <h5 class="modal-title" id="exampleModalLabel">Adaugă un cont</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addAccountForm" action="Scripturi/script-add-account.php" method="post" class="mx-5 mt-3">
          <div class="row mb-4 g-3 align-items-center">
            <div class="col-2">
              <label for="accountName" class="form-label text-light fs-6">Nume cont</label>
            </div>
            <div class="col-9 offset-1">
              <input id="accountName" name="accountName" type="text" class="form-control text-light bg-dark border-secondary border-1" max="10" placeholder="Numele contului">
            </div>

            <div class="col-2">
              <label for="bankName" class="form-label text-light fs-6">Nume bancă</label>
            </div>
            <div class="col-9 offset-1">
              <input id="bankName" name="bankName" type="text" class="form-control text-light bg-dark border-secondary border-1" max="20" placeholder="Numele băncii">
            </div>

            <div class="col-2">
              <label for="accountType" class="form-label text-light fs-6">Tip cont</label>
            </div>
            <div class="col-9 offset-1">
              <select class="form-select text-light bg-dark border-secondary border-1" name="accountType" id="accountType">
                <option selected>Alege tipul contului</option>
                <option value="Economie">Economie</option>
                <option value="Salariu">Salariu</option>
                <option value="Credit">Credit</option>
              </select>
            </div>

            <div class="col-2">
              <label for="accountCurrency" class="form-label text-light fs-6">Valuta</label>
            </div>
            <div class="col-9 offset-1">
              <select onchange="ChangeCurrency(this.value)" class="form-select text-light bg-dark border-secondary border-1" name="accountCurrency" id="accountCurrency">
                <option selected>Alege valuta contului</option>
                <option value="USD">Dolar(USD)</option>
                <option value="EUR">Euro(EUR)</option>
                <option value="RON">Leu(RON)</option>
              </select>
            </div>

            <div class="col-2">
              <label for="accountBalance" class="form-label text-light fs-6">Suma</label>
            </div>
            <div class="col-9 offset-1">
              <div class="input-group mb-3">
                <span id="spanSuma" class="input-group-text text-light border-secondary bg-dark">USD</span>
                <input name="accountBalance" id="accountBalance" type="text" class="form-control text-light bg-dark border-secondary border-1" aria-label="Amount (to the nearest dollar)">
                <span class="input-group-text bg-dark border-secondary text-light">.00</span>
              </div>
            </div>
          </div>
          <div id="errorDiv"></div>
          <div class="float-end mb-3">
            <button type="submit" class="btn btn-success text-light">Salvează</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>