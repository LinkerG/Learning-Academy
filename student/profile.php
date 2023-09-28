<!DOCTYPE html>
<html lang="en">
<?php session_start();?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div id="studentContainer">
        <?php
            include ("../functions.php");
            printHeader();
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(connectBD("learningacademy",$connection)){
                    if($_FILES['photoPath']['error'] == 4){
                        $_POST['photoPath']="/Learning-Academy/img/profilePhotos/default.png";
                    }else{
                        $_POST['photoPath'] = uploadPhoto(2);
                    }
                    $_SESSION['name'] = $_POST['name'];
                    $_SESSION['surname'] = $_POST['surname'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['photoPath'] = $_POST['photoPath'];
                    $_SESSION['birthDate'] = $_POST['birthDate'];
                    $_SESSION['dniStudent'] = $_POST['dniStudent'];
                    $sql = "UPDATE student SET dniStudent = {$_POST['dniStudent']}, name = {$_POST['name']}, surname = {$_POST['surname']}, email = {$_POST['email']}, photoPath = {$_POST['photoPath']}, birthDate = {$_POST['birthDate']} WHERE dniStudent = {$_SESSION['dniStudent']};";
                    updateSQL($connection,$sql);
                    $reply = ["MSJ" => "Updated correctly!"];
                    header("Content-Type: application/json");
                    echo json_encode($reply);
                    exit;
                }
            }
            ?>
                <div id="studentProfile">
                    <div id="profileName">Name: <?php echo "{$_SESSION['name']}";?></div>
                    <div id="profileSurname">Surname: <?php echo "{$_SESSION['surname']}";?></div>
                    <div id="profileEmail">Email: <?php echo "{$_SESSION['email']}"; ?></div>
                    <div id="profilePhoto"><img src="<?php echo "{$_SESSION['photoPath']}";?>"></div>
                    <div id="profileBirthDate">Birth date: <?php echo "{$_SESSION['birthDate']}";?></div>
                    <div id="profileStudentDni">DNI: <?php echo "{$_SESSION['dniStudent']}";?></div>
                    <div class="btn"><button type="button" id="edit-btn" onclick="editProfile()">Edit profile</button></div>
                </div>
                <form enctype="multipart/form-data" id="profile-form" style="display:none;">

                    <label for="name">Name: </label>
                    <input type="text" id="name-input" name="name" value="<?php echo $_SESSION['name'] ?>"></input>

                    <label for="surname">Surname: </label>
                    <input type="text" id="surname-input" name="surname" value="<?php echo $_SESSION['surname']?>"></input>

                    <label for="email">Email: </label>
                    <input type="text" id="email-input" name="email" value="<?php echo $_SESSION['email']?>"></input>

                    <label for="photoPath">Photo: </label>
                    <input type="file" id="photoPath-input" name="photoPath" value="<?php echo $_SESSION['photoPath']?>"></input>

                    <label for="birthDate">Birth date: </label>
                    <input type="date" id="birthDate-input" name="birthDate" value="<?php echo $_SESSION['birthDate']?>"></input>

                    <label for="dniStudent">Dni: </label>
                    <input type="text" id="dni-input" name="dniStudent" value="<?php echo $_SESSION['dniStudent'] ?>" readonly></input>

                    <button type="button" id="save-btn" onclick="editProfile()">Update</button>
                </form>
    </div>
    <script src="../files/scripts.js"></script>
</body>
</html>