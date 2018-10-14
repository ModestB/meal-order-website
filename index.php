<?php
include "partials/_header.php";
include "functions.php";
session_start();
if(isset($_GET['logout'])){
    logout();
};
login();
?> 
<body>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
        <div class="container d-flex justify-content-center mb-0">
            <h4 class="heading-text mt-4 mb-0 ml-0">Meal Order</h4>
        </div>
        <div class="login-page container d-flex justify-content-center align-items-center flex-column mt-0">
            <form class="d-flex flex-column align-items-center" action="index.php" method="post">
                <i class="icon-user"></i>
                <div class="form-group d-flex flex-column">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" pattern="[A-Za-z].{4,20}" required maxlength="20">
                    <span class="icon-invalid icon-x-altx-alt"></span>
                    <span class="icon-valid icon-check-alt"></span>
                </div>
                <div class="form-group d-flex flex-column">
                    <input type="password" name="pass" class="form-control" id="password" placeholder="Password" pattern=".{5,20}" required maxlength="20">
                    <span class="icon-invalid icon-x-altx-alt"></span>
                    <span class="icon-valid icon-check-alt"></span>
                </div>
                <div>                 
                    <?php
                    if(isset($_GET['login']) && $_GET['login'] == 'failed'):
                        ?>
                        <p class='text-danger'>
                            <?php
                            echo $_SESSION['message'];
                            ?>
                        </p>
                        <?php
                    endif;
                    ?>    
                </div>
                <button class="d-flex justify-content-center align-items-center" type="login" name="login" id="login">
                    <p class="m-0">LOGIN</p>
                    <i class="icon-arrow-right"></i>
                    
                </button>
            </form>
            <a href="create_user.php">Don't have a Account? Create one</a>
        </div>
    </div>
<?php
include "partials/_footer.php";
?>