<?php
    $list = array();
    require_once("../classes/db.php");
    require_once("../functions.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
     }
    $datumi = $_GET['datumi'];
    $prijava = $_GET['prijava'];
    $odjava = $_GET['odjava'];

    if(isset($_GET['datum']) && $datumi == false)
    {
        $datum = $_GET['datum'];
        $upitDatum = "SELECT * FROM LOG WHERE DATE(DATUM) = '$datum'";
        $rez = $db->query($upitDatum);
        foreach($rez as $value)
        {
            array_push($list,$value);
        }
    }

    if($prijava == true)
    {
        $upitPrijava = "SELECT * FROM LOG WHERE ISTORIJA = 'Prijava'";
        $rezPrijava = $db->query($upitPrijava);
        foreach($rezPrijava as $value)
        {
            array_push($list,$value);
        }
    }
    if($odjava == true)
    {
        $upitOdjava = "SELECT * FROM LOG WHERE ISTORIJA = 'Odjava'";
        $rezOdjava = $db->query($upitOdjava);
        foreach($rezOdjava as $value)
        {
            array_push($list,$value);
        }
    }

    echo showLogs($list);


?>