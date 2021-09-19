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
    $upitUkupno = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NOT NULL";
    $rezUkupno = $db->query($upitUkupno);
    $ukupno = (mysqli_fetch_row($rezUkupno))[0];

    $upitM = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IN (SELECT IDKARTON FROM KARTON WHERE IDPACIJENT in (SELECT IDPACIJENT FROM PACIJENT WHERE POL = 'M'))";
    $rezM = $db->query($upitM);
    $m = mysqli_fetch_row($rezM)[0];

    $mProcenat = ($m / $ukupno) * 100 . " %";

    $upitZ = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IN (SELECT IDKARTON FROM KARTON WHERE IDPACIJENT in (SELECT IDPACIJENT FROM PACIJENT WHERE POL = 'Ž'))";
    $rezZ = $db->query($upitZ);
    $z = mysqli_fetch_row($rezZ)[0];

    $zProcenat = ($z / $ukupno) * 100 . " %";

    $upitVakc = "SELECT COUNT(IDKARTON) FROM KARTON WHERE VAKCINISAN = 'DA' AND IDKARTON IN (SELECT IDKARTON FROM KREVET)";
    $rezVakc = $db->query($upitVakc);
    $vakc = mysqli_fetch_row($rezVakc)[0];

    $vakcProcenat = ($vakc / $ukupno) * 100 . " %";

    $upitNeVakc = "SELECT COUNT(IDKARTON) FROM KARTON WHERE VAKCINISAN = 'NE' AND IDKARTON IN (SELECT IDKARTON FROM KREVET)";
    $rezNeVakc = $db->query($upitNeVakc);
    $neVakc = mysqli_fetch_row($rezNeVakc)[0];

    $neVakcProcenat = ($neVakc / $ukupno) * 100 . " %";

    $sqlInt = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NOT NULL AND IDSOBA IN (SELECT IDSOBA FROM SOBA WHERE IDODELJENJE = (SELECT IDODELJENJE FROM ODELJENJE WHERE NAZIVODELJENJE = 'Intenzivna nega'))";
    $rezInt = $db->query($sqlInt);
    $brojInt = mysqli_fetch_row($rezInt)[0];

    $intProcenat = ($brojInt / $ukupno) * 100 . " %";
    $sqlPolu = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NOT NULL AND IDSOBA IN (SELECT IDSOBA FROM SOBA WHERE IDODELJENJE = (SELECT IDODELJENJE FROM ODELJENJE WHERE NAZIVODELJENJE = 'Poluintenzivna nega'))";
    $rezPolu= $db->query($sqlPolu);
    $brojPolu = mysqli_fetch_row($rezPolu)[0];
    $poluProcenat = ($brojPolu / $ukupno) * 100 . " %";


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Statistika</title>
    <style>
        body {
            overflow-y: scroll ;
        }
      h2 {
        font-size:25px;
        padding: 10px;
      }
      a:hover {
        color:white;
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
          <div class="row">
              <div class="col-md-4">
                <h2>Odnos muškaraca i žena na lečenju<hr></h2>
                <canvas id="odnosMZ"></canvas>
              </div>
              <div class="col-md-4">
                <h2>Odnos vakcinisanih i nevakcinisanih<hr></h2>
                <canvas id="odnosVakc"></canvas>
              </div>
              <div class="col-md-4">
                <h2>Odnos izmedju popunjenosti odeljenja<hr></h2>
                <canvas id="odnosOdeljenja"></canvas>
              </div>
          </div> <hr>
       
      </div> <br>
    </div>
        
    <script>
        let OdnosMZ = document.querySelector("#odnosMZ");
        let chartOdnosMZ = new Chart(OdnosMZ, {
            type:'pie',
            data: {
                labels:['Muškarci <?php echo $mProcenat?>','Žene <?php echo $zProcenat?>'],
                datasets:[{
                    data:[
                        <?php echo $m?>,
                        <?php echo $z?>
                    ],
                    backgroundColor: [
                        'blue','pink'
                    ]
                }]
            },
            options: {
               layout: {
                   padding:20
               },
               
            }
        }
        )

        let odnosVakc = document.querySelector("#odnosVakc");
        let chartOdnosVakc = new Chart(odnosVakc, {
            type:'pie',
            data: {
                labels:['Vakcinisani <?php echo $vakcProcenat?>','Nevakcinisani <?php  echo $neVakcProcenat?>'],
                datasets:[{
                    label:'Procenat',
                    data:[
                        <?php echo $vakc?>,
                        <?php echo $neVakc?>
                    ],
                    backgroundColor: [
                        'green','red'
                    ]
                }]
            },
            options: {
               layout: {
                   padding:20
               },
               
            }
        })

        let odnosOdeljenja = document.querySelector("#odnosOdeljenja");
        let chartOdnosOdeljenja = new Chart(odnosOdeljenja, {
            type:'pie',
            data: {
                labels:['Intenzivna <?php echo $intProcenat?>','Poluintenzivna <?php echo $poluProcenat?>'],
                datasets:[{
                    data: [
                        <?php echo $brojInt?>,
                        <?php echo $brojPolu?>
                    ],
                    backgroundColor: [
                        'purple','yellow'
                    ]
                }]
            },
            options: {
                layout: {
                    padding:20
                },
            }
        })

        
    </script>
  </body>
</html>
