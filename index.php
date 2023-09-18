<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Academy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        include('functions.php');

        if(!isset($_SESSION['role'])) {
            $role = 'N';
        } else {
            $role = $_SESSION['role'];
        }

        printHeader($role);
        
    ?>
    <h1>Página principal</h1>
</body>
</html>