<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sing In</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        include("functions.php");

        if(!empty($_POST)){
            validateUser();
        }

        if(!isset($_SESSION['role'])) {
            $role = 'N';
        }
        
        printHeader($role);

        if($role != 'N') {
            echo "<p> Ya has iniciado sesión</p>";
            exit;
        }
    ?>
    <div class="loginDiv">
        <form action="signin.php" method="POST">
            <label for="email">Username</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="Sign In">
        </form>
    </div>
    <br>
    <h1>Inicio de sesión</h1>
</body>
</html>