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
    
    $dijagnoza = $_GET['dijagnoze'];
    $tip = $_GET['tip'];
    $datum = $_GET['datum'];
    $karton = $_GET['karton'];

    $upit = "INSERT INTO spisak_dijagnoza (IDDIJAGNOZA,IDKARTON,DATUM_DIJAGNOSTIKE,TIP) VALUES ('$dijagnoza','$karton','$datum','$tip')";
    $rez = $db->query($upit);

    if(!$rez)
    {
        echo "Nije uspelo upisivanje dijagnoze";
    }
    else
    {
        echo "Uspesno upisana dijagnoza";
    }
?>