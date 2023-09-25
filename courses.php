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

        if(isset($_REQUEST['insert'])) {
            $sql = "INSERT INTO matriculates (dniStudent, courseId) VALUES ('{$_REQUEST['dniStudent']}', {$_REQUEST['courseId']})";
            echo $sql;
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
    <h1 class="title">Our courses</h1>
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
                        foreach ($result as $course) {
                            $buttonDisabled = in_array($course['courseId'], $unaviableCourses) ? true : false;

                            echo "<div class='course' onclick='openPopup(this)'>";

                            echo "<figure class='hidden'>";
                            echo "<img src='{$course['photoPath']}'>";
                            echo "<figcaption>Click here to see more info!</figcaption>";
                            echo "</figure>";

                            echo "<p>{$course['name']}</p>";
                            if($buttonDisabled) echo "<button disabled class='courseButton disabled' onclick='enrollFunction($canJoin, {$course['courseId']})'>Enroll !</button>";
                            else echo "<button class='courseButton' onclick='enrollFunction($canJoin, {$course['courseId']})'>Enroll !</button>";

                            echo "<div class='hiddenContent'>";
                            echo "<p class='pCourseName'>{$course['name']}</p>";
                            echo "<p class='pDateLabel'>Start - End</p>";
                            echo "<p class='pDate'>{$course['startDate']} / {$course['endDate']}</p>";

                            if($buttonDisabled) echo "<p class='pButton'>The end date of this course alreafy finished</p>";
                            else echo "<button class='courseButton pButton' onclick='enrollFunction($canJoin, {$course['courseId']})'>Enroll !</button>";

                            echo "<p class='pDesc'>{$course['description']}</p>";
                            echo "</div>";
                            
                            echo "</div>";
                            echo "<div class='popup'>";
                            echo "<div class='popup-content'></div>";   
                            echo "</div>";
                        }
                    }
                }
            }
        ?>
    </div>
    <script src="files/scripts.js">
        function enrollFunction(action, courseId) {
            if (action == 0) {
                let wantLogin = confirm("You must be a student to enroll on this course, want to log in as a student?");
                if(wantLogin) location.href = "/Learning-Academy/close.php";
            } else if (action == 1) {
                let confirmEnroll = confirm("You want to enroll on this course?");
                <?php $dni = isset($_SESSION['dniStudent']) ? $_SESSION['dniStudent'] : "dni";?>
                if(confirmEnroll) location.href = "/Learning-Academy/courses.php?insert=1&dniStudent=<?php echo $dni;?>&courseId="+courseId;
            }
        }
    </script>
</body>
</html>