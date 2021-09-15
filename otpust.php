<?php session_start() ?>
<?php require_once('components/db_connect.php')?>
<?php require_once('functions.php')?>

<?php 
  $patientId = $_GET['id'];
  $patient = fetchPatient($patientId);
  $karton = fetchKarton($patientId);
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

    <title>Otpust</title>
  </head>
  <style>
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
        <!-- <h2 id="mainH">Prijem <hr></h2> -->
        <div class="container">
            <h3>Status pacijenta</h3>
            <select name="status" id="status" onchange="prikazDijagnoza()">
              <option value='0'>--- Izaberite status pacijenta ---</option>
              <option value='1'>ZDRAV</option>
              <option value='2'>PREMINUO</option>
              <option value='2'>KUĆNO LEČENJE</option>
            </select>
            
            <h3 id="h3">Napomena</h3>
            <textarea name="napomena" id="napomena" cols="30" rows="10"></textarea>
            <input id="btn" class="btn btn-info" type="submit" value="Potvrdi">
        </div>
       
      </div>
    </div>

    <script>
        let btn =  document.querySelector("#btn");
        let url = new URL(window.location.href);
        let patientId = url.searchParams.get("id");

        btn.addEventListener("click", () => {
          let status = document.querySelector("#status").options[document.querySelector("#status").value].text;
          let napomena = document.querySelector("#napomena").value;
          $.get("ajax/otpustPacijenta.php",{status:status,napomena:napomena,patientId:patientId},function(odg) {
            alert(odg);
          })
        })

        function prikazDijagnoza() {
          let div = document.createElement('div');
          let selected = document.querySelector("#status");
          if(selected.options[selected.value].text == "ZDRAV" || selected.options[selected.value].text == "KUĆNO LEČENJE") {
            $.get("ajax/dijagnoze.php",{patientId:patientId}, function(odg) {
              dvi.innerHTML += odg;
            })

          }
        }
        
    </script>
  </body>
</html>
