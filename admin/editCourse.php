<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new course</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        include("../functions.php");

        if(isset($_REQUEST['active'])){
            $active = $_REQUEST['active'] == 0 ? 1 : 0;
            $sql = "UPDATE course SET active={$active} WHERE courseId ='{$_REQUEST['courseId']}'";

            if(connectBD("learningacademy", $connection)) {
                updateSQL($connection, $sql);
                header("Refresh: 0; URL='courses.php'");
            }
        } else if(isset($_REQUEST['courseId'])){
            if(connectBD("learningacademy", $connection)){
                $sql = "SELECT * FROM course WHERE courseId='{$_REQUEST['courseId']}'";
                if(selectSQL($connection, $sql, $result));
            }
        }
        $result = $result[0];
        print_r($result);
        if(!empty($_POST)){
            if(!isset($_POST['photoPath'])){
                if(connectBD("learningacademy",$connection)){
                    $sql = "UPDATE course SET name='{$_POST['name']}', hours='{$_POST['hours']}', startDate='{$_POST['startDate']}', endDate='{$_POST['endDate']}', dniTeacher='{$_POST['dniTeacher']}' WHERE courseId='{$_POST['courseId']}';";
                    
                    updateSQL($connection, $sql);
                    header("Refresh: 0; URL='editCourse.php'");
                }
            }else{
                $_POST['photoPath'] = uploadPhoto(true);
                if(connectBD("learningacademy",$connection)){
                    $sql = "UPDATE course SET name='{$_POST['name']}', hours='{$_POST['hours']}', startDate='{$_POST['startDate']}', endDate='{$_POST['endDate']}', dniTeacher='{$_POST['dniTeacher']}', photoPath='{$_POST['photoPath']}' WHERE courseId='{$_POST['courseId']}';";
                    
                    updateSQL($connection, $sql);
                    header("Refresh: 0; URL='courses.php'");
                }
            } 
        }

    ?>
    <form enctype="multipart/form-data" action="#" method="post">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value=<?php echo "'{$result['name']}'";?>>
    <label for="hours">Hours</label>
    <input type="hours" name="hours" id="hours" value=<?php echo "'{$result['hours']}'";?>>
    <label for="startDate">Start date</label>
    <input type="date" name="startDate" id="startDate" value=<?php echo "'{$result['startDate']}'";?>>
    <label for="endDate">end date</label>
    <input type="date" name="endDate" id="endDate" value=<?php echo "'{$result['endDate']}'";?>>
    <label for="dniTeacher">DNI teacher</label>
    <input type="number" name="dniTeacher" id="dniTeacher" value=<?php echo "'{$result['dniTeacher']}'";?>>
    <input type="hidden" value=<?php echo "'{$result['courseId']}'";?>>
    <input type="submit" value="Update">
    </form>
    <a href="courses.php">Back</a>
</body>
</html>