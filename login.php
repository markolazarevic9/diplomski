<?php 
  require_once("classes/db.php");
  require_once("functions.php");

  $db = new Db();

  if(!$db->connect())
  {
      echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
      exit();
  }
?>
 
 <?php
  if(isset($_POST['username']) && isset($_POST['password'])) 
  {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($password == "" && $username == "")
    {
      echo "<div class='wrong-data'> <h2>Niste uneli podatke</h2></div>";
    }
    else 
    {
      $upit = "SELECT * FROM PRISTUP WHERE KORISNICKOIME LIKE '{$username}' AND LOZINKA LIKE '{$password}'";
      $rez=$db->query($upit);
      if($db->affected_rows($rez) != 1) 
      {
        echo "<div class='wrong-data'> <h2>Pogrešni kredencijali </h2></div>";
      }
      else 
      {
        session_start();

        $prijavljeni = mysqli_fetch_object($rez);
        $id = $prijavljeni->IDRADNIK;
        $upit2 = "SELECT * FROM RADNIK WHERE IDRADNIK = '{$id}'";
        $rez2 = $db->query($upit2);
        $podaci =  $db->fetch_assoc($rez2);

        $_SESSION['ime'] = $podaci['IMERADNIK'];
        $_SESSION['prezime'] = $podaci['PREZIMERADNIK'];
        $_SESSION['idKorisnik'] = $podaci['IDRADNIK'];
        $_SESSION['status'] = $prijavljeni->STATUS;
        $_SESSION['CREATED'] = time();
        upisLog("Prijava");
        header("location: dashboard.php");
      }
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login page</title>
    <link rel="stylesheet" href="css/style.css" />
    <script
      src="https://kit.fontawesome.com/486587c22a.js"
      crossorigin="anonymous"
    ></script>
    <style>
      .wrong-data {
      position: relative;
      padding: 20px;
      margin-right: auto;
      margin-left: auto;
      background-color: red;
      color: white;
      width: 400px;
      height: 100px;
      text-align:center;
      border-radius:5px;
      margin-bottom:50px;
  }
  .wrong-data h2 {
    margin-top:15px;
   
  }

    </style>
  </head>
  <body>
    <div class="login">
      <form method="post" action="login.php" autocomplete="off">
        <i class="fas fa-hospital"></i> <br />
        <h2>Prijava na eBolnica informacioni sistem</h2>
        <span>
          <i class="fas fa-user"></i
          ><input type="text" name="username" placeholder="Korisničko ime"
        /></span>
        <br />
        <span
          ><i class="fas fa-lock"></i
          ><input type="password" name="password" placeholder="Lozinka"
        /></span>
        <br />
        <button>Prijavi se</button>
      </form>
    </div>

    <script src="js/index.js"></script>
  </body>
</html>
