<?php
include "partials/_header.php";
include "functions.php";
session_start();
createUser();
?> 
<body>
    <div class="container-fluid flex-container">
        <div class="container flex-container flex--column">
            <form class="flex-container flex--column" action="create_user.php" method="post">
                <i class="icon-user"></i>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" pattern="[A-Za-z].{4,20}" required maxlength="20">
                    <span class="icon-invalid icon-x-altx-alt"></span>
                    <span class="icon-valid icon-check-alt"></span>
                </div>
                <div class="form-group">
                    <input type="password" name="pass" class="form-control" id="password" placeholder="Password" pattern=".{5,20}" required maxlength="20">
                    <span class="icon-invalid icon-x-altx-alt"></span>
                    <span class="icon-valid icon-check-alt"></span>
                </div>
                <button class="flex-container" type="submit" name="submit" id="submit">
                    <p>REGISTER</p>
                    <i class="icon-arrow-right"></i></button>
            </form>
            <a href="index.php">Already have an account? Login</a>
        </div>
    </div>

    <script src="assets/scripts/main.js"></script>
</body>
</html>