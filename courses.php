<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include ("functions.php");
        printHeader();

        if(isset($_REQUEST['insert'])) {
            $sql = "INSERT INTO matriculates (dniStudent, courseId) VALUES ('{$_REQUEST['dniStudent']}', {$_REQUEST['courseId']})";
            if(connectBD("id21353268_learningacademy", $connection)){
                $action = insertSQL($connection, $sql);
                if($action == 0) {
                    echo "<script>alert('You joined correctly in this course!')</script>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=student/index.php'>";
                } else if($action == 1062) {
                    echo "<script>alert('You are already joined in this course')</script>";
                } else {
                    echo "<script>alert('$action')</script>";
                }
            }
                
        }
    ?>
    <div class="top">
        <h1 class="title">Our courses</h1>
        <p class="subtitle">Here is a collection of all our courses</p>
    </div>
    
    <div class="courseContainer">
        <?php
            if(connectBD("id21353268_learningacademy", $connection)) {
                $sql = "SELECT * FROM course;";
                if(selectSQL($connection, $sql, $result)){
                    if(empty($result)) {
                        echo "<div>";
                        echo "<h1>There are no courses avaliable right now</h1>";
                        echo "</div>";
                        echo "<a>";
                    } else {
                        $canJoin = isset($_SESSION['role']) && $_SESSION['role']=="S" ? 1 : 0;
                        
                        $unaviableCourses = unavailableCourses();
                        if(isset($_SESSION['dniStudent'])) {
                            array_push($unaviableCourses, coursesJoined($_SESSION['dniStudent']));
                        }
                        $dni = isset($_SESSION['dniStudent']) ? $_SESSION['dniStudent'] : "0";
                        foreach ($result as $course) {
                            $isAvailable = in_array($course['courseId'], $unaviableCourses) ? false : true;
                            if($isAvailable){
                                echo "<div class='course'>";
    
                                echo "<figure class='hidden' onclick='openPopup(this)'>";
                                echo "<img src='{$course['photoPath']}'>";
                                echo "<figcaption>Click here to see more info!</figcaption>";
                                echo "<div class='hiddenContent'>";
                                echo "<p class='pCourseName'>{$course['name']}</p>";
                                echo "<p class='pDateLabel'>Start - End</p>";
                                echo "<p class='pDate'>{$course['startDate']} / {$course['endDate']}</p>";
    
                                echo "<button class='courseButton pButton blueBtn' onclick='joinFunction($canJoin, {$course['courseId']}, `$dni`)'>Join !</button>";
    
                                echo "<p class='pMain'>{$course['description']}</p>";
                                echo "</div>";
                                
                                
                                
                                echo "</figure>";
    
                                echo "<p>{$course['name']}</p>";
                                echo "<button class='courseButton whiteBtn' onclick='joinFunction($canJoin, {$course['courseId']}, `$dni`)'>Join !</button>";
    
                                echo "</div>";
                            }
                        }
                        echo "<div class='popup'>";
                            echo "<div class='popup-content'></div>";   
                            echo "</div>";
                    }
                }
            }
        ?>
    </div>
    <script src="files/scripts.js"></script>
</body>
</html>