<?php 
include "db_connect.php";

function createUser(){
    if(isset($_POST['submit'])){
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

        //TIKRINAME ar visi formos laukai u=pildyti
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
                    header("Location: " . "personal_page.php");
                    exit();
                    session_abort();
                else:
                    $_SESSION['message'] = "Registration failed!!!";
                    echo mysqli_error($connectToDb);
                    header("Location: " . "error.php");
                    exit();
                    session_abort();
                endif;
            endif; 
        else:
            $_SESSION['message'] = "Username already exists!!!";
            header('location: create_user.php?create=failed');  
        endif;
    };
};


function login() {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
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
            }
        endif;
    }
}
function logout(){
    if ( isset( $_COOKIE[session_name()] ) )
    setcookie( session_name(), "", time()-3600, "/" );
    $_SESSION = [];
    session_destroy();

}

function updateUserOrder(){
    if(isset($_POST['submit'])){
        global $connectToDb;
        $weekDays = ['monday','tuesday','wednesday', 'thursday', 'friday'];
        $username = strtolower($_SESSION['username']);
        foreach($weekDays as $day){
            $mainDish = explode("_", $_POST[$day ."MainDishes"])[0];
            $mainDishPrice = explode("_", $_POST[$day ."MainDishes"])[1];

            if(isset($_POST[$day ."SideDishesHot"])){
                $sideDishHot = $_POST[$day ."SideDishesHot"];
            } else{
                $sideDishHot = "NULL";
            }

            if(isset($_POST[$day ."SideDishesCold"])){
                $sideDishCold= $_POST[$day ."SideDishesCold"];
            } else{
                $sideDishCold = "NULL";
            }
            
            if(isset($_POST[$day ."Salads"])){
                $salads= explode("_", $_POST[$day ."Salads"])[0];
                $saladsPrice = explode("_", $_POST[$day ."Salads"])[1];           
            } else{
                $salads = "NULL";
                $saladsPrice = "";
            }

            if(isset($_POST[$day ."SaladsAddons"])){
                $saladsAddon = explode("_", $_POST[$day ."SaladsAddons"])[0];
                $saladAddonPrice = explode("_", $_POST[$day ."SaladsAddons"])[1];       
            } else{
                $saladsAddon = "NULL";
                $saladAddonPrice = "";
            }

            if(isset($_POST[$day ."Soups"])){
                $soup = explode("_", $_POST[$day ."Soups"])[0];
                $soupPrice = explode("_", $_POST[$day ."Soups"])[1];
            } else{
                $soup = "NULL";
                $soupPrice = "";
            }

            $totalPrice = (float)$mainDishPrice + (float)$saladsPrice + (float)$saladAddonPrice + (float)$soupPrice;
           
            if($connectToDb):
                $query = "INSERT INTO mo_user_orders(id, username, week_day, main_dish, main_dish_price, side_dish_hot, side_dish_cold, salads, salads_price, salads_addons, salads_addons_price, soup, soup_price, total_price) VALUES (NULL, '$username', '$day', '$mainDish', '$mainDishPrice', '$sideDishHot', '$sideDishCold', '$salads','$saladsPrice', '$saladsAddon', '$saladAddonPrice', '$soup', '$soupPrice', '$totalPrice')";
                $result = mysqli_query($connectToDb, $query);
                $_SESSION['message'] = "Meal Plans Created!!!";
                $_POST["submit"] = "";
            endif; 
        }
    };
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
}
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
}
?>