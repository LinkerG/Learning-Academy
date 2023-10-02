<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../files/scripts.js"></script>
</head>
<body>
    <?php
        include("../functions.php");

        if(isset($_SESSION['role']) && $_SESSION['role'] == "S") {
            printHeader();
            $hasPrize = false;
            if(connectBD("learningacademy", $connection)) {
                $sql = "SELECT prize FROM student WHERE dniStudent = '" . $_SESSION['dniStudent'] . "';";

                if(selectSQL($connection, $sql, $result)){
                    if ($result[0]['prize'] == "") $hasPrize = true;
                }
            }
        } else{
            printHeader();
            notValidated();
            exit;
        }
    ?>
    <h1>Welcome <?php echo $_SESSION['name'] . " " . $_SESSION['surname'] ?></h1>
    <div class="container">
        <a href="courses.php">view your courses</a>
        <a href="profile.php">Profile</a>
    </div>
    <script>
        <?php
            if($hasPrize){
                echo "window.open('roulete.php', 'width=100, height=100', '_blank');";
                echo "audioRoulette();";
            }
        ?>
    </script>
</body>
</html>