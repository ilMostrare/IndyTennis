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
require_once ('includes/playerInfo.php');

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

    <div class="ladderContent">
        <p>Singles Ladder:</p>
        <? printSGLSRankings() ?>
        <br />
        <p>Doubles Ladder:</p>
        <? printDBLSRankings() ?>
        <br />
        <p>Singles (Individual):</p>
        <? GetPlayerSGLSRank(4) ?>
        <br />
        <p>Doubles (Individual):</p>
        <? GetPlayerDBLSRank(4) ?>
    </div>

    <? require "includes/footer.html"?>


<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/jquery.svg.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/app.js"></script>
</body>

</html>