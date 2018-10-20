<?php
session_start();
require_once 'models/user.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="../JS/loginJS.js"></script>
        <!--<script src="../JS/administrationJS.js"></script>-->
        <!-- <script src="../JS/studentsJS.js"></script> -->
        <!-- <script src="../JS/coursesJS.js"></script> -->
        <link rel="stylesheet" type="text/css" href="../CSS/loginCSS.css">
        <link rel="stylesheet" type="text/css" href="../CSS/navbarCSS.css">
        <link rel="stylesheet" type="text/css" href="../CSS/adminCSS.css">
        <link rel="stylesheet" type="text/css" href="../CSS/studentsCoursesCSS.css">
        <link href="https://fonts.googleapis.com/css?family=Anonymous+Pro" rel="stylesheet">   
        <link href="../CSS/images/schoolLogoIcon.png" rel="icon" type="image/png">
        <title>Some School</title>
    </head>
    <body>
        <nav class="navbar">
            <img id="schoolLogo" src="../CSS/images/schoolLogo.PNG"/>
            <?php
            echo '<ul class="navbarLinks">';
            if (isset($_SESSION['Owner']) || isset($_SESSION['Sales']) || isset($_SESSION['Manager'])) {
                echo "<li><a id = 'schoolLink' href = 'school'>School</a></li>";
                if (isset($_SESSION['Owner']) || isset($_SESSION['Manager'])) {
                    echo "<li><a id='adminLink' href='administration'>Administration</a></li>";
                }
                echo '</ul>';

                echo '<div class="toggle">';
                echo '<i class="fa fa-bars menu" aria-hidden="true"></i>';
                echo '</div>';

                echo '<div class="navbarUser">';
                if (isset($_SESSION['Owner'])) {
                    echo '<span>' . unserialize($_SESSION['Owner'])->User_Name . ', ' . unserialize($_SESSION['Owner'])->role . '</span>';
                    echo "<img class='navbarPic' src='" . unserialize($_SESSION['Owner'])->picture . "'/>";
                }
                echo '</div>';

                echo '<div class="navbarUser">';
                if (isset($_SESSION['Manager'])) {
                    echo '<span>' . unserialize($_SESSION['Manager'])->User_Name . ', ' . unserialize($_SESSION['Manager'])->role . '</span>';
                    echo "<img class='navbarPic' src='" . unserialize($_SESSION['Manager'])->picture . "'/>";
                }
                echo '</div>';

                echo '<div class="navbarUser">';
                if (isset($_SESSION['Sales'])) {
                    echo '<span>' . unserialize($_SESSION['Sales'])->User_Name . ', ' . unserialize($_SESSION['Sales'])->role . '</span>';
                    echo "<img class='navbarPic' src='" . unserialize($_SESSION['Sales'])->picture . "'/>";
                }
                echo '</div>';

                echo " <a id='logout' href='logout'>Log Out</a>";
            }

            if (isset($_SESSION['Owner'])) {
                define("currentEmail", unserialize($_SESSION['Owner'])->email);
                define("currentRole", unserialize($_SESSION['Owner'])->role);
            } else if (isset($_SESSION['Manager'])) {
                define("currentEmail", unserialize($_SESSION['Manager'])->email);
                define("currentRole", unserialize($_SESSION['Manager'])->role);
            } else if (isset($_SESSION['Sales'])) {
                define("currentEmail", unserialize($_SESSION['Sales'])->email);
                define("currentRole", unserialize($_SESSION['Sales'])->role);
            }
            ?>

        </nav>
        <?php
        $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

        switch ($request_uri[0]) {
            case '/school':
                if (isset($_SESSION['Owner']) || isset($_SESSION['Sales']) || isset($_SESSION['Manager'])) {
                    require 'views/school.php';
                } else {

                    require 'views/login.php';
                }
                break;

            case '/login':
                if (isset($_SESSION['Owner']) || isset($_SESSION['Sales']) || isset($_SESSION['Manager'])) {
                    require 'views/school.php';
                } else {
                    require 'views/login.php';
                }
                break;

            case '/administration':
                if (isset($_SESSION['Owner']) || isset($_SESSION['Manager'])) {
                    require 'views/administration.php';
                } else if (isset($_SESSION['Sales'])) {
                    require 'views/school.php';
                } else {
                    require 'views/login.php';
                }
                break;

            case '/logout':
                require 'views/logout.php';
                break;

            default:
                header('HTTP/1.0 404 Not Found');
                require 'views/404.php';
                break;
        }
        ?>

    </body>
</html>