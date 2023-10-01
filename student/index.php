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

    <div id="roulette" class="roulette" style="display:none;">
    <div class=topBar>
        <button onclick="closeRoulette()" id="closeButton">X</button>
    </div>
        <p>WIN A PRIZE!!!</p>
        <p>Since it's your first time here, you can have one of this prizes!</p>
        <img src="/Learning-Academy/igm/icons/roulette.png" alt="prize roulette">
        <button>SPIN IT!!!</button>
    </div>
    <script>
        <?php
            if($hasPrize){
                echo "window.onload = renderRoulette;";
            }
        ?>
    </script>
</body>
</html>