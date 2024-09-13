<?php
   // Start the session
   session_start();

   if(!isset($_SESSION['login_user'])){
      die();
   }
   $login_session = $_SESSION['login_user'];
?>