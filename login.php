<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sing In</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php
        include("functions.php");

        if(!empty($_POST)){
            validateUser();
        }

        printHeader();

        if(isset($_SESSION['role'])) {
            echo "<p>Ya has iniciado sesión</p>";
            exit;
        }
    ?>
    <h1>Inicio de sesión</h1>
    <div class="loginDiv">
        <form class="loginForm" action="login.php" method="POST">
            <div class="email">
                <label for="email">Username</label>
                <input type="text" name="email" id="email" required>
            </div>
            <div class="password">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <input type="submit" value="Sign In">
        </form>
    </div>
    <br>
</body>
</html>