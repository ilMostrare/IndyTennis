<?php
/**
 * Created by PhpStorm.
 * User: BSlabach
 * Date: 3/21/2018
 * Time: 8:01 AM
 */

session_start();

require_once ('includes/database.php');
require_once ('includes/queries.php');

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

 echo '<div class="ladderContent">';
    echo '<div class="header">';
        echo '<h1><? echo date("Y") ?>Weekly Matchups</h1>';
        echo '<h3><a href="Ladder">Back to Ladder</a></h3>';
    echo '</div>';
    echo '<div class="standings">';
        echo '<div class="left">';
            echo '<h2>Singles - Round ',$SGLSroundID,'</h2>';
            echo '<table id="singles">';
                printSGLSMatchups();
            echo '</table>';
        echo '</div>';

        echo '<div class="right">';
            echo '<h2>Doubles - Round ',$DBLSroundID,'</h2>';
            echo '<table id="doubles">';
                printDBLSMatchups();
            echo '</table>';
        echo '</div>';
    echo '</div>';
 echo '</div>';

?>

<!--<div class="matchesContent">



</div>-->

<?

if ($isLadderLive > 0){
    require "includes/footer.html";
} else {
    require "includes/tempFooter.html";
}

?>

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/jquery.svg.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/app.js"></script>
</body>

</html>