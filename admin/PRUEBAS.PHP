<?php
include "../functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../files/importStudents.js"></script>   
    <title>PRUEBAS</title>
</head>
<body>
    <?php
        if(isset($_POST['students'])){
            $json = json_decode($_POST['students'], true);
            print_r($json);
            foreach($json as $student){
                if(isset($student['courses'])){
                    print_r($student['courses'][0]);
                }
            }
        }else{
            $sql = "SELECT s.*, GROUP_CONCAT(m.courseId) AS enrolledCourses FROM student s LEFT JOIN matriculates m ON s.dniStudent = m.dniStudent GROUP BY s.dniStudent, s.email, s.password, s.name, s.surname, s.birthDate, s.photoPath, s.prize;";
            $campos = ['dniStudent', 'email', 'password', 'name', 'surname', 'birthDate', 'photoPath', 'prize', 'courses'];
            
            if (connectBD("id21353268_learningacademy", $connection)) {
                if (selectSQL($connection, $sql, $result)) {
                    if (empty($result)) {
                        echo "<p>No students matriculated</p>";
                    } else {
                        $fileName = "students.txt";
                        $newFileData = '';
                        foreach ($result as $student => $data) {   
                            // Construir un array de cursos
                            $courses = explode(",", $data['enrolledCourses']);
                            $coursesArray = [];
            
                            foreach ($courses as $course) {
                                $coursesArray[] = intval($course);
                            }
            
                            $data['courses'] = $coursesArray;
                            // Construir la línea clave:valor
                            $KeyValue = "";
                            foreach ($campos as $campo) {
                                $KeyValue .= "$campo:" . (is_array($data[$campo]) ? '[' . implode(';', $data[$campo]) . ']' : $data[$campo]) . ",";
                            }
                            $KeyValue = rtrim($KeyValue, ',');
                            $newFileData .= $KeyValue . PHP_EOL;
                        }
                        $newFileData = rtrim($newFileData, PHP_EOL);
            
                        $file = fopen($fileName, 'w');
                        fwrite($file, $newFileData);
                        fclose($file);
                    }
                }
            }
            

    ?>
    <input type="file" id="fileInput" accept=".txt">
    <button id="importButton">Import</button>
    <div id="datos"></div>
    <?php
        }
    ?>
</body>
</html>