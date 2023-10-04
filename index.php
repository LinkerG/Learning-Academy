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
</head>
<body>
    <?php
        include('functions.php');
        printHeader();  
    ?>
    <div class="index">
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
            <div class="imgs">
                <img class="img1" src="img/fotoIndex1.png">
                <img class="img2" src="img/fotoIndex2.png">
                <img class="img3" src="img/fotoIndex3.png">
            </div>
        </div>

    </div>
    

</body>
</html>