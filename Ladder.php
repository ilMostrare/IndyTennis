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
    <title>IndyTennis - Ladder</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <?php 
        require "includes/nav.html";
        echo '<div class="ladderContent" id="style-2">';

        if ( $sznID != '' ) {
            
            if( ($SGLSroundPLAYOFF != 1) && ($DBLSroundPLAYOFF != 1) ){
                echo '<div class="header">';
                    echo '<h1>'.date("Y").' Ladder Standings</h1>';
                    echo '<h3><a href="RoundMatches">View This Round\'s Matchups</a></h3>';
                echo '</div>';
                echo '<div class="standings">';
                    echo '<div id="mobileViewController" display="none"><h2 id="sglsLadderView">Singles</h2><h2 id="dblsLadderView">Doubles - Ind.</h2><h2 id="TDLadderView">Doubles - Team</h2></div>';
                    echo '<div class="left">';
                        echo '<h2>Singles</h2>';
                        echo '<div><span class="rnk">Rank</span><span class="nme">Player</span><span class="pts"># of Points</span></div>';
                        echo '<table id="singles">';
                            printSGLSRankings();
                        echo '</table>';
                    echo '</div>';

                    echo '<div class="right">';
                        echo '<h2>Doubles - Individual</h2>';
                        echo '<div><span class="rnk">Rank</span><span class="nme">Player</span><span class="pts"># of Points</span></div>';
                        echo '<table id="doubles">';
                            printDBLSRankings();
                        echo '</table>';
                    echo '</div>';

                    echo '<div class="farRight">';
                        echo '<h2>Doubles - Team</h2>';
                        echo '<div><span class="rnk">Rank</span><span class="nme">Team</span><span class="pts"># of Points</span></div>';
                        echo '<table id="teamDoubles">';
                            printTeamDBLSRankings();
                        echo '</table>';
                    echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="header">';
                    echo '<h1>Playoffs</h1>';
                echo '</div>';
            }
            
        } else {

            echo '<div class="header">';
                echo '<h1>Coming Soon!</h1>';
                echo '<h3>Check back '.$PRINTnxtSeasonST.'</h3>';
            echo '</div>';
            echo '<div class="ctIMG">';
                echo '<img src="includes/images/tennis-court-dimensions-and-layout.jpg">';
            echo '</div>';

        }
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