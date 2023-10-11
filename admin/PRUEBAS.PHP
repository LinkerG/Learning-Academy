<?php
include "../functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../files/prueba.js"></script>   
    <title>PRUEBAS</title>
</head>
<body>
    <?php
        if(isset($_POST['students'])){
            $json = json_decode($_POST['students']);
            print_r($json);
            /*foreach($json as $student){
                foreach($student as $data){
                    print_r($data);
                    echo "<br>";
                }
            }*/
        }else{
        $sql = "SELECT s.*, GROUP_CONCAT(m.courseId) AS enrolledCourses FROM student s LEFT JOIN matriculates m ON s.dniStudent = m.dniStudent GROUP BY s.dniStudent, s.email, s.password, s.name, s.surname, s.birthDate, s.photoPath, s.prize;";
        $campos = ['dniStudent','email','password','name','surname','birthDate','photoPath','prize','courses'];
        if (connectBD("id21353268_learningacademy", $connection)){
            if(selectSQL($connection,$sql,$result)){
                if(empty($result)){
                    echo "<p>No students matriculated</p>";
                }
                $fileName = "students.txt";  
                $newFileData = '';
                foreach($result as $student => $data){
                    $KeyValue = "";
                    $numCampos = 0;
                    foreach($data as $value){
                        if($data['enrolledCourses'] == null){
                            $data['enrolledCourses'] = 0;
                        }
                        print_r($value);
                        $KeyValue .= "$campos[$numCampos]:$value,";
                        $numCampos += 1;
                    }
                    $KeyValue = rtrim($KeyValue, ',');
                    $newFileData .= $KeyValue . PHP_EOL;
                }
                $newFileData = rtrim($newFileData, PHP_EOL);
                $file = fopen($fileName, 'w');  
                fwrite($file,$newFileData);
                fclose($file);
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