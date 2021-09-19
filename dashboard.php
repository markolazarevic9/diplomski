<?php
  session_start();  
  require_once("functions.php");
  if(!isset($_SESSION['ime'])) 
  {
    header("location:login.php");
  }
  require_once("components/db_connect.php");

  $sqlPrijemi = "SELECT fun_broj_prijema()";
  $rezPrijemi = $db->query($sqlPrijemi);
  $brojPrijema = mysqli_fetch_row($rezPrijemi);

  $sqlOtpusti = "SELECT fun_broj_otpusta()";
  $rezOtpusti = $db->query($sqlOtpusti);
  $brojOtpusta = mysqli_fetch_row($rezOtpusti);

  $sqlSmrti = "SELECT fun_broj_smrti()";
  $rezSmrti = $db->query($sqlSmrti);
  $brojSmrti = mysqli_fetch_row($rezSmrti);

  $sqlInt = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NULL AND IDSOBA IN (SELECT IDSOBA FROM SOBA WHERE IDODELJENJE = (SELECT IDODELJENJE FROM ODELJENJE WHERE NAZIVODELJENJE = 'Intenzivna nega'))";
  $rezInt = $db->query($sqlInt);
  $brojInt = mysqli_fetch_row($rezInt);

  $sqlPolu = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NULL AND IDSOBA IN (SELECT IDSOBA FROM SOBA WHERE IDODELJENJE = (SELECT IDODELJENJE FROM ODELJENJE WHERE NAZIVODELJENJE = 'Poluintenzivna nega'))";
  $rezPolu= $db->query($sqlPolu);
  $brojPolu = mysqli_fetch_row($rezPolu);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/486587c22a.js"
      crossorigin="anonymous"
    ></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css" />

    <title>Dashboard</title>
    <style>
      .container h1 {
        text-align: center;
        font-weight: bold;
      }
      h2 {
        font-size:25px;
        text-align: center;
      }
      a:hover {
        color:white;
      }
     #stat {
       margin-bottom: 60px;
       font-weight: normal;
       color: red;
     }
      .container h2 {
        padding: 20px;
      }
    </style>
  </head>
  <body>
    <?php require_once("components/header.php")?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>
      <div class="container">
      <h1 id="stat">Statistika za <?php echo date("d.m.Y",time())?></h1>
        <div class="row">
          <div class="col-md-4">
              <h2>Ukupno prijema danas</h2>
              <h1 id="prijemBroj"><?php echo $brojPrijema[0]?></h1>
          </div>
          <div class="col-md-4">
              <h2>Ukupno otpusta danas</h2>
              <h1 id="otpustBroj"><?php echo $brojOtpusta[0]?></h1>
          </div>
          <div class="col-md-4">
              <h2>Ukupno smrtnih slucajeva danas</h2>
              <h1 id="smrtiBroj"><?php echo $brojSmrti[0]?></h1>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h2>Slobodno mesta u bolnici</h2>
          </div>
          <div class="col-md-6">
            <h2>Intenzivna nega</h2> <br>
            <h1 id="intBroj"><?php echo $brojInt[0]?></h1>
          </div>
          <div class="col-md-6">
            <h2>Poluintenzivna nega</h2> <br>
            <h1 id="poluBroj"><?php echo $brojPolu[0]?></h1>
          </div>
        </div>
        <hr>
      </div>
    </div>
  </body>
</html>
