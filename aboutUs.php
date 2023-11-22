<?php
session_start();
include "functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="/Learning-Academy/img/favicon.png">
    <script src="./files/scripts.js"></script>
    <title>About us</title>
</head>
<body>
    <?php
    printHeader();
    ?>
    <div class="aboutUs-container">
        <div class="titulo"><h1>About us</h1></div>
        <div>
            <p>Welcome to Learning Academy, your one-stop destination for comprehensive and dynamic courses in the field of computer science and technology. We are dedicated to providing a nurturing and cutting-edge educational environment where individuals can hone their skills and excel in the rapidly evolving realm of information technology.</p>
            <p>At Learning Academy, we recognize the importance of staying ahead in the digital age. With a diverse array of courses ranging from programming to systems management, cybersecurity, and more, we cater to the varied interests and aspirations of tech enthusiasts, aspiring developers, and seasoned professionals alike.</p>
            <p>Our team of experienced instructors brings a wealth of industry knowledge and expertise to the classroom, ensuring that our students receive top-notch guidance and practical insights to thrive in the competitive tech landscape. We foster a collaborative learning atmosphere that encourages innovation, critical thinking, and hands-on experience, empowering our students to tackle real-world challenges with confidence and proficiency.</p>
            <p>Whether you're a novice eager to embark on your tech journey or a seasoned professional seeking to expand your skill set, Learning Academy is committed to nurturing your passion and transforming your aspirations into tangible achievements. Join us in shaping the future of technology and unlocking a world of endless possibilities.</p>
            <p>Enroll today and embark on an enriching learning experience with Learning Academy.</p>
        </div>
    </div>
    <?php
    printFooter();
    ?>
</body>
</html>