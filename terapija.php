<?php session_start()?>
<?php
    require_once("components/db_connect.php");
    $upit = "SELECT * FROM LEK";
    $rez = $db->query($upit);
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
    <title>Pacijenti</title>

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
          <hr />
          <div class="container">
           <?php 
           if($_SESSION['status'] == "lekar")
           {
             doctorTerLayout();
           }
           if($_SESSION['status'] == "tehnicar")
           {
             $patientId = $_GET['id'];
             $patient = fetchPatient($patientId);
             $karton = fetchKarton($patientId);
             if($karton->STATUSPACIJENTA == "HOSPITALIZOVAN")
             {
              tehTerLayout();
             }
           }
           ?>    
        </div>
        </div>
    </div>
  <script src="js/index.js"></script>
  <?php
    if($_SESSION['status'] == "lekar") 
    {
      echo '<script>
      let btn = document.querySelector("#potvrdi");
      let lek = document.querySelector("#lek");
      let doza = document.querySelector("#doza");
      let aplikovanje = document.querySelector("#aplikovanje");
      let period = document.querySelector("#period");
      let naDan = document.querySelector("#nadan");
      let napomena = document.querySelector("#napomena");
      let url = new URL(window.location.href);
      let patientId = url.searchParams.get("id");


      btn.addEventListener("click", function() {
        lekText = Number(lek.value) + 1;
        if(lek.value == "/" || doza.value == "" || aplikovanje.value == "" || period.value == "" || naDan.value == "") {
          alert("Niste uneli sve parametre");
        } else {
          if(confirm(`Potrvdi terapiju \n Lek: ${lek.options[lekText].text} \n Doza: ${doza.value} \n Aplikovanje: ${aplikovanje.value} \n Na dan: ${naDan.value} \n Period: ${period.value} \n Napomena: ${napomena.value}`)) {
            $.get("ajax/upisiTerapiju.php", {lek: lek.value,doza:doza.value,aplikovanje:aplikovanje.value,naDan:naDan.value,period:period.value,napomena:napomena.value,patientId:patientId},function(odg) {
              alert(odg);
              lek.value = "/";
              doza.value = "";
              aplikovanje.value = "";
              period.value = "";
              naDan.value = "";
              napomena.value = "";
            })
          }
        }
      })
  </script>';
    } 
  ?>
 
  <?php
    if($_SESSION['status'] == "tehnicar")
    {
      echo '<script>
              let zabelezi = document.querySelectorAll(".zabelezi");
              let url = new URL(window.location.href);
              let patientId = url.searchParams.get("id");
              for (const btn of zabelezi) {
                 btn.addEventListener("click",function() {
                 let terapijaId = this.getAttribute("data-id");
                 if(confirm("Da li zelite da zabelezite terapiju")) {
                    $.get("ajax/potrvdiTerapiju.php", {terapijaId:terapijaId,pacijentId:patientId},function(odg) {
                      alert(odg);
                      location.reload();
            })
          }
  
        })
      }
    </script>';
    }
  
  ?>
  
  </body>
</html>
