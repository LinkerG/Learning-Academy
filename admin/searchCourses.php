<?php
    include './../functions.php';

    if (connectBD("id21353268_learningacademy", $connection)) {
        $output = '';

        $sql = "SELECT * FROM course";
        if (isset($_POST['query'])) {
            $search = mysqli_real_escape_string($connection, $_POST['query']);
            $sql .= " WHERE name LIKE '%$search%' OR dniTeacher LIKE '%$search%'";
        }

        if (selectSQL($connection, $sql, $result)) {
            if (empty($result)) {
                $output .= "<tr><td colspan='8'>No hay profesores que coincidan con la búsqueda.</td></tr>";
            } else {
                foreach ($result as $row) {
                    $output .= "<tr>";
                    $output .= "<td>{$row['dniTeacher']}</td>";
                    $output .= "<td><img src='../{$row['photoPath']}'></td>";
                    $output .= "<td>{$row['name']}</td>";
                    $output .= "<td>{$row['surname']}</td>";
                    $output .= "<td>{$row['titulation']}</td>";
                    $output .= "<td>{$row['email']}</td>";
                    $output .= "<td><a href='editTeacher.php?dniTeacher={$row['dniTeacher']}'>Edit</a></td>";
                    $output .= "<td>";
                    $output .= "  <div class='switch-button'>";
                    $output .= "      <input type='checkbox' name='switch-button' id='switch-label-{$row['dniTeacher']}' class='toggle-checkbox' data-id='{$row['dniTeacher']}' data-status='{$row['active']}' data-type='teacher'" . ($row['active'] == '1' ? 'checked' : '') . ">";
                    $output .= "      <label for='switch-label-{$row['dniTeacher']}' class='switch-button__label'></label>";
                    $output .= "  </div>";
                    $output .= "</td>";
                    $output .= "</tr>";
                }
            }
        }
        echo $output;
    }
?>
