<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="PruebaJS.js"></script>
</head>
<body>
<?php
    if(isset($_POST['nums'])){
        echo "hola";
        $json = json_decode($_POST['nums']);
        //var_dump($json);
        echo implode($json);
    }else{
?>
    <button onclick="cargarDatos()">Click aqui</button>
<?php
    }
?>
</body>
</html>