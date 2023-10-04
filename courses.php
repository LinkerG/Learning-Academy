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
            if(connectBD("learningacademy", $connection)){
                $action = insertSQL($connection, $sql);
                if($action == 0) {
                    echo "<script>alert('You enrolled correctly in this course!')</script>";
                } else if($action == 1062) {
                    echo "<script>alert('You are already enrolled in this course')</script>";
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
                        
                        $unaviableCourses = unavailableCourses();
                        $dni = isset($_SESSION['dniStudent']) ? $_SESSION['dniStudent'] : "0";
                        foreach ($result as $course) {
                            $buttonDisabled = in_array($course['courseId'], $unaviableCourses) ? true : false;

                            echo "<div class='course'>";

                            echo "<figure class='hidden' onclick='openPopup(this)'>";
                            echo "<img src='{$course['photoPath']}'>";
                            echo "<figcaption>Click here to see more info!</figcaption>";
                            echo "<div class='hiddenContent'>";
                            echo "<p class='pCourseName'>{$course['name']}</p>";
                            echo "<p class='pDateLabel'>Start - End</p>";
                            echo "<p class='pDate'>{$course['startDate']} / {$course['endDate']}</p>";

                            if($buttonDisabled) echo "<p class='pButton'>The end date of this course alreafy finished</p>";
                            else echo "<button class='courseButton pButton blueBtn' onclick='enrollFunction($canJoin, {$course['courseId']}, `$dni`)'>Enroll !</button>";

                            echo "<p class='pMain'>{$course['description']}</p>";
                            echo "</div>";
                            
                            
                            
                            echo "</figure>";

                            echo "<p>{$course['name']}</p>";
                            if($buttonDisabled) echo "<button disabled class='courseButton disabled witheBtn' onclick='enrollFunction($canJoin, {$course['courseId']}, `$dni`)'>Enroll !</button>";
                            else echo "<button class='courseButton witheBtn' onclick='enrollFunction($canJoin, {$course['courseId']}, `$dni`)'>Enroll !</button>";

                            echo "</div>";
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