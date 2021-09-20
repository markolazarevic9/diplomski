<?php
        $upitUkupno = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NOT NULL";
        $rezUkupno = $db->query($upitUkupno);
        $ukupno = (mysqli_fetch_row($rezUkupno))[0];
    
        $upitM = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IN (SELECT IDKARTON FROM KARTON WHERE IDPACIJENT in (SELECT IDPACIJENT FROM PACIJENT WHERE POL = 'M'))";
        $rezM = $db->query($upitM);
        $m = mysqli_fetch_row($rezM)[0];
    
        $mProcenat = round(($m / $ukupno) * 100,2) . " %";
    
        $upitZ = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IN (SELECT IDKARTON FROM KARTON WHERE IDPACIJENT in (SELECT IDPACIJENT FROM PACIJENT WHERE POL = 'Ž'))";
        $rezZ = $db->query($upitZ);
        $z = mysqli_fetch_row($rezZ)[0];
    
        $zProcenat = round(($z / $ukupno) * 100,2) . " %";
    
        $upitVakc = "SELECT COUNT(IDKARTON) FROM KARTON WHERE VAKCINISAN = 'DA' AND IDKARTON IN (SELECT IDKARTON FROM KREVET)";
        $rezVakc = $db->query($upitVakc);
        $vakc = mysqli_fetch_row($rezVakc)[0];
    
        $vakcProcenat = round(($vakc / $ukupno) * 100,2) . " %";
    
        $upitNeVakc = "SELECT COUNT(IDKARTON) FROM KARTON WHERE VAKCINISAN = 'NE' AND IDKARTON IN (SELECT IDKARTON FROM KREVET)";
        $rezNeVakc = $db->query($upitNeVakc);
        $neVakc = mysqli_fetch_row($rezNeVakc)[0];
    
        $neVakcProcenat = round(($neVakc / $ukupno) * 100,2) . " %";
    
        $sqlInt = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NOT NULL AND IDSOBA IN (SELECT IDSOBA FROM SOBA WHERE IDODELJENJE = (SELECT IDODELJENJE FROM ODELJENJE WHERE NAZIVODELJENJE = 'Intenzivna nega'))";
        $rezInt = $db->query($sqlInt);
        $brojInt = mysqli_fetch_row($rezInt)[0];
    
        $intProcenat = round(($brojInt / $ukupno) * 100,2) . " %";
        $sqlPolu = "SELECT COUNT(IDKREVET) FROM KREVET WHERE IDKARTON IS NOT NULL AND IDSOBA IN (SELECT IDSOBA FROM SOBA WHERE IDODELJENJE = (SELECT IDODELJENJE FROM ODELJENJE WHERE NAZIVODELJENJE = 'Poluintenzivna nega'))";
        $rezPolu= $db->query($sqlPolu);
        $brojPolu = mysqli_fetch_row($rezPolu)[0];
        $poluProcenat = round(($brojPolu / $ukupno) * 100,2) . " %";
    
        $today = date("Y-m-d",time());
        $oneDayAgo = date("Y-m-d",strtotime("-1 days"));
        $twoDayAgo = date("Y-m-d",strtotime("-2 days"));
        $threeDayAgo = date("Y-m-d",strtotime("-3 days"));
        $fourDayAgo = date("Y-m-d",strtotime("-4 days"));
        $fiveDayAgo = date("Y-m-d",strtotime("-5 days"));
        $sixDayAgo = date("Y-m-d",strtotime("-5 days"));
    
        $dates = array();
        $prijemi = array();
        $umrlih = array();
        $ozdrav = array();
        array_push($dates,$today,$oneDayAgo,$twoDayAgo,$threeDayAgo,$fourDayAgo,$fiveDayAgo,$sixDayAgo);
        foreach($dates as $value)
        {
          $upitPrijemaDanas = "SELECT fun_prijemi_datum('$value')";
          $rezPrijemaDanas = $db->query($upitPrijemaDanas);
          $prijemaDanas = (mysqli_fetch_row($rezPrijemaDanas))[0];
          array_push($prijemi,$prijemaDanas);
        }
        foreach($dates as $value)
        {
          $upitUmrlih = "SELECT fun_broj_umrlih('$value')";
          $rezUmrlih = $db->query($upitUmrlih);
          $brojUmrlih = (mysqli_fetch_row($rezUmrlih))[0];
          array_push($umrlih,$brojUmrlih);
        }
        foreach($dates as $value)
        {
          $upitOzd = "SELECT fun_broj_zdravih('$value')";
          $rezOzd = $db->query($upitOzd);
          $brojOzd = (mysqli_fetch_row($rezOzd))[0];
          array_push($ozdrav,$brojOzd);
        }
        


?>