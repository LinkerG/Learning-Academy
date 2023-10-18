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
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=/Learning-Academy/close.php'>";
        } else {
            printHeader();
        
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

            if(!empty($_POST)){
                $isPassword = true;
                $isFile = true;
                if(isset($_POST['showPass']) || isset($_POST['showPhoto'])){
                    if(!empty($_POST['password']) && !empty($_POST['photoPath'])){
                        if(connectBD("id21353268_learningacademy",$connection)){
                            $password = md5($_POST['password']);
                            $photoPath = uploadPhoto(1,$route,false,$_POST['dniTeacher']);
                            $sql = "UPDATE teacher SET email='{$_POST['email']}', password='$password', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}', photoPath = '$route' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                            
                            updateSQL($connection, $sql);
                        }
                    }elseif(!empty($_POST['password'])){
                        if(connectBD("id21353268_learningacademy",$connection)){
                            $password = md5($_POST['password']);
                            $sql = "UPDATE teacher SET email='{$_POST['email']}', password='$password', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                            
                            updateSQL($connection, $sql);
                        }
                    }else{
                        $isPassword = false;
                    }
                    if (isset($_FILES['photoPath'])){
                        if(connectBD("id21353268_learningacademy",$connection)){
                            $photoPath = uploadPhoto(1,$route,false,$_POST['dniTeacher']);
                            $sql = "UPDATE teacher SET email='{$_POST['email']}', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}', photoPath = '$route' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                            
                            updateSQL($connection, $sql);
                        }
                    }else{
                        $isFile = false;
                    }
                }elseif(!isset($_POST['showPass']) && !isset($_POST['showPhoto'])){
                    if(connectBD("id21353268_learningacademy",$connection)){
                        $sql = "UPDATE teacher SET email='{$_POST['email']}', name='{$_POST['name']}', surname='{$_POST['surname']}', titulation='{$_POST['titulation']}' WHERE dniTeacher='{$_POST['dniTeacher']}';";
                        
                        updateSQL($connection, $sql);
                        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                    }
                }
                if($isPassword == false && $isPhotoPath == false){
                    echo "<script> alert('Select a file and put a valid password')</script>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                }elseif($isPassword == false){
                    echo "<script> alert('Put a valid password')</script>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                }elseif($isFile == false){
                    echo "<script> alert('Select a file')</script>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                }elseif($isPassword == true && $isPhotoPath == false){
                    echo "<script> alert('Select a file')</script>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                }elseif($isPassword == false && $isPhotoPath == true){
                    echo "<script> alert('Put a valid password')</script>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=teachers'>";
                }
            }
    ?>
    <!--Acabar el formulario y aplicar los cambios-->
    <div class="formDiv">
        <form action="#" method="post" enctype="multipart/form-data">
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
                        <input type="password" name="password" id="password" style="display: none;">
                    </div>
                    
                </div>
            </div>
            <div class="formRow">
                <div style="display:flex; flex-direction:row;">
                    <label for="showPhoto">Change photo</label>
                    <input type="checkbox" name="showPhoto" id="showPhoto" onchange="checkboxShow('photoPath-input')">
                    <input type="file" id="photoPath-input" name="photoPath" style="display:none;"></input>
                </div>
            </div>
            <div class=formActions>
                <input class="whiteBtn" type="submit" value="Update">
                <a class="whiteBtn" href="index.php?manage=teachers">Back</a>
            </div>
        </form>
    </div>
        <?php
        }
        ?>
</body>
</html>