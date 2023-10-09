<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher panel</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../files/scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "T") {
            printHeader();
            include("needTeacher.html");
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=/Learning-Academy/close.php'>";
            exit;
        } else {
            printHeader();
            if(connectBD("id21353268_learningacademy", $connection)) {
                $sql = "SELECT * FROM course WHERE dniTeacher = '" . $_SESSION['dniTeacher'] . "';";
                if(selectSQL($connection, $sql, $result));
            }
    ?>

    <div class='container'>
        <div class='tabbedWindow'>
            <div class='divWindow hoverable'>
                
            </div>
        </div>
    </div>
    <?php
        }
    ?>
    
</body>
</html>