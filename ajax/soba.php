<?php
    $odeljenje = $_GET['odeljenje'];
    require_once("../classes/db.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
    }

    if($odeljenje != "/")
    {
        $soba = "SELECT * FROM SOBA WHERE IDODELJENJE = {$odeljenje} AND SLOBODNOMESTA > 0 ";
        $rez = $db->query($soba);

        $html = "<option value='/'>---Izaberite sobu---</option>";
        foreach($rez as $value)
        {
            $html .= "<option value='{$value['IDSOBA']}'>{$value['BROJSOBA']}</option>";
        }
    }
    
    echo $html;

?>