<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage teachers</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            include("needAdmin.html");
            header("Refresh: 5; URL='close.php'");
            exit;
        } else {
            printHeader("A");
        }
    ?>
    <h1>Teacher list</h1>
    <div class="listContainer">
        <div class="tableToolbar">
            <a class="linkButton" href="addTeacher.php">Add new teacher</a>
        </div>

        <table>
            <tr>
                <th>DNI</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Password (MD5)</th>
                <th>Edit</th>
                <th>Disabled</th>
            </tr>
            <?php
                if(connectBD("learningacademy", $connection)) {
                    $sql = "SELECT * FROM teacher";

                    if(selectSQL($connection, $sql, $result)){
                        if(empty($result)) {
                            echo "<tr>";
                            echo "<td colspan='7'>There are no teachers right now</td>";
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