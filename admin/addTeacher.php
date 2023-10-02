<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new teacher</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            include("needAdmin.html");
            header("Refresh: 5; URL='close.php'");
            exit;
        } else {
            printHeader();
        }

        if(!empty($_POST)){
            // Data validation
            $continue = true;
            if(!dniVerification($_POST['dniTeacher'])){
                echo "<script>alert('Incorrect DNI format')</script>";
                $continue = false;
            }

            // Insert
            if(connectBD("learningacademy",$connection) && $continue){
                $uploadStatus = uploadPhoto(1, $route);
                if($uploadStatus == 0){
                    $sql = "INSERT INTO teacher (dniTeacher, email, password, name, surname, titulation, photoPath, active) 
                    VALUES ('{$_POST['dniTeacher']}','{$_POST['email']}',md5('{$_POST['password']}'), '{$_POST['name']}','{$_POST['surname']}','{$_POST['titulation']}','$route', '1')";

                $action = insertSQL($connection, $sql);
                if($action == 0) {
                    echo "<script>alert('$route')</script>";
                    echo "<script>alert('Course added correctly')</script>";
                    //header('Location: index.php?manage=teachers');
                } else if($action == 1062) {
                    echo "<script>alert('DNI or email already in use')</script>";
                } else {
                    echo "<script>alert('$action')</script>";
                }
                } elseif ($uploadStatus == 1) {
                    echo "<script>alert('Error uploading photo')</script>";
                } elseif ($uploadStatus == 2) {
                    echo "<script>alert('Please upload a photo')</script>";
                }
            }
        }
    ?>
    <form enctype ="multipart/form-data" action="#" method="POST">
        <label for="dniTeacher">DNI:</label>
        <input type="text" name="dniTeacher" id="dniTeacher">
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
        <label for="photoPath">Photo:</label>
        <input type="file" name="photoPath" id="photoPath">
        <input type="hidden" name="active" id="active" value="1">
        <input type="submit" value="Add">
    </form>
    <a href="index.php?manage=teachers">Cancel</a>
</body>
</html>