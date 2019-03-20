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
        <!-- this for the table which displays the orders.-->
        <table style="width:100%">
         <colgroup>
           <col style="width:7.5%">
           <col style="width:52.5%">
           <col style="width:20%">
           <col style="width:20%">
         </colgroup>
         <tr>
           <th>Table</th>
           <th>Items</th>
           <th>Order Placed</th>
           <th>Status</th>
         </tr>
         <?php
         require '../../Connections/ConnectionStaff.php';

         $sql = "SELECT * FROM Orders";
         $res = $conn->query($sql);
         if($res-> num_rows == 0){
           echo "0 results";
         }
         else{
           while($row = mysqli_fetch_assoc($res)){
                                     // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
             echo "<tr>";
             echo "<td>{$row['ID']}</td><td>{$row['Items']}</td><td>{$row['Time']}</td>";
             ?><td>
               <select>
                 <option value="orderPlaced">Order Placed</option>
                 <option value="cooking">Cooking</option>
                 <option value="cooked">Cooked</option>
                 <option value="delivered">Delivered</option>
               </select>
               <td>
                 <?php
                 echo "</tr>";
               }
             }
             mysqli_close($conn);
             ?>
           </td>
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
        <p>Enter ID</p>
        <input type="number" name="AddItemId" placeholder="Enter ID"><br>
        <input type="radio" name="TrueOrFalse[]" value="True">True
        <input type="radio" name="TrueOrFalse[]" value="False">False<br>
        <input type="submit" class="btn btn-primary" name="GetDish" value="Submit">
        <?php
        require '../../Connections/ConnectionCustomer.php';
        $GetItemID = $_POST['AddItemId'];
        $GetTrueOrFalseArray = array();
        $GetTrueOrFalse = "";

        if(!empty($_POST['AddItemId']) && !empty($_POST['TrueOrFalse'])){
          foreach ($_POST['TrueOrFalse'] as $value) {
            array_push($GetTrueOrFalseArray, $value);
          }
          $GetTrueOrFalse .= join("", $GetTrueOrFalseArray);
          if($GetTrueOrFalse == 'True'){
            $UpdateSql = "UPDATE menu SET Availability = 'True' WHERE id=$GetItemID";
          }elseif ($GetTrueOrFalse == 'False') {
            $UpdateSql = "UPDATE menu SET Availability = 'False' WHERE id=$GetItemID";
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
