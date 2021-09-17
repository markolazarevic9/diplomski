<?php
        session_start();
        require_once("functions.php");
        if(isset($_SESSION['ime']) && $_SESSION['ime'] != "") 
        {
                upisLog("Odjava");
                session_unset();
                session_destroy();
                header("location:login.php");
        }
       
?>