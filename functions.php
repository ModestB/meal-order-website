<?php 
include "db_connect.php";

function createUser(){
    if(isset($_POST['submit'])):
        global $connectToDb;
        $username = strtolower(mysqli_real_escape_string($connectToDb, $_POST["username"]));
        $pass = mysqli_real_escape_string($connectToDb, $_POST["pass"]);
        $pass =  password_hash($pass,  PASSWORD_BCRYPT );
        $email = mysqli_real_escape_string($connectToDb, $_POST["email"]);
        
        $usersRaw = getUsers();
        $users = [];
        foreach($usersRaw as $userRaw):
            array_push($users, $userRaw['username']);
        endforeach;

        //TIKRINAME ar visi formos laukai uzpildyti ir ar nera vartotojo su tokiu paciu vardu
        if(!empty($username) && !empty($pass) && !empty($email)  && !in_array($username, $users)):

            // TIKRINAME ar prisijungeme prie duomenu baze
            if($connectToDb):
                $query = "INSERT INTO mo_users(id, username, password, email) VALUES (NULL, '$username', '$pass', '$email')";
                $result = mysqli_query($connectToDb, $query);
                
                if($result):
                    $_SESSION['message'] = "User Created Successfully!";
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['logged_in'] = true;
                    header("location: " . "personal_page.php");
                    exit();
                    session_abort();
                else:
                    $_SESSION['message'] = "Registration failed!!!";
                    echo mysqli_error($connectToDb);
                    header("location: " . "create_user.php?create=failed");
                    exit();
                    session_abort();
                endif;
            endif; 
        else:
            $_SESSION['message'] = "Username already exists!!!";
            header('location: create_user.php?create=failed');  
        endif;
    endif;
};

function login() {
    if($_SERVER["REQUEST_METHOD"] == "POST"):    
        if(isset($_POST['login'])):
            session_start();
            global $connectToDb;
            $username = mysqli_real_escape_string($connectToDb,$_POST['username']);
            $query = "SELECT * FROM mo_users WHERE username='$username'";
            $result = mysqli_query($connectToDb, $query);
            print_r($result);
            
            if($result -> num_rows == 0){
                $_SESSION['message'] = "Wrong Username or Password!!!";
                header('location: index.php?login=failed');
            } else {
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if( password_verify($_POST['pass'], $user['password'])):   
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['logged_in'] = true;
                   
                    $_SESSION['message'] = "Successfully Logged In!";
                    if($_SESSION['username'] == "admin"):
                        header("location: admin_page.php");
                    else:
                        header("location: personal_page.php");
                    endif;                   
                else:
                    $_SESSION['message'] = "Wrong Username or Password!!!";
                    header('location: index.php?login=failed');
                endif;
            };
        endif;
    endif;
};

function logout(){
    if ( isset( $_COOKIE[session_name()] ) )
    setcookie( session_name(), "", time()-3600, "/" );
    $_SESSION = [];
    session_destroy();
};

function updateUserOrder(){
    if(isset($_POST['submit'])):
        global $connectToDb;
        $weekDays = ['monday','tuesday','wednesday', 'thursday', 'friday'];
        $userName = strtolower($_SESSION['username']);
        foreach($weekDays as $day):
            $mainDish = explode("_", $_POST[$day ."MainDishes"])[0];
            $mainDishPrice = explode("_", $_POST[$day ."MainDishes"])[1];

            if(isset($_POST[$day ."SideDishesHot"])):
                $sideDishHot = $_POST[$day ."SideDishesHot"];
            else:
                $sideDishHot = "NULL";
            endif;

            if(isset($_POST[$day ."SideDishesCold"])):
                $sideDishCold= $_POST[$day ."SideDishesCold"];
            else:
                $sideDishCold = "NULL";
            endif;
            
            if(isset($_POST[$day ."Salads"])):
                $salads= explode("_", $_POST[$day ."Salads"])[0];
                $saladsPrice = explode("_", $_POST[$day ."Salads"])[1];           
            else:
                $salads = "NULL";
                $saladsPrice = "";
            endif;

            if(isset($_POST[$day ."SaladsAddons"])):
                $saladsAddon = explode("_", $_POST[$day ."SaladsAddons"])[0];
                $saladAddonPrice = explode("_", $_POST[$day ."SaladsAddons"])[1];       
            else:
                $saladsAddon = "NULL";
                $saladAddonPrice = "";
            endif;

            if(isset($_POST[$day ."Soups"])):
                $soup = explode("_", $_POST[$day ."Soups"])[0];
                $soupPrice = explode("_", $_POST[$day ."Soups"])[1];
            else:
                $soup = "NULL";
                $soupPrice = "";
            endif;

            $totalPrice = (float)$mainDishPrice + (float)$saladsPrice + (float)$saladAddonPrice + (float)$soupPrice;
           
            if($connectToDb):
                $query = "INSERT INTO mo_user_orders(id, username, week_day, main_dish, main_dish_price, side_dish_hot, side_dish_cold, salads, salads_price, salads_addons, salads_addons_price, soup, soup_price, total_price) VALUES (NULL, '$userName', '$day', '$mainDish', '$mainDishPrice', '$sideDishHot', '$sideDishCold', '$salads','$saladsPrice', '$saladsAddon', '$saladAddonPrice', '$soup', '$soupPrice', '$totalPrice')";
                $result = mysqli_query($connectToDb, $query);
                $_SESSION['message'] = "Meal Plans Created!!!";
                $_POST["submit"] = "";
            endif; 
        endforeach;
    endif;
    header("Location: " . "personal_page.php");
};

function getUserData(){
    global $connectToDb;
    $username = $_SESSION['username'];
    if($connectToDb):
        $query = "SELECT * FROM `mo_user_orders` WHERE username = '$username'";
        $result = mysqli_query($connectToDb, $query);

        return $result->fetch_all(MYSQLI_ASSOC);
    endif;
};

function getUsers(){
    global $connectToDb;
    if($connectToDb):
        $query = "SELECT username FROM `mo_users`";
        $result = mysqli_query($connectToDb, $query);

        return $result->fetch_all(MYSQLI_ASSOC);
    endif;
}

function getAllUsersData(){
    global $connectToDb;
    if($connectToDb):
        $query = "SELECT * FROM `mo_user_orders`";
        $result = mysqli_query($connectToDb, $query);

        return $result->fetch_all(MYSQLI_ASSOC);
    endif;
};

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
    foreach($days as $key => $val):
        global $connectToDb;
        $weekDay = $key;
        $meals = $val['meals'];
        if($connectToDb):
            addSoups($connectToDb, $weekDay, $meals['soups']);
            addMainDishes($connectToDb, $weekDay, $meals['mainDishes']);
            addSalads($connectToDb, $weekDay, $meals['salads']);
            addSideDishes($connectToDb, $weekDay, $meals['sideDishes']['dishes']);
        endif;
    endforeach;
};
      
function addSoups($connectToDb, $weekDay, $soups){
    foreach($soups as $soup):
        $title = $soup["title"];
        $price = $soup["price"];
        $query = "INSERT INTO mo_meals_soups(id, week_day, title, price) VALUES (NULL, '$weekDay', '$title', '$price')";
        $result = mysqli_query($connectToDb, $query);
    endforeach;
};

function addMainDishes($connectToDb, $weekDay, $mainDishes){
    foreach($mainDishes as $mainDish):
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
    endforeach; 
};

function addSalads($connectToDb, $weekDay, $salads){
    foreach($salads as $salad):
        $title = $salad["title"];
        $price = $salad["price"];
        $addons = 0;

        if($salad['addons']):
            $addons = 1;
        endif;

        if($addons > 0):
            addSaladsAddons($connectToDb, $weekDay, $salad['addons']);
        endif;

        $query = 
            "INSERT INTO mo_meals_salads(id, week_day, title, price, addons)
            VALUES (NULL, '$weekDay', '$title', '$price', '$addons')";
        $result = mysqli_query($connectToDb, $query);
    endforeach;
};

function addSaladsAddons($connectToDb, $weekDay, $saladsAddons){
    foreach($saladsAddons as $saladsAddon):
        $title = $saladsAddon["title"];
        $price = $saladsAddon["price"];
        $query = 
            "INSERT INTO mo_meals_salads_addons(id, week_day, title, price)
            VALUES (NULL, '$weekDay', '$title', '$price')";
        $result = mysqli_query($connectToDb, $query);
    endforeach;
};

function addSideDishes($connectToDb, $weekDay, $sideDishes){
    foreach($sideDishes as $sideDish):
        $title = $sideDish["title"];
        $type = $sideDish["type"];
        $query = 
            "INSERT INTO mo_meals_sidedishes(id, week_day, title, dish_type)
            VALUES (NULL, '$weekDay', '$title', '$type')";
        $result = mysqli_query($connectToDb, $query);
    endforeach;
};

function clearTables(){
    global $connectToDb;
    $query = "TRUNCATE mo_meals_maindishes;TRUNCATE mo_meals_salads;TRUNCATE mo_meals_salads_addons;TRUNCATE mo_meals_sidedishes;TRUNCATE mo_meals_soups;TRUNCATE mo_user_orders;";
    $result = mysqli_multi_query($connectToDb, $query);
    header("Location: " . "admin_page.php?update=true");
};

function getSoups(){
    global $connectToDb;
    $query = "SELECT * FROM mo_meals_soups";
    $result = mysqli_query($connectToDb, $query);

    return $result->fetch_all(MYSQLI_ASSOC);
};

function getSalads(){
    global $connectToDb;
    $query = "SELECT * FROM mo_meals_salads";
    $result = mysqli_query($connectToDb, $query);

    return $result->fetch_all(MYSQLI_ASSOC);
};

function getSaladsAddons(){
    global $connectToDb;
    $query = "SELECT * FROM mo_meals_salads_addons";
    $result = mysqli_query($connectToDb, $query);

    return $result->fetch_all(MYSQLI_ASSOC);
};

function getMainDishes(){
    global $connectToDb;
    $query = "SELECT * FROM mo_meals_maindishes";
    $result = mysqli_query($connectToDb, $query);

    return $result->fetch_all(MYSQLI_ASSOC);
};

function getSideDishes(){
    global $connectToDb;
    $query = "SELECT * FROM mo_meals_sidedishes";
    $result = mysqli_query($connectToDb, $query);

    return $result->fetch_all(MYSQLI_ASSOC);
};

function getOrderWithStatistics($day, $usersData){
    $dishOrderAll = [];
    foreach($usersData as $data):
        if($data['week_day'] == $day):
            array_push($dishOrderAll, $data['main_dish']);
        endif;

        if($data['soup'] != "NULL" && $data['week_day'] == $day):
            array_push($dishOrderAll, $data['soup']);
        endif;

        if($data['salads'] != "NULL" && $data['week_day'] == $day):
            array_push($dishOrderAll, $data['salads']);
        endif;

        if($data['salads_addons'] != "NULL" && $data['week_day'] == $day):
            array_push($dishOrderAll, $data['salads_addons']);
        endif;

        if($data['side_dish_hot'] != "NULL" && $data['week_day'] == $day):
            array_push($dishOrderAll, $data['side_dish_hot'] . " (side dish)");
        endif;

        if($data['side_dish_cold'] != "NULL" && $data['week_day'] == $day):
            array_push($dishOrderAll, $data['side_dish_cold'] . " (side dish)");
        endif;
    endforeach;
    
    $dishOrders = array_unique($dishOrderAll);
    $dishOrdersStatistics = [];
    
    foreach($dishOrders as $separateOrder):
        $count = 0;
        $price = 0;
        foreach($dishOrderAll as $singleOrder):
            if($separateOrder == $singleOrder):
                $count++;
            endif;
        endforeach;

        foreach($usersData as $data):
            if($separateOrder == $data['main_dish']):
                $price += $data['main_dish_price'];
                break;
            endif;

            if($separateOrder == $data['salads']):
                $price += $data['salads_price'];
                break;
            endif;

            if($separateOrder == $data['salads_addons']):
                $price += $data['salads_addons_price'];
                break;
            endif;

            if($separateOrder == $data['soup']):
                $price += $data['soup_price'];
                break;
            endif;
        endforeach;
        $price *= $count;

        array_push($dishOrdersStatistics, ["title" => $separateOrder, "count" => $count, "price" => $price]);
    endforeach;
    
    return $dishOrdersStatistics;
};

function getCurrentDayDishOptions($weekDishOptions, $weekDay){
    $currentDayOptiond = [];
    foreach($weekDishOptions as $option):
        if($option['week_day'] == $weekDay):
            array_push($currentDayOptiond, $option);
        endif;
    endforeach;

    return  $currentDayOptiond;
};
?>