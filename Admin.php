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



    </div>

    <? require "includes/footer.html"?>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/jquery.svg.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>