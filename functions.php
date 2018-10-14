<?php 
include "db_connect.php";

function createUser(){
    if(isset($_POST['submit'])){
        global $connectToDb;
        $username = mysqli_real_escape_string($connectToDb, $_POST["username"]);
        $pass = mysqli_real_escape_string($connectToDb, $_POST["pass"]);
        $email = mysqli_real_escape_string($connectToDb, $_POST["email"]);

        $pass =  password_hash($pass,  PASSWORD_BCRYPT );

        //TIKRINAME ar visi formos laukai u=pildyti
        if(!empty($username) && !empty($pass) && !empty($email)):

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
        endif;
    };
};


function login() {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if(isset($_POST['login'])):
            session_start();
            global $connectToDb;
            $username = mysqli_real_escape_string($connectToDb,$_POST['username']);$query = "SELECT * FROM mo_users WHERE username='$username'";
            $result = mysqli_query($connectToDb, $query);
            
            if($result -> num_rows == 0){
                $_SESSION['message'] = "User with that name doens't exist!";
                header('location: index.php?login=failed');
            } else {
                $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
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
                    header("location: error.php");
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
        $username = $_SESSION['username'];
        foreach($weekDays as $day){
            $mainDish = $_POST[$day ."MainDishes"];

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
                $salads= $_POST[$day ."Salads"];
            } else{
                $salads = "NULL";
            }

            if(isset($_POST[$day ."SaladsAddons"])){
                $saladsAddon= $_POST[$day ."SaladsAddons"];
            } else{
                $saladsAddon = "NULL";
            }

            if(isset($_POST[$day ."Soups"])){
                $soup= $_POST[$day ."Soups"];
            } else{
                $soup = "NULL";
            }
           
            if($connectToDb):
                $query = "INSERT INTO mo_user_orders(id, username, week_day, main_dish, side_dish_hot, side_dish_cold, salads, salads_addons, soup) VALUES (NULL, '$username', '$day', '$mainDish', '$sideDishHot', '$sideDishCold', '$salads', '$saladsAddon', '$soup')";
                $result = mysqli_query($connectToDb, $query);
                $_SESSION['message'] = "Meal Plans Created!!!";
            endif; 
        }
    };
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
function gerUsers(){
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