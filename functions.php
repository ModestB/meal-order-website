<?php 
include "db_connect.php";

function createUser(){
    if(isset($_POST['submit'])){
        global $connectToDb;
        $username = mysqli_real_escape_string($connectToDb, $_POST["username"]);
        $pass = mysqli_real_escape_string($connectToDb, $_POST["pass"]);

        $pass =  password_hash($pass,  PASSWORD_BCRYPT );

        //TIKRINAME ar visi formos laukai u=pildyti
        if(!empty($username) && !empty($pass)):

            // TIKRINAME ar prisijungeme prie duomenu baze
            if($connectToDb):
                $query = "INSERT INTO mo_users(id, username, password) VALUES (NULL, '$username', '$pass')";
                $result = mysqli_query($connectToDb, $query);
                
                if($result):
                    $_SESSION['message'] = "User Created Successfully!";
                    $_SESSION['username'] = $username;
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
                   header("location: personal_page.php");
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

function deleteSession(){

}

?>