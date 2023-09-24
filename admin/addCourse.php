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

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "A") {
            include("needAdmin.html");
            header("Refresh: 5; URL='close.php'");
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
                if($_FILES['photoPath']['error'] == 4){
                    $_POST['photoPath']="/Learning-Academy/img/coursePhotos/default.png";
                }else{
                    $_POST['photoPath'] = uploadPhoto(2);
                } 
                
                $sql = "INSERT INTO course (name, hours, startDate, endDate, description, dniTeacher, active, photoPath) 
                VALUES ('{$_POST['name']}','{$_POST['hours']}','{$_POST['startDate']}', '{$_POST['endDate']}','{$_POST['description']}','{$_POST['dniTeacher']}', '1','{$_POST['photoPath']}')";

                $action = insertSQL($connection, $sql);
                if($action == 0) {
                    echo "<script>alert('Course added correctly')</script>";
                    header('Location: courses.php');
                }
                
            }
        }
    ?>
    <form enctype ="multipart/form-data" action="#" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">

        <label for="hours">Hours:</label>
        <input type="number" name="hours" id="hours">

        <label for="startDate">Start date:</label>
        <input type="date" name="startDate" id="startDate" min="<?php echo date("Y-m-d") ?>">

        <label for="endDate">End date:</label>
        <input type="date" name="endDate" id="endDate" min="<?php echo date("Y-m-d") ?>">

        <label for="description">Description</label>
        <input type="text" name="description" id="description">

        <label for="dniTeacher">Teacher DNI:</label>
        <input type="text" name="dniTeacher" id="dniTeacher" required>

        <label for="photoPath">Photo:</label>
        <input type="file" name="photoPath" id="photoPath">

        <input type="submit" value="Add">
    </form>
    <a href="courses.php">Cancel</a>
</body>
</html>