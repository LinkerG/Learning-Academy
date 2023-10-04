<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage courses</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            printHeader();
            include("needAdmin.html");
            header("Refresh: 5; URL='/Learning-Academy/close.php'");
            exit;
        } else {
            printHeader();
        }
    ?>
    <h1>Course list</h1>
    <div class="listContainer">
        <div class="tableToolbar">
            <a class="linkButton" href="addCourse.php">Add new course</a>
        </div>

        <table>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Hours</th>
                <th>Start/End date</th>
                <th>Description</th>
                <th>Teacher</th>
                <th>Edit</th>
                <th>Disabled</th>
            </tr>
            <?php
                if(connectBD("id21353268_learningacademy", $connection)) {
                    $sql = "SELECT c.*,t.name,t.surname,c.name as courseName FROM course c INNER JOIN teacher t ON c.dniTeacher = t.dniTeacher";
                    // SELECT * FROM course;
                    if(selectSQL($connection, $sql, $result)){
                        if(empty($result)) {
                            echo "<tr>";
                            echo "<td colspan='8'>There are no courses right now</td>";
                            echo "</tr>";
                        } else {
                            foreach($result as $row) {
                                echo "<tr>";
                                echo "<td><img src='{$row['photoPath']}'></td>";
                                echo "<td>{$row['courseName']}</td>";
                                echo "<td>{$row['hours']}</td>";
                                echo "<td>{$row['startDate']} / {$row['endDate']}</td>";
                                echo "<td>{$row['description']}</td>";
                                echo "<td>{$row['name']} {$row['surname']}</td>";
                                echo "<td><a href='editCourse.php?courseId={$row['courseId']}'>Edit</a></td>";
                                echo "<td><a href='editCourse.php?active={$row['active']}&courseId={$row['courseId']}'>{$row['active']}</a></td>";
                                echo "</tr>";
                            }
                        }
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>