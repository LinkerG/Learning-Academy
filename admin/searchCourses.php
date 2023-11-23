<?php
    include './../functions.php';

    if (connectBD("id21353268_learningacademy", $connection)) {
        $output = '';

        $sql = "SELECT c.*,t.name,t.surname,c.name as courseName FROM course c INNER JOIN teacher t ON c.dniTeacher = t.dniTeacher";
        if (isset($_POST['query'])) {
            $search = mysqli_real_escape_string($connection, $_POST['query']);
            $sql .= " WHERE c.name LIKE '%$search%' OR t.dniTeacher LIKE '%$search%' OR t.name LIKE '%$search%'";
        }

        if (selectSQL($connection, $sql, $result)) {
            if (empty($result)) {
                $output .= "<tr><td colspan='8'>There are no courses in your search.</td></tr>";
            } else {
                $output .= "<tr>";
                $output .= "    <th>Photo</th>";
                $output .= "    <th>Name</th>";
                $output .= "    <th>Hours</th>";
                $output .= "    <th>Start/End date</th>";
                $output .= "    <th>Description</th>";
                $output .= "    <th>Teacher</th>";
                $output .= "    <th>Edit</th>";
                $output .= "    <th>Disabled</th>";
                $output .= "</tr>";
                foreach ($result as $row) {
                    $output .= "<tr>";
                    $output .= "  <td><img src='../{$row['photoPath']}'></td>";
                    $output .= "  <td>{$row['courseName']}</td>";
                    $output .= "  <td>{$row['hours']}</td>";
                    $output .= "  <td>{$row['startDate']} <br>-<br> {$row['endDate']}</td>";
                    $output .= "  <td>{$row['description']}</td>";
                    $output .= "  <td>{$row['name']} {$row['surname']}</td>";
                    $output .= "  <td><a href='editCourse.php?courseId={$row['courseId']}'>Edit</a></td>";
                    $output .= "<td>";
                    $output .= "  <div class='switch-button'>";
                    $output .= "      <input type='checkbox' name='switch-button' id='switch-label-{$row['courseId']}' class='toggle-checkbox' data-id='{$row['courseId']}' data-status='{$row['active']}' data-type='course' " . ($row['active'] == '1' ? 'checked' : '') . ">";
                    $output .= "      <label for='switch-label-{$row['courseId']}' class='switch-button__label'></label>";
                    $output .= "  </div>";
                    $output .= "</td>";
                    $output .= "</tr>";
                }
            }
        }
        echo $output;
    }
?>
