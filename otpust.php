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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Otpust</title>
  </head>
  <style>
          input,select,textarea {
        padding: 10px;
        width: 60%;
        text-align: center;
      }
      .container {
        text-align: center;
      }
      h2 {
        padding: 5px !important;
        margin-bottom: 0;
      }
      .odeljenje {
        margin-top: 30px;
        margin-bottom: 30px;
      }
      .accordion-item {
        width: 60%;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
      }
      .accordion-button {
        text-align: center;
      }
      .btn-success a {
        color: white;
        text-decoration: none;
      }
  </style>
  <body>
    <?php require_once("components/header.php") ?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>
      <div class="main">
        <h2>Otpust pacijenta <?php echo $patient->IMEPACIJENT . " ". $patient->PREZIMEPACIJENT?> <hr></h2>
        <div class="container">
            <h4>Status pacijenta</h4>
            <select name="status" id="status">
              <option value='0'>--- Izaberite status pacijenta ---</option>
              <option value='1'>ZDRAV</option>
              <option value='2'>PREMINUO</option>
              <option value='2'>KUĆNO LEČENJE</option>
            </select>
           
            <h4>Dijagnoze</h4>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                       <table class="table">
                          <thead>
                            <tr>
                              <th scope='col'>#</th>
                              <th scope='col'>Naziv</th>
                              <th scope='col'>Datum dijagnostike</th>
                              <th scope='col'>Tip</th>
                              <th scope='col'>Izlecen</th>
                              <th scope='col'>Zabelezi</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                                $kartonId = $karton->IDKARTON;
                                $upit = "SELECT * FROM spisak_dijagnoza WHERE IDKARTON = {$kartonId} AND DATUM_IZLECENJA IS NULL ORDER BY DATUM_DIJAGNOSTIKE";
                                $rez = $db->query($upit);
                                $counter = 1;
                                foreach($rez as $value)
                                {
                                  $dijagnoza = fetchDijagnoza($value['IDDIJAGNOZA']);
                                  $datum = showOnlyDate($value['DATUM_DIJAGNOSTIKE']);
                                  echo "
                                  <tr>
                                    <th scope='row'>{$counter}</th>
                                    <td>{$dijagnoza->NAZIVDIJAGNOZA}</td>
                                    <td>{$datum}</td>
                                    <td><input id='tip' value='{$value['TIP']}'></input></td>
                                    <td><input id='izlecen' type='checkbox'></td>
                                    <td class='td'><button data-karton='{$kartonId}' data-id='{$dijagnoza->IDDIJAGNOZA}' class='btn btn-success dugme'>Zabelezi</button></td>
                                  </tr>";
                                  $counter++;
                                }
                              
                              ?>
                          </tbody>
                        
                        </table>
                    </div>
                  </div>
                </div>
            </div>
            <h4 id="h4">Napomena</h4>
            <textarea name="napomena" id="napomena" cols="30" rows="5"></textarea>

            
           
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

     
        document.querySelectorAll(".dugme").forEach(item => {
          item.addEventListener("click", event => {
            // console.log(item.parentElement.parentElement);
            let karton = item.getAttribute("data-karton");
            let dijagnoza = item.getAttribute("data-id");
            let tip = item.parentElement.parentElement.childNodes[7].children[0].value;
            let izlecen = item.parentElement.parentElement.childNodes[9].children[0].checked;
            if(confirm("Da li ste sigurni da zelite da uklonite dijagnozu")) {
              $.get("ajax/izleci.php",{dijagnoza:dijagnoza,karton:karton,tip:tip,izlecen:izlecen},function(odg) {
                item.parentElement.parentElement.childNodes[9].children[0].disabled = true;
                item.parentElement.parentElement.childNodes[7].children[0].disabled = true;
                item.parentElement.innerHTML = odg;
            })
            }            
          })
        })

      
        
    </script>
  </body>
</html>
