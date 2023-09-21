<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <?php 
        session_start();
        include ("functions.php");
    ?>
</head>
<body>
    <?php
        if(!isset($_SESSION['role'])) {
            $role = 'N';
        } else {
            $role = $_SESSION['role'];
        }
        printHeader($role);
    ?>
    <div class="container">
        <?php
            $sql = "SELECT COUNT(*) as total FROM courses;";
            if(selectSQL($connection, $sql, $result)){
                if(empty($result)) {
                    echo "<div>";
                    echo "<h1>You aren't in any course</h1>";
                    echo "</div>";
                    echo "<a>";
                } else {
                    print_r($result);
                }
            }
        ?>
    </div>
    
</body>
</html>