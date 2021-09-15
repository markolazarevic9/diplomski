<?php
  session_start();  
  require_once("functions.php");
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

    <title>Unos nove adrese</title>
    <style>
      h2 {
        font-size:25px;
        padding: 10px;
      }
      a:hover {
        color:white;
      }
     input {
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
        <h2>Unos nove adrese <hr></h2>
        <?php
        if(isset($_POST['potvrdi']))
        {
            $grad = $_POST['grad'];
            $ulica = $_POST['ulica'];
            $broj = $_POST['broj'];
            $pb = $_POST['pb'];

            if($grad == "" || $ulica == "" || $broj == "" || $pb == "")
            {
                echo '<div class="alert alert-danger" role="alert">
               Niste uneli sve podatke
               </div>';
            }
            else
            {
                require_once("components/db_connect.php");
                $upit  = "INSERT INTO ADRESA(GRAD,ULICA,BROJ,POSTANSKIBROJ) VALUES('$grad','$ulica','$broj','$pb')";
                $rez = $db->query($upit);
                if(!$rez)
                {
                    echo '<div class="alert alert-danger" role="alert">
                   Nije uspelo upisavanje adrese
                  </div>';
                }
                else
                {
                    echo '<div class="alert alert-info" role="alert">
                    Uspešno dodata adresa
                  </div>';
                }
            }
        }
      
      ?>
        <form action="adresa.php" method="post">
            <input type="text" name="grad" placeholder="Unesite grad">
            <input type="text" name="ulica" placeholder="Unesite Ulica">
            <input type="text" name="broj" placeholder="Unesite broj">
            <input type="text" name="pb" placeholder="Unesite postanski broj">
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
