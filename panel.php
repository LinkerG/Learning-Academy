<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        if(isset($_SESSION['role'])) {
            switch($_SESSION['role']) {
                case 'A':
                    $role = 'Admin ';
                    break;
                case 'S':
                    $role = 'Student ';
                    break;
                case 'T':
                    $role = 'Teacher ';
                    break;
                default:
                    $role = "";
                    break;
            }
            echo "<title>$role panel</title>";
        } else {
            echo "<title>Panel</title>";
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        include("functions.php");

        if(!isset($_SESSION['role'])) {
            printHeader("N");
            notValidated();
            exit;
        }

        printHeader($_SESSION['role']);
        echo "<h1>$role</h1>";
    ?>
    <h1>PANEL</h1>
</body>
</html>