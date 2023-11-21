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
    <script src="../files/validateForms.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            printHeader("../");
            include("needAdmin.html");
            header("Refresh: 5; URL='../close.php'");
            
        } else {
            printHeader("../");
           
            if(!empty($_POST)){
                // Validacion de datos
                $continue = true;
                if($_POST['endDate']<date("Y-m-d")) {
                    echo "<script>alert('A course cannot end on a date that already passed')</script>";
                    $continue = false;
                }
                if(strtotime($_POST["endDate"])<strtotime($_POST["startDate"])) {
                    echo "<script>alert('The end date cannot be lower than the start date')</script>";
                    $continue = false;
                }

                // Insert
                if(isset($_FILES['photoPath'])){
                    if(connectBD("id21353268_learningacademy",$connection) && $continue){
                        $uploadPhoto = uploadPhoto(2, $route, false, getNextCourseId($connection));
                        if($uploadStatus == 0){
                            $sql = "INSERT INTO course (name, hours, startDate, endDate, description, dniTeacher, active, photoPath) 
                            VALUES ('{$_POST['nameAddCourse']}','{$_POST['hours']}','{$_POST['startDate']}', '{$_POST['endDate']}','{$_POST['description']}','{$_POST['dniTeacher']}', '1','$route')";
    
                            $action = insertSQL($connection, $sql);
                            if($action == 0) {
                                echo "<script>alert('Course added correctly')</script>";
                                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=courses'>";
                            }
                        } elseif ($uploadStatus == 1) {
                            echo "<script>alert('Error uploading photo')</script>";
                        } elseif ($uploadStatus == 2) {
                            echo "<script>alert('Please upload a photo')</script>";
                        }
                    }
                } else {
                    print_r($_POST);
                    if(connectBD("id21353268_learningacademy",$connection) && $continue){
                        $sql = "INSERT INTO course (name, hours, startDate, endDate, description, dniTeacher, active, photoPath) 
                        VALUES ('{$_POST['nameAddCourse']}','{$_POST['hours']}','{$_POST['startDate']}', '{$_POST['endDate']}','{$_POST['description']}','{$_POST['dniTeacher']}', '1','img/coursePhotos/default.png')";
        
                        $action = insertSQL($connection, $sql);
                        if($action == 0) {
                            echo "<script>alert('Course added correctly')</script>";
                            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?manage=courses'>";
                        }
                    }
                }
            }
    ?>
    <div class="formDiv">
        <form enctype ="multipart/form-data" action="#" method="POST" onsubmit="return validateForm(fields)">
            <div class="formRow">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" maxlength="25" name="nameAddCourse" id="name">
                </div>
                <div>
                    <label for="hours">Hours:</label>
                    <input required type="number" max="200" min="1" name="hours" id="hours">
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="startDate">Start date:</label>
                    <input type="date" name="startDate" id="startDate" min="<?php echo date("Y-m-d") ?>">
                </div>
                <div>
                    <label for="endDate">End date:</label>
                    <input type="date" name="endDate" id="endDate" min="<?php echo date("Y-m-d") ?>">
                </div>
            </div>
            <div class="formRow">
                <div>   
                    <label for="description">Description</label>
                    <input type="text" maxlength="20" name="description" id="description">
                </div>
                <div>
                    <label for="dniTeacher">Teacher DNI:</label>
                    <select name="dniTeacher" required>
                        <?php
                        $sql= "SELECT dniTeacher,name,surname FROM teacher";
                        if(connectBD("id21353268_learningacademy", $connection)) {
                            if(selectSQL($connection, $sql,$result)){
                                foreach($result as $teachersInfo){
                                    echo "<option value={$teachersInfo['dniTeacher']}>".$teachersInfo['name']." {$teachersInfo['surname']}</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="photoPath">Photo:</label>
                    <input type="file" name="photoPath" id="photoPath">
                </div>
                <div>
                    <input class="whiteBtn" type="submit" value="Add">
                    <a class="whiteBtn" href="index.php?manage=courses">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <?php
    $fields = array(
        array('id' => 'name', 'name' => 'nameAddCourse', 'type' => 'text', 'label' => 'name'),
        array('id' => 'description', 'name' => 'description', 'type' => 'text', 'label' => 'description'),
        array('id' => 'startDate', 'name' => 'startDate', 'type' => 'date', 'label' => 'startDate'),
        array('id' => 'endDate', 'name' => 'endDate', 'type' => 'date', 'label' => 'endDate')
    );
    ?>
    <script> var fields = <?php echo json_encode($fields); ?>; </script>
    <?php
        }
    ?>
</body>
</html>