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

    <title>Dodaj pacijenta</title>
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
        <h2>Unos novog pacijenta <hr></h2>
        <?php
             if(isset($_POST['potvrdi']))
             {
                 $ime = $_POST['ime'];
                 $prezime = $_POST['prezime'];
                 $adresa = $_POST['adresa'];
                 $pol = $_POST['pol'];
                 $brtel = $_POST['brtel'];
                 $jmbg = $_POST['jmbg'];
                 $lbo = $_POST['lbo'];
                 $vakcinacija = $_POST['vakcinacija'];
                 $krvnaGrupa = $_POST['krvnaGrupa'];
                 $alergije = $_POST['alergije'];
                 $covidTest = $_POST['covidTest'];


                 if($ime == "" || $prezime == "" || $adresa == "/" || $pol == "" || $jmbg == "" || $lbo == "")
                 {
                     echo '<div class="alert alert-danger" role="alert">
                    Niste uneli sve podatke
                    </div>';
                 }
                 else
                 {
                     require_once("components/db_connect.php");
                     $upit  = "INSERT INTO PACIJENT(IMEPACIJENT,PREZIMEPACIJENT,JMBG,LBO,POL,BROJTELEFONA) VALUES('$ime','$prezime','$jmbg','$lbo','$pol','$brtel')";
                     $rez = $db->query($upit);
                     $id = $db->insert_id();
                     $upit2 = "INSERT INTO KARTON (IDPACIJENT,IDADRESA,VAKCINISAN,ALERGIJE,KRVNAGRUPA,TEST) VALUES ('$id','$adresa','$vakcinacija','$alergije','$krvnaGrupa','$covidTest')";
                     $rez2 = $db->query($upit2);
                     if(!$rez || !$rez2)
                     {
                         echo '<div class="alert alert-danger" role="alert">
                        Nije uspelo upisavanje pacijenta
                       </div>';
                       echo $id;
                     }
                     else
                     {
                         echo '<div class="alert alert-info" role="alert">
                         Uspešno dodat pacijent
                       </div>';
                     }
                 }
             }
        ?>
        <form action="unosPacijenta.php" method="post">
            <input type="text" name="ime" placeholder="Unesite ime">
            <input type="text" name="prezime" placeholder="Unesite prezime">
            <select name="pol" id="pol">
                    <option value="0">--- Izaberite pol ---</option>
                    <option value="M">M</option>
                    <option value="Ž">Ž</option>   
            </select>
            <input type="text" name="jmbg" placeholder="Unesite jmbg">
            <input type="text" name="lbo" placeholder="Unesite lbo">
            <input type="text" name="brtel" placeholder="Unesite broj telefona">
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
            <select name="vakcinacija" id="vakcinacija">
                <option value="">--- Da li je pacijent vakcinisan ---</option>
                <option value="DA">Da</option>
                <option value="NE">Ne</option>
            </select>
            <input type="text" name="alergije" placeholder="Unesite alergije">
            <select name="krvnaGrupa" id="krvnaGrupa">
                    <option value="0">--- Izaberite krvnu grupu ---</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
            </select>
            <select name="covidTest" id="covidTest">
                    <option value="0">--- Izaberite opciju covid testa ---</option>
                    <option value="POZITIVAN">POZITIVAN</option>
                    <option value="NEGATIVAN">NEGATIVAN-</option>
                    <option value="NIJE TESTIRAN">NIJE TESTIRAN</option>
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
