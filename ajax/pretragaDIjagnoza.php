<?php
    require_once("../classes/db.php");
    require_once("../functions.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
}

    $upit = "SELECT * FROM DIJAGNOZA";
    $rez = $db -> query($upit);
    $search = strtoupper($_GET['search']);
    $search = str_replace(" ","",$search);
    $list = array();

    foreach($rez as $value) 
     {
         $nazivDijagnoza = strtoupper($value['NAZIVDIJAGNOZA']);
         $nazivDijagnoza = str_replace(" ","",$nazivDijagnoza);
         $sifra = strtoupper($value['SIFRADIJAGNOZA']);
         $sifra = str_replace(" ","",$sifra);
         
         if((str_contains($nazivDijagnoza,$search) || str_contains($sifra,$search))) 
         {
             array_push($list,$value);
         }
    }

    echo showListOfDiagnosis($list);

?>