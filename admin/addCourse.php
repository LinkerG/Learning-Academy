<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new course</title>
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
            if(connectBD("learningacademy",$connection)){
                insertSQL($connection,"course");
            }
        }
    ?>
    <form action="#" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
        <label for="hours">Hours:</label>
        <input type="number" name="hours" id="hours">
        <label for="start">Start date:</label>
        <input type="date" name="start" id="start">
        <label for="end">End date:</label>
        <input type="date" name="end" id="end">
        <label for="teacher">Teacher DNI:</label>
        <input type="text" name="teacher" id="teacher">
        <input type="submit" value="Add">
    </form>
    <a href="courses.php">Cancel</a>
</body>
</html>