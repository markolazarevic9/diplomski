<img src="<?php echo $url?>" class="patientPhoto img-fluid">
              <div class="personalData">
                  <h2><?php echo $pacijent->IMEPACIJENT . " " .$pacijent->PREZIMEPACIJENT ?></h2>
                  <h6>JMBG: <?php echo $pacijent->JMBG?> </h6>
                  <h6>LBO: <?php echo $pacijent->LBO?> </h6>
                  <h6>POL: <?php echo $pacijent->POL?> </h6>
                  <h6>BROJ TELEFONA: <?php echo $pacijent->BROJTELEFONA?> </h6>
              </div>
              <div class="personalData">
                <h4>Karton</h4>
                <h6>VAKCINISAN: <?php echo $karton->VAKCINISAN?> </h6>
                <h6>TEST: <?php echo $karton->TEST?> </h6>
                <h6>ALERGIJE: <?php echo $karton->ALERGIJE?> </h6>
                <h6>KRVNA GRUPA: <?php echo $karton->KRVNAGRUPA?> </h6>
                <h6>STATUS: <?php echo $karton->STATUSPACIJENTA?> </h6>
              </div>
              <div class="personalData">
                  <h4>Adresa</h4>
                  <h6>GRAD: <?php echo $adresa->GRAD?> </h6>
                  <h6>ULICA: <?php echo $adresa->ULICA?> </h6>
                  <h6>BROJ: <?php echo $adresa->BROJ?> </h6>
                  <h6>POSTANSKI BROJ: <?php echo $adresa->POSTANSKIBROJ?> </h6>
              </div>
              <?php
                if($karton->STATUSPACIJENTA == "HOSPITALIZOVAN")
                {
                  echo 
                  "<div class='personalData'>
                  <h4>Hospitalizacija</h4>
                  <h6>Odeljenje: {$odeljenje->NAZIVODELJENJE} </h6>
                  <h6>Soba: {$soba->BROJSOBA} </h6>
                  <h6>Krevet: $krevet->IDKREVET </h6>
                 </div>";  
                }
              ?>