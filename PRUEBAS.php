<?php
include("functions.php");
if(connectBD("learningacademy",$connection)){
    $campos = fieldsSQL($connection,"teacher");
    print_r($campos);
    $campos_str = implode(', ',$campos);

}

?>