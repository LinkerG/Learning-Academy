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
    <link rel="icon" type="image/x-icon" href="/img/favicon.png">
</head>
<body>
    <?php
        include("../functions.php");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            printHeader();
            include("needAdmin.html");
            header("Refresh: 5; URL='/Learning-Academy/close.php'");
            exit;
        } else {
            printHeader();
        }   
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
            if(connectBD("learningacademy",$connection) && $continue){
                $uploadStatus = uploadPhoto(2, $route);
                if($uploadStatus == 0){
                    $sql = "INSERT INTO course (name, hours, startDate, endDate, description, dniTeacher, active, photoPath) 
                    VALUES ('{$_POST['name']}','{$_POST['hours']}','{$_POST['startDate']}', '{$_POST['endDate']}','{$_POST['description']}','{$_POST['dniTeacher']}', '1','$route')";
    
                    $action = insertSQL($connection, $sql);
                    if($action == 0) {
                        echo "<script>alert('Course added correctly')</script>";
                        header('Location: index.php?manage=courses');
                    }
                } elseif ($uploadStatus == 1) {
                    echo "<script>alert('Error uploading photo')</script>";
                } elseif ($uploadStatus == 2) {
                    echo "<script>alert('Please upload a photo')</script>";
                }
            }
        }
    ?>
    <div class="formDiv">
        <form enctype ="multipart/form-data" action="#" method="POST">
            <div class="formRow">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name">
                </div>
                <div>
                    <label for="hours">Hours:</label>
                    <input type="number" name="hours" id="hours">
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
                    <input type="text" name="description" id="description">
                </div>
                <div>
                    <label for="dniTeacher">Teacher DNI:</label>
                    <select name="dniTeacher" required>
                        <?php
                        $sql= "SELECT dniTeacher,name,surname FROM teacher";
                        if(connectBD("learningacademy", $connection)) {
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
                    <input class="witheBtn" type="submit" value="Add">
                </div>
            </div>
        </form>
        <a class="witheBtn" href="index.php?manage=courses">Cancel</a>
    </div>
</body>
</html>