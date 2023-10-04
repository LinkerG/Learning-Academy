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
        <h1>WELCOME TO LEARNING ACADEMY</h1>
        <p>Looking to design your new startup website? 
        or Looking to redesign your website landing page? 
        Get started on Learning Academy!
        </p>
        <div>
            <button class="blueBtn" onclick="location.href='courses.php'">Our courses</button>
            <button class="witheBtn" onclick="location.href='signup.php'">Create account</button>
        </div>  

    </div>
    

</body>
</html>