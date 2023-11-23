<?php
    include './../functions.php';

    if (connectBD("id21353268_learningacademy", $connection)) {
        $output = '';

        $sql = "SELECT * FROM student";
        if (isset($_POST['query'])) {
            $search = mysqli_real_escape_string($connection, $_POST['query']);
            $sql .= " WHERE name LIKE '%$search%' OR dniStudent LIKE '%$search%' OR email LIKE '%$search%'";
        }

        if (selectSQL($connection, $sql, $result)) {
            if (empty($result)) {
                $output .= "<tr><td colspan='8'>There are no students in your search.</td></tr>";
            } else {
                $output .= "<tr>";
                $output .= "    <th>Name</th>";
                $output .= "    <th>Surname</th>";
                $output .= "    <th>Email</th>";
                $output .= "    <th>DNI</th>";
                $output .= "    <th>Number of courses matriculated</th>";
                $output .= "</tr>";
                foreach ($result as $row) {
                    $sqlCourses = "SELECT COALESCE(COUNT(*), 0) AS numCourses FROM matriculates WHERE dniStudent = '{$row['dniStudent']}';";
                        selectSQL($connection,$sqlCourses,$numCourses);
                        $output .= "<tr>";
                        $output .= "<td>{$row['name']}</td>";
                        $output .= "<td>{$row['surname']}</td>";
                        $output .= "<td>{$row['email']}</td>";
                        $output .= "<td>{$row['dniStudent']}</td>";
                        $output .= "<td>{$numCourses[0]['numCourses']}</td>";
                        $output .= "</tr>"; 
                }
            }
        }
        echo $output;
    }
?>
