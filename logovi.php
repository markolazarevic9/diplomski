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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
                 
                  showLogs($rez);

                ?>
             </tbody>
        </table>    
      </div>
    </div>
   
  </body>
</html>
