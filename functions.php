<?php
    function printHeader($rol) {
        echo "<header class='header'>";
        switch($rol) {
            case "N":
                echo "<a href='index.php' class='headerLogo'><img src='img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
                echo "<p class='menu1'>Learning Academy</p>";
                echo "<a href='signin.php' class='Signin'>Sign in</a>";
                echo "<a href='signup.php' class='Signup'>Sing up</a>";
                break;
            case "A":
                echo "<a href='index.php' class='headerLogo'><img src='img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
                echo "<a href='student.php' class='menu1'>Admin panel</a>";
                echo "<a href='close.php' class='logout'>Log out</a>";
                break;
            case "S":
                echo "<a href='index.php' class='headerLogo'><img src='img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
                echo "<a href='student.php' class='menu1'>Student panel</a>";
                echo "<a href='close.php' class='logout'>Log out</a>";
                break;
            case "T":
                echo "<a href='index.php' class='headerLogo'><img src='img/logo.png' alt='the academy logo, the earth with a book under it'></a>";
                echo "<a href='student.php' class='menu1'>Teacher panel</a>";
                echo "<a href='close.php' class='logout'>Log out</a>";
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

    function validateUser() {
        if(!empty($_POST)){
            // Cambiar el nombre de la bd segun convenga
            if(connectBD("learningacademy", $connection)){
                // Cambiar el nombre de la tabla segun convenga
                $sql = "SELECT * FROM users";
    
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
                                $_SESSION['role'] = $row['role'];

                                header('Location: index.php');
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
    
    function no_validado() {
        echo "<div class='container'>";
        echo "<h1 class='no_val'>Necesitas estar validado para ver esta pagina</h1>";
        echo "</div>";
        header("Refresh: 5; URL='cerrar.php'");
    }
?>