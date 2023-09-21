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
                if($_FILES['photoPath']['error'] == 4){
                    $_POST['photoPath']="/Learning-Academy/img/coursePhotos/default.png";
                }else{
                    $_POST['photoPath'] = uploadPhoto(3);
                } 
                insertSQL($connection,"course");
            }
        }
    ?>
    <form enctype ="multipart/form-data" action="#" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
        <label for="hours">Hours:</label>
        <input type="number" name="hours" id="hours">
        <label for="startDate">Start date:</label>
        <input type="date" name="startDate" id="startDate">
        <label for="endDate">End date:</label>
        <input type="date" name="endDate" id="endDate">
        <label for="description">Description</label>
        <input type="text" name="description" id="description">
        <label for="dniTeacher">Teacher DNI:</label>
        <input type="text" name="dniTeacher" id="dniTeacher">
        <label for="photoPath">Photo:</label>
        <input type="file" name="photoPath" id="photoPath">
        <input type="hidden" name="active" id="active" value="1">
        <input type="submit" value="Add">
    </form>
    <a href="courses.php">Cancel</a>
</body>
</html>