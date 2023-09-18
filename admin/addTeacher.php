<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new teacher</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            include("needAdmin.html");
            header("Refresh: 5; URL='close.php'");
            exit;
        } else {
            printHeader("A");
        }

        if(!empty($_POST)){
            print_r($_POST);

            
        }
    ?>
    <form action="#" method="POST">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
        <label for="surname">Surname:</label>
        <input type="text" name="surname" id="surname">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <label for="titulation">Titulation:</label>
        <input type="text" name="titulation" id="titulation">
        <label for="file">Photo:</label>
        <input type="file" name="file" id="file">
        <input type="submit" value="Add">
    </form>
    <a href="teachers.php">Cancel</a>
</body>
</html>