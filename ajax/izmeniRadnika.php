<?php
             require_once("../classes/db.php");
             $db = new Db();
             if(!$db->connect())
             {
                 echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
                 exit();
             }
          
            $id = $_GET['id'];
            $ime = $_GET['ime'];
            $prezime = $_GET['prezime'];
            $adresa = $_GET['adresa'];
            $odeljenje = $_GET['odeljenje'];
            $spec = $_GET['spec'];
            $pozicija = $_GET['pozicija'];
            $datZap = $_GET['datZap'];
            $vakcinisan = $_GET['vakcinisan'];
            $lozinka = $_GET['lozinka'];
            $korisnickoIme = $_GET['korisnickoIme'];
            $isEmpty = $ime == "" || $prezime == "" || $adresa == "" || $odeljenje == "" || $spec == "" || $pozicija == "" || $datZap == "" || $lozinka == "" || $korisnickoIme == "";
            if($isEmpty)
            {
                echo 'Niste uneli sve podatke';
            }
            else
            {
                $upit = "UPDATE radnik SET IMERADNIK = '$ime'
                ,PREZIMERADNIK = '$prezime'
                ,IDADRESA = '$adresa',
                SPEC = '$spec',DAT_ZAP = '$datZap',
                VAKCINISAN = '$vakcinisan',
                IDODELJENJE = '$odeljenje',
                POZICIJA = '$pozicija' WHERE IDRADNIK = '$id'";
                $rez = $db->query($upit);

                $upit2 = "UPDATE PRISTUP SET KORISNICKOIME = '$korisnickoIme', LOZINKA = '$lozinka' WHERE IDRADNIK = '$id'";
                $rez2 = $db->query($upit2);

                if(!$rez || !$rez2)
                {
                    echo   'Nije uspela izmena podataka';
                    echo $db->error();
                 
                }
                else
                {
                    echo 'Uspesno izmenjeni podaci';
                }
            }
            



        
        ?>