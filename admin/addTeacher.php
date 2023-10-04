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
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            printHeader();
            include("needAdmin.html");
            header("Refresh: 5; URL='/Learning-Academy/close.php.php'");
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
                    echo "<script>alert('Teacher added correctly')</script>";
                    header('Location: index.php?manage=teachers');
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
    <div class="formDiv">
        <form enctype ="multipart/form-data" action="#" method="POST">
            <div class="formRow">
                <div>
                    <label for="dniTeacher">DNI:</label>
                    <input type="text" name="dniTeacher" id="dniTeacher">
                </div>
                <div>
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="surname">Surname:</label>
                    <input type="text" name="surname" id="surname">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                <div>
                    <label for="titulation">Titulation:</label>
                    <input type="text" name="titulation" id="titulation">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="photoPath">Photo:</label>
                    <input type="file" name="photoPath" id="photoPath">
                </div>
                <div>
                    <input type="hidden" name="active" id="active" value="1">
                    <input class="witheBtn" type="submit" value="Add">
                    <a class="witheBtn" href="index.php?manage=teachers">Cancel</a>
                </div>
            </div>
        </form>
        
    </div>
</body>
</html>