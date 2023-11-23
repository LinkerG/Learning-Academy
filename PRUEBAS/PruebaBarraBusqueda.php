<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRUEBAS</title>
    <link rel="stylesheet" href="./../css/main.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
</head>
<body>
    <?php
        include('./../functions.php');
    ?>
    <!DOCTYPE html>
<html>
<head>
  <title>Barra de Búsqueda de Profesores por Nombre y DNI</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="prueba.js"></script>
</head>
<body>
  <h1>Barra de Búsqueda de Profesores por Nombre y DNI</h1>
  
  <input type="text" id="search" placeholder="Buscar por nombre...">
  <table id="profesoresTable">
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
                            echo "<td><img src='../{$row['photoPath']}'></td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['surname']}</td>";
                            echo "<td>{$row['titulation']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td><a href='editTeacher.php?dniTeacher={$row['dniTeacher']}'>Edit</a></td>";
                            echo "<td>";
                            echo "  <div class='switch-button'>";
                            echo "      <input type='checkbox' name='switch-button' id='switch-label-{$row['dniTeacher']}' class='toggle-checkbox' data-id='{$row['dniTeacher']}' data-status='{$row['active']}' data-type='teacher'" . ($row['active'] == '1' ? 'checked' : '') . ">";
                            echo "      <label for='switch-label-{$row['dniTeacher']}' class='switch-button__label'></label>";
                            echo "  </div>";
                            echo "</td>";
                        echo "</tr>";
                    }
                }
            }
        }
    ?>
  </table>
  <div id="resultados"></div>
</body>
</html>

</body>
</html>