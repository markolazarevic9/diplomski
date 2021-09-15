<?php
        require_once("../classes/db.php");
        require_once("../functions.php");
        $db = new Db();
        if(!$db->connect())
        {
            echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
            exit();
        }

        $patientId = $_GET['patientId'];
        $karton = fetchKarton($patientId);
        $upit = "SELECT * FROM SPISAK_DIJAGNOZA WHERE IDKARTON = {$karton->IDKARTON} AND datum_izlecenja IS NULL";
        $rez = $db->query($upit);
        foreach($rez as $dijagnoza)
        {
            
        }
?>