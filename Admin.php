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


/* $userSql = "SELECT * FROM `ADMIN` WHERE `ID` = '".$user_id."'";
$userQuery = @$conn->query($userSql);

$userRow=mysqli_fetch_assoc($userQuery); */

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
            <div class='line2'>
                <h2><?                    
                        if ($_SESSION['userFN'] != ''){
                            echo "Welcome, ",$_SESSION['userFN'];
                        } else {
                            echo "Please Login";
                        }
                    ?>
                </h2>
                <!-- <form><button type='submit' class='admin-player-name' name='viewPlayer' value='<? //$_SESSION['adminID'] ?>'><h3>View Player Page</h3></button></form> -->
            </div>
        </div>

        <div class="adminBody">
            <?
            if (!(empty($user_id))) {
                echo '<div class="adminOptions">';
                    echo '<ul class="optionsList">';
                    if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com") {

                        echo '<li id="createMatches">Create Round Matches</li>';
                        echo '<li id="editMatches">Edit Matchups</li>';
                        echo '<li id="addChallengeM">Add Challenge Match</li>';
                        echo '<li id="enterSGLSScores">Enter Singles Scores</li>';
                        echo '<li id="enterDBLSScores">Enter Doubles Scores</li>';
                        echo '<li id="addPlayers">Add Players</li>';
                        echo '<li id="addTDTeam">Add Team Doubles Team</li>';
                        echo '<li id="addAnnounce">Add Announcement</li>';
                        echo '<li id="changePassword">Change Password</li>';
                        echo '<li id="changeEmail">Change Email</li>';
                        echo '<li id="changePhone">Change Phone Number</li>';
                        echo '<li id="viewPlayerPage" data-value="'.$_SESSION['adminID'].'">Go to My Player Page</li>';
                        echo '<li id="loggoutt">Logout</li>';

                    } else {

                        echo '<li id="changePassword">Change Password</li>';
                        echo '<li id="changeEmail">Change Email</li>';
                        echo '<li id="changePhone">Change Phone Number</li>';
                        echo '<li id="viewPlayerPage" data-value="'.$_SESSION['adminID'].'">Go to My Player Page</li>';
                        echo '<li id="loggoutt">Logout</li>';

                    }
                    echo '</ul>';
                echo '</div>';

                echo '<div class="adminForms">';
                    echo '<div id="createRoundMatches">';
                        echo '<h3>Create Round Matches</h3>';
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span><span> | Current Doubles Round: ".$DBLSroundID."</span></div>";
                        echo "<form><label><h4>Singles Round #".$SGLSroundID.": </h4></label><button type='submit' id='createSGLSMatches' class='create-sgls-matches' name='createSGLSMatches' value='".$SGLSroundID."'>Create Singles Matches</button></form>";
                        echo "<form><label><h4>Ind. Doubles Round #".$DBLSroundID.": </h4></label><button type='submit' id='createDBLSMatches' class='create-dbls-matches' name='createDBLSMatches' value='".$DBLSroundID."'>Create Doubles Matches</button></form>";
                        echo "<form><label><h4>Team Doubles Round #".$DBLSroundID.": </h4></label><button type='submit' id='createTDMatches' class='create-TD-matches' name='createTDMatches' value='".$DBLSroundID."'>Create Team Doubles Matches</button></form>";

                    echo '</div>';

                    echo "<div id='editRoundMatches'>";
                        echo "<h3>Edit Round Matches</h3>";
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span><span> | Current Doubles Round: ".$DBLSroundID."</span></div>";
                        echo "<form action='' method='post' class='editSGLSMatch'>";
                            echo "<label><h4>Edit Singles Match: </h4></label>";
                            echo "<select name='editSGLSMatchID' id='editsglsMatchID' required><option disabled selected> -- select an option -- </option>", getSGLSMatches() ,"</select>";
                           
                            echo "<label><h4>Player 1:</h4></label>";
                            echo "<div class='sglsSet'><select name='editSGLSP1' id='editSGLSP1'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllSinglesPlayers() ,"</select></div>";

                            echo "<label><h4>Player 2:</h4></label>";
                            echo "<div class='sglsSet'><select name='editSGLSP2' id='editSGLSP2'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllSinglesPlayers() ,"</select></div>";

                            echo "<input id='sglsMatchEditSubmit' type='submit' value='Submit Singles Match Edit'>";
                        echo "</form>";

                        echo "<form action='' method='post' class='editDBLSMatch'>";
                            echo "<label><h4>Edit Doubles Match: </h4></label>";
                            echo "<select name='editDBLSMatchID' id='editdblsMatchID' required><option disabled selected> -- select an option -- </option>", getDBLSMatches() ,"</select>";
                           
                            echo "<label><h4>Player 1:</h4></label>";
                            echo "<div class='dblsSet'><select name='editDBLSP1' id='editDBLSP1'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllDoublesPlayers() ,"</select></div>";

                            echo "<label><h4>Player 2:</h4></label>";
                            echo "<div class='dblsSet'><select name='editDBLSP2' id='editDBLSP2'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllDoublesPlayers() ,"</select></div>";

                            echo "<label><h4>Player 3:</h4></label>";
                            echo "<div class='dblsSet'><select name='editDBLSP3' id='editDBLSP3'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllDoublesPlayers() ,"</select></div>";

                            echo "<label><h4>Player 4:</h4></label>";
                            echo "<div class='dblsSet'><select name='editDBLSP4' id='editDBLSP4'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllDoublesPlayers() ,"</select></div>";

                            echo "<input id='dblsMatchEditSubmit' type='submit' value='Submit Doubles Match Edit'>";
                        echo "</form>";

                        echo "<form action='' method='post' class='editTDMatch'>";
                            echo "<label><h4>Edit Team Doubles Match: </h4></label>";
                            echo "<select name='editTDMatchID' id='editTDMatchID' required><option disabled selected> -- select an option -- </option>", getTDMatches() ,"</select>";
                           
                            echo "<label><h4>Team 1:</h4></label>";
                            echo "<div class='dblsSet'><select name='editTDT1' id='editTDT1'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllDoublesTeam() ,"</select></div>";

                            echo "<label><h4>Team 2:</h4></label>";
                            echo "<div class='dblsSet'><select name='editTDT2' id='editTDT2'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllDoublesTeam() ,"</select></div>";

                            echo "<input id='TDMatchEditSubmit' type='submit' value='Submit Team Doubles Match Edit'>";
                        echo "</form>";
                    echo "</div>";

                    echo "<div id='addChallengeMatch'>";
                        echo "<h3>Add Challenge Match</h3>";
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span><span> | Current Doubles Round: ".$DBLSroundID."</span></div>";
                        echo "<form action='' method='post' class='addChallenge'>";
                            echo "<label><h4>Player 1:</h4></label>";
                            echo "<div class='sglsSet'><select name='addChallengeP1' id='addChallengeP1'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllSinglesPlayers() ,"</select></div>";

                            echo "<label><h4>Player 2:</h4></label>";
                            echo "<div class='sglsSet'><select name='addChallengeP2' id='addChallengeP2'><option readonly selected value=''> -- if unchanged, leave blank -- </option>", getAllSinglesPlayers() ,"</select></div>";

                            echo "<input id='addChallengeSubmit' type='submit' value='Submit Singles Match Edit'>";
                        echo "</form>";
                    echo "</div>";

                    echo "<div id='enterSGLSScoreResults'>";
                        echo "<h3>Enter Singles Scores</h3>";
                        echo "<div class='roundNumbers'><span>Current Singles Round: ".$SGLSroundID."</span></div><br />";
                        echo "<form action='' method='post' class='enterSGLSScores'>";
                            
                            echo "<label><h4>Match: </h4></label>";
                            echo "<select name='SGLSMatchID' id='sglsMatchID' required><option disabled selected value> -- select an option -- </option>", getSGLSMatches() ,"</select>";
                           
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
                        echo "<h3>Enter Ind. Doubles Scores</h3>";
                        echo "<div class='roundNumbers'><span>Current Doubles Round: ".$DBLSroundID."</span></div><br />";
                        echo "<form action='' method='post' class='enterDBLSScores'>";
                            
                            echo "<label><h4>Match: </h4></label>";
                            echo "<select name='DBLSMatchID' id='DBlsMatchID' required><option disabled selected value> -- select an option -- </option>", getDBLSMatches() ,"</select>";
                           
                            echo "<label><h4>Set 1 (Team 1 First - P1/P2 vs P3/P4):</h4></label>";
                            echo "<div class='DBlsSet'><input type='number' name='DBlsSet1T1' id='DBlsSet1T1' min='0' max='7' required></input><input type='number' name='DBlsSet1T2' id='DBlsSet1T2' min='0' max='7'></input></div>";

                            echo "<label><h4>Set 2 (Team 1 First - P1/P3 vs P2/P4):</h4></label>";
                            echo "<div class='DBlsSet'><input type='number' name='DBlsSet2T1' id='DBlsSet2T1' min='0' max='7' required></input><input type='number' name='DBlsSet2T2' id='DBlsSet2T2' min='0' max='7' required></input></div>";

                            echo "<label><h4>Set 3 (Team 1 First - P1/P4 vs P2/P3):</h4></label>";
                            echo "<div class='DBlsSet'><input type='number' name='DBlsSet3T1' id='DBlsSet3T1' min='0' max='7'></input><input type='number' name='DBlsSet3T2' id='DBlsSet3T2' min='0' max='7'></input></div>";

                            echo "<div class='DBlsSet'><label><h4>Playoff Match?:</h4></label><input type='checkbox' name='DBlsPlayoff' id='DBlsPlayoff' value='pl'></input></div>";

                            echo "<input id='DBlsScoreSubmit' type='submit' value='Submit'>";

                        echo "</form>";
                        
                        echo "<h3>Enter Team Doubles Scores</h3>";
                        echo "<form action='' method='post' class='enterTDScores'>";
                            
                            echo "<label><h4>Match: </h4></label>";
                            echo "<select name='TDMatchID' id='TDMatchID' required><option disabled selected value> -- select an option -- </option>", getTDMatches() ,"</select>";
                           
                            echo "<label><h4>Set 1 (Team 1 First):</h4></label>";
                            echo "<div class='TDSet'><input type='number' name='TDSet1T1' id='TDSet1T1' min='0' max='7' required></input><input type='number' name='TDSet1T2' id='TDSet1T2' min='0' max='7'></input></div>";

                            echo "<label><h4>Set 2 (Team 1 First):</h4></label>";
                            echo "<div class='TDSet'><input type='number' name='TDSet2T1' id='TDSet2T1' min='0' max='7' required></input><input type='number' name='TDSet2T2' id='TDSet2T2' min='0' max='7' required></input></div>";

                            echo "<label><h4>Set 3 (Team 1 First):</h4></label>";
                            echo "<div class='TDSet'><input type='number' name='TDSet3T1' id='TDSet3T1' min='0' max='7'></input><input type='number' name='TDSet3T2' id='TDSet3T2' min='0' max='7'></input></div>";

                            echo "<div class='TDSet'><label><h4>Playoff Match?:</h4></label><input type='checkbox' name='TDPlayoff' id='TDPlayoff' value='pl'></input></div>";

                            echo "<input id='TDScoreSubmit' type='submit' value='Submit'>";

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

                    echo "<div id='addNewTDTeam'>";
                        echo "<h3>Add New Team Doubles Team</h3>";
                        echo "<form action='' method='post' class='addNewTD'>";                            
                            echo "<label><h4>Select Player 1: </h4></label>";
                            echo "<select name='userNewTDID1' id='userNewTDID1' required><option disabled selected value> -- select an player -- </option>", getAllPlayers() ,"</select>";

                            echo "<label><h4>Select Player 2: </h4></label>";
                            echo "<select name='userNewTDID2' id='userNewTDID2' required><option disabled selected value> -- select an player -- </option>", getAllPlayers() ,"</select>";

                            echo "<div class='newPlayer'><label><h4>Starting Points (if any):</h4></label><input type='number' name='newTDPoints' id='newTDPoints' min='0'></input></div>";

                            echo "<input id='newTDTSubmit' type='submit' value='Submit'>";
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
                            if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com"){
                                echo "<label><h4>Select Player: </h4></label>";
                                echo "<select name='userNewPWID' id='userNewPWID' required>", getAllPlayers() ,"</select>";
                            } else {
                                echo "<label><h4>Name: </h4></label>";
                                echo "<select name='userNewPWID' id='userNewPWID' required>", getSinglePlayer($_SESSION['adminID']) ,"</select>";
                            }

                            echo "<label><h4>New Password:</h4></label>";
                            echo "<div class='newPlayer'><input type='password' name='userNewPW' id='userNewPW' required></input></div>";

                            echo "<label><h4>Repeat New Password:</h4></label>";
                            echo "<div class='newPlayer'><input type='password' name='userNewPW2' id='userNewPW2' required></input></div>";

                            echo "<input id='newPasswordSubmit' type='submit' value='Submit'>";
                        echo "</form>";
                    echo "</div>";
                    
                    echo "<div id='changeEM'>";
                        echo "<h3>Change Email</h3>";
                        echo "<form action='' method='post' class='updateEM'>";                            
                            if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com"){
                                echo "<label><h4>Select Player: </h4></label>";
                                echo "<select name='userNewEMID' id='userNewEMID' required>", getAllPlayers() ,"</select>";
                            } else {
                                echo "<label><h4>Name: </h4></label>";
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
                            if ($_SESSION['userEmail'] == "byron.slabach@gmail.com" || $_SESSION['userEmail'] == "wrathofmath85@gmail.com"){
                                echo "<label><h4>Select Player: </h4></label>";
                                echo "<select name='userNewPNID' id='userNewPNID' required>", getAllPlayers() ,"</select>";
                            } else {
                                echo "<label><h4>Name: </h4></label>";
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