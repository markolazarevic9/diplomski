<?php
    $patientId = $_GET['id'];

    $upitPacijent = "SELECT * FROM PACIJENT WHERE IDPACIJENT = {$patientId}";
    $rezPacijent = $db -> query($upitPacijent);
    $pacijent = mysqli_fetch_object($rezPacijent);
  
    $upitKarton = "SELECT * FROM karton where karton.IDPACIJENT = {$patientId}";
    $rezKarton = $db -> query($upitKarton);
    $karton = mysqli_fetch_object($rezKarton);
  
    $upitAdresa = "SELECT * FROM ADRESA WHERE IDADRESA = (SELECT IDADRESA FROM KARTON WHERE IDPACIJENT = {$patientId})";
    $rezAdresa = $db->query($upitAdresa);
    $adresa = mysqli_fetch_object($rezAdresa);
  
    $upitSoba = "SELECT * FROM SOBA WHERE IDSOBA = (SELECT IDSOBA FROM KARTON WHERE IDPACIJENT = {$patientId})";
    $rezSoba = $db->query($upitSoba);
    $soba = mysqli_fetch_object($rezSoba);

      
    $upitKrevet = "SELECT * FROM KREVET WHERE IDKARTON = (SELECT IDKARTON FROM KARTON WHERE IDPACIJENT = {$patientId})";
    $rezKrevet = $db->query($upitKrevet);
    $krevet = mysqli_fetch_object($rezKrevet);

    $upitOdeljenje = "SELECT * FROM ODELJENJE WHERE IDODELJENJE = (SELECT IDODELJENJE FROM SOBA WHERE IDSOBA = (SELECT IDSOBA FROM KARTON WHERE IDPACIJENT = {$patientId}))";
    $rezOdeljenje = $db->query($upitOdeljenje);
    $odeljenje = mysqli_fetch_object($rezOdeljenje);
  
  
    $upitDijagnoza = "SELECT * FROM DIJAGNOZA WHERE IDDIJAGNOZA in (SELECT IDDIJAGNOZA FROM SPISAK_DIJAGNOZA WHERE IDKARTON = {$karton->IDKARTON}) ";
    $rezDijagnoza = $db->query($upitDijagnoza);
  
    $upitTerapija = "SELECT * FROM TERAPIJA WHERE IDTERAPIJA in (SELECT IDTERAPIJA FROM LECENJE WHERE IDKARTON = {$karton->IDKARTON})";
    $rezTerapija = $db->query($upitTerapija);
  
    $upitLecenje = "SELECT * FROM LECENJE WHERE IDKARTON = {$karton->IDKARTON}";
    $rezLecenje = $db->query($upitLecenje);

    $upitIzvestaji = "SELECT * FROM ANALIZA WHERE IDKARTON = {$karton->IDKARTON}";
    $rezIzvestaji = $db->query($upitIzvestaji);
    
    $pol = $pacijent->POL;
    $url = "";
    if($pol == "Ž")
    {
      $url = "img/female.jpg";
    }
    else 
    {
      $url = "img/man.png";
    }        
?>