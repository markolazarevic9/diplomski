<?php
  session_start();  
  require_once("functions.php");
  if(!isset($_SESSION['ime'])) 
  {
    header("location:login.php");
  }

 
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
      h2 {
        font-size:25px;
      }
      a:hover {
        color:white;
      }
    </style>
  </head>
  <body>
    <?php require_once("components/header.php")?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>

      <div class="main">
        <h2 id="mainH">Lekarski sistem</h2>
        <hr />
        <div class="statistics">
          <div class="admission">
            <h2>Ukupno prijema danas</h2>
            <h2>Broj</h2>
          </div>
          <div class="release">
            <h2>Ukupno otpusta</h2>
            <h2>Broj</h2>
          </div>
          <div class="deaths">
            <h2>Smrtnih slucajeva</h2>
            <h2>Broj</h2>
          </div>
        </div>
        <hr />
        <div class="rooms">
          <h2>Slobodno mesta u bolnici</h2>
          <h2>Broj</h2>
        </div>
      </div>
    </div>
  </body>
</html>
