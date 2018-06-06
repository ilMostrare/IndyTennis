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

    <? require "includes/nav.html";

    if ($isLadderLive > 0) {

        echo '<div class="ladderContent">';
            echo '<div class="header">';
                echo '<h1><? echo date("Y") ?> Ladder Standings</h1>';
                echo '<h3><a href="WeeklyMatchUps">View This Weeks Matchups</a></h3>';
            echo '</div>';
            echo '<div class="standings">';
                echo '<div class="left">';
                    echo '<h2>Singles</h2>';
                    echo '<div><span class="rnk">Rank</span><span class="nme">Player</span><span class="pts"># of Points</span></div>';
                    echo '<table id="singles">';
                        printSGLSRankings();
                    echo '</table>';
                echo '</div>';

                echo '<div class="right">';
                    echo '<h2>Doubles</h2>';
                    echo '<div><span class="rnk">Rank</span><span class="nme">Player</span><span class="pts"># of Points</span></div>';
                    echo '<table id="doubles">';
                        printDBLSRankings();
                    echo '</table>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

    } else {

        echo '<div class="ladderContent" id="style-2">';
            echo '<div class="header">';
                echo '<h1>Coming Soon!</h1>';
                echo '<h3>Under Construction. Coming Next Season!</h3>';
            echo '</div>';
            echo '<div class="ctIMG">';
                echo '<img src="includes/images/tennis-court-dimensions-and-layout.jpg">';
            echo '</div>';
        echo '</div>';

    }



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