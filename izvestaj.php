<?php
    session_start();
    if(!isset($_SESSION['ime'])) 
    {
        header("location:login.php");
    }
    require_once("functions.php");
    require_once("components/db_connect.php");
    $upit = "SELECT * FROM ANALIZA WHERE IDANALIZA = {$_GET['IDANALIZA']}";
    $rez = $db->query($upit);
    $izvestaj = mysqli_fetch_object($rez);
    $pacijent = fetchPatient($_GET['id']);

    $upit2 = "SELECT * FROM DIJAGNOZA WHERE IDDIJAGNOZA = {$izvestaj->IDDIJAGNOZA}";
    $rez2 = $db->query($upit2);
    $dijagnoza = mysqli_fetch_object($rez2);

    $lekar = fetchRadnik($izvestaj->IDRADNIK);

    $datum = $izvestaj->datum_analiza;
    $datum = explode("-",$datum);
    $datum[2] = explode(" ",$datum[2]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
      src="https://kit.fontawesome.com/486587c22a.js"
      crossorigin="anonymous"
    ></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Izvestaj</title>
    <style>
        #logUser {
            display: none;
        }
        .container {
            border: 1px solid black;
            border-right: none;
            border-left: none;
            margin-top: 10px;
            clear: both;
        }
        #izvestajNaziv {
            text-align: center;
            clear: both;

        }
        p {
            text-align: left;
            margin: 0;
            margin-left: 30px;
        }

        h6 {
            margin-top: 100px;
            text-align: right;
            margin-right: 30px;
            padding: 20px;
            padding-bottom: 0;
        }

    </style>
</head>
<body>
    <h1 id="eBolnica"><i class="fas fa-hospital"></i> eBolnica</h1>
    <p>
        Datum i vreme štampanja: <?php echo date("d-m-Y H:i:s",time())?> <br>
        Štampa: <?php echo $_SESSION['ime'] . " " .$_SESSION['prezime']?>
    </p>
    <h1 id="izvestajNaziv"><?php echo $izvestaj->NAZIV_ANALIZA?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
               Pacijent: <strong> <?php echo $pacijent->IMEPACIJENT . " " .$pacijent->PREZIMEPACIJENT?></strong>
            </div>
            <div class="col-md-4">
              
            </div>
            <div class="col-md-4">
            JMBG:<strong> <?php echo $pacijent->JMBG?></strong>
            LBO:<strong> <?php echo $pacijent->LBO?></strong>
            POL:<strong> <?php echo $pacijent->POL?></strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                Datum i vreme analize: <strong><?php  echo $datum[2][0] . "." .$datum[1] . "." . $datum[0] ."."?> </strong>
            </div>
            <div class="col-md-12">
                Dijagnoza: <strong><?php  echo $dijagnoza->SIFRADIJAGNOZA."  ".$dijagnoza->NAZIVDIJAGNOZA?> </strong>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>
                Anamneza: <strong><?php  echo $izvestaj->anamneza?> </strong>
            </div> <br>
            <div>
                Opis: <strong><?php  echo $izvestaj->OPIS?> </strong>
            </div> <br>
            <?php
                if($izvestaj->UZORAK != NULL && $izvestaj->VREDNOST != NULL)
                {
                    echo "<div>Uzorak: <strong>{$izvestaj->UZORAK}</strong> </div>";
                    echo "<div>Vrednost: <strong>{$izvestaj->VREDNOST}</strong> </div>";
                }
            ?>
             <div>
                Zakljucak: <strong><?php  echo $izvestaj->ZAKLJUCAK?> </strong>
            </div> <br>
        </div>
    </div>
    <h6>Ordinirajući lekar: <?php echo "<br>" . $lekar->IMERADNIK ." " .$lekar->PREZIMERADNIK?></h6>
    <script>
        window.print();
    </script>
</body>
</html>