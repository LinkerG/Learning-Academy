<?php
if(isset($_POST)){
    echo "SIUUU";
    print_r($_POST);
    $dataJSON = file_get_contents('php://input');
    $arrayData = json_decode($dataJSON, true);
    print_r($arrayData);
}
?>