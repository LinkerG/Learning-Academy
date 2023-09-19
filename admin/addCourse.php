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
        <label for="startDate">Start date:</label>
        <input type="date" name="startDate" id="startDate">
        <label for="endDate">End date:</label>
        <input type="date" name="endDate" id="endDate">
        <label for="dniTeacher">Teacher DNI:</label>
        <input type="text" name="dniTeacher" id="dniTeacher">
        <input type="hidden" name="active" id="active" value="1">
        <input type="submit" value="Add">
    </form>
    <a href="courses.php">Cancel</a>
</body>
</html>