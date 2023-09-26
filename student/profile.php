<!DOCTYPE html>
<html lang="en">
<?php session_start();?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div id="studentContainer">
        <?php
            include ("../functions.php");
            printHeader();?>
                <div id="studentProfile">
                    <div id="profileName">Name: <?php echo "{$_SESSION['name']}";?></div>
                    <div id="profileSurname">Surname: <?php echo "{$_SESSION['surname']}";?></div>
                    <div id="profileEmail">Email: <?php echo "{$_SESSION['email']}"; ?></div>
                    <div id="profilePhoto"><img src="'<?php echo "{$_SESSION['photoPath']}";?>'"></div>
                    <div id="profileBirthDate">Birth date: <?php echo "{$_SESSION['birthDate']}";?></div>
                    <div id="profileStudentDni">DNI: <?php echo "{$_SESSION['dniStudent']}";?></div>
                    <div class="edit-btn"><button type="button" onclick="location.href='editStudent.php'">Edit profile</button></div>
                </div>
                <form enctype="multipart/form-data" id="profile-form" style="display:none;">

                    <label for="name">Name: </label>
                    <input type="text" id="name-input" name="name"></input>

                    <label for="surname">Surname: </label>
                    <input type="text" id="surname-input" name="surname"></input>

                    <label for="email">Email: </label>
                    <input type="text" id="email-input" name="email"></input>

                    <label for="photoPath">Photo: </label>
                    <input type="file" id="photoPath-input" name="photoPath"></input>

                    <label for="birthDate">Birth date: </label>
                    <input type="date" id="birthDate-input" name="birthDate"></input>

                    <label for="dniStudent">Name: </label>
                    <input type="text" id="dni-input" name="dniStudent" readonly></input>

                    <label for="password">Name: </label>
                    <input type="text" id="password-input" name="password" readonly></input>

                    <button type="button" id="save-btn">Update</button>
                </form>
    </div>
</body>
</html>