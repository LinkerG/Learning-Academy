<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage courses</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            include("needAdmin.html");
            header("Refresh: 5; URL='close.php'");
            exit;
        }
    ?>
    <h1>Course list</h1>
    <div class="listContainer">
        <div class="tableToolbar">
            <a class="linkButton" href="addCourse.php">Add new course</a>
        </div>

        <table>
            <tr>
                <th>Name</th>
                <th>Hours</th>
                <th>Start/End date</th>
                <th>Teacher</th>
                <th>Edit</th>
                <th>Disabled</th>
            </tr>
            <?php
                include("../functions.php");

                if(connectBD("learningacademy", $connection)) {
                    $sql = "SELECT * FROM course";

                    if(selectSQL($connection, $sql, $result)){
                        if(empty($result)) {
                            echo "<tr>";
                            echo "<td colspan='6'>There are no courses right now</td>";
                            echo "</tr>";
                        } else {
                            foreach($result as $row) {
                                echo "<tr>";
                                
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