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
</head>
<body>
    <?php
        include("functions.php");

        printHeader();

        if(!empty($_POST)){
            // Data validation
            $continue = true;
            if(!dniVerification($_POST['dniStudent'])){
                echo "<script>alert('Incorrect DNI format')</script>";
                $continue = false;
            }

            // Insert
            if(connectBD("learningacademy",$connection) && $continue){
                if($_FILES['photoPath']['error'] == 4){
                    $_POST['photoPath']="/Learning-Academy/img/profilePhotos/default.png";
                }else{
                    $_POST['photoPath'] = uploadPhoto(2);
                } 
                
                $sql = "INSERT INTO student (dniStudent, email, password, name, surname, birthDate, photoPath) 
                VALUES ('{$_POST['dniStudent']}','{$_POST['email']}',md5('{$_POST['password']}'), '{$_POST['name']}','{$_POST['surname']}','{$_POST['birthDate']}','{$_POST['photoPath']}')";

                $action = insertSQL($connection, $sql);
                if($action == 0) {
                    echo "<script>alert('You signed in correctly, now log in')</script>";
                    header("Refresh: 1; URL='login.php'");
                } else if($action == 1062) {
                    echo "<script>alert('DNI or email already in use')</script>";
                }
                
            }
        }
    ?>
    <div class="formDiv">
        <form enctype ="multipart/form-data" action="#" method="POST">
            <div class="formRow">
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">
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
                        <input type="file" name="photoPath" id="photoPath" value="Select photo">
                    </div>
                </div>
            </div>
            <div class=formActions>
                <input type="submit" value="Sign Up">
                <a href="index.php">Cancel</a>
            </div>  
        </form>
    </div>
</body>
</html>