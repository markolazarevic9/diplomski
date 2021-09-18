<?php
    $karton = $_GET['karton'];
    $dijagnoza = $_GET['dijagnoza'];

    require_once("../classes/db.php");
    require_once("../functions.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
     }
     $datum = date("d-m-Y H:i:s",time());
     $upit = "UPDATE SPISAK_DIJAGNOZA SET DATUM_IZLECENJA = '$datum' WHERE IDKARTON = '$karton' AND IDDIJAGNOZA = '$dijagnoza'";
     $rez = $db->query($upit);
     echo showOnlyDate($datum);
?>