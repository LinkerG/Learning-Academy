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
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <script src="./files/scripts.js"></script>
</head>
<body>
    <?php   
        include('functions.php');
        generarFicheroStudents();
        printHeader();  
    ?>
    <div class="indexContainer">
        <div class="title">
            <h1>WELCOME TO LEARNING ACADEMY</h1>
        </div>
        <div class="description">
            <p>Looking to design your new startup website? 
            or Looking to redesign your website landing page? 
            Get started on Learning Academy!
            </p>
        </div>
        <div class="buttons">
            <a class="blueBtn" href="courses.php">Our courses</a>
            <a class="whiteBtn" href="signup.php">Create account</a>
        </div>
        <div class="imgs">
            <div class="img1">
                <img alt="image of a laptop" src="img/fotoIndex1.png">
            </div>
            <div class="img2">
                <img alt="image of a computer" src="img/fotoIndex2.png">
            </div>
            <div class="img3">
                <img alt="image of a computer" src="img/fotoIndex3.png">
            </div>
        </div>
    </div>
    <?php
        printFooter();
    ?>
</body>
</html>