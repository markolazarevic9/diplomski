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

<?php
  
    $radnik = fetchRadnik($_GET['id']);
    $upit = "SELECT * FROM ADRESA WHERE IDADRESA = (SELECT IDADRESA FROM RADNIK WHERE IDRADNIK = {$radnik->IDRADNIK})";
    $rez = $db->query($upit);
    $adresa = mysqli_fetch_object($rez);
    $idRadnika = $_GET['id'];
    $upitPristup = "SELECT * FROM PRISTUP WHERE IDRADNIK = {$radnik->IDRADNIK}";
    $rezPristup = $db->query($upitPristup);
    $pristup = mysqli_fetch_object($rezPristup);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Izmeni pacijenta</title>
    <style>
      h2 {
        font-size:25px;
        padding: 5px !important;
        margin-bottom: 0;
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
      body {
          overflow-y: scroll;
      }
    </style>
  </head>
  <body>
    <?php require_once("components/header.php")?>
    
    <div class="central">
      <?php require_once("components/sidebar.php")?>
      
      <div class="main container">
        <h2>Izmena radnika <?php echo $radnik->IMERADNIK . " ". $radnik->PREZIMERADNIK?> <hr></h2>
        <div id="div"></div>
      
        <form>
            <input  type="hidden" id="id" name='id' value=<?php echo $_GET['id']?>>
            <input type="text" id='ime' name="ime" value=<?php echo $radnik->IMERADNIK?>>
            <input type="text" id='prezime' name="prezime" value=<?php echo $radnik->PREZIMERADNIK?>>
            <select name="adresa" id="adresa">
                <option value="/">--- Izaberite adresu ---</option>
                <?php
                    $upit = "SELECT * FROM ADRESA";
                    $rez = $db->query($upit);
                    foreach($rez as $value)
                    {
                        if($value['IDADRESA'] == $adresa->IDADRESA)
                        {
                            echo "<option selected value='{$value['IDADRESA']}'>{$value['GRAD']}" . ", ". "{$value['ULICA']}" . ", " ."{$value['BROJ']} </option>";
                        } 
                        else
                        {
                            echo "<option value='{$value['IDADRESA']}'>{$value['GRAD']}" . ", ". "{$value['ULICA']}" . ", " ."{$value['BROJ']} </option>";
                        }
                      
                    }
                ?>
            </select>
            <select name="odeljenje" id="odeljenje">
                <?php
                    $upit = "SELECT * FROM ODELJENJE";
                    $rez = $db->query($upit);
                    foreach($rez as $value)
                    {
                        if($value['IDODELJENJE'] == $radnik->IDODELJENJE)
                        {
                            echo "<option selected value='{$value['IDODELJENJE']}'>{$value['NAZIVODELJENJE']}</option>";
                        } 
                        else
                        {
                            echo "<option selected value='{$value['IDODELJENJE']}'>{$value['NAZIVODELJENJE']}</option>";

                        }
                    }
                ?>
            </select> <br><br>
            <h5>Specijalizacija</h5>
            <input type="text" name="spec" id="spec" value=<?php echo $radnik->SPEC?>> <br><br>
            <h5>Pozicija</h5>
            <input type="text" name="pozicija" id="pozicija" value=<?php echo $radnik->POZICIJA?>>
            <input type="date" name="datZap" id="datZap" value=<?php echo $radnik->DAT_ZAP?>>
            <select name="vakcinisan" id="vakcinisan">
                <?php
                    if($radnik->VAKCINISAN = "DA")
                    {
                        echo "<option selected value='DA'>Vakcinisan: Da</option> <option value='NE'>Vakcinisan: Ne</option>";
                      
                    }
                    else
                    {
                        echo "<option value='DA'>Vakcinisan: Da</option><option selected value='NE'>Vakcinisan: Ne</option>";
                    }
                ?>
            </select>
            <h5>Korisnicko ime</h5>
            <input type="text" name="korisnickoIme" id="korisnickoIme" value=<?php echo $pristup->KORISNICKOIME?>>
            <h5>Lozinka</h5>
            <input type="text" name="lozinka" id="lozinka" value=<?php echo $pristup->LOZINKA?>>


            <input class="btn btn-info" id='potvrdi' type="submit" value="Potvrdi" name='potvrdi'>
        </form>
      </div>
      <script>
        
    let btn =  document.querySelector("#potvrdi");
    btn.addEventListener("click", () => {
      let ime = document.querySelector("#ime").value;
      let prezime = document.querySelector("#prezime").value;
      let id = document.querySelector("#id").value;
      let odeljenje = document.querySelector("#odeljenje").value;
      let adresa = document.querySelector("#adresa").value;
      let spec = document.querySelector("#spec").value;
      let pozicija = document.querySelector("#pozicija").value;
      let datZap = document.querySelector("#datZap").value;
      let vakcinisan = document.querySelector("#vakcinisan").value;
      let lozinka = document.querySelector("#lozinka").value;
      let korisnickoIme = document.querySelector("#korisnickoIme").value;



      $.get("ajax/izmeniRadnika.php",{ime:ime,prezime:prezime,id:id,odeljenje:odeljenje,adresa:adresa,vakcinisan:vakcinisan,spec:spec,pozicija:pozicija,datZap:datZap,vakcinisan:vakcinisan,lozinka:lozinka,korisnickoIme:korisnickoIme},function(odg) {
        alert(odg);
      })

    })
      </script>
    </div>
 
     
  </body>
</html>
