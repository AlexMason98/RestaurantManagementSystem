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
               </tr>
             </table>
           </div>
         </div>

         <div class="right">
           <div class="waiterButtonDiv">
            <a href="#ChangeMenuPopUp" class="waiterButtons">Change Menu</a>
            <a href="../TableAssistance.php" class="waiterButtons">Table Assistance</a>
            <a href="../PlaceOrders.php" class="waiterButtons">Place Orders</a>
            <a href="../CancelOrders.php" class="waiterButtons">Cancel Orders</a>
          </div>
        </div>

        <div id="ChangeMenuPopUp" class="ChangeMenuOverlay">
          <div class="ChangeMenuPopup">
            <a class="close" href="#">&times;</a>
            <div class="popupInfo">

              <h4>Add ID</h4>
              <input type="text" name="AddID" placeholder="ID">
              <h4>Add Item Name</h4>
              <input type="text" name="AddItem" placeholder="Item Names">
              <h4>Add Category</h4>
              <?php
              require "CategoryDropDown.php";
              ?>
              <h4>Add Sub_Category</h4>
              <?php
              require "Sub_CategoryDropDown.php";
              ?>
              <h4>Add Price</h4>
              <input type="float" name="AddPrice" placeholder="Price">
              <h4>Add Ingredients</h4>
              <input type="text" name="AddIngredients" placeholder="Ingredients">
              <h4>Add Calories </h4>
              <input type="number" name="AddCalories" placeholder="Calories">
              <h4>Add Description</h4>
              <input type="text" name="AddDescription" placeholder="Description">
              <?php 
              require "Add_Refinements.php";
              ?>
              <input type="submit" name="AddDish" value="submit">

              <?php
              require '../../Connections/ConnectionCustomer.php';
              include_once "AddCategorys.php";


              $AddID = $_POST['AddID'];
              $AddItem = $_POST['AddItem'];
              $AddCategoryArray = $_POST['AddCategory'];
              $AddCategorys = "";
              foreach ($AddCategoryArray as $key => $value) {
                $AddCategory = $value;
              }

              $AddSubCategoryArray = $_POST['AddSubCategory'];
              $AddSubCategory = "";
              foreach ($AddCategoryArray as $key => $value) {
                $AddSubCategory = $value;
              }
              $AddPrice = $_POST['AddPrice'];
              $AddIngredients = $_POST['AddIngredients'];
              $AddCalories = $_POST['AddCalories'];
              $AddDescription = $_POST['AddDescription'];

             
              
              

              $DishAllergens = join(", ", $Allergens);

              // $sql = "INSERT INTO menu(ID, Item, Category, Sub_Category, Price, ImagePath) VALUES($AddID, $AddItem, $AddCategory, $AddSubCategory, $AddPrice, $AddID.'jpg')";
              // $sql2 = "INSERT INTO IngredientsAndCalories(ID, Item, Ingredients, Calories) VALUES ($AddID, $AddItem, $AddIngredients, $AddCalories)";
              // $sql3 = "INSERT INTO DietaryRequirements(ID, Item, Vegetarian, Vegan, GlutenFree, ContainsEgg, ContainsMilk, ContainsPeanuts, ContainsTreeNuts, ContainsCelery, ContainsFish, ContainsCrustaceans, ContainsMolluscs, ContainsMustard, ContainsSoya, ContainsSulphites, ContainsSesameSeeds, ContainsLupin) VALUES ($AddID, $AddItem,$AddVegetarian,$AddVegan,$AddGluten,$AddEggs,$AddMilk,$AddPeanuts,$AddNuts,$AddCelery,$AddFish,$AddCurstanceans,$AddMolluscs,$AddMustard,$AddSoya,$AddSulphites,$AddSesameSeeds,$AddLupin)";
              // $sql4 = "INSERT INTO Description(ID, Item, Description) VALUES ($AddID, $AddItem, $AddDescription)";
              // $sql5 = "INSERT INTO Allergens(ID, Item, Allergens) VALUES ($AddID, $AddItem, $DishAllergens)";

              echo $DishAllergens;
              // echo $sql;
              // echo $sql2;
              // echo $sql3;
              // echo $sql4;
              // echo $sql5;

              echo $AddID;
              echo $AddItem;
              echo $AddCategory;
              echo $AddSubCategory;
              echo $AddPrice;
              echo $AddIngredients;
              echo $AddCalories;
              echo $AddDescription;
              echo $AddVegetarian;
              echo $AddVegan;
              echo $AddGluten;
              echo $AddEggs;
              echo $AddMilk;
              echo $AddPeanuts;
              echo $AddNuts;
              echo $AddCelery;
              echo $AddFish;
              echo $AddCurstanceans;
              echo $AddMolluscs;
              echo $AddMustard;
              echo $AddSoya;
              echo $AddSulphites;
              echo $AddSesameSeeds;
              echo $AddLupin;


              mysqli_close($conn);
              ?>

            </div>
          </div>
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
include_once '../../footer.php';
?>
<!-- Footer -->
