<?php
function printHeader() {
    echo "<header class='header'>";
    if(!isset($_SESSION['role'])) {
        $role = 'N';
    } else {
        $role = $_SESSION['role'];
    }
    if($role == "") $role = "N";
    switch($role) {
        case "N":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<p class='menu1'>Learning Academy</p>";
            echo "<a href='/Learning-Academy/courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<a href='login.php' id='login' class='blueBtn'>Log in</a>";
            echo "<a href='signup.php' id='signup' class='witheBtn'>Sing up</a>";
            break;
        case "A":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<a href='/Learning-Academy/admin/index.php' class='menu1 blueBtn'>Admin panel</a>";
            echo "<a href='/Learning-Academy/courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<a href='/Learning-Academy/close.php' id='logout' class='blueBtn'>Log out</a>";
            break;
        case "S":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<a href='/Learning-Academy/student/index.php' class='menu1 blueBtn'>Student panel</a>";
            echo "<a href='/Learning-Academy/courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<a href='/Learning-Academy/close.php' id='logout' class='blueBtn'>Log out</a>";
            break;
        case "T":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<a href='/Learning-Academy/teacher/index.php' class='menu1 blueBtn'>Teacher panel</a>";
            echo "<a href='/Learning-Academy/courses.php' class='Course blueBtn'>Our courses</a>";
            echo "<a href='/Learning-Academy/close.php' class='blueBtn' id='logout'>Log out</a>";
            break;
    }
    echo "</header>";
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
        die("Error en la preparación de la consulta: " . $connection->error);
    }
    // Ejecuta la consulta y en caso de error te lo dice
    if ($executeQuery->execute() === false) {
        echo "Error al insertar el registro: " . $executeQuery->error;
    }
    // Cerrar la conexión a la base de datos y la query
    $executeQuery->close();
    $connection->close();
}

function validateUser() {
    if(!empty($_POST)){
        // Cambiar el nombre de la bd segun convenga
        if(connectBD("learningacademy", $connection)){
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
                        if(connectBD("learningacademy", $connection)){
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
                        $route = "/Learning-Academy/img/" . "profilePhotos/" . $_POST['dniStudent'] . ".png";
                        break;
                    case 1:
                        $route = "/Learning-Academy/img/" . "profilePhotos/" . $_POST['dniTeacher'] . ".png";
                        break;
                    case 2:
                        if($courseId == null) {
                            if(connectBD("learningacademy", $connection)){
                                $sql = $query = "SELECT COUNT(*) AS total FROM course";
                                if(selectSQL($connection, $sql, $result)) {
                                    $count = intval($result[0]['total']);
                                    $count+=1;
                                    $route = "/Learning-Academy/img/" . "coursePhotos/" . $count . ".png";
                                }
                            }
                        } else {
                            $route = "/Learning-Academy/img/" . "coursePhotos/" . $courseId . ".png";
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
    WHERE c.endDate < CURRENT_DATE();";

    if(connectBD("learningAcademy", $connection)){
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
?>