<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("../functions.php");

        if(isset($_REQUEST['active'])){
            $active = $_REQUEST['active'] == 0 ? 1 : 0;
            $sql = "UPDATE teacher SET active={$active} WHERE dniTeacher='{$_REQUEST['dniTeacher']}'";

            if(connectBD("learningacademy", $connection)) {
                updateSQL($connection, $sql);
                header("Refresh: 0; URL='teachers.php'");
                exit;
            }
        } else if(isset($_REQUEST['dniTeacher'])){
            if(connectBD("learningacademy", $connection)){
                $sql = "SELECT * FROM teacher WHERE dniTeacher='{$_REQUEST['dniTeacher']}'";
                if(selectSQL($connection, $sql, $result))$result = $result[0];
            }
        }
        print_r($_REQUEST);
        print_r($_POST);
        print_r($result);
        if(!empty($_POST)){
            echo "A";
            $password = md5($_POST['password']);
            if(!isset($_POST['photoPath'])){
                if(connectBD("learningacademy",$connection)){
                    $sql = "UPDATE teacher SET email='{$_POST['email']}', password='$password', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                    
                    updateSQL($connection, $sql);
                    header("Refresh: 0; URL='teachers.php'");
                    die;
                }
            }else{
                $_POST['photoPath'] = uploadPhoto(1);
                if(connectBD("learningacademy",$connection)){
                    $sql = "UPDATE teacher SET email='{$_POST['email']}', password='$password', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}', photoPath='{$_POST['photoPath']}' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                    
                    updateSQL($connection, $sql);
                    header("Refresh: 0; URL='teachers.php'");
                    die;
                }
            } 
        }
    ?>
    <!--Acabar el formulario y aplicar los cambios-->
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="dniTeacher" id="dniTeacher" value=<?php echo "'{$result['dniTeacher']}'";?>>
        
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value=<?php echo "'{$result['email']}'";?>>

        <label for="password">Pasword</label>
        <input type="text" name="password" id="password" value=<?php echo "'{$result['password']}'";?>>

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value=<?php echo "'{$result['name']}'";?>>

        <label for="surname">Surname</label>
        <input type="text" name="surname" id="surname" value=<?php echo "'{$result['surname']}'";?>>

        <label for="titulation">Titulation</label>
        <input type="text" name="titulation" id="titulation" value=<?php echo "'{$result['titulation']}'";?>>

        <label for="email">Photo</label>
        <input type="file" name="photoPath" id="photoPath">

        <input type="submit" value="Update">
    </form>
    <a href="teachers.php">Back</a>
</body>
</html>