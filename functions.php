<?php
    function upisLog($log) {
        session_start();
        require_once("classes/db.php");
        $db = new Db();
        if(!$db->connect())
        {
          echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
          exit();
       }
       $id = $_SESSION['idKorisnik'];
       $upit = "INSERT INTO LOG (IDRADNIK,ISTORIJA) VALUES ('$id','$log')";
       $rez = $db->query($upit);
       if(!$rez)
       {
         echo "greska";
       }
    }

    function logOf() {
        if(isset($_POST['odjava']))
        {
            upisLog("odjavio");
            session_unset();
            session_destroy();
        }
    }
    function showDate($datum)
    {
      $datum = explode("-",$datum);
      $datum[2] = explode(" ",$datum[2]);
      return $datum[2][0] . "." .$datum[1] ."." . $datum[0] . "." .$datum[2][1];
    }
    function showOnlyDate($datum)
    {
      $datum = explode("-",$datum);
      $datum[2] = explode(" ",$datum[2]);
      return $datum[2][0] . "." .$datum[1] ."." . $datum[0] . ".";
    }

    function showPatiens($list) {
        error_reporting(0);
        session_start();
        $counter = 1;
        foreach($list as $value) 
        {   
            echo "<tr>
            <th scope='row'> " .$counter."</th>
            <td>{$value['IMEPACIJENT']}</td>
            <td>{$value['PREZIMEPACIJENT']}</td>
            <td>{$value['JMBG']}</td>";
            if($_SESSION['status'] == "lekar")
            {
              echo "
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
          <td>
          <button class='btn-light'>
            <a data-id={$value['IDPACIJENT']} class='text-dark btnKarton' href='dodajDijagnozuPacijentu.php?id={$value['IDPACIJENT']}'>Dijagnoze</a>
          </button>
        </td>";
        }
        if($_SESSION['status'] == "tehnicar")
        {
          echo "
          <td>
            <button type='button' class='btn-primary'>
              <a data-id={$value['IDPACIJENT']} class='text-white btnKarton' href='karton.php?id={$value['IDPACIJENT']}'>Karton</a>
            </button>
         </td>
         <td>
          <button class='btn-success'>
            <a data-id={$value['IDPACIJENT']} class='text-white btnKarton' href='terapija.php?id={$value['IDPACIJENT']}'>Terapija</a>
          </button>
         </td>";
        }
        if($_SESSION['status'] == "admin")
        {
          echo " <td>
          <button class='btn-warning'>
            <a data-id={$value['IDPACIJENT']} class='text-dark btnKarton' href='izmeni.php?id={$value['IDPACIJENT']}'>Izmeni</a>
          </button>
        </td>";
        }
       
            
         echo "</tr>";
         $counter++;
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
      $counter = 1;
      foreach($list as $value) 
      {   
          $diagnosis = showDiagnosisList($value['IDDIJAGNOZA']);
          $datum1 = showOnlyDate($diagnosis->DATUM_DIJAGNOSTIKE);
          if(is_null($diagnosis->DATUM_IZLECENJA))
          {
            $datum2 = "";
          }
          else
          {
            $datum2 = showOnlyDate($diagnosis->DATUM_IZLECENJA);

          }
          echo "<tr>
          <th scope='row'> " .$counter ."</th>
          <td>{$value['NAZIVDIJAGNOZA']}</td>
          <td>{$value['SIFRADIJAGNOZA']}</td>
          <td>{$value['OPISDIJAGNOZA']}</td>
          <td>{$datum1}</td>
          <td>{$datum2}</td>
          <td>{$diagnosis->TIP}</td>
        </tr>";
        $counter++;
      }
    }

    function showListOfDiagnosis($list)
    {
      $counter = 1;
      foreach($list as $value)
      {
        echo "<tr>
        <th scope='row'> " .$counter ."</th>
        <td>{$value['NAZIVDIJAGNOZA']}</td>
        <td>{$value['SIFRADIJAGNOZA']}</td>
        <td>{$value['OPISDIJAGNOZA']}</td>
      </tr>";
      $counter++;
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
       $datum  = showOnlyDate($terapija->DATUM_TERAPIJA);
       $datum2 = showDate($value['DATUM']);
        echo "<tr>
        <th scope='row'> " .$counter ."</th>
        <td>{$lek->NAZIVLEK}</td>
        <td>{$terapija->DOZA}</td>
        <td>{$lek->JEDMERELEK}</td>
        <td>{$terapija->APLIKOVANJE}</td>
        <td>{$datum}</td>
        <td>{$lekar->IMERADNIK}". " " ." {$lekar->PREZIMERADNIK}</td>
        <td>{$datum2}</td> ";
        if(!is_null($value['IDTEHNICAR'])) 
        {
          echo "<td>{$medTeh->IMERADNIK}". " " ." {$medTeh->PREZIMERADNIK}</td>
          </tr>";
        } 
        else
        {
          echo `<td>Nesto</td>`;
        } 
      echo "</tr>";
      $counter++;
      }
    }

    function showReports($list) 
    {
      error_reporting(0);
      $counter = 1;
      foreach($list as $value) 
      {   
         $datum = showOnlyDate($value['DATUM_ANALIZA']);
         $lekar = fetchRadnik($value['IDRADNIK']);
          echo "<tr>
          <th scope='row'> " .$counter ."</th>
          <td>{$value['NAZIV_ANALIZA']}</td>
          <td>{$value['UZORAK']}</td>
          <td>{$value['VREDNOST']}</td>
          <td>{$value['OPIS']}</td>
          <td>{$datum}</td>
          <td>{$lekar->IMERADNIK}" . " " ."{$lekar->PREZIMERADNIK}</td>
          <td><button class='btn btn-primary'><a target='_blank' href='izvestaj.php?IDANALIZA={$value['IDANALIZA']}&&id={$_GET['id']}'>Štampa</a></button></td>
        </tr>";
        $counter++;
      }
    }

    function showMedicines($list) {
      $counter = 1;
      foreach($list as $value) 
      {   
          echo "<tr>
          <th scope='row'> " .$counter ."</th>
          <td>{$value['NAZIVLEK']}</td>
          <td>{$value['JEDMERELEK']}</td>
          <td>{$value['KOLICINALEK']}</td>
          <td>{$value['SUPSTANCA']}</td>
          <td>{$value['TIPLEKA']}</td>
          <td>{$value['OBLIK']}</td>
        </tr>";
        $counter++;
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

    function showPrijem($id) 
    {
      require("components/db_connect.php");
      $upit = "SELECT * FROM PRIJEM WHERE IDKARTON = (SELECT IDKARTON FROM KARTON WHERE IDPACIJENT = {$id})";
      $rez = $db->query($upit);
      $counter = 1;
      foreach($rez as $value)
      {
        $lekar = fetchRadnik($value['IDRADNIK']);
        $datum = showOnlyDate($value['DATUM_PRIJEM']);
        echo 
        "
          <tr>
            <th scope='row'>{$counter}</th>
            <td>{$datum}</td>
            <td>{$value['STATUS_PRIJEM']}</td>
            <td>{$lekar->IMERADNIK}" . " " ." {$lekar->PREZIMERADNIK}</td>
          </tr>
        ";
        $counter++;
      } 
    }
    function showOtpust($id) 
    {
      require("components/db_connect.php");
      $upit = "SELECT * FROM OTPUST WHERE IDKARTON = (SELECT IDKARTON FROM KARTON WHERE IDPACIJENT = {$id})";
      $rez = $db->query($upit);
      $counter = 1;
      foreach($rez as $value)
      {
        $datum = showOnlyDate($value['DATUM_OTPUST']);

        $lekar = fetchRadnik($value['IDRADNIK']);
        echo 
        "
          <tr>
            <th scope='row'>{$counter}</th>
            <td>{$datum}</td>
            <td>{$value['OTPUST_NAPOMENA']}</td>
            <td>{$lekar->IMERADNIK}" . " " ." {$lekar->PREZIMERADNIK}</td>
          </tr>
        ";
        $counter++;
      } 

    }

    function showEm($list)
    {
      require_once("classes/db.php");
      $db = new Db();
      if(!$db->connect())
      {
          echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
          exit();
     }
      foreach($list as $value) 
      {   

          $upit = "SELECT * FROM ODELJENJE WHERE IDODELJENJE = (SELECT IDODELJENJE FROM RADNIK WHERE IDRADNIK = {$value['IDRADNIK']})";
          $rez = $db->query($upit);
          $odeljenje = mysqli_fetch_object($rez);
          if(is_null($odeljenje))
          {
            error_reporting(0);
          }
          $datum = showOnlyDate($value['DAT_ZAP']);
          echo "<tr>
          <th scope='row'> " .$value['IDRADNIK']."</th>
          <td>{$value['IMERADNIK']}</td>
          <td>{$value['PREZIMERADNIK']}</td>
          <td>{$value['SPEC']}</td>
          <td>{$value['POZICIJA']}</td>
          <td>{$datum}</td>
          <td>{$odeljenje->NAZIVODELJENJE}</td>
          <td>
              <button type='button' class='btn-danger'>
                <a data-id={$value['IDRADNIK']} class='text-white btnKarton' href='izmeniRadnika.php?id={$value['IDRADNIK']}'>Izmeni</a>
              </button>
            </td>
          </tr>";
         }
      }

      function fetchDijagnoza($id)
      {
        require_once("classes/db.php");
        $db = new Db();
        if(!$db->connect())
        {
            echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
            exit();
       }

       $upit = "SELECT * FROM DIJAGNOZA WHERE IDDIJAGNOZA = {$id}";
       $rez = $db->query($upit);

       return mysqli_fetch_object($rez);
      }

      function showLogs($list)
      {
        $counter = 1;
        foreach($list as $log)
        {
          $datum = showDate($log['DATUM']);
          $radnik = fetchRadnik($log['IDRADNIK']);
          echo "<tr> 
          <th scope='row'> {$counter} </th>
          <th> {$radnik->IMERADNIK}</th>
          <th> {$radnik->PREZIMERADNIK} </th>
          <th>{$log['ISTORIJA']}</th>
          <th>{$datum}</th>
          </tr>";
          $counter++;
        }
      }
 
?>