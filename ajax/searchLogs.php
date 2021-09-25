<?php
    $search = $_GET['search'];

    require_once("../classes/db.php");
    require_once("../functions.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
    }

    $upit = "SELECT * FROM LOG";
    $rez = $db -> query($upit);
    $search = strtoupper($_GET['search']);
    $list = array();

    foreach($rez as $value) 
     {
         $istorija = strtoupper($value['ISTORIJA']);
         $datum = showOnlyDate($value['DATUM']);
         $radnik = fetchRadnik($value['IDRADNIK']);
         $radnikIme = strtoupper($radnik->IMERADNIK);
         $radnikPrezime = strtoupper($radnik->PREZIMERADNIK);

         if((str_contains($istorija,$search) || str_contains($datum,$search) || str_contains($radnikIme,$search) || str_contains($radnikPrezime,$search))) 
         {
             array_push($list,$value);
         }
    }



?>