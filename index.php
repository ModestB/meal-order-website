<?php
include "partials/_header.php";
include "functions.php";
session_start();
login();
?> 
<body>
    <div class="container-fluid flex-container">
        <div class="container flex-container flex--column">
            <form class="flex-container flex--column" action="index.php" method="post">
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
                <button class="flex-container" type="login" name="login" id="login">
                    <p>LOGIN</p>
                    <i class="icon-arrow-right"></i></button>
            </form>
            <?php
            if($_GET['signup'] == 'success'):
                ?>
                <p class="success-msg" id="msg">User Created Successfully!</p>
                <?php
            endif;
            ?>
            <a href="create_user.php">Don't have a Account? Create one</a>
        </div>
    </div>

    <script src="assets/scripts/main.js"></script>
</body>
</html>