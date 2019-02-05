<!-- Header -->
<?php
include_once 'Header.php';
?>
<!-- Header -->

<section>

  <form method ="post">
    <div class="loginbox">
      <!-- top and left is for the placement of the box-->
      <h1>Log In</h1>
      <!--The post method is used to send the form-->
      <p>Username</p>
      <input type="text" name="ID" placeholder="Enter Username" >

      <p>Password</p>
      <input type="password" name="password" placeholder="Enter Password" >

      <button type="submit" name="login-button" >Sign in</button>
      <!--Placeholder:- The text that will appear in the boxes. Required:-to let the user know it has to be filled out -->    
      <?php
      if(isset($_POST['login-button']))
      {
        include_once '/var/www/html/Harshdeep/php/Connections/ConnectionStaff.php';
        } 
        $sql = "SELECT DISTINCT * FROM Logins";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
    // output data of each row
          while($row = $result->fetch_assoc()) {
           if ($row['ID'] == $_POST['ID'] && $row['Password'] == $_POST['password'] )
           {
            session_start();
            echo "Ting works";
            $_SESSION['ID'] = $row["ID"];
            session_write_close();
            header("Location: indexPage.php");
          } else {
            echo "Wrong Password";
          }
        }
      } else {
        echo "0 results";
      }
      $conn->close();
    }
    ?>
  </div>

</form>


</section>
<!-- Footer -->
<?php
include_once 'footer.php';
?>
<!-- Footer -->

