<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../files/scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
        <?php
            include ("../functions.php");

            if(!isset($_SESSION['role']) || $_SESSION['role'] != "S") {
                printHeader();
                include("needStudent.html");
                header("Refresh: 5; URL='/Learning-Academy/close.php'");
                exit;
            } else {
                printHeader();
            } 

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (connectBD("id21353268_learningacademy", $connection)) {
                    if(isset($_POST['password']) && $_POST['photoPath']){
                        $password = md5($_POST['password']);
                        $uploadStatus = uploadPhoto(0,$route);
                        $sql = "UPDATE student SET email = {$_POST['email']}, password = $password, name = {$_POST['name']}, surname = {$_POST['surname']}, birthDate = {$_POST['birthDate']}, photoPath = $route;";
                        updateSQL($connection, $sql);
                        header("Refresh: 0; URL='index.php'");
                    }elseif(isset($_POST['password'])){
                        $password = md5($_POST['password']);
                        $sql = "UPDATE student SET email = {$_POST['email']}, password = $password, name = {$_POST['name']}, surname = {$_POST['surname']}, birthDate = {$_POST['birthDate']};";
                        updateSQL($connection, $sql);
                    }elseif(isset($_POST['photoPath'])){
                        $uploadStatus = uploadPhoto(0,$route);
                        $sql = "UPDATE student SET email = {$_POST['email']}, name = {$_POST['name']}, surname = {$_POST['surname']}, birthDate = {$_POST['birthDate']}, photoPath = $route;";
                        updateSQL($connection, $sql);
                    }else{
                        $sql = "UPDATE student SET email = {$_POST['email']},name = {$_POST['name']}, surname = {$_POST['surname']}, birthDate = {$_POST['birthDate']};";
                        updateSQL($connection, $sql);
                    }
                }
            }
            else{
                ?>
                <div class="studentContainer">
                    <div class="formDiv">
                        <form enctype="multipart/form-data" id="profile-form" action="profile.php" method="POST">
                            <div class="formRow">
                                <div>
                                    <label for="name-input">Name: </label>
                                    <input type="text" class="form-element" id="name-input" name="name" required value="<?php echo $_SESSION['name'] ?>"></input>
                                </div>
                                <div>
                                    <label for="dni-input">DNI: </label>
                                    <input type="text" readonly  class="form-element" id="dni-input" name="dni" required value="<?php echo $_SESSION['dniStudent'] ?>"></input>
                                </div>
                            </div>
                            <div class="formRow">
                                <div>
                                    <label for="surname-input">Surname: </label>
                                    <input type="text" class="form-element" id="surname-input" name="surname" required value="<?php echo $_SESSION['surname']?>"></input>
                                </div>
                                <div>
                                    <label for="email-input">Email: </label>
                                    <input type="text" class="form-element" id="email-input" name="email" required value="<?php echo $_SESSION['email']?>"></input>
                                </div>
                            </div>
                            <div class="formRow">
                                <div>
                                    <div style="display:flex; flex-direction:row;">
                                        <label for="showPass">Change password</label>
                                        <input type="checkbox" name="showPass" id="showPass" onchange="checkboxShow('password')">
                                        <input type="password" name="password" id="password" required style="display: none;">
                                    </div>
                                    <div style="display:flex; flex-direction:row;">
                                        <label for="showPhoto">Change photo</label>
                                        <input type="checkbox" name="showPhoto" id="showPhoto" onchange="checkboxShow('photoPath-input')">
                                        <input type="file" id="photoPath-input" name="photoPath" required style="display:none;"></input>
                                    </div>
                                </div>
                                <div>                                        
                                    <label for="birthDate-input">Birth date: </label>
                                    <input type="date" required class="form-element" id="birthDate-input" name="birthDate" value="<?php echo $_SESSION['birthDate']?>"></input>
                                </div>
                            </div>
                            <div class="formActions">
                                <input class="witheBtn" type="submit" value="Update"></input>
                                <a class='witheBtn' href="index.php">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
</body>
</html>