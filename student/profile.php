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
</head>
<body>
        <?php
            include ("../functions.php");
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (connectBD("learningacademy", $connection)) {
                    if ($_FILES['photoPath']['error'] == 4) {
                        $_POST['photoPath'] = "/Learning-Academy/img/profilePhotos/default.png";
                    } else {
                        $_POST['photoPath'] = uploadPhoto(2);
                    }
                    $_SESSION['name'] = $_POST['name'];
                    $_SESSION['surname'] = $_POST['surname'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['photoPath'] = $_POST['photoPath'];
                    $_SESSION['birthDate'] = $_POST['birthDate'];
                    $sql = "UPDATE student SET dniStudent = '{$_POST['dniStudent']}', email = '{$_POST['email']}', name = '{$_POST['name']}', surname = '{$_POST['surname']}', birthDate = '{$_POST['birthDate']}', photoPath = '{$_POST['photoPath']}' WHERE dniStudent = '{$_SESSION['dniStudent']}';";
                    updateSQL($connection, $sql);
                    echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0;URL=profile.php'>";
                }
            }
            else{
                printHeader();
                ?>
                <div class="studentContainer">
                    <div class="studentProfile">
                        <div class="profile-element" id="profileName">Name: <?php echo "{$_SESSION['name']}";?></div>
                        <div class="profile-element" id="profileSurname">Surname: <?php echo "{$_SESSION['surname']}";?></div>
                        <div class="profile-element" id="profileEmail">Email: <?php echo "{$_SESSION['email']}"; ?></div>
                        <div class="profile-element" id="profilePhoto"><img src="<?php echo "{$_SESSION['photoPath']}";?>"></div>
                        <div class="profile-element" id="profileBirthDate">Birth date: <?php echo "{$_SESSION['birthDate']}";?></div>
                        <div class="profile-element" id="profileStudentDni">DNI: <?php echo "{$_SESSION['dniStudent']}";?></div>
                        <div class="btn"><button type="button" id="edit-btn" onclick="editProfile()">Edit profile</button></div>
                    </div>
                    <form enctype="multipart/form-data" id="profile-form" style="display:none" action="profile.php" method="POST">

                        <label for="name-input">Name: </label>
                        <input type="text" class="form-element" id="name-input" name="name" value="<?php echo $_SESSION['name'] ?>"></input>

                        <label for="surname-input">Surname: </label>
                        <input type="text" class="form-element" id="surname-input" name="surname" value="<?php echo $_SESSION['surname']?>"></input>

                        <label for="email-input">Email: </label>
                        <input type="text" class="form-element" id="email-input" name="email" value="<?php echo $_SESSION['email']?>"></input>

                        <label for="photoPath-input">Photo: </label>
                        <input type="file" class="form-element" id="photoPath-input" name="photoPath" value="<?php echo $_SESSION['photoPath']?>"></input>

                        <label for="birthDate-input">Birth date: </label>
                        <input type="date" class="form-element" id="birthDate-input" name="birthDate" value="<?php echo $_SESSION['birthDate']?>"></input>

                        <label style="display:none" for="dniStudent-input">DNI: </label>
                        <input type="hidden" class="form-element" id="dniStudent-input" name="dniStudent" value="<?php echo $_SESSION['dniStudent']?>"></input>

                        <input type="submit" value="Update"></input>
                    </form>
                </div>
            <script src="../files/scripts.js"></script>
            <?php
            }
            ?>
      
           
</body>
</html>