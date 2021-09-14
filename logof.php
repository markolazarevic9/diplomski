<?php
        session_start();
        require_once("functions.php");
        upisLog("odjavio");
        session_unset();
        session_destroy();
        header("location:login.php");
?>