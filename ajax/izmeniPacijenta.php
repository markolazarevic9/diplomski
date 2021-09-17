<?php
                 require_once("../classes/db.php");
                 $db = new Db();
                 if(!$db->connect())
                 {
                     echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
                     exit();
                 }
                $ime = $_GET['ime'];
                $prezime = $_GET['prezime'];
                $id = $_GET['id'];
                $brtel = $_GET['brtel'];
                $adresa = $_GET['adresa'];
                $vakcinacija = $_GET['vakcinacija'];
                $alergije = $_GET['alergije'];
                $covidTest = $_GET['covidTest'];

                if($ime == "" || $prezime == "" || $brtel == "" || $adresa == "/" || $vakcinacija == "/" || $covidTest == "/" || $alergije == "")
                {
                    echo 'Niste uneli sve podatke';
                }
                else
                {
                    $upit2 = "UPDATE KARTON SET IDADRESA = '$adresa',VAKCINISAN = '$vakcinacija',ALERGIJE = '$alergije',TEST  = '$covidTest' WHERE IDPACIJENT = '$id'";
                    $rez2 = $db->query($upit2);
                    $upit = "UPDATE pacijent SET IMEPACIJENT = '$ime',PREZIMEPACIJENT ='$prezime',BROJTELEFONA = '$brtel' WHERE IDPACIJENT = '$id'";
                    $rez = $db->query($upit);
                    if(!$rez || !$rez2)
                    {
                        echo 'Nije uspeo upit';
                    }
                    else
                    {
                        echo 'Uspešno izmenjen pacijent';
                    }
                }
            
        
        ?>