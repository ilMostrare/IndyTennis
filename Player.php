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
require_once ('includes/playerInfo.php');

if (empty($_SESSION['playerID'])){
    echo "<script>window.location.href = './';</script>";
}

$user_id = $_SESSION['adminID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IndyTennis - Player</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

<?

require "includes/nav.html";

    if (!(empty($user_id))){

        echo "<div class='playerContent' id='style-2'>";

            GetPlayerInfo($_SESSION['playerID']);

            echo "<div class='upcomingMatches'>";
                echo "<h4>Current Matches</h4>";
                echo "<div class='printMatch tblHead'>";
                    echo "<table>";
                        echo "<th>Round Number</td>";
                        echo "<th>Opponent(s)</td>";
                        echo "<th>Playoff Match?</td>";
                        echo "<th>Due Date</td>";
                    echo "</table>";
                echo "</div>";    
                GetPlayerCurrentMatches($_SESSION['playerID']);
            echo "</div>";

            echo "<div class='matchHistory'>";
                echo "<h4>Past Matches</h4>";
                echo "<div class='printMatch tblHead'>";
                    echo "<table>";
                        echo "<th>Round Number</th>";
                        echo "<th>Opponent(s)</th>";
                        echo "<th class='mid'>Win/Loss</th>";
                        echo "<th class='mid'>Set 1</th>";
                        echo "<th class='mid'>Set 2</th>";
                        echo "<th class='mid'>Set 3</th>";
                    echo "</table>";
                echo "</div>"; 
                GetPlayerPastMatches($_SESSION['playerID']);
            echo "</div>";

        echo "</div>";

    } else {
        echo "<div class='playerContent' id='style-2'>";
        echo "<div class='header'><h1>Please Login</h1></div>";
        echo "<div class='loginDiv'>";
                    echo "<form action='' method='post' class='loginForm'>";
                        echo "<label>Email: </label>";
                        echo "<input id='loginEM' name='loginEmail' type='email' placeholder='Email'>";
                        echo "<label>Password: </label>";
                        echo "<input id='loginPASS' name='loginPassword' type='password' placeholder='Password'>";
                        echo "<input id='loginSubmit' type='submit' value='Login'>";
                    echo "</form>";
                echo "</div>";
        echo "</div>";
    }

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