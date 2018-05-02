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
                    <li id="createMatches">Create Round Matches</li>
                    <li id="editMatches">Edit Matchups</li>
                    <li id="enterScores">Enter Scores</li>
                    <li id="addAnnounce">Add Announcement</li>
                    <li id="changePassword">Change Password</li>
                </ul>

            </div>
            <div class="adminForms">
                <div id="createRoundMatches">
                    <h3>Create Round Matches</h3>
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