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
    
        $karton = fetchKarton($pacijentId);
    
        if($karton->STATUSPACIJENTA == "ZDRAV" || $karton->STATUSPACIJENTA == "PREMINUO")
        {
            echo "Nije moguće otpustiti zadatog pacijenta";
        }
        else
        {
            
            $kartonId = $karton->IDKARTON;
            $upit = "INSERT INTO OTPUST(IDKARTON,IDRADNIK,OTPUST_NAPOMENA) VALUES('$kartonId','$lekar','$napomena')";
            $upit2 = "UPDATE KARTON SET STATUSPACIJENTA = '$status' WHERE IDKARTON = '$kartonId'";
    
            $rez1 = $db->query($upit);
            $rez2 = $db->query($upit2);
    
            if($rez1 && $rez2)
            {
                echo "Uspešno zabeležen otpust";
            }
    
        }
    }
    else
    {
        echo "Nemate prava da otpustate pacijente";
    }
   

?>