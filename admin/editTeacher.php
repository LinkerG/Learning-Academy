<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit teacher</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../files/scripts.js"></script>
    <script src="../files/validateForms.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
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
        
            if(isset($_REQUEST['active'])){
                $active = $_REQUEST['active'] == 0 ? 1 : 0;
                $sql = "UPDATE teacher SET active={$active} WHERE dniTeacher='{$_REQUEST['dniTeacher']}'";

                if(connectBD("id21353268_learningacademy", $connection)) {
                    updateSQL($connection, $sql);
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                }
            } else if(isset($_REQUEST['dniTeacher'])){
                if(connectBD("id21353268_learningacademy", $connection)){
                    $sql = "SELECT * FROM teacher WHERE dniTeacher='{$_REQUEST['dniTeacher']}'";
                    if(selectSQL($connection, $sql, $result))$result = $result[0];
                }
            }
            if (!empty($_POST)) {   
                // Verificar si se ha cambiado la contraseña
                $valid = true;
                $passwordChanged = false;
                $continueExecution = true;
                if (connectBD("id21353268_learningacademy", $connection)) {
                    $existingEmailQuery = "SELECT email FROM teacher WHERE email = '{$_POST['email']}' AND dniTeacher != '{$_POST['dniTeacher']}' UNION SELECT email FROM student WHERE email = '{$_POST['email']}' UNION SELECT email FROM admin WHERE email = '{$_POST['email']}';";
                
                    $existingEmailResult = selectSQL($connection, $existingEmailQuery, $existingResult);
                
                    if (!empty($existingResult)) {  
                        echo "<script>alert('This email is already in use. Please use a different email.')</script>";
                        echo "<script>history.back();</script>";
                        $continueExecution = false;
                    }
                }
                if (isset($_POST['showPass'])) {
                    if (!empty($_POST['password'])) {
                        $passwordChanged = true;
                    }else{
                        $valid = false;
                    }
                }
        
                // Verificar si se ha cambiado la foto
                $photoChanged = false;
                if (isset($_POST['showPhoto'])) {
                    if (!empty($_FILES['photoPath']['name'])) {
                        // Aquí deberías manejar la lógica de subida de la nueva foto
                        $photoChanged = true;
                    }
                }
        
                // Actualizar según los cambios realizados
                if ($valid && $continueExecution) {
                    // Resto del código de conexión a la base de datos y validación
        
                    $sql = "UPDATE teacher SET email='{$_POST['email']}', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}'";
        
                    if ($passwordChanged) {
                        $password = md5($_POST['password']);
                        $sql .= ", password='$password'";
                    }
        
                    if ($photoChanged) {
                        // Aquí deberías manejar la lógica de subida de la nueva foto y actualizar la ruta de la foto en la consulta SQL
                        $uploadPhoto = uploadPhoto(1, $route, false, $_POST['dniTeacher']);
                        $sql .= ", photoPath = '$route'";
                    }
        
                    $sql .= " WHERE dniTeacher='{$_POST['dniTeacher']}';";
                    if (connectBD("id21353268_learningacademy", $connection)) {
                        updateSQL($connection, $sql);
                    }
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                }
            }
    ?>
    <!--Acabar el formulario y aplicar los cambios-->
    <div class="formDiv">
        <form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateForm(fields)">
            <div class="formRow">
                <div>
                    <label for="dniTeacher">DNI</label>
                    <input type="text" readonly name="dniTeacher" id="dniTeacher" value=<?php echo "'{$result['dniTeacher']}'";?>>
                </div>
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" maxlength="15" value=<?php echo "'{$result['name']}'";?>>
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" id="surname" maxlength="25" value=<?php echo "'{$result['surname']}'";?>>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" maxlength="40" value=<?php echo "'{$result['email']}'";?>>
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="titulation">Titulation</label>
                    <input type="text" name="titulation" id="titulation" maxlength="50" value=<?php echo "'{$result['titulation']}'";?>>
                </div>
                <div>
                    <div style="display:flex; flex-direction:row;">
                        <label for="showPass">Change password</label>
                        <input type="checkbox" name="showPass" id="showPass" onchange="checkboxShow('password')">

                        <input type="password" name="password" id="password" maxlength="50" style="display: none;">
                    </div>
                    
                </div>
            </div>
            <div class="formRow">
                <div style="display:flex; flex-direction:row;">
                    <label for="showPhoto">Change photo</label>
                    <input type="checkbox" name="showPhoto" id="showPhoto" onchange="checkboxShow('photoPath-input')">
                    <input type="file" id="photoPath-input" name="photoPath" style="display:none;">
                </div>
            </div>
            <div class=formActions>
                <input class="whiteBtn" type="submit" value="Update">
                <a class="whiteBtn" href="index.php?manage=teachers">Back</a>
            </div>
        </form>
    </div>
        <?php
        $fields = array(
            array('id' => 'name', 'name' => 'name', 'type' => 'text', 'label' => 'name'),
            array('id' => 'surname', 'name' => 'surname', 'type' => 'text', 'label' => 'surname'),
            array('id' => 'email', 'name' => 'email', 'type' => 'email', 'label' => 'email'),
            array('id' => 'titulation', 'name' => 'titulation', 'type' => 'text', 'label' => 'titulation'),
            array('id' => 'showPass', 'name' => 'showPass', 'type' => 'checkbox', 'label' => 'showPass'),
            array('id' => 'password', 'name' => 'password', 'type' => 'password')
        );
        ?>
        <script> var fields = <?php echo json_encode($fields); ?>; </script>
        <?php
        }
        ?>
</body>
</html>