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
    <script src="../files/validateForms.js"></script>
    <script src="../files/scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <script src="../files/validateForms.js"></script>
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            printHeader("../");
            include("needAdmin.html");
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=../close.php'>";
        } else {
            printHeader("../");
        

        if(!empty($_POST)){
            // Data validation
            $continue = true;
            if(!dniVerification($_POST['dniTeacher'])){
                echo "<script>alert('Incorrect DNI format')</script>";
                $continue = false;
            }
            if(connectBD("id21353268_learningacademy",$connection)){
                $sql = "SELECT dniStudent, email FROM student";
                if(selectSQL($connection, $sql, $result)){
                    foreach($result as $student) {
                        if($student['dniStudent'] == $_POST['dniTeacher'] || $student['email'] == $_POST['email']){
                            echo "<script>alert('DNI or email already in use')</script>";
                            $continue = false;
                        }
                    }
                }
            }

            // Insert
            if(connectBD("id21353268_learningacademy",$connection) && $continue){
                if(isset($_FILES['photoPath'])){
                    $uploadStatus = uploadPhoto(1, $route);
                    if($uploadStatus == 0){
                        $sql = "INSERT INTO teacher (dniTeacher, email, password, name, surname, titulation, photoPath, active) 
                        VALUES ('{$_POST['dniTeacher']}','{$_POST['email']}',md5('{$_POST['passwordAdd']}'), '{$_POST['name']}','{$_POST['surname']}','{$_POST['titulation']}','$route', '1')";
    
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
                } else {
                    $sql = "INSERT INTO teacher (dniTeacher, email, password, name, surname, titulation, photoPath, active) 
                        VALUES ('{$_POST['dniTeacher']}','{$_POST['email']}',md5('{$_POST['passwordAdd']}'), '{$_POST['name']}','{$_POST['surname']}','{$_POST['titulation']}','img/profilePhotos/default.png', '1')";
    
                    $action = insertSQL($connection, $sql);
                    if($action == 0) {
                        echo "<script>alert('Teacher added correctly')</script>";
                        header('Location: index.php?manage=teachers');
                    } else if($action == 1062) {
                        echo "<script>alert('DNI or email already in use')</script>";
                    } else {
                        echo "<script>alert('$action')</script>";
                    }
                }
            }
        }
    ?>
    <div class="formDiv">
        <form enctype ="multipart/form-data" action="#" method="POST" onsubmit="return validateForm(fields)">
            <div class="formRow">
                <div>
                    <label for="dniTeacher">DNI:</label>
                    <input type="text" maxlength="9" name="dniTeacher" id="dniTeacher" required>
                </div>
                <div>
                    <label for="name">Name:</label>
                    <input type="text" maxlength="15" name="name" id="name">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="surname">Surname:</label>
                    <input type="text" maxlength="25" name="surname" id="surname">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" maxlength="40" name="email" id="email">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="passwordAdd" id="password">
                </div>
                <div>
                    <label for="titulation">Titulation:</label>
                    <input type="text" maxlength="50" name="titulation" id="titulation">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="photoPath">Photo:</label>
                    <input type="file" name="photoPath" id="photoPath">
                </div>
                <div>
                    <input type="hidden" name="active" id="active" value="1">
                    <input class="whiteBtn" type="submit" value="Add">
                    <a class="whiteBtn" href="index.php?manage=teachers">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <?php
        $fields = array(
            array('id' => 'name', 'name' => 'name', 'type' => 'text', 'label' => 'name'),
            array('id' => 'surname', 'name' => 'surname', 'type' => 'text', 'label' => 'surname'),
            array('id' => 'email', 'name' => 'email', 'type' => 'email', 'label' => 'email'),
            array('id' => 'titulation', 'name' => 'titulation', 'type' => 'text', 'label' => 'titulation'),
            array('id' => 'password', 'name' => 'passwordAdd', 'type' => 'password')
        );
        ?>
        <script> var fields = <?php echo json_encode($fields); ?>; </script>
        <?php
        }
    ?>
</body>
</html>