<?php
session_start();
include "../functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../files/importStudents.js"></script>   
    <link rel="stylesheet" href="../css/main.css">
    <title>PRUEBAS</title>
</head>
<body>
    <?php
        if(!isset($_SESSION['role']) && $_SESSION['role'] != "A") {
            printHeader();
            include("needAdmin.html");
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=/Learning-Academy/close.php'>";
        }else{
            printHeader();

        if(isset($_POST['import'])){
            $json = json_decode($_POST['students'], true);
            echo "<h1>Hola JSON</h1>";
            if(connectBD("id21353268_learningacademy", $connection)) {
                $sql = "SELECT email, dniTeacher AS dni
                FROM teacher
                UNION ALL
                SELECT email, dniStudent as dni
                FROM student;";
                $existing = [];
                if(selectSQL($connection, $sql, $emailsAndDni)) {
                    foreach ($emailsAndDni as $key => $value) {
                        array_push($existing, $value['email'], $value['dni']);
                    }
                }

                $courses = [];
                $sql = "SELECT courseId FROM course;";
                if(selectSQL($connection, $sql, $courseIds)) {
                    foreach ($courseIds as $key => $value) {
                        array_push($courses, $value['courseId']);
                    }
                }
            }
            $failedStudents = [];
            $failedMatriculations = [];
            if(connectBD("id21353268_learningacademy", $connection)){
            foreach($json as $student){
                if(in_array($student['dniStudent'], $existing) || in_array($student['dniStudent'], $existing)){
                    array_push($failedStudents, $student["dniStudent"]);
                } else {
                    $sqlStudent = "INSERT INTO student (dniStudent, email, password, name, surname, birthDate, photoPath, prize) 
                    VALUES ('{$student['dniStudent']}', '{$student['email']}', '{$student['password']}', '{$student['name']}', '{$student['surname']}', '{$student['birthDate']}', '{$student['photoPath']}', '{$student['prize']}');";
                    $action = insertSQL($connection, $sqlStudent);
                    if($action!=0) {
                        echo "Insert {$student['dniStudent']} ";
                        echo "<br> $sqlStudent <br>";
                        echo "unexpected error $action";
                    }

                    if($student['courses'][0]!=0){
                        foreach ($student['courses'] as $key => $value) {
                            if(!in_array($value, $courses)){
                                array_push($failedMatriculations, [$student['dniStudent'], $value]);
                            } else {
                                $sqlMatricula = "INSERT INTO matriculates (dniStudent, courseId) VALUES ('{$student['dniStudent']}', '$value')";
    
                                $action = insertSQL($connection, $sqlMatricula);
                                if($action!=0) {
                                    echo "Matricula {$student['dniStudent']} ";
                                    echo "unexpected error $action";
                                }
                            }
                        }
                    } else {
                        echo "no <br>";
                    }
                }
            }
            }
            echo "Han fallado estos alumnos";
            print_r($failedStudents);
            echo "Han fallado estas matriculaciones";
            print_r($failedMatriculations);
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
                                $KeyValue .= "$campo:" . (is_array($data[$campo]) ? '(' . implode(';', $data[$campo]) . ')' : $data[$campo]) . ",";
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
    }
    ?>
</body>
</html>