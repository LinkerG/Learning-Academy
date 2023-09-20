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
            }
        } else if(isset($_REQUEST['dniTeacher'])){
            if(connectBD("learningacademy", $connection)){
                $sql = "SELECT * FROM teacher WHERE dniTeacher='{$_REQUEST['dniTeacher']}'";
                if(selectSQL($connection, $sql, $result));
            }
        }
        $result = $result[0];
        print_r($result);
    ?>
    <!--Acabar el formulario y aplicar los cambios-->
    <form action="#" method="post">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" value=<?php echo "'{$result['name']}'";?>>
    </form>
    <a href="teachers.php">Back</a>
</body>
</html>