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
    <script src="../files/validateForms.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
</head>
<body>
        <?php
            include ("../functions.php");

            if(!isset($_SESSION['role']) || $_SESSION['role'] != "S") {
                printHeader("../");
                include("needStudent.html");
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=/Learning-Academy/close.php'>";
            } else {
                if (connectBD("id21353268_learningacademy", $connection)) {
                    $sqlStudent = "SELECT * FROM student WHERE dniStudent = '{$_SESSION['dniStudent']}';";
                    if(selectSQL($connection,$sqlStudent,$result)); $result = $result[0];
                }
                printHeader("../");
                if (!empty($_POST)) {   
                    // Verificar si se ha cambiado la contraseña
                    $valid = true;
                    $continueExecution = true;
                    $passwordChanged = false;
                    $photoChanged = false;
                    if (connectBD("id21353268_learningacademy", $connection)) {
                        $existingEmailQuery = "SELECT email FROM student WHERE email = '{$_POST['email']}' AND dniStudent != '{$result['dniStudent']}' UNION SELECT email FROM teacher WHERE email = '{$_POST['email']}'";
                    
                        $existingEmailResult = selectSQL($connection, $existingEmailQuery, $existingResult);
                    
                        if (!empty($existingResult)) {  
                            echo "<script>alert('This email is already in use. Please use a different email.')</script>";
                            echo "<script>history.back();</script>";
                            $continueExecution = false;
                        }
                    }
                    if (isset($_POST['showPass'])) {
                        if (empty($_POST['password'])) {
                            $valid = false;
                            echo "<script> alert('Please enter a valid password')</script>";
                        } else {
                            $passwordChanged = true;
                        }
                    }
                    // Verificar si se ha cambiado la foto
                    
                    if (isset($_POST['showPhoto'])) {
                        if (!empty($_FILES['photoPath']['name'])) {
                            $photoChanged = true;
                        }
                    }
                
                    if ($valid && $continueExecution) {
                        $sql = "UPDATE student SET email='{$_POST['email']}', name='{$_POST['name']}', surname='{$_POST['surname']}', birthDate='{$_POST['birthDate']}'";
                
                        if ($passwordChanged) {
                            $password = md5($_POST['password']);
                            $sql .= ", password='$password'";
                        }
                
                        if ($photoChanged) {
                            $uploadStatus = uploadPhoto(0, $route, false, $_POST['dniStudent']);
                            $sql .= ", photoPath = '$route'";
                        }
                
                        $sql .= " WHERE dniStudent='{$_POST['dniStudent']}';";
                
                        if (connectBD("id21353268_learningacademy", $connection)) {
                            updateSQL($connection, $sql);
                            $_SESSION['name'] = $_POST['name'];
                            $_SESSION['surname'] = $_POST['surname'];
                            $_SESSION['email'] = $_POST['email'];
                            $_SESSION['password'] = $_POST['password'];
                            $_SESSION['birthDate'] = $_POST['birthDate'];
                            $_SESSION['birthDate'] = $route;
                            echo "<meta http-equiv='REFRESH' content='0;URL=../student/index.php'>";
                        }
                    }
                }else{
                ?>
                <div class="studentContainer">
                    <div class="formDiv">
                        <form enctype="multipart/form-data" id="profile-form" action="profile.php" method="POST" onsubmit="return validateForm(fields)">
                            <div class="formRow">
                                <div>
                                    <label for="name">Name: </label>
                                    <input type="text" class="form-element" id="name" name="name" required value="<?php echo $result['name'] ?>">
                                </div>
                                <div>
                                    <label for="dni">DNI: </label>
                                    <input type="text" readonly  class="form-element" id="dni" name="dniStudent" value="<?php echo $result['dniStudent'] ?>">
                                </div>
                            </div>
                            <div class="formRow">
                                <div>
                                    <label for="surname">Surname: </label>
                                    <input type="text" class="form-element" id="surname" name="surname" required value="<?php echo $result['surname']?>">
                                </div>
                                <div>
                                    <label for="email">Email: </label>
                                    <input type="text" class="form-element" id="email" name="email" required value="<?php echo $result['email']?>">
                                </div>
                            </div>
                            <div class="formRow">
                                <div>
                                    <div style="display:flex; flex-direction:row;">
                                        <label for="showPass">Change password</label>
                                        <input type="checkbox" name="showPass" id="showPass" onchange="checkboxShow('password')">
                                        <input type="password" name="password" id="password" style="display: none;">
                                    </div>
                                    <div style="display:flex; flex-direction:row;">
                                        <label for="showPhoto">Change photo</label>
                                        <input type="checkbox" name="showPhoto" id="showPhoto" onchange="checkboxShow('photoPath')">
                                        <input type="file" id="photoPath" name="photoPath" style="display:none;">
                                    </div>
                                </div>
                                <div>                                        
                                    <label for="birthDate">Birth date: </label>
                                    <input type="date" required class="form-element" id="birthDate" name="birthDate" value="<?php echo $result['birthDate']?>">
                                </div>
                            </div>
                            <div class="formActions">
                                <input class="whiteBtn" type="submit" value="Update">
                                <a class='whiteBtn' href="index.php">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
            $fields = array(
                array('id' => 'name', 'name' => 'name', 'type' => 'text', 'label' => 'name'),
                array('id' => 'surname', 'name' => 'surname', 'type' => 'text', 'label' => 'surname'),
                array('id' => 'email', 'name' => 'email', 'type' => 'email', 'label' => 'email'),
                array('id' => 'birthDate', 'name' => 'birthDate', 'type' => 'date', 'label' => 'birthDate'),
                array('id' => 'showPass', 'name' => 'showPass', 'type' => 'checkbox', 'label' => 'showPass'),
                array('id' => 'password', 'name' => 'password', 'type' => 'password')
            );
            ?>
            <script> var fields = <?php echo json_encode($fields); ?>; </script>
            <?php
        }
    }
            ?>
</body>
</html>