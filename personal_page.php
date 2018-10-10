<?php
include "partials/_header.php";
session_start();

?>

<body>
    <div class="container-fluid flex-container">
        <div class="container flex-container">
            <div class="personal-page flex-container flex--column">
                <p class="username"><i class="icon-user"></i><?php echo $_SESSION['username']?></p>

            <?php
            if($_SESSION['message']):
                ?>
                <p class="success-msg" id="msg"><?php echo $_SESSION['message'] ?></p>
                <?php
            endif;
            ?>

            </div>           

        </div>
    </div>

    <script src="assets/scripts/main.js"></script>
</body>
</html>