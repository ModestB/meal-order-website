<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <div class="container-fluid flex-container">
        <div class="container flex-container flex--column">
            <form class="flex-container flex--column" action="login_create.php" method="post">
                <i class="icon-user"></i>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" pattern="[A-Za-z].{5,20}" required maxlength="20">
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
            <a href="#">Already have an account? Login</a>
        </div>
    </div>

    <script src="assets/scripts/main.js"></script>
</body>
</html>