<?php

      session_start();
      require_once("../classes/db.php");
      require_once("../functions.php");
      $patientId = $_GET['id'];
      $naziv = $_GET['naziv'];
      $uzorak = $_GET['uzorak'];
      $vrednost = $_GET['vrednost'];
      $opis = $_GET['opis'];
      $anamneza = $_GET['anamneza'];
      $zakljucak = $_GET['zakljucak'];
      $karton = fetchKarton($patientId);
      $kartonId = $karton->IDKARTON;
      $korisnikId = $_SESSION['idKorisnik'];
      $dijagnoza = $_GET['dijagnoza'];
      $db = new Db();
      if(!$db->connect())
      {
          echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
          exit();
      }

      if($_SESSION['status'] !== "lekar")
      {
        echo "Nemate pristupna prava da izvrsite akciju";
      }
      else
      {
         
          $upit = "INSERT INTO ANALIZA(IDRADNIK,IDKARTON,NAZIV_ANALIZA,UZORAK,VREDNOST,OPIS,anamneza,IDDIJAGNOZA,ZAKLJUCAK)
                    VALUES ('$korisnikId','$kartonId','$naziv','$uzorak','$vrednost','$opis','$anamneza','$dijagnoza','$zakljucak')";
          
          $rez = $db->query($upit);
          if($rez)
          {
              echo "Uspešno zabeležen izveštaj";
          }
          else
          {
              echo "Izveštaj nije zabeležen";
          }
      }

?>
