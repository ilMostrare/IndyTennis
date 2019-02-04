<?php
/**
 * Created by PhpStorm.
 * User: bslabach
 * Date: 3/8/18
 * Time: 6:08 PM
 */

session_start();

require_once ('includes/database.php');
require_once ('includes/queries.php');
require_once ('includes/announcements.php');
require_once ('includes/adminLogin.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IndyTennis</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <? require "includes/nav.html"?>

    <div class="homeContent">

        <div class="hmLeft" id="style-2">
            <div class="headerIMG">
                <img src="includes/images/headerIMG.jpg">
            </div>

            <div class="homeTxt">
                    <div class="header">
                        <h1>INDYTENNIS</h1>
                        <h2>::Serving Since 2004::</h2>
                        <br />
                    </div>
                    <h3>Our Mission</h3>
                    <p>To provide a healthy, accepting, and positive atmosphere for tennis and related activities among LGBT community members, friends, family members and allies.  As with the sport of tennis, IndyTennis starts with LOVE.</p>
                    <br />
                    <p>Started in 2004, IndyTennis is a nonproFIT social tennis organization welcoming players of all abilities and backgrounds. The group is affiliated with the Gay & Lesbian Tennis Alliance (GLTA) and the United States Tennis Association’s (USTA) Midwest Section. IndyTennis hosts tennis play and social gatherings year-round, with a season-ending party each November.  IndyTennis is an official USTA community tennis association (CTA).</p>
                    <br /><br />
                    <h3>Come Hit With Us!</h3>
                    <p>Join us at our social plays - Saturday mornings in the summer, 10AM @ Riverside Park or in the Winter, Sunday evenings<br /> @ West Indy Racquet Club</p>
                    <br />
                    <p>Check out the <a href="About">About Page</a> for contact information!</p>
            </div>
        </div>

        <? displayAnnouncements() ?>

    </div>

    <?

    if ($isLadderLive > 0){
        require "includes/footer.html";
    } else {
        require "includes/tempFooter.html";
    }

    //require_once ("includes/adminLoginModal.php");

    ?>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/jquery.svg.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>