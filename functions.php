<?php
function printHeader($role) {
    echo "<header class='header'>";
    if($role == "") $role = "N";
    switch($role) {
        case "N":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<p class='menu1'>Learning Academy</p>";
            echo "<a href='signin.php' class='Signin'>Sign in</a>";
            echo "<a href='signup.php' class='Signup'>Sing up</a>";
            break;
        case "A":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<a href='/Learning-Academy/panel.php' class='menu1'>Admin panel</a>";
            echo "<a href='/Learning-Academy/close.php' class='logout'>Log out</a>";
            break;
        case "S":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<a href='/Learning-Academy/panel.php' class='menu1'>Student panel</a>";
            echo "<a href='/Learning-Academy/close.php' class='logout'>Log out</a>";
            break;
        case "T":
            echo "<a href='/Learning-Academy/index.php' class='headerLogo'><img src='/Learning-Academy/img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
            echo "<a href='/Learning-Academy/panel.php' class='menu1'>Teacher panel</a>";
            echo "<a href='/Learning-Academy/close.php' class='logout'>Log out</a>";
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

function insertSQL($connection,$table){
    /*Se inserta bien los profes, pero los cursos necesitan que el codigo no lo inserte porque es una clave primaria
    y habia pensado en hacer un desplegable en la parte del dni teacher con los nombres que eso es facil y que en el 
    dni se inserte el dni del profe que haya elegido.Si no entiendes mandame un mensaje GGOGOGO */
    
    if($connection){
        $names = colNameSQL($connection,$table);
        $values = "";
        foreach($names as $fieldName){
            if($fieldName == "password") $values = $values . "'" . md5($_POST[$fieldName]) . "'" . ", ";
            else if($fieldName == "courseId") continue;
            else $values = $values . "'" . $_POST[$fieldName] . "'" . ",";
        }
        $colNames = implode(', ',$names);
        $values = trim($values, ",");
        $query = "INSERT INTO $table ($colNames) VALUES ($values)";
        //Prepara la query para controlar mejor los errores
        $executeQuery = $connection->prepare($query);
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
}

function validateUser() {
    if(!empty($_POST)){
        // Cambiar el nombre de la bd segun convenga
        if(connectBD("learningacademy", $connection)){
            // Cambiar el nombre de la tabla segun convenga
            $sql = "SELECT * FROM admin";

            if(selectSQL($connection, $sql, $result)) {
                // Estas variables sirven para cambiar el mensaje de error si no se encuentra
                $found = false;
                $valid = false;

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
                            header('Location: index.php');
                        }
                    }
                }
                if ($found == false) {
                    $sql = "SELECT * FROM teacher";

                    if(selectSQL($connection, $sql, $result)) {
                        // Estas variables sirven para cambiar el mensaje de error si no se encuentra
                        $found = false;
                        $valid = false;
        
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
                                    header('Location: index.php');
                                }
                            }
                        }
                    }
                }
                if ($found == false) {
                    $sql = "SELECT * FROM student";

                    if(selectSQL($connection, $sql, $result)) {
                        // Estas variables sirven para cambiar el mensaje de error si no se encuentra
                        $found = false;
                        $valid = false;
        
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
                                    header('Location: index.php');
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
//Funcion para subir foto copiada de otra practica GOGOGO ya nos encargaremos de implementarla en nuestro codigo mañana -Alex 
function uploadPhoto($aux) {
    if (is_uploaded_file($_FILES['photoPath']['tmp_name'])) {
        if($aux == true){
            //Para los profes
            $directoryName = '../img/profilePhotos/';
            $fileName = $_POST['dniTeacher'] . '.png'; // Aquí estableces el nombre de la foto como el dni y la extensión ".png"
        }else{
            //Para los alumnos
            $directoryName = '../img/profilePhotos/';
        } 
        $fileRoute = $directoryName . $fileName;
        if (move_uploaded_file($_FILES['photoPath']['tmp_name'], $fileRoute)) {         
            return $fileRoute;
        } else {
            return "No se ha podido subir el fichero";
        }
    } else {
        return "No se ha subido ningún archivo";
    }
}
?>