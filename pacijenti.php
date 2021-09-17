<?php 
  session_start();
  require_once("classes/db.php");
  require_once("components/db_connect.php");
  $upit = "SELECT * FROM PACIJENT";
  $rez = $db -> query($upit);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <script
      src="https://kit.fontawesome.com/486587c22a.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/pacijenti.css" />
    <link rel="stylesheet" href="css/dashboard.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Pacijenti</title>
  </head>
   <style>
      #tbody > tr > td > button {
        padding: 3px;
        border-radius: 7px;
      }
   </style>
  <body>
   <?php require_once("components/header.php")?>

    <div class="central">
    <?php require_once("components/sidebar.php")?>
      <div class="main">
        <h2 id="mainH">Pacijenti</h2>
        <form class="searchMed" action="/">
          <span
            ><i class="fas fa-search"></i
            ><input id="pretraga" placeholder="Pretraži pacijente" type="text"
          /></span>
        </form>
        <hr />
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Ime</th>
              <th scope="col">Prezime</th>
              <th scope="col">JMBG</th>
              <?php
                if($_SESSION['status'] == "admin")
                {
                  echo '<th scope="col">Izmeni</th>';
                }
                if($_SESSION['status'] == "lekar")
                {
                  echo '<th scope="col">Karton</th>
                  <th scope="col">Terapija</th>
                  <th scope="col">Prijem</th>
                  <th scope="col">Otpust</th>
                  <th scope="col">Dijagnostika</th>
                  <th scope="col">Dijagnzoze</th>';
                }
                if($_SESSION['status'] == "tehnicar")
                {
                  echo '<th scope="col">Karton</th>
                  <th scope="col">Terapija</th>';
                }
                // if($_SESSION['status'] != "admin")
                // {
                //   echo '<th scope="col">Karton</th>
                //   <th scope="col">Terapija</th>
                //   <th scope="col">Prijem</th>
                //   <th scope="col">Otpust</th>
                //   <th scope="col">Dijagnostika</th>
                //   <th scope="col">Dijagnzoze</th>';
                  
                  
                // }
                // else
                // {
                //   echo '<th scope="col">Izmeni</th>';
                // }
              ?>
             
            </tr>
          </thead>
          <tbody id="tbody">
            <?php showPatiens($rez) ?>
          </tbody>
        </table>
      </div>
    </div>
  <script src="js/index.js"></script>
  </body>
</html>
