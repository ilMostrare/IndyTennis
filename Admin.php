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
require_once ('includes/adminLogin.php');
require_once ('includes/adminTools.php');


$user_id = $_SESSION['adminID'];


$userSql = "SELECT * FROM `ADMIN` WHERE `ID` = '".$user_id."'";
$userQuery = @$conn->query($userSql);

$userRow=mysqli_fetch_assoc($userQuery);

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

    <div class="adminContent">
        <div class="header">
            <h1>Admin Panel</h1>
            <h3>Welcome, <? echo $_SESSION['userFN'] ?></h3>
        </div>

        <div class="adminBody">
            <?
            if (!(empty($user_id))) {
                echo '<div class="adminOptions">';
                    echo '<ul class="optionsList">';
                    if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com") {

                        echo '<li id="createMatches">Create Round Matches</li>';
                        echo '<li id="editMatches">Edit Matchups</li>';
                        echo '<li id="enterScores">Enter Scores</li>';
                        echo '<li id="addPlayers">Add Players</li>';
                        echo '<li id="addAnnounce">Add Announcement</li>';
                        echo '<li id="changePassword">Change Password</li>';
                        echo '<li id="changeEmail">Change Email</li>';
                        echo '<li id="changePhone">Change Phone Number</li>';

                    } else {

                        echo '<li id="changePassword">Change Password</li>';
                        echo '<li id="changeEmail">Change Email</li>';
                        echo '<li id="changePhone">Change Phone Number</li>';
                        echo '<li id="loggoutt">Logout</li>';

                    }
                    echo '</ul>';
                echo '</div>';

                echo '<div class="adminForms">';
                    echo '<div id="createRoundMatches">';
                        echo '<h3>Create Round Matches</h3>';
                        echo '<div class="roundNumbers">';
                            echo '<span>Current Singles Round: $SGLSroundID</span>';
                            echo '<span>Current Doubles Round: $DBLSroundID</span>';
                        echo '</div>';
                        echo "<form><button type='submit' id='createSGLSMatches' class='create-sgls-matches' name='createSGLSMatches' value='".$SGLSroundID."'>Create Singles Round #".$SGLSroundID." Matches</button></form>";
                    echo '</div>';

                    echo "<div id='editRoundMatches'>";
                        echo "<h3>Edit Round Matches</h3>";
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span><span>Current Doubles Round: ".$DBLSroundID."</span></div>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='enterScoreResults'>";
                        echo "<h3>Enter Scores</h3>";
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span><span>Current Doubles Round: ".$DBLSroundID."</span></div>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='addAnnouncement'>";
                        echo "<h3>Add Announcement</h3>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='addNewPlayers'>";
                        echo "<h3>Add New Player</h3>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='changeEM'>";
                        echo "<h3>Change Email</h3>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='changePW'>";
                        echo "<h3>Change Password</h3>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='changePH'>";
                        echo "<h3>Change Phone Number</h3>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='logout'>";
                        echo "<h3>Logout</h3>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                echo '</div>';

            } else {
                echo "<div class='playerContent'>";
                    echo "<h1>Please Login</h1>";
                        echo "<form action='' method='post'>";
                        echo "<label>Email:</label>";
                        echo "<input id='loginEM' name='loginEmail' type='email' placeholder='Email'>";
                        echo "<label>Password:</label>";
                        echo "<input id='loginPASS' name='loginPassword' type='password' placeholder='Password'>";
                        echo "<input id='loginSubmit' type='submit' value='Login'>";
                    echo "</form>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
            




<!--

                <div id="enterScoreResults">
                    <h3>Edit Scores</h3>
                    <div class="roundNumbers">
                        <span>Current Singles Round: <?/* echo $SGLSroundID*/  ?></span>
                        <span>Current Doubles Round: <?/* echo $DBLSroundID  */?></span>
                    </div>
                    <form action='' method='post'>

                    </form>
                </div>
                <div id="addNewPlayers">
                    <h3>Add Players</h3>
                    <form action='' method='post'>

                    </form>
                </div>
                <div id="addAnnouncement">
                    <h3>Add Announcement</h3>
                    <form action='' method='post'>

                    </form>
                </div>
                <div id="changePW">
                    <h3>Change Password</h3>
                    <form action='' method='post'>

                    </form>
                </div>
                <div id="changeEM">
                    <h3>Change Email</h3>
                    <form action='' method='post'>

                    </form>
                </div>
                <div id="changePH">
                    <h3>Change Phone #</h3>
                    <form action='' method='post'>

                    </form>
                </div>
                <div id="logout">
                    <h3>Logout</h3>
                    <form action='' method='post'>

                    </form>
                </div>
           -->


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