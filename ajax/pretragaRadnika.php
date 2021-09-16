<?php
     require_once("../classes/db.php");
     require_once("../functions.php");
     $db = new Db();
     if(!$db->connect())
     {
         echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
         exit();
    }

    $upit = "SELECT * FROM RADNIK";
    $rez = $db->query($upit);
    $list = array();
    $search = strtoupper($_GET['search']);

    foreach($rez as $value) 
     {
         $radnik = strtoupper($value['IMERADNIK'] . " ". $value['PREZIMERADNIK']);
         if((str_contains($radnik,$search))) 
         {
             array_push($list,$value);
         }
    }

    echo showEm($list);
 

?>