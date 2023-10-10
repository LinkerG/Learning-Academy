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
        } else {
            printHeader();
            if(connectBD("id21353268_learningacademy", $connection)) {
                $sql = "SELECT c.*, COUNT(m.dniStudent) AS numberOfStudents, COUNT(CASE WHEN m.score IS NOT NULL THEN 1 ELSE NULL END) AS gradedStudents 
                FROM course c 
                LEFT JOIN matriculates m ON c.courseId = m.courseId 
                WHERE c.dniTeacher ='" . $_SESSION['dniTeacher'] . "' 
                GROUP BY c.courseId, c.name, c.hours, c.startDate, c.endDate, c.description, c.dniTeacher, c.active, c.photoPath;";
                if(selectSQL($connection, $sql, $result));
            }
    ?>

    <div class='container'>
        <h1>Teacher panel</h1>
        <div class="tabbedWindow">
            <?php
                if(connectBD("id21353268_learningacademy", $connection)) {
                foreach ($result as $course) {
                    
                    $isFinished = strtotime($course['endDate'])<date("Y-m-d") ? "Finished" : "Not finished";
                    echo "<div class='divWindow hoverable teacherWindow' id='{$course['courseId']}'>";
                    echo "<p>Course: {$course['name']}</p>";
                    echo "<p>Status: " . $isFinished . "</p>";
                    echo "<p>Students: {$course['numberOfStudents']}</p>";
                    echo "<p>Graded students: {$course['gradedStudents']}/{$course['numberOfStudents']}";
                    echo "</div>";

                    echo "<div class='' id='course{$course['courseId']}'>";

                    $studentsForCourse = "SELECT * FROM matriculates WHERE courseID = '" . $course['courseId'] ."';";
                    if(selectSQL($connection, $studentsForCourse, $courseStudents)){
                        if(empty($courseStudents)){
                            echo "There are no students matriculated in this course";
                        } else {
                            foreach ($courseStudents as $student) {
                                print_r($student);
                            }
                        }
                    }

                    echo "</div>";
                }
                }
            ?>
        </div>
    </div>
    <?php
        }
    ?>
    <?php
    if(isset($_REQUEST['manage'])) {
        echo "<script>window.onload = loadTeacher(1,'{$_REQUEST['manage']}')</script>";
    } else {
        echo "<script>window.onload = loadTeacher(0);</script>";
    }
?>
</body>
</html>