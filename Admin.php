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

if (empty($userRow)){
    echo "<script>window.location.href = './';</script>";
} else {
    $userFN = $userRow["FIRST_NAME"];
    $userLN = $userRow["LAST_NAME"];
    $userEM = $userRow["EMAIL"];
}

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
            <h3>Welcome, <? echo $userFN ?></h3>
        </div>

        <div class="adminBody">
            <div class="adminOptions">
                <ul class="optionsList">
                    <?
                    if ($userEM = "byron.slabach@gmail.com" || "wrathofmath85@gmail.com") {

                        echo '<li id="createMatches">Create Round Matches</li>';
                        echo '<li id="editMatches">Edit Matchups</li>';
                        echo '<li id="enterScores">Enter Scores</li>';
                        echo '<li id="addAnnounce">Add Announcement</li>';
                        echo '<li id="changePassword">Change Password</li>';

                    } else {

                        echo '<li id="changePassword">Change Password</li>';
                        echo '<li id="changeEmail">Change Email</li>';
                        echo '<li id="changePhone">Change Phone Number</li>';

                    }
                    ?>
                </ul>

            </div>
            <div class="adminForms">
                <div id="createRoundMatches">
                    <h3>Create Round Matches</h3>
                    <div class="roundNumbers">
                        <span>Current Singles Round: <? echo $SGLSroundID  ?></span>
                        <span>Current Doubles Round: <? echo $DBLSroundID  ?></span>
                    </div>
                    <form>
                        <button type='submit' id='createSGLSMatches' class='create-sgls-matches' name='createSGLSMatches' value=<? echo $SGLSroundID  ?> >Create Singles Round #<? echo $SGLSroundID  ?> Matches</button>
                    </form>
                </div>
                <div id="editRoundMatches">
                    <h3>Edit Round Matches</h3>
                    <form action='' method='post'>

                    </form>
                </div>
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