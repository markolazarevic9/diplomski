<?php
  session_start();  
  require_once("functions.php");
  if(!isset($_SESSION['ime']) && $_SESSION['status'] != 'admin') 
  {
    header("location:login.php");
  }
  if($_SESSION['status'] != "admin")
  {
      header("location:dashboard.php");
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
      body {
          overflow-y: scroll;
      }
      .container {
        text-align: center;
      }
      #datum {
        display: none;
      }
    </style>
  </head>
  <body>
    <?php require_once("components/header.php")?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>
      
      <div class="main container">
          <h2>Pretraga logova</h2>
          <form>
              <input id='prijava' type="checkbox" data-id="PRIJAVA" checked> Prijava
              <input id='odjava' type="checkbox" data-id="ODJAVA" checked> Odjava
              <input id='datumi' type="checkbox" checked> Svi datumi
              <input id='datum' type="date"> 
              <button class='btn btn-info'>Prikaži</button> 

          </form>
          <table class="table">
              <thead>
                  <tr>
                  <th scope="col">#</th>
                  <th scope="col">Ime</th>
                  <th scope="col">Prezime</th>
                  <th scope="col">Istorija</th>
                  <th scope="col">Datum i vreme</th>
                </tr>
            </thead>
             <tbody>
                <?php
                    require_once("classes/db.php");
                    $db = new Db();
                    if(!$db->connect())
                    {
                      echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
                      exit();
                  }

                  $upit = "SELECT * FROM LOG";
                  $rez = $db->query($upit);
                  foreach($rez as $log)
                  {
                    $datum = showDate($log['DATUM']);
                    $radnik = fetchRadnik($log['IDRADNIK']);
                    echo "<tr> 
                    <th scope='row'> {$log['IDLOG']} </th>
                    <th> {$radnik->IMERADNIK}</th>
                    <th> {$radnik->PREZIMERADNIK} </th>
                    <th>{$log['ISTORIJA']}</th>
                    <th>{$datum}</th>
                    </tr>";
                  }

                ?>
             </tbody>
        </table>    
      </div>
    </div>
    <script>
       document.querySelector("#datum").style.display = 'none';
        document.querySelector("#datumi").addEventListener("change",function() {
          if(document.querySelector("#datumi").checked) {
            document.querySelector("#datum").style.display = 'none';
          } else {
            document.querySelector("#datum").style.display = 'inline';

          }
        })
    </script>
  </body>
</html>
