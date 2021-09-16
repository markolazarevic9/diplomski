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
  
    $pacijent = fetchPatient($_GET['id']);
    $karton = fetchKarton($pacijent->IDPACIJENT);
    $upit = "SELECT * FROM ADRESA WHERE IDADRESA = (SELECT IDADRESA FROM KARTON WHERE IDKARTON = {$karton->IDKARTON})";
    $rez = $db->query($upit);
    $adresa = mysqli_fetch_object($rez);
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
        <h2>Izmena pacijenta <?php echo $pacijent->IMEPACIJENT . " ". $pacijent->PREZIMEPACIJENT?> <hr></h2>
        <div id="div"></div>
        <?php
            if(isset($_GET['potvrdi']))
            {
                $ime = $_GET['ime'];
                $prezime = $_GET['prezime'];
                $id = $_GET['id'];
                $brtel = $_GET['brtel'];
                $adresa = $_GET['adresa'];
                $vakcinacija = $_GET['vakcinacija'];
                $alergije = $_GET['alergije'];
                $covidTest = $_GET['covidTest'];

                if($ime == "" || $prezime == "" || $brtel == "" || $adresa == "/" || $vakcinacija == "/" || $covidTest == "/" || $alergije == "")
                {
                    echo '<div class="alert alert-danger" role="alert">
                    Niste uneli sve podatke
                    </div>';
                }
                else
                {
                    $upit2 = "UPDATE KARTON SET IDADRESA = '$adresa',VAKCINISAN = '$vakcinacija',ALERGIJE = '$alergije',TEST  = '$covidTest' WHERE IDPACIJENT = '$id'";
                    $rez2 = $db->query($upit2);
                    $upit = "UPDATE pacijent SET IMEPACIJENT = '$ime',PREZIMEPACIJENT ='$prezime',BROJTELEFONA = '$brtel' WHERE IDPACIJENT = '$id'";
                    $rez = $db->query($upit);
                    if(!$rez || !$rez2)
                    {
                        echo '<div class="alert alert-danger" role="alert">
                            Nije uspeo upit
                        </div>';
                    }
                    else
                    {
                        echo '<div class="alert alert-info" role="alert">
                        Uspešno izmenjen pacijent
                      </div>';
                    }
                }
            }
        
        ?>
        <form action="izmeni.php" method="GET">
            <input  type="hidden" id="id" name='id' value=<?php echo $_GET['id']?>>
            <input type="text" id='ime' name="ime" value=<?php echo $pacijent->IMEPACIJENT?>>
            <input type="text" id='prezime' name="prezime" value=<?php echo $pacijent->PREZIMEPACIJENT?>>
            <input type="text" id='brtel' name="brtel" value="<?php echo $pacijent->BROJTELEFONA?>">
            <select name="adresa" id="adresa">
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
            <select name="vakcinacija" id="vakcinacija">
                <option value="/">--- Da li je pacijent vakcinisan ---</option>
                <option value="DA">Da</option>
                <option value="NE">Ne</option>
            </select>
            <input id='alergije' type="text" name="alergije" value=<?php echo $karton->ALERGIJE?>>
            <select name="covidTest" id="covidTest">
                    <option value="/">--- Izaberite opciju covid testa ---</option>
                    <option value="POZITIVAN">POZITIVAN</option>
                    <option value="NEGATIVAN">NEGATIVAN-</option>
                    <option value="NIJE TESTIRAN">NIJE TESTIRAN</option>
            </select>
          
           
            <input class="btn btn-info" id='potvrdi' type="submit" value="Potvrdi" name='potvrdi'>
        
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
