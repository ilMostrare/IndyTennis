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
    //$logPass = $uPass;

    //echo "Data: ",$logEmail,", ",$logPass,"";

    // send login info to database
    $adminSql = "SELECT * FROM `PLAYERS` WHERE `EMAIL` LIKE '$logEmail'";
    $adminQuery = @$conn->query($adminSql);
    $adminRow = mysqli_fetch_assoc($adminQuery);

    $userPassword = $adminRow["PASSWORD"];

    if (password_verify($logPass,$userPassword)){
        $_SESSION['adminID'] = $adminRow["ID"];
        $_SESSION['userEmail'] = $adminRow['EMAIL'];
        $_SESSION['userFN'] = $adminRow['FIRST_NAME'];
    
        echo "", $_SESSION['adminID'],"";
    } else {
        echo "0";
    }

}

#endregion

