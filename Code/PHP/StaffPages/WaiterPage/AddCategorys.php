<?php
$AddVegetarian = "";
$AddVegan = "";
$AddGluten = "";
$AddEggs = "";
$AddMilk = "";
$AddPeanuts = "";
$AddNuts = "";
$AddCelery = "";
$AddFish = "";
$AddCurstanceans = "";
$AddMolluscs = "";
$AddMustard = "";
$AddSoya = "";
$AddSulphites = "";
$AddSesameSeeds = "";
$AddLupin = "";

$Allergens = array();

// if(sizeof($_POST['DietReq'])>0){
//       foreach ($_POST['DietReq'] as $key => $value) {if($value == 'Vegetarian'){ echo "checked";}}}
 // && (sizeof($AddVeganArray)>0) && (sizeof($AddGlutenArray)>0) && (sizeof($AddEggsArray)>0) && (sizeof($AddMilkArray)>0) && (sizeof($AddPeanutsArray)>0) && (sizeof($AddNutsArray)>0) && (sizeof($AddCeleryArray)>0) && (sizeof($AddFishArray)>0) && (sizeof($AddCurstanceansArray)>0) && (sizeof($AddMolluscsArray)>0) && (sizeof($AddMustardArray)>0) && (sizeof($AddSoyaArray)>0) && (sizeof($AddSulphitesArray)>0) && (sizeof($AddSesameSeedsArray)>0) && (sizeof($AddLupinArray)>0)

if((sizeof($_POST['AddVegetarian'])>0) and (sizeof($_POST['AddVegan'])>0) and (sizeof($_POST['AddGluten'])>0) and (sizeof($_POST['AddEggs'])>0) and (sizeof($_POST['AddMilk'])>0) and (sizeof($_POST['AddPeanuts'])>0) and (sizeof($_POST['AddNuts'])>0) and (sizeof($_POST['AddCelery'])>0) ){

  array_push($Allergens, "Contains");

  foreach ($_POST['AddVegetarian'] as $key => $value) {
    if($value == 'Yes'){ 
      $AddVegetarian = "Yes";
      array_push($Allergens, "Vegetarian");
    }else{
      $AddVegetarian = "No";
    }
  }
  foreach ($_POST['AddVegan'] as $key => $value) {
    if($value == "Yes"){ 
      $AddVegan = "Yes";
      array_push($Allergens, "Vegan");
    }else{
      $AddVegan= "No";
    }

  }
  foreach ($_POST['AddGluten'] as $key => $value) {
    if($value == "Yes"){ 
      $AddGluten = "Yes";
      array_push($Allergens, "Gluten");
    }else{
      $AddGluten = "No";
    }
  }
  foreach ($_POST['AddEggs'] as $key => $value) {
    if($value == "Yes"){ 
      $AddEggs = "Yes";
      array_push($Allergens, "Eggs");
    }else{
      $AddEggs = "No";
    }
  }
  foreach ($_POST['AddMilk'] as $key => $value) {
    if($value == "Yes"){ 
      $AddMilk = "Yes";
      array_push($Allergens, "Milk");
    }else{
      $AddMilk = "No";
    }

  }
  foreach ($_POST['AddPeanuts'] as $key => $value) {
    if($value == "Yes"){ 
      $AddPeanuts = "Yes";
      array_push($Allergens, "Peanuts");
    }else{
      $AddPeanuts = "No";
    }
  }
  foreach ($_POST['AddNuts']as $key => $value) {
    if($value == "Yes"){ 
      $AddNuts = "Yes";
      array_push($Allergens, "Nuts");
    }else{
      $AddNuts = "No";
    }
  }
  foreach ($_POST['AddCelery'] as $key => $value) {
    if($value == "Yes"){ 
      $AddCelery = "Yes";
      array_push($Allergens, "Celery");
    }else{
      $AddCelery = "No";
    }
  }
  foreach ($_POST['AddFish'] as $key => $value) {
    if($value == "Yes"){ 
      $AddFish = "Yes";
      array_push($Allergens, "Fish");
    }else{
      $AddFish = "No";
    }

  }
  foreach ($_POST['AddCurstanceans'] as $key => $value) {
    if($value == "Yes"){ 
      $AddCurstanceans = "Yes";
      array_push($Allergens, "Curstanceans");
    }else{
      $AddCurstanceans = "No";
    }

  }
  foreach ($_POST['AddMolluscs'] as $key => $value) {
    if($value == "Yes"){ 
      $AddMolluscs = "Yes";
      array_push($Allergens, "Molluscs");
    }else{
      $AddMolluscs = "No";
    }

  }
  foreach ($_POST['AddMustard'] as $key => $value) {
    if($value == "Yes"){ 
      $AddMustard = "Yes";
      array_push($Allergens, "Mustard");
    }else{
      $AddMustard = "No";
    }

  }
  foreach ($_POST['AddSoya'] as $key => $value) {
    if($value == "Yes"){ 
      $AddSoya = "Yes";
      array_push($Allergens, "Soya");
    }else{
      $AddSoya = "No";
    }

  }
  foreach ($_POST['AddSulphites'] as $key => $value) {
    if($value == "Yes"){ 
      $AddSulphites = "Yes";
      array_push($Allergens, "Sulphites");
    }else{
      $AddSulphites = "No";
    }

  }
  foreach ($_POST['AddSesameSeeds'] as $key => $value) {
    if($value == "Yes"){ 
      $AddSesameSeeds = "Yes";
      array_push($Allergens, "Sesame Seeds");
    }else{
      $AddSesameSeeds = "No";
    }

  }
  foreach ($_POST['AddLupin'] as $key => $value) {
    if($value == "Yes"){ 
      $AddLupin = "Yes";
      array_push($Allergens, "Lupin");
    }else{
      $AddLupin = "No";
    }

  }
}
   
  


?>