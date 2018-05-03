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
    <title>IndyTennis</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

<?

require "includes/nav.html";

    if (!(empty($user_id))){

        if ($adminRow["EMAIL"] = "byron.slabach@gmail.com" || "wrathofmath85@gmail.com"){
            echo "<div class='playerContent'>";

            GetPlayerInfo($_SESSION['playerID']);

            echo "</div>";

        } else {
            echo "<div class='playerContent'>";

            GetPlayerInfo($_SESSION['playerID']);

            echo "</div>";
        }

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