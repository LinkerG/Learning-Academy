<?php
session_start();
include "../functions.php";
    if(!isset($_SESSION['role']) && $_SESSION['role'] != "A") {
        include("needAdmin.html");
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../close.php'>";
    }else{
        $entityId = $_POST['entityId'];
        $newStatus = $_POST['newStatus'];
        $dataType = $_POST['dataType'];
        $sql = "";

        if($dataType == "course"){
            $sql = "UPDATE course SET active = '$newStatus' WHERE courseId = '$entityId';";
            if(connectBD("id21353268_learningacademy", $connection)) {
                updateSQL($connection, $sql);
            }
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='10;URL=index.php?manage=courses'>";
        }else{
            $sql = "UPDATE teacher SET active = '$newStatus' WHERE dniTeacher = '$entityId';";
            if(connectBD("id21353268_learningacademy", $connection)) {
                updateSQL($connection, $sql);
            }
            
        }
        if($sql == ""){
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../index.php'>";
        }
    }
?>
</body>
</html>



