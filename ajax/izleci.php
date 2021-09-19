<?php
    $karton = $_GET['karton'];
    $dijagnoza = $_GET['dijagnoza'];
    $tip =  $_GET['tip'];
    $izlecen = $_GET['izlecen'];
    require_once("../classes/db.php");
    require_once("../functions.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
     }
     $datum = date("Y-m-d",time());
     if($izlecen = true)
     {
        $upit = "UPDATE SPISAK_DIJAGNOZA SET DATUM_IZLECENJA = '$datum', TIP = '$tip' WHERE IDKARTON = '$karton' AND IDDIJAGNOZA = '$dijagnoza'";
        $rez = $db->query($upit);
     }
     else
     {
        $upit = "UPDATE SPISAK_DIJAGNOZA SET TIP = '$tip' WHERE IDKARTON = '$karton' AND IDDIJAGNOZA = '$dijagnoza'";
        $rez = $db->query($upit);
     }
    
     echo showOnlyDate($datum);
?>