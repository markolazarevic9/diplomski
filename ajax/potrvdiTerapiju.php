<?php
    session_start();
    $terapijaId = $_GET['terapijaId'];
    $pacijentId = $_GET['pacijentId'];
    $korisnik = (int)$_SESSION['idKorisnik'];

    require_once("../functions.php");
    require_once("../classes/db.php");
    $db = new Db();
    if(!$db->connect())
    {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
    }

    $upit = "UPDATE lecenje SET IDTEHNICAR = '$korisnik',DATUM=CURRENT_TIMESTAMP WHERE IDTERAPIJA='{$terapijaId}'";
    $rez = $db->query($upit);

    if($rez) 
    {
        echo "Terapija zabeležena";
    } 
    else
    {
        echo "Terapija nije zabeležena. Pokušajte ponovo.";
    }

?>