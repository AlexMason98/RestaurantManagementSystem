<!-- Header -->
<?php

include_once '../../Header.php';
include_once '../../Connections/ConnectionStaff';
include('../../LoginScripts/Session.php');
$results = mysqli_query("SELECT * FROM Logins WHERE ID = {$_SESSION['ID']}");
$user = mysqli_fetch_array($results);

?>
<!-- Header -->
<section>
 <form method="post">
   <div class="container-fluid">
     <div class="left">
       <div class="currentOrderTitle">
         <h3>Current Orders</h3>
       </div>
       <div class="currentOrderTable">
         <table style="width:100%; font-size: 20px">
           <colgroup>
             <col style="width:5%">
             <col style="width:43%">
             <col style="width:15%">
             <col style="width:10%">
             <col style="width:10%">
             <col style="width:17%">
             <!-- Sets the width of the tables -->
           </colgroup>
           <tr>
             <th>Table</th>
             <th>Items</th>
             <th>Time</th>
             <th>Payment Status</th>
             <th>Status</th>
             <th>Change Status</th>
             <!-- The heading for the table -->
           </tr>
           <?php
           require '../../Connections/ConnectionCustomer.php';
           // connection file to the database
           $sql = "SELECT TableNo, Item, Time, Quantity, Price, PaymentStatus, Status FROM Orders ORDER BY Time ASC";
           // sql query for which get the dishes from the databse, ordered by Time
           $res = $conn->query($sql);
           // gets the result from the database
           if($res-> num_rows == 0){
             echo "0 results";
           }
           else{
            $num_rows = 0;
            while($row = mysqli_fetch_assoc($res)){
              $num_rows++;
              $id = $row['ID'];
              echo "<tr>";
              echo "<td>{$row['TableNo']}</td><td>{$row['Item']}</td><td>{$row['Time']}</td><td>{$row['PaymentStatus']}</td><td>{$row['Status']}</td><td>";
              // Displays the dishes for each table including the status for each dish.

              $StatusId = "status".$num_rows."[]";
              $dropdownChange = "dropdownChange".$num_rows;
              // variable used to differentiate the dropdown and status for each dish by differentiating the name of each dropdown
              ?>
              <select name="<?php echo $StatusId ?>" id="statusSelect">
                <option value="Order Placed">Order Placed</option>
                <option value="Cooking">Cooking</option>
                <option value="Cooked">Cooked</option>
                <option value="Delivered">Delivered</option>
                  <!-- The dropdown option -->
                  <?php 
                  $submitButtonID = "submitButton".$num_rows;
                  $hrefSubmitButtonID = "#submitButton".$num_rows;
                  // variable used to differentiate the submit button for each dropdown
                  ?>
                  <input type="submit" class="btn btn-success" name="<?php echo($submitButtonID); ?>" id="statusSubmit" value="Submit" href="<?php echo($hrefSubmitButtonID); ?>" />
                  <!-- the submit button to send the info as a post -->
              </select>

              <?php
              echo "</td>";
              echo "</tr>";
            }
            for ($i = 1; $i <= $num_rows; $i++) {
              $submitButtonID = "submitButton".$i;
              $StatusID = "status".$i;
              ?>
              <!-- To differentiate the drop menu which changes the status of the dish -->
              <div id="<?php echo($submitButtonID); ?>" class="addItemToCart">
                <?php
                if (isset($_POST[$submitButtonID]) && $_POST[$StatusID]) {
                  $ItemRowData =array();
                  $IdRowData = array();
                  $TableNoRowData = array();

                  $sql = "SELECT TableNo, ID, Item, Status FROM Orders ORDER BY Time ASC";
                  // sql get the orders and there status.
                  $res = $conn->query($sql);
                  if ($res -> num_rows == 0) {
                    echo "0 results";
                  }else{
                    while($row = mysqli_fetch_assoc($res)){
                      array_push($IdRowData, $row['ID']);
                      array_push($TableNoRowData, $row['TableNo']);
                      array_push($ItemRowData, $row['Item']);
                      // Pushes the data from database into the array so it can be used outside the while loop
                    }
                    $GetStatusArray =array();
                    foreach ($_POST[$StatusID] as $value) {
                      array_push($GetStatusArray, $value);
                      // get the value from the dropdown menu and then stores the values to the array.
                    }
                    $GetStatus = join("", $GetStatusArray);

                    for ($j=0; $j < $i; $j++) { 
                      switch($GetStatus){
                        case "Order Placed":
                        $UpdateSql = "UPDATE Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
                        break;
                        case "Cooking":
                        $UpdateSql = "UPDATE Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
                        break;
                        case "Cooked":
                        $UpdateSql = "UPDATE Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
                        break;
                        case "Delivered":
                        $UpdateSql = "DELETE FROM Orders WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
                        break;
                        default:
                        echo "Error getting status";
                        // The switch statement selects the SQL query.  
                        // This updates the status to 'Order Placed', 'Cooking' and 'Cooked'. 
                        // When the status is set to 'Delivered' the Dish is removed from the database.
                      }
                    }
                    $res = $conn->query($UpdateSql);
                    if($res === True){
                      // We refresh the Waiter page if the UpdateSQL query has executed so that we can display the new status change
                      echo('<script>');
                      echo('window.location.href = "WaiterPage.php";');
                      echo('</script>');
                    } else{
                      echo "Error updating record! Try again.";
                    }
                  }
                }
                ?>
              </div>
              <?php
            }
          } 
          mysqli_close($conn);
          ?>
        </table>
      </div>
    </div>

    <div class="right">
      <div class="waiterButtonDiv">
        <a href="#ChangeMenuAvailability" class="waiterButtons">Change Availability</a>
        <a href="TableAssignment.php" class="waiterButtons">Table Assistance</a>
      </div>
    </div>
  </div>

  <div id="ChangeMenuAvailability" class="ChangeMenuAvailability">
    <div class="ChangeAvailabilityPopUp">
      <a class="close" href="">&times;</a>
      <!-- this is cross which allows you to close the pop up -->
      <div class="popupInfo">
        <h3 id="enterDishNameText">Enter Dish Name</h3>
        <input type="text" name="AddItemName" id="dishNameText" placeholder="Dish Name"><br>
        <div id="trueAndFalseButtons">
          <input type="radio" name="TrueOrFalse[]" value="True"> True
          <input type="radio" name="TrueOrFalse[]" value="False"> False<br>
        </div>
        <input type="submit" class="btn btn-success btn-md" id="getDishSubmit" name="GetDish" value="Submit">
        <!-- pop up for the change avaiablitiy. -->
        <?php
        require '../../Connections/ConnectionCustomer.php';
        if(isset($_POST['AddItemName'])){
          $GetItemStatus = $_POST['AddItemName'];
          $GetStatusArray = array();
          $GetStatus = "";
        }

        if(!empty($_POST['AddItemName']) && !empty($_POST['TrueOrFalse'])){
          foreach ($_POST['TrueOrFalse'] as $value) {
            array_push($GetStatusArray, $value);
          }
          $GetStatus .= join("", $GetStatusArray);
          // store the value of true or false
          if($GetStatus == 'True'){
            $UpdateSql = "UPDATE menu SET Availability = 'True' WHERE Item='$GetItemStatus'";
          }elseif ($GetStatus == 'False') {
            $UpdateSql = "UPDATE menu SET Availability = 'False' WHERE Item='$GetItemStatus'";
          }
          // the sql queries depending which avaialabity is selected. 
          $res = $conn->query($UpdateSql);
          if($res === True){
            echo "<br>Dish Availability has changed.";
          }else{
            echo "Error updating record! Try again.";
          }
        }

        mysqli_close($conn);
        ?>
      </div>
    </div>
  </div>

  <div class="footer">
    <footer>
      <a href="../../LoginScripts/Logout.php" class="signOutButton">Sign Out</a>
      <!-- footer which has the sign button. -->
    </footer>
  </div>
</form>
</section>

<!-- Footer -->
<?php
include_once '../../footer.php';
?>
<!-- Footer -->
