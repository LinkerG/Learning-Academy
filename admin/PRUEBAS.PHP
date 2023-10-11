<?php
include "../functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>PRUEBAS</title>
</head>
<body>
    <?php
        $sql = "SELECT * FROM student;";
        $campos = ['dniStudent','email','password','name','surname','birthDate','photoPath','prize'];
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
                        $KeyValue .= "$campos[$numCampos]:$value,";
                        $numCampos += 1;
                    }
                    $KeyValue = rtrim($KeyValue, ',');
                    $newFileData .= $KeyValue . PHP_EOL;
                }
                $file = fopen($fileName, 'w');
                fwrite($file,$newFileData);
                fclose($file);
            }
        }
    ?>
    <form id="uploadForm" enctype="multipart/form-data" action="#">
        <input type="file" id="fileInput" accept=".txt">
        <button id="importButton">Import</button>
    </form> 
    <script>
        var button = document.getElementById('importButton');
        button.addEventListener('click', function() {
        let input = document.getElementById("fileInput");
        if (input.files.length > 0) {
            let file = input.files[0];
            const reader = new FileReader();
            
            reader.addEventListener("load", function(e) {
            const content = e.target.result;
            

            // Procesa el contenido del archivo
            const lines = content.split('\n');
            const students = [];

            lines.forEach(line => {
                const keyValuePairs = line.split(',');
                const studentData = {};

                keyValuePairs.forEach(pair => {
                const [key, value] = pair.split(':');
                if (key && value) {
                    studentData[key.trim()] = value.trim();
                }
                });

                students.push(studentData);
            });

            console.log(students);
            });

            reader.readAsText(file);
        }
        });


        /*if (file) {
            // Enviar el array a PHP
            const studentsJSON = JSON.stringify(students);
                const xhr = new XMLHttpRequest();
                xhr.open("POST","pruebas2.php", true);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                xhr.onreadystatechange = function() {
                    if(xhr.readyState === 4 && xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send(studentsJSON);
            
            //reader.readAsText(file);
        }else{
            alert('Select a file please');
        }*/
        
    </script>
</body>
</html>