<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <?php
        include("../functions.php");

        if(isset($_SESSION['role']) && $_SESSION['role'] == "S") {
            printHeader();
        } else{
            printHeader();
            notValidated();
            exit;
        }
    ?>
    <h1>Welcome <?php echo $_SESSION['name'] . " " . $_SESSION['surname'] ?></h1>
    <div class="container">
        <a href="courses.php">view your courses</a>
        <a href="profile.php">Profile</a>
    </div>
</body>
</html>