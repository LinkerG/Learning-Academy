<?php
session_start();
include "../functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../files/importStudents.js"></script>   
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
    <title>Import Students</title>
</head>
<body>
    <?php
        if(!isset($_SESSION['role']) && $_SESSION['role'] != "A") {
            printHeader();
            include("needAdmin.html");
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=/Learning-Academy/close.php'>";
        }else{
            if(isset($_POST['students'])){
                insertStudents();
            }else{
                ?>
                <?php printHeader(); ?>
                <div>
                    <input type="file" id="fileInput" accept=".txt" >
                    <!--<button id="export" onclick= "<?php //generarFicheroStudents() ?>">Export</button>-->
                </div>
                <div id="datos"></div>
                <div id="tableContainer"></div>
                <div id="btns"></div>
                <?php
            }
        }
        ?>
</body>
</html>