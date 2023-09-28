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

        if(isset($_SESSION['role']) && $_SESSION['role'] == "A") {
            printHeader();
        } else{
            printHeader();
            notValidated();
            exit;
        }
    ?>
    <div class="container">
    <h1>ADMIN PANEL</h1>
    <div class="tabbedWindow">
        <a href="courses.php">Manage courses</a>
        <a href="teachers.php">Manage teachers</a>
    </div>
</div>
</body>
</html>