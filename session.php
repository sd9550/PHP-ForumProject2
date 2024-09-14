<?php
   // Start the session
   session_start();

   if(!isset($_SESSION['login_user'])){
      die();
   }
   $login_session = $_SESSION['login_user'];

   /*
git remote add origin https://github.com/sd9550/PHP-ForumProject2.git
git branch -M main
git push -u origin main
*/
?>