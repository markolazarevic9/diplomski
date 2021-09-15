<?php
    function upisLog($log) {
        $file = fopen("logs/logs.txt","a");
        $txt = "\n". $_SESSION['ime'] . " " . $_SESSION['prezime'] . " se " . $log . " ".  date("Y-m-d h:i:sa");
        fwrite($file,$txt);
        fclose($file);
    }

    function logOf() {
        if(isset($_POST['odjava']))
        {
            upisLog("odjavio");
            session_unset();
            session_destroy();
        }
    }

    function showPatiens($list) {
        foreach($list as $value) 
        {   
            echo "<tr>
            <th scope='row'> " .$value['IDPACIJENT'] + 1 ."</th>
            <td>{$value['IMEPACIJENT']}</td>
            <td>{$value['PREZIMEPACIJENT']}</td>
            <td>{$value['JMBG']}</td>
            <td>
              <button type='button' class='btn-primary'>
                <a data-id={$value['IDPACIJENT']} class='text-white btnKarton' href='karton.php?id={$value['IDPACIJENT']}'>Karton</a>
              </button>
            </td>
            <td>
            <button class='btn-success'>
              <a data-id={$value['IDPACIJENT']} class='text-white btnKarton' href='terapija.php?id={$value['IDPACIJENT']}'>Terapija</a>
            </button>
          </td>
          <td>
            <button class='btn-info'>
              <a data-id={$value['IDPACIJENT']} class='text-dark btnKarton' href='prijem.php?id={$value['IDPACIJENT']}'>Prijem</a>
            </button>
          </td>
          <td>
            <button class='btn-secondary'>
              <a data-id={$value['IDPACIJENT']} class='text-white btnKarton' href='otpust.php?id={$value['IDPACIJENT']}'>Otpust</a>
            </button>
          </td>
          <td>
            <button class='btn-warning'>
              <a data-id={$value['IDPACIJENT']} class='text-dark btnKarton' href='dijagnostika.php?id={$value['IDPACIJENT']}'>Dijagnostika</a>
            </button>
          </td>
          </tr>";
        }
    }

    function showDiagnosisList($id)
    {
      require("components/db_connect.php");
      $upit = "SELECT * FROM SPISAK_DIJAGNOZA WHERE IDDIJAGNOZA = {$id}";
      $rez = $db -> query($upit);
      return mysqli_fetch_object($rez);
    }

    function showDiagnosis($list) {
      foreach($list as $value) 
      {   
          $diagnosis = showDiagnosisList($value['IDDIJAGNOZA']);
          echo "<tr>
          <th scope='row'> " .$value['IDDIJAGNOZA'] + 1 ."</th>
          <td>{$value['NAZIVDIJAGNOZA']}</td>
          <td>{$value['SIFRADIJAGNOZA']}</td>
          <td>{$value['OPISDIJAGNOZA']}</td>
          <td>{$diagnosis->datum_dijagnostike}</td>
          <td>{$diagnosis->datum_izlecenja}</td>
          <td>{$diagnosis->TIP}</td>
        </tr>";
      }
    }

   function fetchTerapija($id)
   {
      require("components/db_connect.php");
      $upit = "SELECT * FROM TERAPIJA WHERE IDTERAPIJA = {$id}";
      $rez = $db -> query($upit);
      $terapija = mysqli_fetch_object($rez);
      return $terapija;
   }
   function fetchLek($id)
   {
      $id = (int)$id;
      require_once("classes/db.php");
      $db = new Db();
      if(!$db->connect())
      {
        echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
        exit();
     }
      $upit = "SELECT * FROM LEK WHERE IDLEK = {$id}";
      $rez = $db -> query($upit);
      $lek = mysqli_fetch_object($rez);
      return $lek;
   }
  
   function fetchRadnik($id)
   {
      require("components/db_connect.php");
      $upit = "SELECT * FROM RADNIK WHERE IDRADNIK = {$id}";
      $rez = $db -> query($upit);
      $radnik = mysqli_fetch_object($rez);
      return $radnik;
   }
   function fetchPatient($id)
   {
      require("components/db_connect.php");
      $upit = "SELECT * FROM PACIJENT WHERE IDPACIJENT = {$id}";
      $rez = $db -> query($upit);
      $pacijent = mysqli_fetch_object($rez);
      return $pacijent;
   }

   function fetchKarton($id)
   {
      require_once("classes/db.php");
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

    function showTreatment($list)
    {
      $counter = 1;
      foreach($list as $value)
      {
       $terapija = fetchTerapija($value['IDTERAPIJA']);
       $lek = fetchLek($terapija->IDLEK); 
       $lekar = fetchRadnik($terapija->IDRADNIK);
       if(!is_null($value['IDTEHNICAR']))
       {
        $medTeh = fetchRadnik($value['IDTEHNICAR']);
       } else {
         $medTeh = "";
       }
        echo "<tr>
        <th scope='row'> " .$counter ."</th>
        <td>{$lek->NAZIVLEK}</td>
        <td>{$terapija->DOZA}</td>
        <td>{$lek->JEDMERELEK}</td>
        <td>{$terapija->APLIKOVANJE}</td>
        <td>{$terapija->DATUM_TERAPIJA}</td>
        <td>{$lekar->IMERADNIK}". " " ." {$lekar->PREZIMERADNIK}</td>
        <td>{$value['DATUM']}</td> ";
        if($value['IDTEHNICAR'] != null) 
        {
          echo "<td>{$medTeh->IMERADNIK}". " " ." {$medTeh->PREZIMERADNIK}</td>
          </tr>;";
        } else
        {
          echo `<td>{$medTeh}</td>
          </tr>";`;
        } 
     
      $counter++;
      }
    }

    function showReports($list) 
    {
      foreach($list as $value) 
      {   
         $lekar = fetchRadnik($value['IDRADNIK']);
          echo "<tr>
          <th scope='row'> " .$value['IDANALIZA'] ."</th>
          <td>{$value['NAZIV_ANALIZA']}</td>
          <td>{$value['UZORAK']}</td>
          <td>{$value['VREDNOST']}</td>
          <td>{$value['OPIS']}</td>
          <td>{$value['datum_analiza']}</td>
          <td>{$lekar->IMERADNIK}" . " " ."{$lekar->PREZIMERADNIK}</td>
          <td><button class='btn btn-primary'><a target='_blank' href='izvestaj.php?IDANALIZA={$value['IDANALIZA']}&&id={$_GET['id']}'>Štampa</a></button></td>
        </tr>";
      }
    }

    function showMedicines($list) {
      foreach($list as $value) 
      {   
          echo "<tr>
          <th scope='row'> " .$value['IDLEK'] + 1 ."</th>
          <td>{$value['NAZIVLEK']}</td>
          <td>{$value['JEDMERELEK']}</td>
          <td>{$value['KOLICINALEK']}</td>
          <td>{$value['SUPSTANCA']}</td>
          <td>{$value['TIPLEKA']}</td>
          <td>{$value['OBLIK']}</td>
        </tr>";
      }
    }

    function doctorTerLayout() {
      require("components/db_connect.php");
    $upit = "SELECT * FROM LEK";
    $rez = $db->query($upit);
      echo 
      "
      <select name='lek' id='lek'>
         <option value='/'>---Izaberite lek---</option>
      " ;
      foreach($rez as $lek)
      {
          echo "<option value='{$lek['IDLEK']}'>{$lek['NAZIVLEK']}</option>";
      }
      echo "</select> <br>";
      echo "<input type='text' name='doza' id='doza' placeholder='Unesite dozu'> <br>
      <input type='text' name='aplikovanje' id='aplikovanje' placeholder='Unesite nacin aplikovanja'> <br>
      <input type='text' name='nadan' id='nadan' placeholder='Unesite koliko puta na dan'> <br>
      <input type='text' name='period' id='period' placeholder='Unesite period'> <br>
      <textarea name='napomena' id='napomena' placeholder='Napomena'> </textarea> <br>
      <input type='submit' id='potvrdi' class='btn btn-secondary' value='Potvrdi'>";
    }

    function tehTerLayout() {
      require("components/db_connect.php");
      $pacijentId = $_GET['id'];
      $upit = "SELECT * FROM lecenje WHERE IDKARTON = (SELECT IDKARTON FROM KARTON WHERE KARTON.IDPACIJENT = {$pacijentId})
       AND IDTERAPIJA in (SELECT IDTERAPIJA FROM TERAPIJA WHERE DATUM_TERAPIJA = CURRENT_DATE)
       AND IDTEHNICAR IS NULL";
      $rez = $db->query($upit);
      $counter = 1;
      echo "<h2>Terapija za danas</h2>";
      echo "<table class='table'
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Lek</th>
            <th scope='col'>Doza</th>
            <th scope='col'>Aplikovanje</th>
            <th scope='col'>Period</th>
            <th scope='col'>Napomena</th>
            <th scope='col'>Zabeleži</th>
          </tr>
        </thead>
        <tbody>";
        foreach($rez as $ter)
        {
          $terapija = fetchTerapija($ter['IDTERAPIJA']);
          $lek = fetchLek($terapija->IDLEK);

          echo 
          "
            <tr id='{$counter}'>
              <th scope='row'>{$counter}</th>
              <td>{$lek->NAZIVLEK}</td>
              <td>{$terapija->DOZA}</td>
              <td>{$terapija->APLIKOVANJE}</td>
              <td>{$terapija->NAPOMENA}</td>
              <td>{$terapija->PERIOD}</td>
              <td> <button class='btn btn-success zabelezi' data-id='{$ter['IDTERAPIJA']}'>Zabeleži</button></td>
            </tr>
          ";
          $counter++;
        }
        echo "</tbody></table>";
    }
?>