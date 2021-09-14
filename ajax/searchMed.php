<?php
    require_once("../classes/db.php");
    require_once("../functions.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
}

    $upit = "SELECT * FROM LEK";
    $rez = $db -> query($upit);
    $search = strtoupper($_GET['search']);
    $search = str_replace(" ","",$search);
    $list = array();

    foreach($rez as $value) 
     {
         $lek = strtoupper($value['NAZIVLEK']);
         $lek = str_replace(" ","",$lek);
         $namena = strtoupper($value['TIPLEKA']);
         $namena = str_replace(" ","",$namena);
         
         if((str_contains($lek,$search) || str_contains($namena,$search))) 
         {
             array_push($list,$value);
         }
    }

    echo showMedicines($list);

?>