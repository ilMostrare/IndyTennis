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

    <div class="adminContent" id='style-2'>
        <div class="header">
            <h1><?  if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com") {
                        echo "Admin Panel";
                    } else {
                        echo "Settings";
                    }            
                ?>
            </h1>
            <h3><?                    
                    if ($_SESSION['userFN'] != ''){
                        echo "Welcome, ",$_SESSION['userFN'],"";
                    } else {
                        echo "Please Login";
                    }
                ?>
            </h3>
        </div>

        <div class="adminBody">
            <?
            if (!(empty($user_id))) {
                echo '<div class="adminOptions">';
                    echo '<ul class="optionsList">';
                    if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com") {

                        echo '<li id="createMatches">Create Round Matches</li>';
                        echo '<li id="editMatches">Edit Matchups</li>';
                        echo '<li id="enterSGLSScores">Enter Singles Scores</li>';
                        echo '<li id="enterDBLSScores">Enter Doubles Scores</li>';
                        echo '<li id="addPlayers">Add Players</li>';
                        echo '<li id="addAnnounce">Add Announcement</li>';
                        echo '<li id="changePassword">Change Password</li>';
                        echo '<li id="changeEmail">Change Email</li>';
                        echo '<li id="changePhone">Change Phone Number</li>';
                        echo '<li id="loggoutt">Logout</li>';

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
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span><span> | Current Doubles Round: ".$DBLSroundID."</span></div>";
                        echo "<form><button type='submit' id='createSGLSMatches' class='create-sgls-matches' name='createSGLSMatches' value='".$SGLSroundID."'>Create Singles Round #".$SGLSroundID." Matches</button></form>";
                    echo '</div>';

                    echo "<div id='editRoundMatches'>";
                        echo "<h3>Edit Round Matches</h3>";
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span><span> | Current Doubles Round: ".$DBLSroundID."</span></div>";
                        echo "<form action='' method='post'></form>";
                    echo "</div>";

                    echo "<div id='enterSGLSScoreResults'>";
                        echo "<h3>Enter Singles Scores</h3>";
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span></div><br />";
                        echo "<form action='' method='post' class='enterSGLSScores'>";
                            
                            echo "<label><h4>Match: </h4></label>";
                            echo "<select name='SGLSMatchID' id='sglsMatchID' required>", getSGLSMatches() ,"</select>";
                           
                            echo "<label><h4>Set 1 (Player 1 First):</h4></label>";
                            echo "<div class='sglsSet'><input type='number' name='sglsSet1P1' id='sglsSet1P1' min='0' max='7' required></input><input type='number' name='sglsSet1P2' id='sglsSet1P2' min='0' max='7'></input></div>";

                            echo "<label><h4>Set 2 (Player 1 First):</h4></label>";
                            echo "<div class='sglsSet'><input type='number' name='sglsSet2P1' id='sglsSet2P1' min='0' max='7' required></input><input type='number' name='sglsSet2P2' id='sglsSet2P2' min='0' max='7' required></input></div>";

                            echo "<label><h4>Set 3 (Player 1 First):</h4></label>";
                            echo "<div class='sglsSet'><input type='number' name='sglsSet3P1' id='sglsSet3P1' min='0' max='7'></input><input type='number' name='sglsSet3P2' id='sglsSet3P2' min='0' max='7'></input></div>";

                            echo "<div class='sglsSet'><label><h4>Playoff Match?:</h4></label><input type='checkbox' name='sglsPlayoff' id='sglsPlayoff' value='pl'></input><label><h4>Challenge Match?:</h4></label><input type='checkbox' name='sglsChallenge' id='sglsChallenge' value='ch'></input></div>";

                            echo "<div class='sglsSet'><label><h4>Match Winner?:</h4></label><span><input type='radio' name='sglsWinner' value='1' required><label>Player 1</label></input><input type='radio' name='sglsWinner' value='2'><label>Player 2</label></input></span></div>";

                            echo "<input id='sglsScoreSubmit' type='submit' value='Submit'>";

                        echo "</form>";
                    echo "</div>";

                    echo "<div id='enterDBLSScoreResults'>";
                        echo "<h3>Enter Doubles Scores</h3>";
                        echo "<div class='roundNumbers'><span>Current Doubles Round: ".$DBLSroundID."</span></div><br />";
                        echo "<form action='' method='post' class='enterDBLSScores'>";
                            
                            /* echo "<label>Match:</label>";
                            echo "<select name='MatchID' required>", getMatches() ,"</select>"; */
                           
                        echo "</form>";
                    echo "</div>";

                    echo "<div id='addNewPlayers'>";
                        echo "<h3>Add New Player</h3>";
                        echo "<form action='' method='post' class='addNewPLYR'>";
                            echo "<label><h4>First Name:</h4></label>";
                            echo "<div class='newPlayer'><input type='text' name='newFName' id='newFName' placeholder='John' required></input></div>";

                            echo "<label><h4>Last Name:</h4></label>";
                            echo "<div class='newPlayer'><input type='text' name='newLName' id='newLName' placeholder='Doe' required></input></div>";

                            echo "<label><h4>Email</h4></label>";
                            echo "<div class='newPlayer'><input type='text' name='newEmail' id='newEmail' placeholder='example@email.com' required></div>";

                            echo "<label><h4>Phone:</h4></label>";
                            echo "<div class='newPlayer'><input type='number' name='newPhone' id='newPhone' min='0' placeholder='3178885000' required></input></div>";

                            echo "<label><h4>Password:</h4></label>";
                            echo "<div class='newPlayer'><input type='password' name='newPassword' id='newPassword' required></input></div>";

                            echo "<div class='newPlayer'><label><h4>Singles Player?:</h4></label><input type='checkbox' name='newSGLSPlayer' id='newSGLSPlayer' value='sg'></input><label><h4>Doubles Player?:</h4></label><input type='checkbox' name='newDBLSPlayer' id='newDBLSPlayer' value='db'></input></div>";

                            echo "<div class='newPlayer'><label><h4>Starting Singles<br />Points (if any):</h4></label><input type='number' name='newSGLSPoints' id='newSGLSPoints' min='0'></input><label><h4>Starting Doubles<br />Points (if any):</h4></label><input type='number' name='newDBLSPoints' id='newDBLSPoints' min='0'></input></div>";

                            echo "<input id='newPlayerSubmit' type='submit' value='Submit'>";
                        echo "</form>";
                    echo "</div>";

                    echo "<div id='addAnnouncement'>";
                        echo "<h3>Add Announcement</h3>";
                        echo "<form action='' method='post' class='addAnnounce'>";
                            echo "<label><h4>Title</h4></label>";
                            echo "<div class='newPlayer'><input type='text' name='announceTitle' id='announceTitle' placeholder='End of Season BBQ' required></input></div>";

                            echo "<label><h4>Description (wrap the word you'd like to link like such /*word*/):</h4></label>";
                            echo "<div class='newPlayer'><textarea rows='4' cols='50' name='announceDesc' id='announceDesc' placeholder='Checkout the Facebook page for the address!' required></textarea></div>";

                            echo "<label><h4>Event Date</h4></label>";
                            echo "<div class='newPlayer'><input type='date' name='announceDate' id='announceDate' placeholder='01/01/2001' required></div>";

                            echo "<label><h4>Link:</h4></label>";
                            echo "<div class='newPlayer'><input type='text' name='announceLink' id='announceLink' placeholder='mailto:contact@indytennis.com'></input></div>";

                            echo "<input id='newAnnounceSubmit' type='submit' value='Submit'>";
                        echo "</form>";
                    echo "</div>";

                    echo "<div id='changePW'>";
                        echo "<h3>Change Password</h3>";
                        echo "<form action='' method='post' class='updatePW'>";
                            echo "<label><h4>Select Player: </h4></label>";
                            if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com"){
                                echo "<select name='userNewPWID' id='userNewPWID' required>", getAllPlayers() ,"</select>";
                            } else {
                                echo "<select name='userNewPWID' id='userNewPWID' required>", getSinglePlayer($_SESSION['adminID']) ,"</select>";
                            }

                            echo "<label><h4>New Password:</h4></label>";
                            echo "<div class='newPlayer'><input type='password' name='userNewPW' id='userNewPW' required></input></div>";

                            echo "<input id='newPasswordSubmit' type='submit' value='Submit'>";
                        echo "</form>";
                    echo "</div>";
                    
                    echo "<div id='changeEM'>";
                        echo "<h3>Change Email</h3>";
                        echo "<form action='' method='post' class='updateEM'>";
                            echo "<label><h4>Select Player: </h4></label>";
                            if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com"){
                                echo "<select name='userNewEMID' id='userNewEMID' required>", getAllPlayers() ,"</select>";
                            } else {
                                echo "<select name='userNewEMID' id='userNewEMID' required>", getSinglePlayer($_SESSION['adminID']) ,"</select>";
                            }

                            echo "<label><h4>New Email:</h4></label>";
                            echo "<div class='newPlayer'><input type='email' name='userNewEM' id='userNewEM' required></input></div>";

                            echo "<input id='newEmailSubmit' type='submit' value='Submit'>";
                        echo "</form>";
                    echo "</div>";

                    echo "<div id='changePH'>";
                        echo "<h3>Change Phone Number</h3>";
                        echo "<form action='' method='post' class='updatePN'>";
                            echo "<label><h4>Select Player: </h4></label>";
                            if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com"){
                                echo "<select name='userNewPNID' id='userNewPNID' required>", getAllPlayers() ,"</select>";
                            } else {
                                echo "<select name='userNewPNID' id='userNewPNID' required>", getSinglePlayer($_SESSION['adminID']) ,"</select>";
                            }

                            echo "<label><h4>New Phone Number:</h4></label>";
                            echo "<div class='newPlayer'><input type='number' name='userNewPN' id='userNewPN' min='0' required></input></div>";

                            echo "<input id='newPhoneSubmit' type='submit' value='Submit'>";
                        echo "</form>";
                    echo "</div>";

                    echo "<div id='logout'>";
                        echo "<h3>Logout</h3>";
                    echo "</div>";

                echo '</div>';

            } else {
                echo "<div class='loginDiv'>";
                    echo "<form action='' method='post' class='loginForm'>";
                        echo "<label>Email: </label>";
                        echo "<input id='loginEM' name='loginEmail' type='email' placeholder='Email'>";
                        echo "<label>Password: </label>";
                        echo "<input id='loginPASS' name='loginPassword' type='password' placeholder='Password'>";
                        echo "<input id='loginSubmit' type='submit' value='Login'>";
                    echo "</form>";
                echo "</div>";
            }
            ?>
        </div>
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