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
    <script src="../files/scripts.js"></script>
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
                            echo "<p class='pCourseName'>{$course['name']}</p>";
                            
                        ?>
                                <div class="tabs-container tabsPopup">
                                    <div class="tabsLine">
                                        <div class="tab selected" id="t1" onclick="openTab(1)">Pestaña 1</div>
                                        <div class="tab" id="t2" onclick="openTab(2)">Pestaña 2</div>
                                        <div class="tab" id="t3" onclick="openTab(3)">Pestaña 3</div>
                                        <div class="tab" id="t4" onclick="openTab(4)">Pestaña 4</div>
                                        <div class="tab" id="t5" onclick="openTab(5)">Pestaña 5</div>
                                    </div>
                                    <div class="tabWindow">
                                        <div class="tab-content" id="tab1" style="z-index: 1;">Contenido de la Pestaña 1</div>
                                        <div class="tab-content" id="tab2" style="z-index: 0;">Contenido de la Pestaña 2</div>
                                        <div class="tab-content" id="tab3" style="z-index: 0;">Contenido de la Pestaña 3</div>
                                        <div class="tab-content" id="tab4" style="z-index: 0;">Contenido de la Pestaña 4</div>
                                        <div class="tab-content" id="tab5" style="z-index: 0;">Contenido de la Pestaña 5</div>
                                    </div>
                                    
                                </div>

                        <?php
                            
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
    <script>
        //window.onload=addEvents;
    </script>
  
</body>
</html>