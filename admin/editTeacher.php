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
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            printHeader();
            include("needAdmin.html");
            header("Refresh: 5; URL='/Learning-Academy/close.php'");
            exit;
        } else {
            printHeader();
        }
        if(isset($_REQUEST['active'])){
            $active = $_REQUEST['active'] == 0 ? 1 : 0;
            $sql = "UPDATE teacher SET active={$active} WHERE dniTeacher='{$_REQUEST['dniTeacher']}'";

            if(connectBD("id21353268_learningacademy", $connection)) {
                updateSQL($connection, $sql);
                header("Refresh: 0; URL='index.php?manage=teachers'");
                die;
            }
        } else if(isset($_REQUEST['dniTeacher'])){
            if(connectBD("id21353268_learningacademy", $connection)){
                $sql = "SELECT * FROM teacher WHERE dniTeacher='{$_REQUEST['dniTeacher']}'";
                if(selectSQL($connection, $sql, $result))$result = $result[0];
            }
        }

        if(!empty($_POST)){
            if(isset($_POST['password'])){
                if(connectBD("id21353268_learningacademy",$connection)){
                    $password = md5($_POST['password']);
                    $sql = "UPDATE teacher SET email='{$_POST['email']}', password='$password', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                    
                    updateSQL($connection, $sql);
                    header("Refresh: 0; URL='index.php?manage=teachers'");
                }
            } else{
                if(connectBD("id21353268_learningacademy",$connection)){
                    $sql = "UPDATE teacher SET email='{$_POST['email']}', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                    
                    updateSQL($connection, $sql);
                    header("Refresh: 0; URL='index.php?manage=teachers'");
                }
            }
        }
    ?>
    <!--Acabar el formulario y aplicar los cambios-->
    <div class="formDiv">
        <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="formRow">
                <div>
                    <label for="dniTeacher">DNI</label>
                    <input type="text" readonly name="dniTeacher" id="dniTeacher" value=<?php echo "'{$result['dniTeacher']}'";?>>
                </div>
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value=<?php echo "'{$result['name']}'";?>>
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" id="surname" value=<?php echo "'{$result['surname']}'";?>>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value=<?php echo "'{$result['email']}'";?>>
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="titulation">Titulation</label>
                    <input type="text" name="titulation" id="titulation" value=<?php echo "'{$result['titulation']}'";?>>
                </div>
                <div>
                    <div style="display:flex; flex-direction:row;">
                        <label for="showPass">Change password</label>
                        <input type="checkbox" name="showPass" id="showPass" onchange="checkboxShow('password')">
                    </div>
                    <input type="password" name="password" id="password" required style="display: none;">
                </div>
            </div>
            <div class=formActions>
                <input class="witheBtn" type="submit" value="Update">
                <a class="witheBtn" href="index.php?manage=teachers">Back</a>
            </div>
        </form>
    </div>
</body>
</html>