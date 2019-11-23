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
require_once ('includes/playoff.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IndyTennis</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/playoff.css">
    <link rel="stylesheet" href="dist/css/styles.min.css">
</head>

<body>

    <?php 
        require "includes/nav.html";

        echo '<div class="matchesContent" id="style-2">';
            echo '<div class="header">';
            if (($SGLSroundPLAYOFF != 0) || ($SGLSroundID == '')){
                echo '<h1>Singles Playoff Brackets</h1>';
                echo '<h3><a href="Ladder">Back to Ladder</a></h3>';
                echo '</div>';
                echo '<h1 id="poHeader" style="text-align: center; margin-top:20px">Choose a Bracket</h1>';
                echo '<div class="bracketSelector"><h3>A</h3> - <h3>B</h3> - <h3>C</h3> - <h3>D</h3> - <h3>E</h3> - <h3>F</h3> - <h3>G</h3></div>';

                echo '<div id="playoffContainer">';
                // echo '<p>a</p>';
                    //javascript to insert playoff bracket here
                    // require_once "includes/brackets/A.html";
                echo '</div>';
                
                /*require_once "includes/brackets/A.html";
                require_once "includes/brackets/B.html";
                require_once "includes/brackets/C.html";
                require_once "includes/brackets/D.html";
                require_once "includes/brackets/E.html";
                require_once "includes/brackets/F.html";
                require_once "includes/brackets/G.html";
                require_once "includes/brackets/H.html";*/
            
            } else {
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