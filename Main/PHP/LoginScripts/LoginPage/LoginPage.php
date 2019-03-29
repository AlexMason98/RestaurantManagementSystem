<!-- Header -->
<?php
include_once '../../Header.php';
include_once '../../Connections/ConnectionStaff.php';
session_start();
?>
<!-- Header -->

<?php

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prevents SQL injection by taking the string and escaping special characters for use in our SQL query below
    // This is important as the Waiter Page contains information about orders and has some admin/staff roles in regards to orders
    $ID = mysqli_real_escape_string($conn, $_POST['ID']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);

    // SQL statement to validate the ID and password entered with the Logins table
    $query = "SELECT * FROM Logins WHERE ID = '$ID' AND Password = '$Password'";

    // Execute query and count number of rows
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    /* If entered ID equals ID in database and entered password equals password in
    database, we would get 1 table row */
    if ($count == 1) {
      $_SESSION['userSession'] = $ID;
      header("Location: ../../StaffPages/WaiterPage/WaiterPage.php");
    } else {
      // If details entered do not match those in the database, print "Incorrect Details Entered" to the staff member
      ?><script>alert("Incorrect Details Entered, Please Try Again");</script><?php
    }
  }

 ?>

<html>
<body>
  <form method ="post">
    <!-- Generate form for the Staff member to log in -->
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
