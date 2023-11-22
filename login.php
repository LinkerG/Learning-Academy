<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <script src="./files/scripts.js"></script>
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
        } else {
    ?>
    <div class="formDiv">
        <form class="loginForm" action="login.php" method="POST">
            <div class="formRow">
                <h3>Log In</h3>
            </div>
            <div class="formRow">
                <div class="singleRow">
                    <label for="email">Username</label>
                    <input type="text" name="email" id="email" required>
                </div>
            </div>
            <div class="formRow">
                <div class="singleRow">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
            </div>
            <div class="formActions">
                <input class="whiteBtn" type="submit" value="Log In">
                <a href="index.php" class="whiteBtn">Cancel</a>
            </div>
        </form>
    </div>
    <?php
        }
    ?>
</body>
</html>