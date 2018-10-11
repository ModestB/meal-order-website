<?php
include "db_connect.php";
function updateMealPlans(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.sender.net/meals/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $response = json_decode($response, true);
    $days = $response['feed']['days'];
    foreach($days as $key => $val){
        global $connectToDb;
        $weekDay = $key;
        $meals = $val['meals'];
        if($connectToDb):
            addSoups($connectToDb, $weekDay, $meals['soups']);
            addMainDishes($connectToDb, $weekDay, $meals['mainDishes']);
            addSalads($connectToDb, $weekDay, $meals['salads']);
            addSaladsAddons($connectToDb, $weekDay, $meals['salads']);
            addSideDishes($connectToDb, $weekDay, $meals['sideDishes']['dishes']);
        endif;


    };
}
        
function addSoups($connectToDb, $weekDay, $soups){
    foreach($soups as $soup){
        $title = $soup["title"];
        $price = $soup["price"];
        $query = "INSERT INTO mo_meals_soups(id, week_day, title, price) VALUES (NULL, '$weekDay', '$title', '$price')";
        $result = mysqli_query($connectToDb, $query);
    };
}

function addMainDishes($connectToDb, $weekDay, $mainDishes){
    foreach($mainDishes as $mainDish){
        $title = $mainDish["title"];
        $price = $mainDish["price"];
        $side_dish = 0;
        if($mainDish['sideDishCounts']):
            $side_dish = 1;
        endif;
        $query = 
            "INSERT INTO mo_meals_maindishes(id, week_day, title, price, side_dish)
            VALUES (NULL, '$weekDay', '$title', '$price', '$side_dish')";
        $result = mysqli_query($connectToDb, $query);
    }; 
}


function addSalads($connectToDb, $weekDay, $salads){
    foreach($salads as $salad){
        $title = $salad["title"];
        $price = $salad["price"];
        $addons = 0;
        if($salad['addons']):
            $addons = 1;
        endif;
        addSaladsAddons($connectToDb, $weekDay, $salad['addons']);
        $query = 
            "INSERT INTO mo_meals_salads(id, week_day, title, price, addons)
            VALUES (NULL, '$weekDay', '$title', '$price', '$addons')";
        $result = mysqli_query($connectToDb, $query);
    };
}

function addSaladsAddons($connectToDb, $weekDay, $saladsAddons){
    foreach($saladsAddons as $saladsAddon){
        $title = $saladsAddon["title"];
        $price = $saladsAddon["price"];
        $query = 
            "INSERT INTO mo_meals_salads_addons(id, week_day, title, price)
            VALUES (NULL, '$weekDay', '$title', '$price')";
        $result = mysqli_query($connectToDb, $query);
    };
}

function addSideDishes($connectToDb, $weekDay, $sideDishes){
    foreach($sideDishes as $sideDish){
        $title = $sideDish["title"];
        $type = $sideDish["type"];
        $query = 
            "INSERT INTO mo_meals_sidedishes(id, week_day, title, dish_type)
            VALUES (NULL, '$weekDay', '$title', '$type')";
        $result = mysqli_query($connectToDb, $query);
    };
}

function clearTables(){
    global $connectToDb;
    $query = "TRUNCATE mo_meals_maindishes;TRUNCATE mo_meals_salads;TRUNCATE mo_meals_salads_addons;TRUNCATE mo_meals_sidedishes;TRUNCATE mo_meals_soups;";
    $result = mysqli_multi_query($connectToDb, $query);
}
 ?>