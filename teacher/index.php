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
    <script src="../files/changeScore.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "T") {
            printHeader("../");
            include("needTeacher.html");
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=../close.php'>";

        } else {
            printHeader("../");
            if(isset($_REQUEST['manage'])) {
                if(connectBD("id21353268_learningacademy", $connection)){
                    $updateScore = "UPDATE matriculates SET score=" . $_REQUEST['newScore'] . " WHERE dniStudent ='" . $_REQUEST['dniStudent'] . "' AND courseId = '" . $_REQUEST['manage'] . "';";
                    updateSQL($connection, $updateScore);
                }
            }
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
                    $isFinished = strtotime($course['endDate'])<strtotime(date("Y-m-d")) ? "Finished" : "Not finished";
                    echo "<div class='divWindow hoverable teacherWindow' id='{$course['courseId']}'>";
                    echo "<p>Course: {$course['name']}</p>";
                    echo "<p>Status: " . $isFinished . "</p>";
                    echo "<p>Students: {$course['numberOfStudents']}</p>";
                    echo "<p>Graded students: {$course['gradedStudents']}/{$course['numberOfStudents']}";
                    echo "</div>";
                    echo "<div class='courseHidden' id='course{$course['courseId']}'>";

                    $studentsForCourse = "
                    SELECT m.*, s.name, s.surname
                    FROM matriculates AS m
                    JOIN student AS s ON m.dniStudent = s.dniStudent
                    WHERE m.courseId = '" . $course['courseId'] . "';
                    ";
                    
                    if(selectSQL($connection, $studentsForCourse, $courseStudents)){
                        if(empty($courseStudents)){
                            echo "There are no students matriculated in this course";
                        } else {
                            echo "<table>";
                            echo "<tr class='courseIdRow'><td class='courseIdCol' colspan='7'><p class='courseIdValue'>{$course['courseId']}</p></td></tr>";
                            echo "<tr>";
                            echo "<th>DNI</th>";
                            echo "<th>Name</th>";
                            echo "<th>Task 1</th>";
                            echo "<th>Task 2</th>";
                            echo "<th>Task 3</th>";
                            echo "<th>Task 4</th>";
                            echo "<th>Score</th>";
                            echo "</tr>";
                            foreach ($courseStudents as $student) {
                                echo "<tr>";
                                echo "<td class='dniStudent'>{$student['dniStudent']}</td>";
                                echo "<td>{$student['name']} {$student['surname']}</td>";
                                $numberOfTasks=0;
                                for ($i=1; $i < 5; $i++) { 
                                    $task = "task" . $i;
                                    if($student[$task] == null){
                                        echo "<td> Not submitted </td>";
                                    } else {
                                        $numberOfTasks+=1;
                                        echo "<td><a target='_blank' href='{$student[$task]}'> Download </a></td>";
                                    }
                                }

                                //Mira si puede el estudiante tener nota o no
                                $errMsg = [];
                                
                                if(strtotime($course['endDate']) > strtotime(date("Y-m-d"))) array_push($errMsg,"Course must be finished");
                                if($numberOfTasks<4) array_push($errMsg, "Student must send all four tasks");

                                //Si puede tener se le da la opcion
                                if(empty($errMsg)){
                                    if($student['score'] == null) {
                                        echo "<td>";
                                        echo "<select name='score' class='selectedScore'>";
                                        echo "<option value='null'>Nothing</option>
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                        <option value='3'>3</option>
                                        <option value='4'>4</option>
                                        <option value='5'>5</option>
                                        <option value='6'>6</option>
                                        <option value='7'>7</option>
                                        <option value='8'>8</option>
                                        <option value='9'>9</option>
                                        <option value='10'>10</option>";
                                        echo "</select>";
                                        echo "</td>";
                                    } else {
                                        echo "<td>";
                                        echo "<select name='score' class='selectedScore'>";
                                        for ($i=1; $i <11 ; $i++) { 
                                            if($student['score'] == $i) {
                                                echo "<option value='$i' selected>$i</option>";
                                            } else {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        }
                                        echo "</select>";
                                        echo "</td>";
                                    }
                                } else {
                                    //Si no, le dice porque
                                    echo "<td>";
                                    foreach ($errMsg as $error) {
                                        echo "$error";
                                        echo "<br>";
                                    }
                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
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
        echo "<script>
        window.addEventListener('load', function() {
            window.onload = loadTeacher(1,'{$_REQUEST['manage']}');
            addChangeListeners();
        });
        </script>";
    } else {
        echo "<script>
        window.addEventListener('load', function() {
            window.onload = loadTeacher(0);
            addChangeListeners();
        });
        </script>";
    }
?>
</body>
</html>