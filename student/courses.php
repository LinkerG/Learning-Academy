<!DOCTYPE html>
<html lang="en">
<?php
    include ("../functions.php"); 
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Student courses</title>
</head>
<body>
    <?php
        if(!isset($_SESSION['role']) || $_SESSION['role'] != "S") {
            include("needStudent.html");
            header("Refresh: 5; URL='close.php'");
            exit;
        } else {
            printHeader();
        }   
        echo "<h1>Welcome " . $_SESSION['name'] . " " . $_SESSION['surname'] . "</h1>";
        echo "<h2>This are your courses right now</h2>";
    ?>
    <div class="courseContainer">
    <?php
        if(connectBD("learningacademy", $connection)) {
            $sql = "SELECT m.task1,m.task2,m.task3,m.task4,m.score,c.endDate,c.name,c.photoPath,m.courseId FROM matriculates m INNER JOIN course c ON c.courseId = m.courseId INNER JOIN student s ON s.dniStudent = m.dniStudent WHERE s.dniStudent = '" . $_SESSION['dniStudent'] . "' ;";
        }
            if(selectSQL($connection, $sql, $result)){
                if(empty($result)) {
                    echo "<div>";
                    echo "<h1>You aren't in any course</h1>";
                    echo "<a src=".'../courses.php'.">enter on any of our courses!</a>";
                    echo "</div>";
                } else {
                    foreach ($result as $course){
                            echo "<div class='course' onclick='openPopup(this)'>";

                            echo "<figure class='hidden'>";
                            echo "<img src='{$course['photoPath']}'>";
                            echo "<figcaption>Hola</figcaption>";
                            echo "</figure>";

                            echo "<p>{$course['name']}</p>";

                            echo "<div class='hiddenContent'>";
                            echo "<h1>{$course['name']}</h1>";
                            echo "<div class='courseForm'>";
                        ?>
                                <div class="window-container">
                                    <div class="windows">
                                        <button class="window" onclick="showWindow(0)">Results</button>
                                        <button class="window" onclick="showWindow(1)">Task 1</button>
                                        <button class="window" onclick="showWindow(2)">Task 2</button>
                                        <button class="window" onclick="showWindow(3)">Task 3</button>
                                        <button class="window" onclick="showWindow(4)">Task 4</button>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="window-content">Resultado</div>
                                    <div class="window-content">Contenido 1</div>
                                    <div class="window-content">Contenido 2</div>
                                    <div class="window-content">Contenido 3</div>
                                    <div class="window-content">Contenido 4</div>
                                </div>
                        <?php
                            echo "</div>";
                            echo "</div>";
                            
                            echo "</div>";
                            echo "<div class='popup'>";
                            echo "<div class='popup-content'></div>";   
                            echo "</div>";
                    }
                }
            }
    ?> 
    </div>
    <script src="../files/scripts.js"></script>
</body>
</html>