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

    <title>Dodaj radnika</title>
    <style>
      h2 {
        font-size:25px;
        padding: 10px;
      }
      a:hover {
        color:white;
      }
     input,select{
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
        <h2>Unos novog radnika <hr></h2>

        <?php
             if(isset($_POST['potvrdi']))
             {
                 $ime = $_POST['ime'];
                 $prezime = $_POST['prezime'];
                 $adresa = $_POST['adresa'];
                 $odeljenje = $_POST['odeljenje'];
                 $spec = $_POST['spec'];
                 $datZap = $_POST['datZap'];
                 $korisnickoIme = $_POST['korisnickoIme'];
                 $lozinka = $_POST['lozinka'];
                 $status = $_POST['status'];
                 $odeljenje = $_POST['odeljenje'];

                 if($ime == "" || $prezime == "" || $adresa == "/" || $spec == "" || $datZap == "" || $korisnickoIme == "" || $lozinka == "" || $status == "/")
                 {
                     echo '<div class="alert alert-danger" role="alert">
                    Niste uneli sve podatke
                    </div>';
                 }
                 else
                 {
                     require_once("components/db_connect.php");
                     $upit  = "INSERT INTO RADNIK(IMERADNIK,PREZIMERADNIK,SPEC,DAT_ZAP,POZICIJA,IDODELJENJE,IDADRESA) VALUES('$ime','$prezime','$spec','$datZap','$status','$odeljenje','$adresa')";
                     $rez = $db->query($upit);
                     $id = $db->insert_id();
                     $upit2 = "INSERT INTO PRISTUP(IDRADNIK,KORISNICKOIME,LOZINKA,STATUS) VALUES ('$id','$korisnickoIme','$lozinka','$status')";
                     $rez2 = $db->query($upit2);
                     if(!$rez || !$rez2)
                     {
                         echo '<div class="alert alert-danger" role="alert">
                        Nije uspelo upisavanje radnika
                       </div>';
                     }
                     else
                     {
                         echo '<div class="alert alert-info" role="alert">
                         Uspešno dodat radnik
                       </div>';
                     }
                 }
             }
        ?>
        <form action="dodajRadnika.php" method="post">
            <input type="text" name="ime" placeholder="Unesite ime">
            <input type="text" name="prezime" placeholder="Unesite prezime">
            <select name="adresa" id="adresa">
                <option value="/">--- Izaberite adresu ---</option>
                <?php
                    $upit = "SELECT * FROM ADRESA";
                    $rez = $db->query($upit);
                    foreach($rez as $adresa)
                    {
                        echo "<option value='{$adresa['IDADRESA']}'>{$adresa['GRAD']}" . ", ". "{$adresa['ULICA']}" . ", " ."{$adresa['BROJ']} </option>";
                    }
                ?>
            </select>
            <select name="odeljenje" id="odeljenje">
                <option value="/">--- Izaberite odeljenje ---</option>
                <?php
                    $upit = "SELECT * FROM odeljenje";
                    $rez = $db->query($upit);
                    foreach($rez as $odeljenje)
                    {
                        echo "<option value='{$odeljenje['IDODELJENJE']}'>{$odeljenje['NAZIVODELJENJE']}</option>";
                    }
                ?>
            </select>
            <input type="text" name="spec" placeholder="Unesite specijalizaciju">
            <input type="date" name="datZap">
            <input type="text" name="korisnickoIme" placeholder="Unesite korisnicko ime">
            <input type="text" name="lozinka" placeholder="Unesite lozinku">

            <select name="status" id="status">
                <option value="/">--- Izaberite status korisnika ---</option>
                <option value="lekar">Lekar</option>
                <option value="tehnicar">Tehničar</option>
                <option value="admin">Admin</option>
            </select>
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
