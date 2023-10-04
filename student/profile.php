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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (connectBD("learningacademy", $connection)) {
                    if(isset($_POST['photoPath'])){
                        $_SESSION['name'] = $_POST['name'];
                        $_SESSION['surname'] = $_POST['surname'];
                        $_SESSION['email'] = $_POST['email'];
                        $_SESSION['photoPath'] = $_POST['photoPath'];
                        $_SESSION['birthDate'] = $_POST['birthDate'];
                        $uploadStatus = uploadPhoto(0, $route);
                        if($uploadStatus == 0){
                            $sql = "UPDATE student SET email = '{$_POST['email']}', name = '{$_POST['name']}', surname = '{$_POST['surname']}', birthDate = '{$_POST['birthDate']}', photoPath = '$route' WHERE dniStudent = '{$_SESSION['dniStudent']}';";
                            updateSQL($connection, $sql);
                            echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0;URL=profile.php'>";
                        } else if ($uploadStatus == 1) {
                            echo "<script>alert('Error uploading photo')</script>";
                        } else if ($uploadStatus == 2) {
                            echo "<script>alert('Please upload a photo')</script>";
                        }
                    } else{
                        $_SESSION['name'] = $_POST['name'];
                        $_SESSION['surname'] = $_POST['surname'];
                        $_SESSION['email'] = $_POST['email'];
                        $_SESSION['birthDate'] = $_POST['birthDate'];
                        $sql = "UPDATE student SET email = '{$_POST['email']}', name = '{$_POST['name']}', surname = '{$_POST['surname']}', birthDate = '{$_POST['birthDate']}' WHERE dniStudent = '{$_SESSION['dniStudent']}';";
                        updateSQL($connection, $sql);
                        echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0;URL=profile.php'>";
                    }
                }
            }
            else{
                printHeader();
                ?>
                <div class="studentContainer">
                    <div class="studentProfile" style="color:white;">
                        <div class="profile-element" id="profileName">Name: <?php echo "{$_SESSION['name']}";?></div>
                        <div class="profile-element" id="profileSurname">Surname: <?php echo "{$_SESSION['surname']}";?></div>
                        <div class="profile-element" id="profileEmail">Email: <?php echo "{$_SESSION['email']}"; ?></div>
                        <div class="profile-element" id="profilePhoto"><img class="provisionalFoto" src="<?php echo "{$_SESSION['photoPath']}";?>"></div>
                        <div class="profile-element" id="profileBirthDate">Birth date: <?php echo "{$_SESSION['birthDate']}";?></div>
                        <div class="profile-element" id="profileStudentDni">DNI: <?php echo "{$_SESSION['dniStudent']}";?></div>
                        <div class="btn"><button type="button" id="edit-btn" onclick="editProfile()">Edit profile</button></div>
                    </div>
                    <div class="formDiv">
                        <form enctype="multipart/form-data" id="profile-form" style="display:none" action="profile.php" method="POST">
                            <div class="formRow">
                                <div>
                                    <label for="name-input">Name: </label>
                                    <input type="text" class="form-element" id="name-input" name="name" value="<?php echo $_SESSION['name'] ?>"></input>
                                </div>
                                <div>
                                    <label for="dni-input">DNI: </label>
                                    <input type="text" readonly  class="form-element" id="dni-input" name="dni" value="<?php echo $_SESSION['dniStudent'] ?>"></input>
                                </div>
                            </div>
                            <div class="formRow">
                                <div>
                                    <label for="surname-input">Surname: </label>
                                    <input type="text" class="form-element" id="surname-input" name="surname" value="<?php echo $_SESSION['surname']?>"></input>
                                </div>
                                <div>
                                    <label for="email-input">Email: </label>
                                    <input type="text" class="form-element" id="email-input" name="email" value="<?php echo $_SESSION['email']?>"></input>
                                </div>
                            </div>
                            <div class="formRow">
                                <div>
                                    <!--
                                    <label for="photoPath-input">Photo: </label>
                                    <input type="file" class="form-element" id="photoPath-input" name="photoPath" value="<?php echo $_SESSION['photoPath']?>"></input>
                                    -->
                                </div>
                                <div>                                        
                                    <label for="birthDate-input">Birth date: </label>
                                    <input type="date" class="form-element" id="birthDate-input" name="birthDate" value="<?php echo $_SESSION['birthDate']?>"></input>
                                </div>
                            </div>
                            <div class="formActions">
                                <input type="submit" value="Update"></input>
                                <a class='witheBtn' href="profile.php">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            
            <?php
            }
            ?>
      
           <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Llama a la función editProfile cuando el DOM esté listo
                    editProfile();
                });
           </script>
</body>
</html>