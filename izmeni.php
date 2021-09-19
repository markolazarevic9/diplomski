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
       
        <form>
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
                <?php
                  if($karton->VAKCINACIJA == "DA")
                  {
                    echo "<option selected value='DA'>Da</option>
                    <option value='NE'>Ne</option>";
                  }
                  else
                  {
                    echo "<option value='DA'>Da</option>
                    <option selected value='NE'>Ne</option>";
                  }
                ?>
            </select>
            <input id='alergije' type="text" name="alergije" value=<?php echo $karton->ALERGIJE?>>
            <select name="covidTest" id="covidTest">
                    <option value="/">--- Izaberite opciju covid testa ---</option>
                    <?php
                      if($karton->TEST == "POZITIVAN")
                      {
                       echo '<option selected value="POZITIVAN">POZITIVAN</option>
                       <option value="NEGATIVAN">NEGATIVAN-</option>
                       <option value="NIJE TESTIRAN">NIJE TESTIRAN</option>';
                      }
                      elseif($karton->TEST == "NEGATIVAN")
                      {
                        echo '<option value="POZITIVAN">POZITIVAN</option>
                       <option selected value="NEGATIVAN">NEGATIVAN-</option>
                       <option value="NIJE TESTIRAN">NIJE TESTIRAN</option>';
                      }
                      else
                      {
                        echo '<option value="POZITIVAN">POZITIVAN</option>
                        <option value="NEGATIVAN">NEGATIVAN-</option>
                        <option selected value="NIJE TESTIRAN">NIJE TESTIRAN</option>';
                      }
                    ?>
                    
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

    let btn =  document.querySelector("#potvrdi");
    btn.addEventListener("click", () => {
      let ime = document.querySelector("#ime").value;
      let prezime = document.querySelector("#prezime").value;
      let id = document.querySelector("#id").value;
      let brtel = document.querySelector("#brtel").value;
      let adresa = document.querySelector("#adresa").value;
      let vakcinacija = document.querySelector("#vakcinacija").value;
      let alergije = document.querySelector("#alergije").value;
      let covidTest = document.querySelector("#covidTest").value;

      $.get("ajax/izmeniPacijenta.php",{ime:ime,prezime:prezime,id:id,brtel:brtel,adresa:adresa,vakcinacija:vakcinacija,alergije:alergije,covidTest:covidTest},function(odg) {
        alert(odg);
      })

    })
  </script>
  </body>
</html>
