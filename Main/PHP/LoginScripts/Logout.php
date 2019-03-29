<?php
session_start();

// If session has successfully been destroyed, link to the LoginPage 
if (session_destroy()) {
  header("Location: LoginPage/LoginPage.php");
}
?>
