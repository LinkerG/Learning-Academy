<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Academy</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="/img/favicon.png">
</head>
<body>
    <?php
        include('functions.php');
        printHeader();  
    ?>
    <div class="contentIndex">
        <div class="div1"> 
            <h1>WELCOME TO LEARNING ACADEMY</h1> 
        </div>
        <div class="div2"> 
            <p>Looking to design your new startup website? 
            or Looking to redesign your website landing page? 
            Get started on Learning Academy!
            </p>
        </div>
        <div class="div3">
            <a class="blueBtn" href="courses.php">Our courses</a>
            <a class="witheBtn" href="signup.php">Create account</a> 
        </div>
        <div class="div4"> 
            <img class="img1" src="img/fotoIndex1.png">
        </div>
        <div class="div5">
            <img class="img2" src="img/fotoIndex2.png">
        </div>
    </div>
    <!--<div class="indexContent">
        <div class="content">
            <h1>WELCOME TO LEARNING ACADEMY</h1>
            <p>Looking to design your new startup website? 
            or Looking to redesign your website landing page? 
            Get started on Learning Academy!
            </p>
        <div>
            <a class="blueBtn" href="courses.php">Our courses</a>
            <a class="witheBtn" href="signup.php">Create account</a>
        </div>
        </div>
        <div class="imgs">
            <img class="img1" src="img/fotoIndex1.png">
            <img class="img2" src="img/fotoIndex2.png">
        </div>
    </div>-->
</body>
</html>