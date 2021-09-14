<?php session_start() ?>
<?php require_once('components/db_connect.php')?>
<?php require_once('functions.php')?>

<?php 
  $patientId = $_GET['id'];
  echo $patientId;
  function fetchKarton($id)
  {
    require_once("classes/db.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
    }
    $upit = "SELECT * FROM KARTON WHERE IDPACIJENT = {$id}";
    $rez = $db -> query($upit);
    $karton = mysqli_fetch_object($rez);
    return $karton;
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css" />

    <title>Prijem</title>
  </head>
  <style>
      body {
          overflow-y: scroll;
      }
          input,select,textarea {
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
      .odeljenje {
        margin-top: 30px;
        margin-bottom: 30px;
      }
  </style>
  <body>
    <?php require_once("components/header.php") ?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>
      <div class="main">
        <h2 id="mainH">Dijagnostika <hr></h2>
        <div class="container">
           <form>
               <input type="text" name="naziv" placeholder="Unesite naziv izveštaja">
               <select name="dijagnoza" id="dijagnoza">
                   <option value="0">--- Izaberite dijagnozu ---</option>
                   <?php
                        $kartonId = $karton->IDKARTON;
                        $upit = "SELECT * FROM DIJAGNOZA WHERE IDDIJAGNOZA IN (SELECT IDDIJAGNOZA FROM SPISAK_DIJAGNOZA WHERE IDKARTON = '$kartonId')";
                        $rez = $db->query($upit);
                        foreach($rez as $value)
                        {
                            echo "<option value='{$value['IDDIJAGNOZA']}'>{$value['NAZIVDIJAGNOZA']}</option>";
                        }
                   
                   ?>
               </select>
               <input type="text" name="uzorak" placeholder="Unesite uzorak">
               <input type="text" name="vrednost" placeholder="Unesite vrednost">
               <textarea name="opis" id="opis" cols="30" rows="5" placeholder="Unesite opis"></textarea>
               <textarea name="anamneza" id="anamneza" cols="30" rows="5" placeholder="Unesite anamnezu"></textarea>
               <textarea name="zakljucak" id="zakljucak" cols="30" rows="5" placeholder="Unesite zakljucak"></textarea>
               <input id="btn" class="btn btn-info" type="submit" value="Potvrdi">
           </form>
        </div>
       
      </div>
    </div>
      <script>
           let url = new URL(window.location.href);
           let patientId = url.searchParams.get("id");
           let naziv = document.getElementsByName('naziv').value;
           let uzorak = document.getElementsByName('uzorak').value;
           let vrednost = document.getElementsByName('vrednost').value;
           let opis = document.getElementsByName('opis').value;
           let anamneza = document.getElementsByName('anamneza').value;
           let zakljucak = document.getElementsByName('zakljucak').value;
           let btn = document.querySelector('#btn');

          btn.addEventListener("click", function() {
              let dijagnoza = document.querySelector('#dijagnoza').value;
              if(naziv != "" && opis != "" && zakljucak != "" && dijagnoza != 0) {
                  $.get("ajax/izvestaj.php",{naziv:naziv,uzorak:uzorak,vrednost:vrednost,opis:opis,anamneza:anamneza,zakljucak:zakljucak,patientId:patientId,dijagnoza:dijagnoza},function(odg) {
                      alert(odg);
                  })
              }
          })


      </script>
  </body>
</html>
