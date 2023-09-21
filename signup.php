<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        include("functions.php");

        if(!isset($_SESSION['role'])) $role = "N";
        else $role = $_SESSION['role'];

        printHeader($role);

        if(!empty($_POST)){
            if(connectBD("learningacademy",$connection)){
                if($_FILES['photoPath']['error'] == 4){
                    $_POST['photoPath']="/Learning-Academy/img/coursePhotos/default.png";
                }else{
                    $_POST['photoPath'] = uploadPhoto(2);
                } 
                insertSQL($connection,"student");
            }
        }
    ?>
    <div class="container">
        <form enctype ="multipart/form-data" action="#" method="POST">
            <label for="dniStudent">DNI</label>    
            <input type="text" name="dniStudent" id="dniStudent">
            
            <label for="email">Email</label>
            <input type="text" name="email" id="email">

            <label for="password">Password</label>    
            <input type="password" name="password" id="password">

            <label for="name">Name</label>    
            <input type="text" name="name" id="name">

            <label for="surname">Surname</label>    
            <input type="text" name="surname" id="surname">

            <label for="birthDate">Birth date</label>    
            <input type="date" name="birthDate" id="birthDate">
            
            <label for="photoPath">Photo</label>    
            <input type="file" name="photoPath" id="photoPath">

            <a href="index.php">Cancel</a>
            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>