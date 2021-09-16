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
        <?php
           if(isset($_GET['potvrdi']))
           {
            $id = $_GET['id'];
            $ime = $_GET['ime'];
            $prezime = $_GET['prezime'];
            $adresa = $_GET['adresa'];
            $odeljenje = $_GET['odeljenje'];
            $spec = $_GET['spec'];
            $pozicija = $_GET['pozicija'];
            $datZap = $_GET['datZap'];
            $vakcinisan = $_GET['vakcinisan'];

            $isEmpty = $ime == "" || $prezime == "" || $adresa == "" || $odeljenje == "" || $spec == "" || $pozicija == "" || $datZap == "";
            if($isEmpty)
            {
                echo '<div class="alert alert-danger" role="alert">
                Niste uneli sve podatke
                </div>';
            }
            else
            {
                $upit = "UPDATE radnik SET IMERADNIK = '$ime'
                ,PREZIMERADNIK = '$prezime'
                ,IDADRESA = '$adresa',
                SPEC = '$spec',DAT_ZAP = '$datZap',
                VAKCINISAN = '$vakcinisan',
                IDODELJENJE = '$odeljenje',
                POZICIJA = '$pozicija' WHERE IDRADNIK = '$id'";
                $rez = $db->query($upit);

                if(!$rez)
                {
                    echo   '<div class="alert alert-danger" role="alert">
                    Nije uspela izmena podataka
                    </div>';
                    echo $db->error();
                 
                }
                else
                {
                    echo '<div class="alert alert-success" role="alert">
                    Uspesno izmenjeni podaci
                    </div>';
                }
            }
            }



        
        ?>
        <form action="izmeniRadnika.php" method="GET">
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


            <input class="btn btn-info" id='potvrdi' type="submit" value="Potvrdi" name='potvrdi'>
        </form>
      </div> <br>
    </div>
 
     
  </body>
</html>
