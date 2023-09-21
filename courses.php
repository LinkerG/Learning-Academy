<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        include ("functions.php");
        printHeader();
    ?>
    
    <div class="container">
        <?php
            if(connectBD("learningacademy", $connection)) {
                $sql = "SELECT * FROM course;";
                if(selectSQL($connection, $sql, $result)){
                    if(empty($result)) {
                        echo "<div>";
                        echo "<h1>There are no courses avaliable right now</h1>";
                        echo "</div>";
                        echo "<a>";
                    } else {
                        $canJoin = isset($_SESSION['role']) && $_SESSION['role']=="S" ? 1 : 0;
                        
                        foreach ($result as $course) {
                            echo "<div class='course'>";
                            echo "<img src='{$course['photoPath']}'>";
                            echo "<p>{$course['name']}<p>";
                            echo "<button onclick='enrollFunction($canJoin)'>Enroll!</button>";
                            echo "</div>";
                        }
                    }
                }
            }
        ?>
    </div>
    
</body>
</html>