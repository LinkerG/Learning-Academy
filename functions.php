<?php
function printHeader($dir = "") {
    echo "<header class='header'>";
    if(!isset($_SESSION['role'])) {
        $role = 'N';
    } else {
        $role = $_SESSION['role'];
    }
    if($role == "") $role = "N";
    switch($role) {
        case "N":
            echo "<a href='" . $dir . "index.php' class='headerLogo'><img src='" . $dir . "img/logo.png' alt='the academy logo, the earth with a book under it'><p class='menu1'>Learning Academy</p></a>";
            echo "<a href='" . $dir . "courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<a href='" . $dir . "login.php' id='login' class='blueBtn'>Log in</a>";
            echo "<a href='" . $dir . "signup.php' id='signup' class='whiteBtn'>Sign up</a>";
            break;
        case "A":
            echo "<a href='" . $dir . "index.php' class='headerLogo'><img src='" . $dir . "img/logo.png' alt='the academy logo, the earth with a book under it'><p class='menu1'>Learning Academy</p></a>";
            echo "<a href='" . $dir . "admin/index.php' class='menu1 blueBtn'>Admin panel</a>";
            echo "<a href='" . $dir . "courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<div class='dropdown'>";
            echo "  <button>";
                        $src = $dir . $_SESSION['photoPath'];
            echo "      <img src='" . $src . "' alt='profile photo'>";
            echo "      <p> Admin </p>";
            echo "  </button>";
            echo "  <div class='dropdown-menu'>";
            echo "      <a href='" . $dir . "index.php' class='dropdown-item'>Home</a>";
            echo "      <div class='dropdown-divider'></div>";
            echo "      <a href='" . $dir . "close.php' id='logout' class='dropdown-item'>Log out</a>";
            echo "  </div>";
            echo "</div>";
            break;
        case "S":
            echo "<a href='" . $dir . "index.php' class='headerLogo'><img src='" . $dir . "img/logo.png' alt='the academy logo, the earth with a book under it'><p class='menu1'>Learning Academy</p></a>";
            echo "<a href='" . $dir . "student/index.php' class='menu1 blueBtn'>Student panel</a>";
            echo "<a href='" . $dir . "courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<div class='dropdown'>";
            echo "  <button>";
                        $src = $dir . $_SESSION['photoPath'];
            echo "      <img src='" . $src . "' alt='profile photo'>";
            echo "      <p> " . $_SESSION['name'] . " </p>";
            echo "  </button>";
            echo "  <div class='dropdown-menu'>";
            echo "      <a href='" . $dir . "index.php' class='dropdown-item'>Home</a>";
            if($dir != "") {
                echo "  <a href='profile.php' class='dropdown-item'>My profile</a>";
            } else {
                echo "  <a href='student/profile.php' class='dropdown-item'>My profile</a>";
            }
            echo "      <div class='dropdown-divider'></div>";
            echo "      <a href='" . $dir . "close.php' id='logout' class='dropdown-item'>Log out</a>";
            echo "  </div>";
            echo "</div>";
            break;
        case "T":
            echo "<a href='" . $dir . "index.php' class='headerLogo'><img src='" . $dir . "img/logo.png' alt='the academy logo, the earth with a book under it'><p class='menu1'>Learning Academy</p></a>";
            echo "<a href='" . $dir . "teacher/index.php' class='menu1 blueBtn'>Teacher panel</a>";
            echo "<a href='" . $dir . "courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<div class='dropdown'>";
            echo "  <button>";
                        $src = $dir . $_SESSION['photoPath'];
            echo "      <img src='" . $src . "' alt='profile photo'>";
            echo "      <p> " . $_SESSION['name'] . " </p>";
            echo "  </button>";
            echo "  <div class='dropdown-menu'>";
            echo "      <a href='" . $dir . "index.php' class='dropdown-item'>Home</a>";
            echo "      <div class='dropdown-divider'></div>";
            echo "      <a href='" . $dir . "close.php' id='logout' class='dropdown-item'>Log out</a>";
            echo "  </div>";
            echo "</div>";
            break;
    }
    echo "</header>";
}
function printFooter(){
    echo "<div class='footer-container'>";
        echo "<footer class='footer'>";
            echo '  <div class="text">';
            echo '    <div class="logo"><img alt="the academy logo but dark" src="img/logoOscuro.png"></div>';
            echo '    <div class="info">This is our school.</div>';
            echo '  </div>';
            echo '  <div class="quickLinks">';
            echo '    <div class="Title">Quick links</div>';
            echo '    <div class="aboutUs"><a href="aboutUs.php">About us</a></div>';
            echo '    <div class="contactUs"><a href="contactUs.php">Contact us</a></div>';
            echo '    <div class="courses"><a href="courses.php">Courses</a></div>';
            echo '  </div>';
            echo '  <div class="Services">';
            echo '    <div class="title">Services</div>';
            echo '    <div class="appDev">App development</div>';
            echo '    <div class="webDev">Web development</div>';
            echo '    <div class="machineLearn">Machine learning</div>';
            echo '  </div>';
            echo '  <div class="ReachUs">';
            echo '    <div class="reachUs">Reach us</div>';
            echo '    <div class="icon1"><img alt="icon with our mail address to send us an email" src="img/icons/Message.png"></div>';
            echo '    <div class="icon2"><img alt="icon of a phone with our phone number" src="img/icons/Mobile.png"></div>';
            echo '    <div class="icon3"><img alt="icon of a map pointer with our asdress" src="img/icons/Location.png"></div>';
            echo '    <div class="mail">learningacademy@gmail.com</div>';
            echo '    <div class="tel">655 43 43 43</div>';
            echo '    <div class="direc">INS La Pineda</div>';
            echo '  </div>';
            echo '  <div class="icon"><img alt="the academy logo but dark" src="img/logoMedium.png"></div>';
        echo "</footer>";
    echo "</div>";
}
function connectBD($bd, &$connection) {
    $connectionOk = false;

    try {
        $connection = mysqli_connect("localhost", "root", "", $bd);

        if ($connection) $connectionOk = true;
        else throw new Exception(mysqli_connect_error());
    } catch (Exception $e) {
        echo "<p>Error connecting database</p>";
        errorMsg($e);
    }

    return $connectionOk;
}

function selectSQL($connection, $sql, &$result) {
    $resultOk = false;

    try {
        $consulta = mysqli_query($connection, $sql);
        if ($consulta) {
            $resultOk = true;
            
            $result = mysqli_fetch_all($consulta, MYSQLI_ASSOC);
        }
        else throw new Exception(mysqli_sql_exception());
    } catch (Exception $e) {    
        echo "<p>Error en la consulta SQL</p>";
        errorMsg($e);
    }

    return $resultOk;
}

function colNameSQL($connection, $table){
    if($connection){
        $query = "DESCRIBE $table";
        $result = $connection -> query($query);

        if($result === false){
            die("Error to obtain information from the table: " . $connection -> error);
        }

        $fields = [];
        while($row = $result -> fetch_assoc()){
            if($row['Field']=="courseId") continue;
            else $fields[] = $row['Field'];
        }

        return $fields;
    }
}

function insertSQL($connection, $sql) {
    try {
        $executeQuery = $connection->prepare($sql);
        $executeQuery->execute();
        return 0;
    } catch(mysqli_sql_exception $e){
        // 1062 es el código de error para una clave primaria duplicada
        if ($e->getCode() == 1062) {
            return 1062;
        } else {
            $error = $e->getMessage();
            echo "<script>alert('{$error}')</script>";
        }
        return $e->getCode();
    }
}

function updateSQL($connection, $sql) {
    $executeQuery = $connection->prepare($sql);
    if ($executeQuery === false) {
        return "Error en la preparación de la consulta: " . $connection->error;
    }
    // Ejecuta la consulta y en caso de error te lo dice
    if ($executeQuery->execute() === false) {
        return "Error al insertar el registro: " . $executeQuery->error;
    }
    // Cerrar la conexión a la base de datos y la query
    $executeQuery->close();
    $connection->close();
    return "Update succes!";
}

function validateUser() {
    if(!empty($_POST)){
        // Cambiar el nombre de la bd segun convenga
        if(connectBD("id21353268_learningacademy", $connection)){
            // Cambiar el nombre de la tabla segun convenga
            $sql = "SELECT * FROM admin";

            $found = false;
            $valid = false;
            if(selectSQL($connection, $sql, $result)) {
                // Estas variables sirven para cambiar el mensaje de error si no se encuentra    
                foreach ($result as $row){
                    // Cambiar email por la clave primaria que se necesite
                    if ($row['email'] == $_POST['email']){
                        $found = true;

                        if($row['password'] == md5($_POST['password'])){
                            $valid = true;
                            // Se crean las variables de sesión añadir las que hagan falta
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['password'] = $row['password'];
                            $_SESSION['role'] = "A";
                            $_SESSION['photoPath'] = "img/profilePhotos/default.png";
                            header('Location: admin/index.php');
                        } else $found = false;
                    }
                }
            }
            if ($found == false) {
                $sql = "SELECT * FROM teacher";

                if(selectSQL($connection, $sql, $result)) {
                    // Estas variables sirven para cambiar el mensaje de error si no se encuentra
    
                    foreach ($result as $row){
                        // Cambiar email por la clave primaria que se necesite
                        if ($row['email'] == $_POST['email']){
                            $found = true;
    
                            if($row['password'] == md5($_POST['password'])){
                                $valid = true;
                                // Se crean las variables de sesión añadir las que hagan falta
                                $_SESSION['email'] = $row['email'];
                                $_SESSION['password'] = $row['password'];
                                $_SESSION['role'] = "T";
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['dniTeacher'] = $row['dniTeacher'];
                                $_SESSION['photoPath'] = $row['photoPath'];
                                header('Location: teacher/index.php');
                            } else $found=false;
                        }
                    }
                }
            }
            if ($found == false) {
                $sql = "SELECT * FROM student";

                if(selectSQL($connection, $sql, $result)) {
                    // Estas variables sirven para cambiar el mensaje de error si no se encuentra
    
                    foreach ($result as $row){
                        // Cambiar email por la clave primaria que se necesite
                        if ($row['email'] == $_POST['email']){
                            $found = true;
    
                            if($row['password'] == md5($_POST['password'])){
                                $valid = true;
                                // Se crean las variables de sesión añadir las que hagan falta
                                $_SESSION['email'] = $row['email'];
                                $_SESSION['password'] = $row['password'];
                                $_SESSION['role'] = "S";
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['surname'] = $row['surname'];
                                $_SESSION['birthDate'] = $row['birthDate'];
                                $_SESSION['photoPath'] = $row['photoPath'];
                                $_SESSION['dniStudent'] = $row['dniStudent'];
                                header('Location: student/index.php');
                            }
                        }
                    }
                }
            }
            if ($found==false) echo '<script>alert("Username does not exist");</script>';
            else if ($valid==false) echo '<script>alert("Wrong password");</script>';
        }
    }
}

function errorMsg($e){
    echo "<p>Error (" . $e -> getCode() . "): " . $e -> getMessage() . "</p>";
}

function notValidated() {
    echo "<div class='container'>";
    echo "<h1 class='no_val'>Necesitas estar validado para ver esta pagina</h1>";
    echo "</div>";
    header("Refresh: 5; URL='close.php'");
}

function uploadPhoto($aux, &$route, $signin = false, $courseId = null) {
    $relativeRoute = $signin ? "img/" : "../img/";

    if (isset($_FILES['photoPath']) && $_FILES['photoPath']['error'] === UPLOAD_ERR_OK) {
        $isImage = getimagesize($_FILES["photoPath"]["tmp_name"]);

        if ($isImage !== false) {
            switch ($aux) {
                case 0:
                    $relativeRoute = $relativeRoute . "profilePhotos/" . $_POST['dniStudent'] . ".png";
                    break;
                case 1:
                    $relativeRoute = $relativeRoute . "profilePhotos/" . $_POST['dniTeacher'] . ".png";
                    break;
                case 2:
                    if($courseId == null) {
                        if(connectBD("id21353268_learningacademy", $connection)){
                            $sql = "SELECT COUNT(*) AS total FROM course";
                            if(selectSQL($connection, $sql, $result)) {
                                $count = intval($result[0]['total']);
                                $count+=1;
                                $relativeRoute = $relativeRoute . "coursePhotos/" . $count . ".png";
                            }
                        }
                    } else {
                        $relativeRoute = $relativeRoute . "coursePhotos/" . $courseId . ".png";
                    }
                    break;
            }
            if (move_uploaded_file($_FILES["photoPath"]["tmp_name"], $relativeRoute)) {
                switch ($aux) {
                    case 0:
                        $route = "img/" . "profilePhotos/" . $_POST['dniStudent'] . ".png";
                        break;
                    case 1:
                        $route = "img/" . "profilePhotos/" . $_POST['dniTeacher'] . ".png";
                        break;
                    case 2:
                        if($courseId == null) {
                            if(connectBD("id21353268_learningacademy", $connection)){
                                $sql = "SELECT COUNT(*) AS total FROM course";
                                if(selectSQL($connection, $sql, $result)) {
                                    $count = intval($result[0]['total']);
                                    $count+=1;
                                    $route = "img/" . "coursePhotos/" . $count . ".png";
                                }
                            }
                        } else {
                            $route = "img/" . "coursePhotos/" . $courseId . ".png";
                        }
                        break;
                    }
                return 0;
            } else {
                return 1; // Error al mover el archivo
            }
        } else {
            return 2; // No es una imagen válida
        }
    } else {
        // No se cargó un archivo, no es necesario modificar la ruta
        return 0;
    }
}

function unavailableCourses() {
    $sql = "SELECT c.courseId
    FROM course c 
    WHERE c.endDate < CURRENT_DATE() OR c.active = 0;";

    if(connectBD("id21353268_learningacademy", $connection)){
        if(selectSQL($connection, $sql, $result)) {
            $idArray = array();
            foreach ($result as $courseId) {
                $idArray[] = $courseId['courseId'];
            }
            return $idArray;
        }
        
    }
}

function getNextCourseId($connection) {
    $sql = "SELECT MAX(courseId) FROM course;";
    if(selectSQL($connection, $sql, $max)){
        return $max[0]['MAX(courseId)']+1;
    }
}

function coursesJoined($dniStudent) {
    $sql = "SELECT courseId FROM matriculates WHERE dniStudent = '" . $dniStudent ."';";

    if(connectBD("id21353268_learningacademy", $connection)){
        if(selectSQL($connection, $sql, $result)) {
            $idArray = array();
            foreach ($result as $courseId) {
                $idArray[] = $courseId['courseId'];
            }
            return $idArray;
        }
        
    }
}

function dniVerification($dni) {
    $dni = strtoupper(trim($dni));

    if (strlen($dni) == 9 && preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        $dniNumbers = substr($dni, 0, 8);
        $dniLetter = $dni[8];
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';

        $dniNumbers = intval($dniNumbers);

        $index = $dniNumbers % 23;

        $letter = $letters[$index];

        if ($dniLetter == $letter) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function uploadPdf($courseId,$connection,$numTask) {
    $task = "task".$numTask;
    $extension = pathinfo($_FILES[$task]['name'],PATHINFO_EXTENSION);
    if(strtolower($extension) !== 'pdf'){   
        return "Sube un archivo PDF.";
    }else{  
        $directoryName = '../files/tasks/';
        $fileName = $_SESSION['dniStudent']."_".$courseId."_".$task.'.pdf';
        if(move_uploaded_file($_FILES[$task]['tmp_name'],$directoryName . $fileName)){
            $fileRoute=$directoryName . $fileName;
            $sql = "UPDATE matriculates SET $task = '$fileRoute' WHERE dniStudent = '{$_SESSION['dniStudent']}' AND courseId = $courseId;"; 
            updateSQL($connection,$sql);
            return "La $task se ha subido correctamente!";
        }else{
            return "Error al subir la $task";
        }
        
    }
}
function generarFicheroStudents(){
    $sql = "SELECT s.*, IFNULL(GROUP_CONCAT(m.courseId), 0) AS enrolledCourses FROM student s LEFT JOIN matriculates m ON s.dniStudent = m.dniStudent GROUP BY s.dniStudent, s.email, s.password, s.name, s.surname, s.birthDate, s.photoPath, s.prize;";
    
    if (connectBD("id21353268_learningacademy", $connection)) {
        if (selectSQL($connection, $sql, $result)) {
            if (empty($result)) {
                echo "<p>No students matriculated</p>";
            } else {
                $fileName = "students.txt";
                $newFileData = '';
                foreach ($result as $data) {   
                    // Construir un array de cursos
                    $courses = '(' . str_replace(",", ";", $data['enrolledCourses']) . ')';

                    // Construir la línea con los valores separados por comas
                    $line = $data['dniStudent'] . "," . $data['email'] . "," . $data['password'] . "," . $data['name'] . "," . $data['surname'] . "," . $data['birthDate'] . "," . $data['photoPath'] . "," . $data['prize'] . "," . $courses;
                    $newFileData .= $line . PHP_EOL;
                }
                $newFileData = rtrim($newFileData, PHP_EOL);

                $file = fopen($fileName, 'w');
                fwrite($file, $newFileData);
                fclose($file);
            }
        }
    }
}


function insertStudents(){
    $json = json_decode($_POST['students'], true);
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
                }
            }
        }
    }
    
    if(empty($failedStudents) && empty($failedMatriculations)){
        echo "<h3>The students were inserted correctly!</h3>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0.5;URL=index.php?manage=students'>";
    }elseif(empty($failedMatriculations)){
        echo "<div>";
        echo "<h3 class='error'>These are the students that we cant insert:</h3>";
        echo "<div>";
        foreach ($failedStudents as $fail) {
            echo "<p>$fail<p>";
        }
        echo "</div>";
        echo "<a href='index.php?manage=students' class='whiteBtn'>Go back</a>";
        echo "</div>";
    }else{
        echo "<div>";
        echo "<h3 class='error'>These are the students that we cant insert:</h3>";
        echo "<div>";
        foreach ($failedStudents as $fail) {
            echo "<p>$fail<p>";
        }
        echo "</div>";
        echo "<h3 class='error'>These are the matriculations that we cant insert</h3>";
        foreach ($failedMatriculations as $fail) {
            echo "<p>{$fail[0]} on course {$fail[1]}<p>";
        }
        echo "</div>";
        echo "<a href='index.php?manage=students' class='whiteBtn'>Go back</a>";
        echo "</div>";
    }
}

?>