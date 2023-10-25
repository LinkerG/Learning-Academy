<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>!!!! WINNER !!!!</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../files/scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
</head>
<body class="roulette">
    <?php
    include("../functions.php");

    if(!isset($_SESSION['role']) || $_SESSION['role'] != "S") {
        include("needStudent.html");
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=../close.php'>";
    } else {
    ?>
    <div class="rouletteContainer">
        <div id="roulette" class="roulette">
            <div class="rouletteText">
                <p>WIN A PRIZE!!!</p>
                <p>Since it's your first time here,<br> you can have one of this prizes!</p>
            </div>
            <div class="arrow"></div>
            <img src="../img/icons/roulette.png" alt="prize roulette" id="rouletteImg">
            <button id="rouletteButton" onclick="return spinRoulette()">SPIN IT!!!</button>
        </div>
    </div>
    <?php
        }
    ?>
</body>
</html>
