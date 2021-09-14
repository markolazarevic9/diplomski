
 <div class="sidebar">
     <div class="option">
       <a href="/"><i class="fas fa-desktop"></i> Dashboard</a>
     </div>
     <div class="option">
       <a href="pacijenti.php"
         ><i class="fas fa-procedures"></i> Pacijenti</a
       >
     </div>
     <div class="option">
       <a href="lekovi.php"
         ><i class="fas fa-prescription-bottle-alt"></i> Lekovi</a
       >
     </div>
    
     <?php
        if($_SESSION['status'] == 'admin')
        {
          echo '<div class="option">
          <a href="logovi.php"><i class="fa fa-history"></i> Logovi</a>
        </div>';
        }
     ?>
   </div> 
