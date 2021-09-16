<?php session_start()?>
<?php require_once("functions.php")?>
<?php require_once("components/db_connect.php")?>
<?php
    $upit = "SELECT * FROM DIJAGNOZA";
    $rez = $db->query($upit);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css" />
    <link rel="stylesheet" href="css/lekovi.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Dijagnoze</title>
  </head>
  <body>
    <?php require_once("components/header.php")?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>
      <div class="main">
        <h2 id="mainH">Pretraga dijagnoza</h2>
        <form class="searchMed" action="/">
            <span><i class="fas fa-search"></i><input id="pretragaDijagnoza"placeholder="Pretraži dijagnoze" type="text"></span>
        </form>
        <hr />
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Naziv</th>
              <th scope="col">Šifra</th>
              <th scope="col">Opis</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <?php showListOfDiagnosis($rez) ?>
          </tbody>
        </table>
    </div>
    <script>
        let searchBoxDijag = document.querySelector("#pretragaDijagnoza");

         searchBoxDijag.addEventListener("input", () => {
            let search = $("#pretragaDijagnoza").val().trim();
            $.get("ajax/pretragaDijagnoza.php",{search:search}, function(odg) {
                $("#tbody").html(odg);
            })
    });
    </script>
  </body>
</html>
