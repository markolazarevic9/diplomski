<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/486587c22a.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css" />

    <title>Prijem</title>
  </head>
  <body>
    <?php require_once("components/header.php") ?>

    <div class="central">
      <?php require_once("components/sidebar.php")?>
      <div class="main">
        <h2 id="mainH">Prijem</h2>
        <hr />
        <form action="/" autocomplete="off">
          <input type="text" name="name" placeholder="Unesite ime pacijenta" />
          <br />
          <input
            type="text"
            name="lastName"
            placeholder="Unesite prezime pacijenta"
          />
          <br />
          <input type="text" placeholder="Unesite jmbg" /> <br />
          <input type="text" placeholder="Unesite lbo" /> <br />
          <input type="text" placeholder="Unesite pol" /> <br />
          <input type="text" placeholder="Unesite broj telefona" />
        </form>
      </div>
    </div>
  </body>
</html>
