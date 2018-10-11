<?php
include "partials/_header.php";
include "functions.php";
session_start();
createUser();
?> 
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="container d-flex justify-content-center align-items-center flex-column">
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
                <button class="d-flex justify-content-center align-items-center" type="submit" name="submit" id="submit">
                    <p class="m-0">REGISTER</p>
                    <i class="icon-arrow-right"></i></button>
            </form>
            <a href="index.php">Already have an account? Login</a>
        </div>
    </div>

<?php
include "partials/_footer.php";
?>