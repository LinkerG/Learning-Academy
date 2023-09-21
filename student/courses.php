<!DOCTYPE html>
<html lang="en">
<?php
    include ("../functions.php"); 
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student courses</title>
</head>
<body>
    <?php
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
                $sql = "SELECT * FROM course c INNER JOIN matriculates m ON c.courseId = m.courseId INNER JOIN student s ON s.dniStudent = m.dniStudent WHERE s.name = '" . $_SESSION['name'] . "' ;";
            }
                if(selectSQL($connection, $sql, $result)){
                    if(empty($result)) {
                        echo "<tr>";
                        echo "<td colspan='6'>You aren't in any course</td>";
                        echo "</tr>";
                        echo "<a>";
                    } else {
                        print_r($result);
                    }
                }
            
        ?>
    </table>
    
</body>
</html>