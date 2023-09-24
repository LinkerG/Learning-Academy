<!DOCTYPE html>
<html lang="en">
<?php
    include ("../functions.php"); 
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Student courses</title>
</head>
<body>
    <?php
        if(!isset($_SESSION['role']) || $_SESSION['role'] != "S") {
            include("needStudent.html");
            header("Refresh: 5; URL='close.php'");
            exit;
        } else {
            printHeader();
        }   
        echo "<h1>Welcome " . $_SESSION['name'] . " " . $_SESSION['surname'] . "</h1>";
        echo "<h2>This are your courses right now</h2>";
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Hours</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Photo path</th>
        </tr>
        <?php
            if(connectBD("learningacademy", $connection)) {
                $sql = "SELECT m.task1,m.task2,m.task3,m.task4,m.score,c.endDate,c.name,c.photoPath FROM matriculates m INNER JOIN course c ON c.courseId = m.courseId INNER JOIN student s ON s.dniStudent = m.dniStudent WHERE s.dniStudent = '" . $_SESSION['dniStudent'] . "' ;";
            }
                if(selectSQL($connection, $sql, $result)){
                    if(empty($result)) {
                        echo "<div>";
                        echo "<h1>You aren't in any course</h1>";
                        echo "<a src=".'../courses.php'.">enter on any of our courses!</a>";
                        echo "</div>";
                    } else {
                        foreach ($result as $course){
                            echo"<div class="."course".">";
                            echo "";
                            echo "</div>";
                        }
                    }
                }
            
        ?>
    </table>
    
</body>
</html>