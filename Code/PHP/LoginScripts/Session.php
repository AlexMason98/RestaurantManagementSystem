<?php
  include('../Connections/ConnectionStaff.php');
  session_start();

  // Make session for 'userSession' if Login was successful
  $user_check = $_SESSION['userSession'];
  $session = mysqli_query($conn, "SELECT ID FROM Logins WHERE ID = '$ID'");
  $row = mysqli_fetch_array($session, MYSQLI_ASSOC);

  $loginSession = $row['ID'];

  // If there isn't a session set in 'userSession', redirect user back to Login Page
  if (!isset($_SESSION['userSession'])) {
    header("Location: LoginPage/LoginPage.php");
    die();
  }

?>
