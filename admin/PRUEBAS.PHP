<?php
session_start();
include "../functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRUEBAS</title>
</head>
<body>
    <table>
        <tr>
            <td>Name</td>
            <td>Surname</td>
            <td>Email</td>
            <td>DNI</td>
            <td>Number of courses matriculated</td>
        </tr>
        <?php
            $sql = "SELECT * FROM student;";
            if (connectBD("id21353268_learningacademy", $connection)){
                if(selectSQL($connection,$sql,$result)){
                    if(empty($result)){
                        echo "<tr>";
                            echo "<td colspan='5'>";
                                echo "<p>There are no students</p>";
                            echo "</td>";
                        echo "</tr>";
                    }else{
                        foreach($result as $student => $data){
                            $sqlCourses = "SELECT COALESCE(COUNT(*), 0) AS numCourses FROM matriculates WHERE dniStudent = '{$data['dniStudent']}';";
                            selectSQL($connection,$sqlCourses,$numCourses);
                            echo "<tr>";
                                echo "<td>{$data['name']}</td>";
                                echo "<td>{$data['surname']}</td>";
                                echo "<td>{$data['email']}</td>";
                                echo "<td>{$data['dniStudent']}</td>";
                                echo "<td>{$numCourses[0]['numCourses']}</td>";
                            echo "</tr>";
                            
                        }
                    }
                };
            }
        ?>

    </table>
</body>
</html>