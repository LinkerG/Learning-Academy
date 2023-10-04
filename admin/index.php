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
    <script src="../files/scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(isset($_SESSION['role']) && $_SESSION['role'] == "A") {
            printHeader();
        } else{
            printHeader();
            notValidated();
            header("Refresh: 5; URL='/Learning-Academy/close.php.php'");
            exit;
        }

        
    ?>
    <div class="container">
    <h1>ADMIN PANEL</h1>
    <div class="tabbedWindow">
        <div id="courses" class="divWindow hoverable">Manage courses</div>
        <div id="teachers" class="divWindow hoverable">Manage teachers</div>
    </div>
        <table id="teachersTable" style="display:none;">
            <tr>
                <th>DNI</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Titulation</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Active</th>
            </tr>
            <?php
                if(connectBD("id21353268_learningacademy", $connection)) {
                    $sql = "SELECT * FROM teacher";

                    if(selectSQL($connection, $sql, $result)){
                        if(empty($result)) {
                            echo "<tr>";
                            echo "<td colspan='8'>There are no teachers right now</td>";
                            echo "</tr>";
                        } else {
                            foreach($result as $row) {
                                echo "<tr>";
                                echo "<td>{$row['dniTeacher']}</td>";
                                echo "<td><img src='{$row['photoPath']}'></td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['surname']}</td>";
                                echo "<td>{$row['titulation']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td><a href='editTeacher.php?dniTeacher={$row['dniTeacher']}'>Edit</a></td>";
                                echo "<td><a href='editTeacher.php?active={$row['active']}&dniTeacher={$row['dniTeacher']}'>{$row['active']}</a></td>";
                                echo "</tr>";
                            }
                        }
                    }
                }
            ?>
        </table>
        <table id="coursesTable" style="display:none;">
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
                                echo "<td>{$row['startDate']} <br>-<br> {$row['endDate']}</td>";
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
<?php
if(isset($_REQUEST['manage'])) {
    echo "<script>window.onload = loadAdmin(1,'{$_REQUEST['manage']}')</script>";
} else {
    echo "<script>window.onload = loadAdmin(0);</script>";
}
?>
</body>
</html>