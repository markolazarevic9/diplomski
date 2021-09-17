<?php session_start();
  if(!isset($_SESSION['ime'])) 
  {
    header("location:login.php");
  }

?>
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
        padding: 5px !important;
        margin-bottom: 0;
      }
    
  </style>
  <body>
    <?php require_once("components/header.php") ?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>
      <div class="main">
        <h2 id="mainH">Prijem pacijenta <?php echo $patient->IMEPACIJENT . " ". $patient->PREZIMEPACIJENT?><hr></h2>
        <div class="container">
            <h4>Status pacijenta</h4>
            <select name="status" id="status" onchange="odeljenje()">
              <option value='0'>--- Izaberite status pacijenta ---</option>
              <option value='1'>KUĆNO LEČENJE</option>
              <option value='2'>HOSPITALIZOVAN</option>
            </select>
            <h4>Dijagnoza</h4>
            <select name="dijagnoza" id="dijagnoza">
              <option value='0'>--- Izaberite dijagnozu ---</option>
                <?php
                  $kartonId = $karton->IDKARTON;
                  $upit = "SELECT * FROM DIJAGNOZA";
                  $rez = $db->query($upit);
                  foreach($rez as $value)
                  {
                      echo "<option value='{$value['IDDIJAGNOZA']}'>{$value['NAZIVDIJAGNOZA']}</option>";
                  } 
                ?>
            </select>
            <select name="tip" id="tip">
              <option value="/">--- Izaberi tip dijagnoze ---</option>
              <option value="AKUTNO">Akutno</option>
              <option value="AKUTNO">Hronično</option>
            </select>
            <div class="div"> <h4>Izaberite odeljenje</h4></div>
            <div class="div2"></div>

            <h4 id="h4">Napomena</h4>
            <textarea name="napomena" id="napomena" cols="30" rows="5"></textarea>
            <input id="btn" class="btn btn-info" type="submit" value="Potvrdi">
        </div>
       
      </div>
    </div>

    <script>
        let div2 = document.querySelector(".div2");
        div2.style.display = "none";
        let btn =  document.querySelector("#btn");
        let url = new URL(window.location.href);
        let patientId = url.searchParams.get("id");
        let soba = document.createElement("select");
        soba.innerHTML = "<option  value='/'>--- Izaberite odeljenje ---</option> <option value='4'>Intenzivna nega</option> <option value='1'>Poluintenzivna nega</option>";
        soba.classList.add("odeljenje");
        soba.setAttribute("name","odeljenje");
        
        document.querySelector(".div").appendChild(soba);
     
       
        function odeljenje() {
         
          if(document.querySelector("#status").options[document.querySelector("#status").value].text == "HOSPITALIZOVAN") {
            document.querySelector(".div").style.display = "inline";
          } else {
            document.querySelector(".div").style.display = "none";
          }
         
        }
        if(document.querySelector(".odeljenje")) {
          let odeljenje = document.querySelector(".odeljenje");
          odeljenje.addEventListener("change",function() {
            $.get("ajax/soba.php",{odeljenje:odeljenje.value},function(odg) {
              $(".div2").html(odg);
            })
          })
        }
      
        btn.addEventListener("click", () => {
          let status = document.querySelector("#status").options[document.querySelector("#status").value].text;
          let napomena = document.querySelector("#napomena").value;
          $.get("ajax/prijemPacijenta.php",{status:status,napomena:napomena,patientId:patientId,odeljenje:odeljenje},function(odg) {
            alert(odg);
          })
        })

    </script>
  </body>
</html>
