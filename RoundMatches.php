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

    <?php 
        require "includes/nav.html";

        echo '<div class="matchesContent" id="style-2">';
            echo '<div class="header">';
                echo '<h1>Current Round Matches</h1>';
                echo '<h3><a href="Ladder">Back to Ladder</a></h3>';
            echo '</div>';
            echo '<div class="displayMatches">';
                echo '<div id="mobileViewController" display="none"><h2 id="sglsLadderView">Singles</h2><h2 id="dblsLadderView">Doubles - Ind.</h2><h2 id="TDLadderView">Doubles - Team</h2></div>';
                echo '<div class="left">';
                    echo '<h2>Singles - Round ',$SGLSroundID,'</h2>';
                    echo '<table id="singlesMU">';
                        printSGLSMatchups();
                    echo '</table>';
                echo '</div>';

                echo '<div class="right">';
                    echo '<h2>Doubles - Individual - Round ',$DBLSroundID,'</h2>';
                    echo '<table id="doublesMU">';
                        printDBLSMatchups();
                    echo '</table>';
                echo '</div>';     
                
                echo '<div class="farRight">';
                    echo '<h2>Doubles - Team - Round ',$DBLSroundID,'</h2>';
                    echo '<table id="teamDoubles2">';
                        printTeamDBLSMatchups();
                    echo '</table>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        


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