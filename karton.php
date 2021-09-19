<?php session_start()?>
<?php
  if(!isset($_SESSION['ime'])) 
  {
    header("location:login.php");
  }
  require_once("components/db_connect.php");
  require_once("functions.php");
  require_once("components/fetchPatient.php");
  error_reporting(0);
 ?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css" />
    <link rel="stylesheet" href="css/karton.css">
    <script
      src="https://kit.fontawesome.com/486587c22a.js"
      crossorigin="anonymous"
    ></script>
    <title>Karton pacijenta</title>
    <style>
      #collapseFour > div > table > tbody > tr > td > button > a {
        color: white;
        text-decoration: none;
      }
      h3 {
        text-align: center;
      }
    </style>
  </head>
  <body>
  <?php require_once("components/header.php") ?>

    <div class="central">
    <?php require_once("components/sidebar.php")?>
      <div class="main">
        <h2 id="mainH">Karton pacijenta</h2>
        
        <hr />
        <div class="statistics">
          <div class="patient">
            <?php require_once("components/patientData.php")?>
          </div>
        </div>
        <div class="history">
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    DIJAGNOZE
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naziv dijagnoze</th>
                            <th scope="col">Sifra</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Datum dijagnostike</th>
                            <th scope="col">Datum izlecenja</th>
                            <th scope="col">Tip</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                        <?php
                          showDiagnosis($rezDijagnoza);
                        ?>
                        </tbody>
                      </table>
                   
                  </div>
                </div>
              </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  TERAPIJA
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">LEK</th>
                      <th scope="col">DOZA</th>
                      <th scope="col">JEDINICA MERE</th>
                      <th scope="col">Nacin aplikovanja</th>
                      <th scope="col">DATUM PREPISIVANJA</th>
                      <th scope="col">PREPISAO LEKAR</th>
                      <th scope="col">DATUM APLIKOVANJA</th>
                      <th scope="col">APLIKOVAO</th>  
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      showTreatment($rezLecenje);
                   ?>
                  </tbody>
                </table>
                </div>
              </div>
              </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  PRIJEMI I OTPUSTI
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <h3>Prijemi</h3>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Status</th>
                            <th scope="col">Lekar</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                          <?php showPrijem($_GET['id']) ?>
                        </tbody>
                    </table>
                    <h3>Otpusti</h3>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Napomena</th>
                            <th scope="col">Lekar</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                          <?php showOtpust($_GET['id']) ?>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
                  IZVEŠTAJI
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">NAZIV IZVEŠTAJA</th>
                          <th scope="col">UZORAK</th>
                          <th scope="col">VREDNOST</th>
                          <th scope="col">OPIS</th>
                          <th scope="col">DATUM</th>
                          <th scope="col">LEKAR</th>
                          <th scope="col">ŠTAMPA</th>

                        </tr>
                      </thead>
                      <tbody>
                      <?php
                         showReports($rezIzvestaji);
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              </div>
    </div>
        </div>
      </div>
    </div>
  </body>
</html>
