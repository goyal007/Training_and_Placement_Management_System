<?php 
  session_start(); 
  //this page is to redirect to mnit.php always




/* A session is a way to store information (in variables) to be used across multiple pages.
Unlike a cookie, the information is not stored on the users computer.*/
  if (!isset($_SESSION['username'])) 
  {
    $_SESSION['msg'] = "";
    header('location: mnit.php');
  }
  ?>