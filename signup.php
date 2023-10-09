<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include("functions.php");

        printHeader();
        if(isset($_SESSION['role'])){
            echo "<h1>You are already signed up!</h1>";
            echo "<meta http-equiv='refresh' content='1;URL=index.php'>";
        }else{
            if(!empty($_POST)){
                // Data validation
                $continue = true;
                if(!dniVerification($_POST['dniStudent'])){
                    echo "<script>alert('Incorrect DNI format')</script>";
                    $continue = false;
                }
                if(connectBD("id21353268_learningacademy",$connection)){
                    $sql = "SELECT dniTeacher, email FROM teacher";
                    if(selectSQL($connection, $sql, $result)){
                        foreach($result as $teacher) {
                            if($teacher['dniTeacher'] == $_POST['dniStudent'] || $teacher['email'] == $_POST['email']){
                                echo "<script>alert('DNI or email already in use')</script>";
                                $continue = false;
                            }
                        }
                    }
                }

                // Insert
                if(connectBD("id21353268_learningacademy",$connection) && $continue){
                    if(isset($_POST['photoPath'])){
                        $uploadStatus = uploadPhoto(0,$route, true);
                        if($uploadStatus == 0) {
                            $sql = "INSERT INTO student (dniStudent, email, password, name, surname, birthDate, photoPath) 
                            VALUES ('{$_POST['dniStudent']}','{$_POST['email']}',md5('{$_POST['password']}'), '{$_POST['name']}','{$_POST['surname']}','{$_POST['birthDate']}','$route')";
        
                            $action = insertSQL($connection, $sql);
                            if($action == 0) {
                                echo "<script>alert('You signed in correctly, now log in')</script>";
                                echo "<META HTTP-EQUIV='REFRESH' CONTENT='1;URL=login.php'>";
                            } else if($action == 1062) {
                                echo "<script>alert('DNI or email already in use')</script>";
                            }
                        } elseif ($uploadStatus == 1) {
                            echo "<script>alert('Error uploading photo')</script>";
                        } elseif ($uploadStatus == 2) {
                            echo "<script>alert('Please upload a photo')</script>";
                        }
                    } else {
                        $sql = "INSERT INTO student (dniStudent, email, password, name, surname, birthDate, photoPath) 
                        VALUES ('{$_POST['dniStudent']}','{$_POST['email']}',md5('{$_POST['password']}'), '{$_POST['name']}','{$_POST['surname']}','{$_POST['birthDate']}','/Learning-Academy/img/profilePhotos/default.png')";
                        $action = insertSQL($connection, $sql);
                        if($action == 0) {
                            echo "<script>alert('You signed in correctly, now log in')</script>";
                            echo "<META HTTP-EQUIV='REFRESH' CONTENT='1;URL=login.php'>";
                        } else if($action == 1062) {
                            echo "<script>alert('DNI or email already in use')</script>";
                        }
                    }

                }
            }
        ?>
        <div class="formDiv">
            <form enctype ="multipart/form-data" action="#" method="POST">
                <div class="formRow">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div>
                        <label for="password">Password</label>    
                        <input type="password" name="password" id="password">
                    </div>
                </div>
                <div class="formRow">
                    <div>
                        <label for="name">Name</label>    
                        <input type="text" name="name" id="name">
                        
                    </div>
                    <div>
                        <label for="dniStudent">DNI</label>    
                        <input type="text" name="dniStudent" id="dniStudent">    
                    </div>
                </div>
                <div class="formRow">
                    <div>
                        <label for="surname">Surname</label>    
                        <input type="text" name="surname" id="surname">
                    </div>
                    <div class="formDivided">
                        <div>
                            <label for="birthDate">Birth date</label>    
                            <input type="date" name="birthDate" id="birthDate" max="<?php echo date("Y-m-d")?>">
                        </div>
                        <div>
                            <label for="photoPath">Photo</label>    
                            <input type="file" name="photoPath" id="photoPath">
                        </div>
                    </div>
                </div>
                <div class=formActions>
                    <input class="witheBtn" type="submit" value="Sign Up">
                    <a class="witheBtn" href="index.php">Cancel</a>
                </div>  
            </form>
        </div>
    <?php
    }
    ?>
</body>
</html>