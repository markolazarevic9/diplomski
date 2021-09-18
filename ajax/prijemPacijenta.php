<?php
        session_start();
        require_once("../classes/db.php");
        $db = new Db();
        if(!$db->connect())
        {
            echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
            exit();
        }
        function fetchKarton($id)
        {
         require_once("../classes/db.php");
         $db = new Db();
         if(!$db->connect())
         {
             echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
             exit();
         }
         $upit = "SELECT * FROM KARTON WHERE IDPACIJENT = {$id}";
         $rez = $db -> query($upit);
         $karton = mysqli_fetch_object($rez);
         return $karton;
        }


    if($_SESSION['status'] == "lekar")
    {
        $status = $_GET['status'];
        $napomena = $_GET['napomena'];
        $pacijentId = $_GET['patientId'];
        $lekar = $_SESSION['idKorisnik'];
        $dijagnoza = $_GET['dijagnoza'];
        $tip = $_GET['tip'];
        $karton = fetchKarton($pacijentId);

        if($status == "KUĆNO LEČENJE")
        {
            if($karton->STATUSPACIJENTA == $status || $karton->STATUSPACIJENTA == "HOSPITALIZOVAN" || $karton->STATUSPACIJENTA == "PREMINUO")
            {
                echo "Pacijent je već na kućnom lečenju ili je hospitalizovan";
            }
            else
            {
                $datum = date("d-m-Y H:i:s",time());
                $kartonId = $karton->IDKARTON;
                $upit = "INSERT INTO PRIJEM(IDKARTON,IDRADNIK,STATUS_PRIJEM) VALUES('$kartonId','$lekar','$napomena')";
                $upit2 = "UPDATE KARTON SET STATUSPACIJENTA = '$status' WHERE IDKARTON = '$kartonId'";
                $upit6 = "INSERT INTO spisak_dijagnoza (IDDIJAGNOZA,IDKARTON,TIP,DATUM_DIJAGNOSTIKE) VALUES ('$dijagnoza','$kartonId','$tip',$datum)";
                $rez6 = $db->query($upit6);
                $rez1 = $db->query($upit);
                $rez2 = $db->query($upit2);
                echo "Uspesno zabelezen prijem";
            }
        }
        else
        {
            $odeljenje = $_GET['odeljenje'];
            $soba = $_GET['soba'];
            $krevet = $_GET['krevet'];

            if($karton->STATUSPACIJENTA == $status || $karton->STATUSPACIJENTA == "KUĆNO LEČENJE" || $karton->STATUSPACIJENTA == "PREMINUO")
            {
                echo "Pacijent je već na kućnom lečenju ili je hospitalizovan";
            }
            else
            {
                if($odeljenje == "/" || $soba == "/" || $krevet == "/")
                {
                    echo "Niste izabrali odeljenje, sobu ili krevet";
                }
                else
                {
                    $kartonId = $karton->IDKARTON;
                    $upit5 = "SELECT * FROM krevet";
                    $rez5 = $db->query($upit5);
                    $prisutan = false;
                    foreach($rez5 as $value)
                    {
                        if($value['IDKARTON'] == $kartonId)
                        {
                            $prisutan == true;
                        }
                    }
                    if($prisutan == false)
                    {
                        echo $prisutan;
                        $upit = "INSERT INTO PRIJEM (IDKARTON,IDRADNIK,STATUS_PRIJEM) VALUES('$kartonId','$lekar','$napomena')"; // da
                        $upit2 = "UPDATE KARTON SET STATUSPACIJENTA = '$status',IDSOBA = '$soba' WHERE IDKARTON = '$kartonId'"; // da
                        $upit3 = "UPDATE KREVET SET IDKARTON = '$kartonId' WHERE IDKREVET = '$krevet'"; //da
                        $upit4 = "UPDATE SOBA SET SLOBODNOMESTA = SLOBODNOMESTA - 1 WHERE IDSOBA = (SELECT IDSOBA FROM KREVET WHERE IDKREVET = '$krevet')"; //da
                        $upit6 = "INSERT INTO spisak_dijagnoza (IDDIJAGNOZA,IDKARTON,TIP) VALUES ('$dijagnoza','$kartonId','$tip')";
                        $rez1 = $db->query($upit);
                        $rez2 = $db->query($upit2);
                        $rez3 = $db->query($upit3);
                        $rez4 = $db->query($upit4);
                        $rez6 = $db->query($upit6);
                        if($rez1 && $rez2 && $rez3 && $rez4 && $rez6)
                        {
                            echo "Uspesno zabelezen upit";
                        }
                        else
                        {
                            echo "Nije zablezen prijem";
                            echo $db->error();
                        }
                     
                    }
                    else
                    {
                        echo "Pacijent se već nalazi na lečenju";
                    }
                    
                } 
            }   
        }
    }
    else
    {
        echo "Nemate prava da primate pacijente";
    }
   

?>