<?php
/**
 * Created by PhpStorm.
 * User: bslabach
 * Date: 3/30/18
 * Time: 8:42 PM
 */

#region Admin Login
if (isset($_POST['loginEmail'])){
    $uEmail = isset($_POST['loginEmail']) ? $_POST['loginEmail'] : 'No data found';
    $uPass = isset($_POST['loginPassword']) ? $_POST['loginPassword'] : 'No data found';


    $logEmail = $uEmail;
    $logPass = $uPass;

    //echo "Data: ",$logEmail,", ",$logPass,"";

    // send login info to database
    $adminSql = "SELECT * FROM `ADMIN` WHERE `EMAIL` LIKE '$logEmail' AND `PASSWORD` = '$logPass'";
    $adminQuery = @$conn->query($adminSql);
    $adminRow = mysqli_fetch_assoc($adminQuery);

    $_SESSION['adminID'] = $adminRow["ID"];
    echo "", $_SESSION['adminID'],"";

}

#endregion

