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
    <script src="./files/scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
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
                    } else {
                        $canJoin = isset($_SESSION['role']) && $_SESSION['role']=="S" ? 1 : 0;
                        
                        $unaviableCourses = array();
                        $unaviableCourses = array_merge($unaviableCourses, unavailableCourses());
                        if(isset($_SESSION['dniStudent'])) {
                            $unaviableCourses = array_merge($unaviableCourses, coursesJoined($_SESSION['dniStudent']));
                        }
                        $dni = isset($_SESSION['dniStudent']) ? $_SESSION['dniStudent'] : "0";
                        foreach ($result as $key => $curso) {
                            if (in_array($curso['courseId'], $unaviableCourses)) {
                                unset($result[$key]);
                            }
                        }
                        if(empty($result)){
                            echo "<div class='noCourses'>";
                            echo "<h1>There are no courses avaliable right now</h1>";
                            echo "</div>";
                        } else {
                            foreach ($result as $course) {
                                $isAvailable = in_array($course['courseId'], $unaviableCourses) ? false : true;
                                if($isAvailable){
        
                                    echo "<div class='flip-card'>";
                                    echo "  <div class='flip-card-inner'>";
                                    echo "      <div class='flip-card-front'>";
                                    echo "          <img src='{$course['photoPath']}'>";
                                    echo "      </div>";
                                    echo "      <div class='flip-card-back'>";
                                    echo "          <h1>{$course['name']}</h1>";
                                    echo "          <p>{$course['description']}</p>";
                                    echo "          <button class='whiteBtn' onclick='joinFunction($canJoin, {$course['courseId']}, `$dni`)'>Join !</button>";
                                    echo "      </div";
                                    echo "  </div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </div>
    <script src="files/scripts.js"></script>
</body>
</html>