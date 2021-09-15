<?php
  session_start();  
  require_once("functions.php");
  require_once("components/db_connect.php");

  if(!isset($_SESSION['ime'])) 
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

    <title>Dodaj dijagnoza</title>
    <style>
      h2 {
        font-size:25px;
        padding: 10px;
      }
      a:hover {
        color:white;
      }
     input,textarea{
        padding: 10px;
        width: 50%;
        text-align: center;
      }
      .container {
        text-align: center;
      }
      h2 {
        padding: 5px;
        margin-bottom: 0;
      }
    </style>
  </head>
  <body>
    <?php require_once("components/header.php")?>
    
    <div class="central">
      <?php require_once("components/sidebar.php")?>
      
      <div class="main container">
        <h2>Unos dijagnoze <hr></h2>
        <?php
             if(isset($_POST['potvrdi']))
             {
                 $naziv = $_POST['naziv'];
                 $sifra = $_POST['sifra'];
                 $opis = $_POST['opis'];
                 
                 if($naziv == "" || $sifra == "")
                 {
                     echo '<div class="alert alert-danger" role="alert">
                    Niste uneli sve podatke
                    </div>';
                 }
                 else
                 {
                     require_once("components/db_connect.php");
                     $upit = "INSERT INTO DIJAGNOZA(NAZIVDIJAGNOZA,SIFRADIJAGNOZA,OPISDIJAGNOZA) VALUES('$naziv','$sifra','$opis')";
                     $rez = $db->query($upit);
                     if(!$rez)
                     {
                         echo '<div class="alert alert-danger" role="alert">
                        Nije uspelo upisavanje dijagnoze
                       </div>';
                       echo $id;
                     }
                     else
                     {
                         echo '<div class="alert alert-info" role="alert">
                         Uspešno dodata dijagnoza
                       </div>';
                     }
                 }
             }
        ?>
        <form action="dodajDijagnozu.php" method="post">
            <input type="text" name="naziv" placeholder="Unesite naziv dijagnoze">
            <input type="text" name="sifra" placeholder="Unesite sifru dijagnoze">
            <textarea name="opis" id="opis" cols="30" rows="10" placeholder="Unesite opis"></textarea>
           
            <input class="btn btn-info" type="submit" value="Potvrdi" name='potvrdi'>
        </form>
      </div> <br>
    </div>
  <script>
      if (document.querySelector("body > div.central > div.main.container > div")) {
         setTimeout(function () {
            document.querySelector("body > div.central > div.main.container > div").style.display = "none";
     }, 2000);
    }

  </script>
  </body>
</html>
