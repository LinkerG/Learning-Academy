<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage teachers</title>
    <link rel="stylesheet" href="../css/main.css">
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
    <h1>Teacher list</h1>
    <div class="listContainer">
        <div class="tableToolbar">
            <a class="linkButton" href="addTeacher.php">Add new teacher</a>
        </div>

        <form action="#" method="post" id="teacherForm">
            <table>
                <tr>
                    <th>DNI</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Titulation</th>
                    <th>Email</th>
                    <th>Password (MD5)</th>
                    <th>Edit</th>
                    <th>Active</th>
                </tr>
                <?php
                    if(connectBD("learningacademy", $connection)) {
                        $sql = "SELECT * FROM teacher";

                        if(selectSQL($connection, $sql, $result)){
                            if(empty($result)) {
                                echo "<tr>";
                                echo "<td colspan='9'>There are no teachers right now</td>";
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
                                    echo "<td>{$row['password']}</td>";
                                    echo "<td><a href='editTeacher.php?dniTeacher={$row['dniTeacher']}'>Edit</a></td>";
                                    echo "<td><a href='editTeacher.php?active={$row['active']}&dniTeacher={$row['dniTeacher']}'>{$row['active']}</a></td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    }
                ?>
            </table>
        </form>
    </div>
</body>
</html>