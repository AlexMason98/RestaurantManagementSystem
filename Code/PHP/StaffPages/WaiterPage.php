<!-- Header -->
<?php

include_once '/var/www/html/Alex/php/Header.php';
//include_once '../Connections/ConnectionStaff';
include('../LoginScripts/Session.php');
  $results = mysqli_query("SELECT * FROM Logins WHERE ID = {$_SESSION['ID']}");
  $user = mysqli_fetch_array($results);

?>
<!-- Header -->

<section>

 <form method="post">
   <div class="container-fluid">
       <!--<div class="col-lg-2 col-md-3 col-sm-4" id="left">-->
       <div class="left">
         <div class="currentOrderTitle">
           <h3>Current Orders</h3>
         </div>

         <div class="currentOrderTable">
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
               require '/var/www/html/Alex/php/Connections/ConnectionStaff.php';

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
             <!--<tr>
               <th>1</th>
               <th>Boganzo Meal with Pepsi,<br>
               Double Boganzo Meal with 2 Pepsis</th>
               <th>01:16</th>
               <th>Order Placed</th> -->
            </tr>
           </table>
         </div>
       </div>

       <div class="right">
         <div class="waiterButtonDiv">
           <a href="ChangeMenu.php" class="waiterButtons">Change Menu</a>
           <a href="TableAssistance.php" class="waiterButtons">Table Assistance</a>
           <a href="PlaceOrders.php" class="waiterButtons">Place Orders</a>
           <a href="CancelOrders.php" class="waiterButtons">Cancel Orders</a>
         </div>
       </div>
   </div>


   <div class="footer">
     <footer>
       <!--<h6>User: </h6>-->
       <a href="../LoginScripts/Logout.php" class="signOutButton">Sign Out</a>
     </footer>
   </div>
 </form>
</section>

<!-- Footer -->
<?php
include_once '../footer.php';
?>
<!-- Footer -->
