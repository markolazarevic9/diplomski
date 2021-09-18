<?php
    $soba = $_GET['soba'];
    require_once("../classes/db.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
    }

    $upit = "SELECT * FROM KREVET WHERE IDSOBA = {$soba} AND IDKARTON IS NULL";
    $rez = $db->query($upit);

    $html = "<option value='/'>---Izaberite krevet---</option>";
    foreach($rez as $value)
    {
        $html .= "<option value='{$value['IDKREVET']}'>{$value['IDKREVET']}</option>";
    }

    echo $html; 
?>