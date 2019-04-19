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
    <title>IndyTennis - About</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <?php require "includes/nav.html"?>

    <div class="aboutContent">

        <div class="abtLeft" id="style-2">
            <div class="aboutTxt">
                <div class="header">
                    <h1>About INDYTENNIS</h1>
                    <h2>94 Members and Growing!</h2>
                    <br />
                </div>
                <h3>Contact / Join</h3>
                <p>Email: <a href="mailto:indytennis317@gmail.com?body=Name%3A%20%0AUSTA%20Rating%20(N%2FA%20if%20Unsure)%3A%20%0AComment%2FQuestion%3A%20">indytennis317@gmail.com</a></p>
                <br />
                <h3>Year Round Social Tennis Play</h3>
                <p>Summers – Join us at Riverside Park every Saturday Morning @ 10am for laid back tennis play​</p>
                <p>Winters – We meet every Sunday evening at West Indy Racquet Club.  RSVP required as space is limited for our social doubles play​</p>
                <br />
                <h3>Competitive Tennis​</h3>
                <p>Join our Singles and/or Doubles ladder, run April through September.  Win and move up, lose and move down.  With over 80 players this year, we have a spot for every level of tennis player, including women.​</p>
                <br />
                <h3>Social Outings​</h3>
                <p>In an effort to build camaraderie within the group, we attempt to host one non tennis social outing a month.  These include but are not limited to happy hours, house parties, BBQs, Wine and Canvas, game nights, and sporting events.​</p>
                <br />
                <h3>Fundraisers​​</h3>
                <p>We turn some of our social events into fundraisers.  At the conclusion of the year, we donate all monies raised to our charity partner, the Indiana AIDS fund.  We happily donated $6,000 in 2016.​</p>
                <br />
                <h3>Indy Classic​</h3>
                <p>Our annual international tennis tournament is help each September.  This tournament is one of 70 WORLDWIDE tournaments on the GLTA circuit.  In 2016 we had 120 players from all over the US and Canada (and even a player from India and Australia).  The tournament offers 5 levels of play from beginner to advanced.  We are also one of the few tournaments to offer mixed doubles!  While this is a tournament and winners do receive trophies, it is a very social setting.  Player parties and a banquet help participants to get to know each other off the court and make life long friendships.​​ Find more information about the tournament <a href="https://glta.net/tournament-details/indytennis-classic-2019" target="_blank">here!</a></p>
                <br />
                <h3>Women​​</h3>
                <p>In the last few years, we have seen a growth in the number of women in our club.  We currently have 9 women playing our ladders and had 25 women play our tournament in 2016.​</p>
                <br />
                <h3>Beginners​</h3>
                <p>The great thing about IndyTennis is that you need no tennis experience to play with us.  We truly do welcome players of all abilities.  We even offer a instructional tennis course offered through the USTA to help you learn.  Taught by one of our own players, the course meets once a week for 6-8 weeks.  Contact us for more information.​</p>
                <br />
            </div>

        </div>

        <?php displayAnnouncements() ?>

    </div>

    <?php

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