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
         <table style="width:100%">
           <colgroup>
             <col style="width:5%">
             <col style="width:50%">
             <col style="width:15%">
             <col style="width:15%">
             <col style="width:15%">
           </colgroup>
           <tr>
             <th>Table</th>
             <th>Items</th>
             <th>Time</th>
             <th>Status</th>
             <th>Change Status</th>
           </tr>
           <?php
           require '../../Connections/ConnectionCustomer.php';

           $sql = "SELECT ID, Item, Time,Quantity, Price, Status FROM Orders ORDER BY Time ASC";
           $res = $conn->query($sql);
           if($res-> num_rows == 0){
             echo "0 results";
           }
           else{
            $num_rows = 0;
            while($row = mysqli_fetch_assoc($res)){
              $num_rows++;
              $id = $row['ID'];
             // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
              echo "<tr>";
              echo "<td>{$row['ID']}</td><td>{$row['Item']}</td><td>{$row['Time']}</td><td>{$row['Status']}</td><td>";
              $StatusId = "status".$num_rows;
              $hrefStatusId = "#status".$num_rows;
              $StatusId = "status".$num_rows."[]";
              $dropdownChange = "dropdownChange".$num_rows;
              ?>

              <select name="<?php echo $StatusId ?>">
                <option value="NoStatus">No Status</option>
                <option value="OrderPlaced">Order Placed</option>
                <option value="Cooking">Cooking</option>
                <option value="Cooked">Cooked</option>
                <option value="Delivered">Delivered</option>
                <div class="itemBoxes">
                  <?php 
                  $submitButtonID = "submitButton".$num_rows;
                  $hrefSubmitButtonID = "#submitButton".$num_rows;
                  ?>
                  <input type="submit" class="btn btn-success" name="<?php echo($submitButtonID); ?>" value="Submit" href="<?php echo($hrefSubmitButtonID); ?>" />
                </div>
              </select>


              <?php
              echo "</td>";
              echo "</tr>";
            }

            for ($i = 1; $i <= $num_rows; $i++) {
              $submitButtonID = "submitButton".$i;
              $StatusID = "status".$i;

              ?>
              <div id="<?php echo($submitButtonID); ?>" class="addItemToCart">
                <?php
                echo("Before if");
                if (isset($_POST[$submitButtonID]) && $_POST[$StatusID]) {
                  $ItemRowData =array();
                  $IdRowData = array();
                  $sql = "SELECT ID, Item, Status FROM Orders";
                  $res = $conn->query($sql);
                  if ($res -> num_rows == 0) {
                    echo "0 results";
                  }else{
                    while($row = mysqli_fetch_assoc($res)){
                      array_push($IdRowData, $row['ID']);
                      array_push($ItemRowData, $row['Item']);
                    }
                    $GetStatusArray =array();
                    foreach ($_POST[$StatusID] as $value) {
                      array_push($GetStatusArray, $value);
                    }
                    $GetStatus = join("", $GetStatusArray);
                    if ($GetStatus == $_POST[$StatusID]) {
                      echo("Ting Works 2");
                    }else{
                      for ($j=0; $j < $i; $j++) { 
                        if($GetStatus == "OrderPlaced"){
                          $UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND ID='$IdRowData[$j]'";
                        }elseif($GetStatus =="Cooking"){
                          $UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND ID='$IdRowData[$j]'";
                        }elseif($GetStatus == "Cooked"){
                          $UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND ID='$IdRowData[$j]'";
                        }elseif ($GetStatus == "Delivered"){
                          $UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND ID='$IdRowData[$j]'";
                        }
                      }                      
                    }
                    //echo $UpdateSql;
                    $res = $conn->query($UpdateSql);
                    if($res === True){
                      echo "Status changed";
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
       <a href="../TableAssistance.php" class="waiterButtons">Table Assistance</a>
       <a href="../PlaceOrders.php" class="waiterButtons">Place Orders</a>
       <a href="../CancelOrders.php" class="waiterButtons">Cancel Orders</a>
     </div>
   </div>
 </div>

 <div id="ChangeMenuAvailability" class="ChangeMenuAvailability">
  <div class="ChangeAvailabilityPopUp">
    <a class="close" href="">&times;</a>
    <div class="popupInfo">
      <h3>Enter Dish Name</h3>
      <input type="text" name="AddItemName" placeholder="Dish Name"><br>
      <input type="radio" name="TrueOrFalse[]" value="True">True
      <input type="radio" name="TrueOrFalse[]" value="False">False<br>
      <input type="submit" class="btn btn-primary" name="GetDish" value="Submit">
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
        if($GetStatus == 'True'){
          $UpdateSql = "UPDATE menu SET Availability = 'True' WHERE Item='$GetItemStatus'";
        }elseif ($GetStatus == 'False') {
          $UpdateSql = "UPDATE menu SET Availability = 'False' WHERE Item='$GetItemStatus'";
        }
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
   <!--<h6>User: </h6>-->
   <a href="../../LoginScripts/Logout.php" class="signOutButton">Sign Out</a>
 </footer>
</div>
</form>
</section>

<!-- Footer -->
<?php
include_once '../footer.php';
?>
<!-- Footer -->
