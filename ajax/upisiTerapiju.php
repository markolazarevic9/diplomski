<?php
    session_start();
    require_once("../functions.php");
    require_once("../classes/db.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
    }
    $lekId = (int)$_GET['lek'];
    $doza = $_GET['doza'];
    $aplikovanje = $_GET['aplikovanje'];
    $naDan = $_GET['naDan'];
    $period = $_GET['period'];
    $napomena = $_GET['napomena'];
    $lek = fetchLek($lekId);
    $korisnik = (int)$_SESSION['idKorisnik'];
    $patientId = (int)$_GET['patientId'];

    $upit = "INSERT INTO TERAPIJA (IDLEK,IDRADNIK,DOZA,APLIKOVANJE,NADAN,PERIOD,NAPOMENA) 
    values ('$lekId','$korisnik','$doza','$aplikovanje','$naDan','$period','$napomena')";
    $rez = $db->query($upit);

    $upit2 = "SELECT * from KARTON where KARTON.IDPACIJENT = {$patientId}";
    $rez2 = $db->query($upit2);
    $karton = mysqli_fetch_object($rez2);
    $kartonId = $karton->IDKARTON;

    $upit3 = "SELECT * FROM TERAPIJA ORDER BY IDTERAPIJA desc LIMIT 1";
    $rez3 = $db->query($upit3);
    $terapija = mysqli_fetch_object($rez3);
    $terapijaId = $terapija->IDTERAPIJA;
    $upit4 = "INSERT INTO lecenje(IDKARTON,IDTERAPIJA) values ('$kartonId', '$terapijaId')";
    $rez4 = $db->query($upit4);
    if($rez && $rez4)
    {
        echo "Uspesno dodata terapija";
    } 
    else
    {
        echo "Terapija nija dodata. Pokusajte ponovo";
    }
?>