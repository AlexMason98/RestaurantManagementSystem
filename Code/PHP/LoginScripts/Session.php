<?php
  include('../Connections/ConnectionStaff.php');
  session_start();

  $user_check = $_SESSION['userSession'];
  $session = mysqli_query($conn, "SELECT ID FROM Logins WHERE ID = '$ID'");
  $row = mysqli_fetch_array($session, MYSQLI_ASSOC);

  $loginSession = $row['ID'];

  if (!isset($_SESSION['userSession'])) {
    header("Location: LoginPage/LoginPage.php");
    die();
  }

?>
