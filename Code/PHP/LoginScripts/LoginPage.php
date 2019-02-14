<!-- Header -->
<?php
include_once '../Header.php';
?>
<!-- Header -->

<?php
include_once '../Connections/ConnectionStaff.php';
session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = mysqli_real_escape_string($conn, $_POST['ID']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);

    $query = "SELECT * FROM Logins WHERE ID = '$ID' AND Password = '$Password'";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    /* If entered ID equals ID in database and entered password equals password in
    database, we would get 1 table row */
    if ($count == 1) {
      $_SESSION['userSession'] = $ID;
      header("Location: ../StaffPages/WaiterPage.php");
    } else {
      ?><script>alert("Incorrect Details Entered, Please Try Again");</script><?php
    }
  }

 ?>

<html>
<body>
  <form method ="post">

    <div class="title">
      <h1>Staff Login Page</h1>
    </div>
    <div class="loginbox">
      <!-- top and left is for the placement of the box-->
      <h1>Log In</h1>
      <!--The post method is used to send the form-->
      <p>Username</p>
      <input type="text" name="ID" placeholder="Enter Username" required />

      <p>Password</p>
      <input type="Password" name="Password" placeholder="Enter Password" required />

      <button type="submit" name="login-button">Sign in</button>
      <!--Placeholder:- The text that will appear in the boxes. Required:-to let the user know it has to be filled out -->
  </div>

</form>
</body>
</html>
<!-- Footer -->
<?php
include_once 'footer.php';
?>
<!-- Footer -->
