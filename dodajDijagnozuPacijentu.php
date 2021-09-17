<?php session_start()?>
<?php
    require_once("components/db_connect.php");
    require_once("functions.php");
    $upit = "SELECT * FROM DIJAGNOZA";
    $rez = $db->query($upit);
    $idPacijent = $_GET['id'];
    $pacijent = fetchPatient($idPacijent);
    $karton = fetchKarton($idPacijent);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <script
      src="https://kit.fontawesome.com/486587c22a.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/pacijenti.css" />
    <link rel="stylesheet" href="css/dashboard.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Unos dijagnoza pacijenta</title>

    <style>
   
      input,select,textarea {
        padding: 10px;
        width: 50%;
        text-align: center;
      }
      .container {
        text-align: center;
      }
    </style>
  </head>
  
  <body>
   <?php require_once("components/header.php")?>
    <div class="central">
      <?php require_once("components/sidebar.php")?>
        <div class="main">
          <h2>Unesite dijagnozu za <?php echo $pacijent->IMEPACIJENT . " ". $pacijent->PREZIMEPACIJENT?></h2><hr />
          <div class="container">
              <input type="hidden" name="karton" id="karton" value="<?php echo $karton->IDKARTON?>">
             <select name="dijagnoze" id="dijagnoze">
                 <option value="/">--- Izaberite dijagnozu ---</option>
                 <?php
                    foreach($rez as $dijagnoza)
                    {
                        echo "<option value={$dijagnoza['IDDIJAGNOZA']}>{$dijagnoza['NAZIVDIJAGNOZA']}" ." " ."{$dijagnoza['SIFRADIJAGNOZA']} </option>";
                    }
                 ?>
             </select>
             <select name="tip" id="tip">
                 <option value="/">--- Izaberite tip ---</option>
                 <option value="AKUTNO">Akutno</option>
                 <option value="HRONICNO">Hronicno</option>
             </select> <br>
             <label for="datum">Unesite datum dijagnostike</label> <br>
             <input type="date" name="datum" id="datum">
             <input class="btn btn-info" type="submit" value="Potvrdi" name="potvrdi" id="potvrdi">
        </div>
        </div>
    </div>
    <script>
        let btn = document.querySelector("#potvrdi");

       btn.addEventListener("click", () => {
            let dijagnoze = document.querySelector("#dijagnoze").value;
            let tip = document.querySelector("#tip").value;
            let datum = document.querySelector("#datum").value;
            let karton = document.querySelector("#karton").value;
            let isEmpty = dijagnoze == "/" || tip == "/" || datum == "";
           if(isEmpty) {
               alert("Niste uneli sve podatke");
           } else {
               $.get("ajax/dodajDijagnozu.php",{dijagnoze:dijagnoze,tip:tip,datum:datum,karton:karton}, function(odg) {
                 alert(odg);
                 dijagnoze = "/";
                 tip = "/";
                 datum = "";
               })
           }
       })

    </script>
 
  
  </body>
</html>
