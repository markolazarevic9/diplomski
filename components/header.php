<?php
  if(!isset($_SESSION['ime'])) 
  {
    header("location:login.php");
  }
?>

<div class="header">
      <h1 id="eBolnica"><i class="fas fa-hospital"></i> eBolnica</h1>
      <span id="logUser">Ulogovani korisnik: <?php echo $_SESSION['ime'] ." ".$_SESSION['prezime']?> <br>
      <button class="btn btn-outline-danger btn-sm"><a style="color:white;text-decoration:none;" href="logof.php">Odjava</a></button></span>
 </div>


 <?php
  require_once("functions.php");
  if(time() - $_SESSION['CREATED'] > 1000) {
    if(isset($_SESSION['ime']) && $_SESSION['ime'] != "")
    {
      upisLog("odjavio");
      session_unset();
      session_destroy();
      header("location:login.php");
    }
    
  }
 ?>