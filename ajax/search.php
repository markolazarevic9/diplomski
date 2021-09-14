<?php
    require_once("../classes/db.php");
    require_once("../functions.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
}
    $upit = "SELECT * FROM PACIJENT";
    $rez = $db -> query($upit);
    $search = strtoupper($_GET['search']);
    $list = array();

    foreach($rez as $value) 
     {
        $patient = strtoupper($value['IMEPACIJENT'] . " ". $value['PREZIMEPACIJENT']);
         if((str_contains($patient,$search))) 
         {
             array_push($list,$value);
         }
    }

    echo showPatiens($list)

?>