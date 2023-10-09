<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new course</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            printHeader();
            include("needAdmin.html");
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=/Learning-Academy/close.php'>";
        } else {
            printHeader();

        if(isset($_REQUEST['active'])){
            $active = $_REQUEST['active'] == 0 ? 1 : 0;
            $sql = "UPDATE course SET active={$active} WHERE courseId ='{$_REQUEST['courseId']}'";

            if(connectBD("id21353268_learningacademy", $connection)) {
                updateSQL($connection, $sql);
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=courses'>";
            }
        } else if(isset($_REQUEST['courseId'])){
            if(connectBD("id21353268_learningacademy", $connection)){
                $sql = "SELECT * FROM course WHERE courseId='{$_REQUEST['courseId']}'";
                if(selectSQL($connection, $sql, $result)) $result = $result[0];
            }
        }
        

        if(!empty($_POST)){
            if(!isset($_POST['photoPath'])){
                if(connectBD("id21353268_learningacademy",$connection)){
                    $sql = "UPDATE course SET name='{$_POST['name']}', hours='{$_POST['hours']}', startDate='{$_POST['startDate']}', endDate='{$_POST['endDate']}', description='{$_POST['description']}', dniTeacher='{$_POST['dniTeacher']}' WHERE courseId='{$_POST['courseId']}';";
                    
                    updateSQL($connection, $sql);
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=courses'>";
                }
            }else{
                $uploadStatus = uploadPhoto(3, $route, false, $_POST['courseId']);
                if(connectBD("id21353268_learningacademy",$connection)){
                    $sql = "UPDATE course SET name='{$_POST['name']}', hours='{$_POST['hours']}', startDate='{$_POST['startDate']}', endDate='{$_POST['endDate']}', description='{$_POST['description']}', dniTeacher='{$_POST['dniTeacher']}', photoPath='$route' WHERE courseId='{$_POST['courseId']}';";
                    
                    updateSQL($connection, $sql);
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=courses'>";
                }
            } 
        }
        
        ?>
    <div class="formDiv">
        <form enctype="multipart/form-data" action="#" method="post">
            <div class="formRow">
                <div>
                    <label for="courseId">Course ID</label>
                    <input type="text" readonly name="courseId" id="courseId" value="<?php echo "{$result['courseId']}";?>">
                </div>
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo "{$result['name']}";?>">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="hours">Hours</label>
                    <input type="number" name="hours" id="hours" value="<?php echo "{$result['hours']}";?>">
                </div>
                <div>
                    <label for="dniTeacher">DNI teacher</label>
                    <input type="text" name="dniTeacher" id="dniTeacher" value="<?php echo "{$result['dniTeacher']}";?>">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="startDate">Start date</label>
                    <input type="date" name="startDate" id="startDate" value="<?php echo "{$result['startDate']}";?>">
                </div>
                <div>
                    <label for="endDate">End date</label>
                    <input type="date" name="endDate" id="endDate" value="<?php echo "{$result['endDate']}";?>">
                </div>
            </div>
            <div class="formRow">
                <div class="singleRow">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" value="<?php echo "{$result['description']}"; ?>">
                </div>
            </div>
            <div class="formActions">
                <input class="whiteBtn" type="submit" value="Update">
                <a class="whiteBtn" href="index.php?manage=courses">Back</a>
            </div>
        </form>
    </div>
    <?php
        }
    ?>
</body>
</html>