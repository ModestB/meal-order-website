<?php
include "partials/_header.php";
include "functions.php";
session_start();
createUser();
?> 
<body>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
        <div class="container d-flex justify-content-center mb-0">
            <h4 class="heading-text mt-4 mb-0 ml-0">Register Account</h4>
        </div>
        <div class="register-page container d-flex justify-content-center align-items-center flex-column mt-0">
            <form class="d-flex flex-column align-items-center" action="create_user.php" method="post">
                <i class="icon-user"></i>
                <div class="form-group  d-flex flex-column">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" pattern="[A-Za-z].{4,20}" required maxlength="20">
                    <span class="icon-invalid icon-x-altx-alt"></span>
                    <span class="icon-valid icon-check-alt"></span>
                </div>
                <div class="form-group  d-flex flex-column">
                    <input type="password" name="pass" class="form-control" id="password" placeholder="Password" pattern=".{5,20}" required maxlength="20">
                    <span class="icon-invalid icon-x-altx-alt"></span>
                    <span class="icon-valid icon-check-alt"></span>
                </div>
                <div class="form-group  d-flex flex-column">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required maxlength="40">
                    <span class="icon-invalid icon-x-altx-alt"></span>
                    <span class="icon-valid icon-check-alt"></span>
                </div>
                <?php
                if(isset($_GET['create']) && $_GET['create'] == 'failed'):
                    ?>
                    <p class='text-danger'>
                        <?php
                        echo $_SESSION['message'];
                        ?>
                    </p>
                    <?php
                endif;
                ?>  
                <button class="d-flex justify-content-center align-items-center" type="submit" name="submit" id="submit">
                    <p class="m-0">REGISTER</p>
                    <i class="icon-arrow-right"></i>
                </button>
            </form>
            <a href="index.php">Already have an account? Login</a>
        </div>
    </div>

<?php
include "partials/_footer.php";
?>