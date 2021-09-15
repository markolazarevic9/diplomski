
 <div class="sidebar">
     <div class="option">
       <a href="dashboard.php"><i class="fas fa-desktop"></i> Dashboard</a>
     </div>
     <?php
        if($_SESSION['status'] != 'admin')
        {
          echo ' <div class="option">
          <a href="pacijenti.php"
            ><i class="fas fa-procedures"></i> Pacijenti</a
          >
        </div>
        <div class="option">
          <a href="lekovi.php"
            ><i class="fas fa-prescription-bottle-alt"></i> Lekovi</a
          >
        </div>';
        }
     ?>
    
     <?php
        if($_SESSION['status'] == 'admin')
        {
          echo '<div class="option">
          <a href="logovi.php"><i class="fa fa-history"></i> Logovi</a>
        </div>';
        echo '<div class="option">
          <a href="dodajRadnika.php"><i class="fas fa-users"></i></i> Dodaj radnika</a>
        </div>';
        echo '<div class="option">
          <a href="adresa.php"><i class="fas fa-map-marked"></i> Dodaj Adresu</a>
        </div>';
        echo '<div class="option">
        <a href="unosPacijenta.php"><i class="fab fa-accessible-icon"></i> Unos pacijenta</a>
      </div>';
      echo '<div class="option">
      <a href="logovi.php"><i class="fas fa-scroll"></i> Statistika</a>
    </div>';
    echo '<div class="option">
      <a href="dodajLek.php"><i class="fas fa-prescription-bottle-alt"></i> Dodaj Lek</a>
    </div>';
    echo '<div class="option">
      <a href="dodajDijagnozu.php"><i class="fas fa-stethoscope"></i> Dodaj dijagnozu</a>
    </div>';
        }
     ?>
   </div> 
