<?php
include("functions.php");
if(connectBD("learningacademy",$connection)){
    insertSQL($connection,"teacher");
}

?>