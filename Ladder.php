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

    <? require "includes/nav.html"?>

    <div class="ladderContent">
        <div class="header">
            <h1><? echo date("Y") ?> Ladder Standings</h1>
            <h3><a href="WeeklyMatchUps">View This Weeks Matchups</a></h3>
        </div>
        <div class="standings">
            <div class="left">
                <h2>Singles</h2>
                <div><span class="rnk">Rank</span><span class="nme">Player</span><span class="pts"># of Points</span></div>
                <table id="singles">
                    <? printSGLSRankings() ?>
                </table>
            </div>

            <div class="right">
                <h2>Doubles</h2>
                <div><span class="rnk">Rank</span><span class="nme">Player</span><span class="pts"># of Points</span></div>
                <table id="doubles">
                    <? printDBLSRankings() ?>
                </table>
            </div>
        </div>


    </div>

    <?

    require "includes/footer.html";
    require_once ("includes/adminLoginModal.php");

    ?>

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/jquery.svg.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/app.js"></script>
</body>

</html>