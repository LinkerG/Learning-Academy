<!DOCTYPE html>
<html lang="en">
<?php
    include ("../functions.php"); 
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <script src="../files/scripts.js"></script>
    <title>Student courses</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
</head>
<body>
    <?php
    if(!isset($_SESSION['role']) || $_SESSION['role'] != "S") {
        printHeader("../");
        include("needStudent.html");
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=../close.php'>";
    } else {
        printHeader("../");
    
    $hasPrize = false;
    if (connectBD("id21353268_learningacademy", $connection)) {
        $prizeSQL = "SELECT prize FROM student WHERE dniStudent = '" . $_SESSION['dniStudent'] . "';";

                if(selectSQL($connection, $prizeSQL, $prizeQuery)){
                    if ($prizeQuery[0]['prize'] == "no prize" && isset($_REQUEST['prize'])){
                        $update = "UPDATE student SET prize = '" . $_REQUEST['prize'] . "' WHERE dniStudent = '" . $_SESSION['dniStudent'] . "'";
                        updateSQL($connection, $update);
                        $hasPrize = true;
                    }
                    else if ($prizeQuery[0]['prize'] != "no prize") $hasPrize = true;
                }
    }
    if(connectBD("id21353268_learningacademy", $connection)) {
        $sql = "SELECT m.task1,m.task2,m.task3,m.task4,m.score,c.endDate,c.name,c.photoPath,m.courseId FROM matriculates m INNER JOIN course c ON c.courseId = m.courseId INNER JOIN student s ON s.dniStudent = m.dniStudent WHERE s.dniStudent = '" . $_SESSION['dniStudent'] . "' ;";
        selectSQL($connection,$sql,$result);
    }

    if(isset($_REQUEST['delete'])){
        $dni = $_REQUEST["dni"];
        $courseId = $_REQUEST['id'];
    
        if(connectBD("id21353268_learningacademy", $connection)) {
            $sql = "DELETE FROM matriculates WHERE dniStudent = '" . $dni . "' AND courseId = '" . $courseId . "';";
            updateSQL($connection, $sql);
            echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php'>";
        }
    }    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        for($i = 1; $i < 5;$i++){
            if(isset($_FILES['task'.$i])){
                $msg = uploadPdf($_POST['courseId'],$connection,$i); 
            }
        }
        echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php'>";
        echo "<script>alert($msg);</script>";
    }else{
    ?>
    <?php
          
        echo "<div class='top'>";
        echo "<div>";
        echo "<h1>Welcome " . $_SESSION['name'] . " " . $_SESSION['surname'] . "</h1>";
        echo "<a class='whiteBtn' href='profile.php'>Edit profile</a>";
        echo "</div>";
        echo "<h2>This are your courses right now</h2>";
        echo "</div>";
    ?>
    <div class="courseContainer">
    <?php
        if(empty($result)) {
            echo "<div>";
            echo "<h1 style='color:white;'>You aren't in any course</h1>";
            echo "<a style='color:white;' href=".'../courses.php'.">enter on any of our courses!</a>";
            echo "</div>";
        } else {
            foreach ($result as $course){
                    echo "<div class='course' onclick='openPopup(this)'>";

                    echo "<figure class='hidden'>";
                    echo "<img alt='photo of the course' src='../{$course['photoPath']}'>";
                    echo "<figcaption></figcaption>";
                    echo "</figure>";
                    echo "<p>{$course['name']}</p>";

                    echo "<div class='hiddenContent'>";
                    echo "<p class='pCourseName'>{$course['name']}</p>";
                    $dniStudent = $_SESSION['dniStudent'];
                    $currentCourseId = $course['courseId'];
                    $finished = strtotime($course['endDate'])<strtotime(date("Y-m-d")) ? true : false;
                    if(!$finished) echo "<button class='blueBtn' onclick='baja(`$dniStudent`,`$currentCourseId`)'>Leave course</button>";
                    else echo "<p>This course already finished</p>"
                    
                ?>
                        <div class="tabs-container tabsPopup">
                            <div class="tabsLine">
                                <div class="tab selected" id="t1" onclick="openTab(1)">Summary</div>
                                <div class="tab" id="t2" onclick="openTab(2)">Task 1</div>
                                <div class="tab" id="t3" onclick="openTab(3)">Task 2</div>
                                <div class="tab" id="t4" onclick="openTab(4)">Task 3</div>
                                <div class="tab" id="t5" onclick="openTab(5)">Task 4</div>
                            </div>
                            <div class="tabWindow">
                                <div class="tab-content selected" id="tab1">
                                    <ul>
                                        <?php
                                            $task1 = $course['task1'] == null ? "X" : "O";
                                            echo "<li>Task 1: $task1</li>";
                                            $task2 = $course['task2'] == null ? "X" : "O";
                                            echo "<li>Task 2: $task2</li>";
                                            $task3 = $course['task3'] == null ? "X" : "O";
                                            echo "<li>Task 3: $task3</li>";
                                            $task4 = $course['task4'] == null ? "X" : "O";
                                            echo "<li>Task 4: $task4</li>";
                                            $score = $course['score'] == null ? "No score" : $course['score'];
                                            echo "<li>Score: $score</li>";
                                        ?>
                                    </ul>
                                </div>
                                <?php
                                    for ($i = 1; $i < 5; $i++) { 
                                        $task = "task" . $i;
                                        $tabid = "tab".($i+1);
                                        $taskStatus = $course[$task]==null ? false : true;
                                        $formId = "form" .$i;
                                        echo "<div class='tab-content' id='$tabid'>";
                                        echo "<div>";
                                        echo "<p>Task $i</p>";
                                        if($taskStatus) {
                                            echo "<p>Already uploaded</p>";
                                            echo "</div>";
                                            echo "<div>";
                                            echo "<p>Your task:</p>";
                                            echo "<a href='{$course[$task]}'>See your taks</a>";
                                            if(!$finished){
                                                echo "<input type='checkbox' class='showCheck' onchange='checkboxShow(`$formId`)'> Change task";
                                                echo "<form enctype ='multipart/form-data' action='index.php' method='POST' id='$formId' name='form$i'>";
                                                echo "<input type='file' name='$task' id='$task'>";
                                                echo "<input type='hidden' name='courseId' value='{$course['courseId']}'>";
                                                echo "<input type='submit' value='Save changes'>";
                                                echo "</form>";
                                            }
                                        } else {
                                            echo "<p>Not uploaded</p>";
                                            echo "</div>";
                                            echo "<div>";
                                            if(!$finished) {
                                                echo "<p>Upload your task:</p>";
                                                echo "<form enctype ='multipart/form-data' action='index.php' method='POST' id='$formId' name='form$i' class='noHide'>";
                                                echo "<input type='file' name='$task' id='$task'>";
                                                echo "<input type='hidden' name='courseId' value='{$course['courseId']}'>";
                                                echo "<input type='submit' value='Save changes'>";
                                                echo "</form>";
                                            } else {
                                                echo "<p>Course finished, you cant upload your task</p>";
                                            }
                                        }
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                ?>
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
    ?>
    </div>
    <script>
        window.onload = hideForms;
        <?php
            if(!$hasPrize){
                echo "windowPosition('roulette.php');audioRoulette();";
            }
        ?>
    </script>
    <?php
    }
}
    ?>
</body>
</html>