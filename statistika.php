<?php
  session_start();  
  require_once("functions.php");
  require_once("components/db_connect.php");
  require_once("components/statisticsData.php");

  if(!isset($_SESSION['ime'])) 
  {
    header("location:login.php");
  }
  if($_SESSION['status'] != "admin")
  {
      header("location:dashboard.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Statistika</title>
    <style>
      .sidebar {
        height: 3000px;
      }
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
          <div class="row">
          <div class="col-md-12">
                <h2>Kretanje broja hospitalizacija u poslednjih 7 dana</h2>
                <canvas id="poDanima"></canvas>
              </div>
          </div> <hr>
          <div class="row">
          <div class="col-md-12">
                <h2>Kretanje broja umrlih u poslednjih 7 dana</h2>
                <canvas id="poDanimaUmrlih"></canvas>
              </div>
          </div> <hr>
          <div class="row">
          <div class="col-md-12">
                <h2>Kretanje broja pacijenata koji su ozdravili u poslednjih 7 dana</h2>
                <canvas id="poDanimaZdravih"></canvas>
              </div>
          </div> <hr>
       
      </div> <br>
    </div>
    <script>
          function days() {
    let today = new Date();
    let oneDayAgo = new Date();
    let twoDaysAgo = new Date();
    let threeDaysAgo = new Date();
    let fourDaysAgo = new Date();
    let fiveDaysAgo = new Date();
    let sixDaysAgo = new Date();

    oneDayAgo.setDate(today.getDate() - 1);
    twoDaysAgo.setDate(today.getDate() - 2);
    threeDaysAgo.setDate(today.getDate() - 3);
    fourDaysAgo.setDate(today.getDate() - 4);
    fiveDaysAgo.setDate(today.getDate() - 5);
    sixDaysAgo.setDate(today.getDate() - 6);

    let arr = new Array();

    arr.push((today.getDate() + "." + (today.getMonth() + 1) + "."), (oneDayAgo.getDate() + "." + (oneDayAgo.getMonth() + 1) + "."), (twoDaysAgo.getDate() + "." + (twoDaysAgo.getMonth() + 1) + "."), (threeDaysAgo.getDate() + "." + (threeDaysAgo.getMonth() + 1) + "."), (fourDaysAgo.getDate() + "." + (fourDaysAgo.getMonth() + 1) + "."), (fiveDaysAgo.getDate() + "." + (fiveDaysAgo.getMonth() + 1) + "."), (sixDaysAgo.getDate() + "." + (sixDaysAgo.getMonth() + 1) + "."));
    return arr;
  }



    let daysSeven = days();
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

    let poDanima = document.querySelector("#poDanima");
    let chartPoDanima = new Chart(poDanima, {
      type:'line',
      data: {
        labels: [daysSeven[6],daysSeven[5],daysSeven[4],daysSeven[3],daysSeven[2],daysSeven[1],daysSeven[0]],
        datasets:[{
          label: 'Hospitalizacija',
          data: [
            <?php echo $prijemi[6]?>,
            <?php echo $prijemi[5]?>,
            <?php echo $prijemi[4]?>,
            <?php echo $prijemi[3]?>,
            <?php echo $prijemi[2]?>,
            <?php echo $prijemi[1]?>,
            <?php echo $prijemi[0]?>
          ],
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1,
          fill:true
        }]
      },
      options: {
        layout: {
          padding:40
        }
      }
    })

    let poDanimaUmrlih = document.querySelector('#poDanimaUmrlih');
    let chartPoDanimaUmrlih = new Chart(poDanimaUmrlih, {
      type:'line',
      data: {
        labels: [daysSeven[6],daysSeven[5],daysSeven[4],daysSeven[3],daysSeven[2],daysSeven[1],daysSeven[0]],
        datasets:[{
          label: 'Umrlih',
          data: [
            <?php echo $umrlih[6]?>,
            <?php echo $umrlih[5]?>,
            <?php echo $umrlih[4]?>,
            <?php echo $umrlih[3]?>,
            <?php echo $umrlih[2]?>,
            <?php echo $umrlih[1]?>,
            <?php echo $umrlih[0]?>
          ],
          borderColor: 'red',
          tension: 0.1,
          fill:true
        }]
      },
      options: {
        layout: {
          padding:40
        }
      }
    })

    let poDanimaZdravih = document.querySelector("#poDanimaZdravih");
    let chartPoDanimaZdravih = new Chart(poDanimaZdravih, {
      type:'line',
      data: {
        labels: [daysSeven[6],daysSeven[5],daysSeven[4],daysSeven[3],daysSeven[2],daysSeven[1],daysSeven[0]],
        datasets:[{
          label: 'Umrlih',
          data: [
            <?php echo $ozdrav[6]?>,
            <?php echo $ozdrav[5]?>,
            <?php echo $ozdrav[4]?>,
            <?php echo $ozdrav[3]?>,
            <?php echo $ozdrav[2]?>,
            <?php echo $ozdrav[1]?>,
            <?php echo $ozdrav[0]?>
          ],
          borderColor: 'green',
          tension: 0.1,
          fill:true
        }]
      },
      options: {
        layout: {
          padding:40
        }
      }
    })
    </script>
  </body>
</html>
