<?php
/**
 * User: bslabach
 * Date: 3/30/18
 * Time: 7:40 PM
 */

#region Create Matches Function

function createSGLSMatches(){
    global $conn;
    global $sznID;
    global $SGLSroundID;

    $resultSet = array();

    $allSinglesPlayersSQL = "SELECT `ID` FROM `PLAYERS` WHERE `SGLS_PLAYER`=1 AND `SEASON_NUM`='" . $sznID . "'";
    $allSinglesPlayersQuery = @$conn->query($allSinglesPlayersSQL);
    while ($all_SGLS_Players_Row = mysqli_fetch_assoc($allSinglesPlayersQuery)) {
        $resultSet = $all_SGLS_Players_Row;
        // echo $resultSet;
    }
    foreach ($resultSet as &$player) {
        echo "$player";
    }

    /* foreach($resultSet as &$player){
        $j = rand(1, 3);
        $player2 = $player + $j;

        $existsSQL = "SELECT * FROM `SGLSMATCH` WHERE ((`PLAYER1` = '" . $player . "') OR (`PLAYER2` = '" . $player . "')) AND `ROUND_NUM` = '" . $SGLSroundID . "'";
        $existsQRY = @$conn->query($existsSQL);
        $alreadyExistsROW = mysqli_num_rows(($existsQRY));


        $totalSGLSplayersSQL = "SELECT * FROM `PLAYERS` WHERE `SGLS_PLAYER`=1 AND `SEASON_NUM`='" . $sznID . "'";
        $totalSGLSplayersQRY = @$conn->query($totalSGLSplayersSQL);
        $totalSGLSplayersROW = mysqli_num_rows($totalSGLSplayersQRY);

        if ($alreadyExistsROW > 0) {
            //$i++;
            echo "Player exists, do nothing";
        } else {
            if ($player2 > $totalSGLSplayersROW) {
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '" . $player . "', NULL, " . $SGLSroundID . ", " . $sznID . ", '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                //$i++;
            } else {
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '" . $player . "', '" . $player2 . "', '" . $SGLSroundID . "', '" . $sznID . "', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                //$i++;
            }
        }
    } */
}



if (isset($_POST['createSGLSID'])){

    createSGLSMatches();

}

#endregion

#region Enter Singles Scores

function getSGLSMatches(){
    global $conn;
    global $sznID;
    // global $currentRound;
    global $SGLSroundID;

    $optSGLSMatchupsSQL = "SELECT `SGLSMATCH`.`ID`, `P1`.`LAST_NAME` as `P_1`, `P2`.`LAST_NAME` as `P_2` FROM `SGLSMATCH` INNER JOIN `PLAYERS` as `P1` ON `P1`.`ID` = `SGLSMATCH`.`PLAYER1` INNER JOIN `PLAYERS` as `P2` ON `P2`.`ID` = `SGLSMATCH`.`PLAYER2` WHERE `SGLSMATCH`.`ROUND_NUM` = '".$SGLSroundID."' AND `SGLSMATCH`.`MATCHWINNER` = 0";
    $optSGLSMatchupsQuery = @$conn->query($optSGLSMatchupsSQL);
    if (!$optSGLSMatchupsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($optSGLSMatchupsRow = mysqli_fetch_assoc($optSGLSMatchupsQuery)) {
        $sglsMatchID = $optSGLSMatchupsRow["ID"];
        $sglsMatchPlayer1 = $optSGLSMatchupsRow["P_1"];
        $sglsMatchPlayer2 = $optSGLSMatchupsRow["P_2"];
        
        // echo "<li>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</li>";
        echo "<option value='",$sglsMatchID,"'>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</option>";
    }

}

function ntrSGLSScores($_matchID, $_p1s1, $_p1s2, $_p1s3, $_p2s1, $_p2s2, $_p2s3,$_playoff,$_challenge,$_winner){
    global $conn;
    global $sznID;
    global $SGLSroundID;

    #region get match players
    $sglsMatchPlayersSQL = "SELECT `ID`,`PLAYER1`,`PLAYER2` FROM `SGLSMATCH` WHERE `ID` = '".$_matchID."'";
    $sglsMatchPlayersQuery = @$conn->query($sglsMatchPlayersSQL);
    #region error handling
    if (!$sglsMatchPlayersQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($sglsMatchPlayersRow = mysqli_fetch_assoc($sglsMatchPlayersQuery)) {
        $sglsMatchNum = $sglsMatchPlayersRow["ID"];
        $sglsMatchP1 = $sglsMatchPlayersRow["PLAYER1"];
        $sglsMatchP2 = $sglsMatchPlayersRow["PLAYER2"];
    }
    #endregion

    #region Get Ranks
    $player1RankSQL = "SELECT `SGLSLADDER`.`ID` AS `Rank` FROM `SGLSLADDER` WHERE `SGLSLADDER`.`PLAYER_ID` = '".$sglsMatchP1."'";
    $player1RankQuery = @$conn->query($player1RankSQL);
    #region error handling
    if (!$player1RankQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player1RankRow = mysqli_fetch_assoc($player1RankQuery)) {
        $player1Rank = $player1RankRow["Rank"];
    }
    $player2RankSQL = "SELECT `SGLSLADDER`.`ID` AS `Rank` FROM `SGLSLADDER` WHERE `SGLSLADDER`.`PLAYER_ID` =  '".$sglsMatchP2."'";
    $player2RankQuery = @$conn->query($player2RankSQL);
    #region error handling
    if (!$player2RankQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player2RankRow = mysqli_fetch_assoc($player2RankQuery)) {
        $player2Rank = $player2RankRow["Rank"];
    }

    $player1curPTSSQL = "SELECT `SGLSLADDER`.`SGLS_POINTS` AS `SGLS_POINTS` FROM `SGLSLADDER` WHERE `SGLSLADDER`.`PLAYER_ID` = '".$sglsMatchP1."'";
    $player1curPTSQuery = @$conn->query($player1curPTSSQL);
    #region error handling
    if (!$player1curPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player1curPTSRow = mysqli_fetch_assoc($player1curPTSQuery)) {
        $player1curPTS = $player1curPTSRow["SGLS_POINTS"];
    }

    $player2curPTSSQL = "SELECT `SGLSLADDER`.`SGLS_POINTS` AS `SGLS_POINTS` FROM `SGLSLADDER` WHERE `SGLSLADDER`.`PLAYER_ID` = '".$sglsMatchP2."'";
    $player2curPTSQuery = @$conn->query($player2curPTSSQL);
    #region error handling
    if (!$player2curPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player2curPTSRow = mysqli_fetch_assoc($player2curPTSQuery)) {
        $player2curPTS = $player2curPTSRow["SGLS_POINTS"];
    }
    #endregion
    
    #region Insert Scores
    $insrtSGLSScores = "UPDATE `SGLSMATCH` SET `P1_SET1` = '".$_p1s1."', `P1_SET2` = '".$_p1s2."', `P1_SET3` = '".$_p1s3."', `P2_SET1` = '".$_p2s1."', `P2_SET2` = '".$_p2s2."', `P2_SET3` = '".$_p2s3."', `MATCHWINNER` = '".$_winner."', `CHALLENGE` = '".$_challenge."', `PLAYOFF` = '".$_playoff."' WHERE `SGLSMATCH`.`ID` = '".$_matchID."'";
    @$conn->query($insrtSGLSScores);
    #endregion

    #region Calculate # of games won
    $player1GamesWon = ($_p1s1 + $_p1s2 + $_p1s3);
    $player2GamesWon = ($_p2s1 + $_p2s2 + $_p2s3);

    #endregion

    #region calculate points
    $player1Points = $player1curPTS;
    $player2Points = $player2curPTS;

    if($_winner == 1){
        if ($player2GamesWon > 10){
            $player2Points += 10;
        } else {
            $player2Points += $player2GamesWon;
        }

        if (($player2Rank - $player1Rank) >= 2){
            $player1Points += (10 + ($player1GamesWon - $player2GamesWon) + (($player1GamesWon - $player2GamesWon)/2));

            if($player1Points < 15){
                $player1Points += 15;
            } 
            if ($player1Points > 25){
                $player1Points += 25;
            } 
        } else {
            $player1Points += (10 + ($player1GamesWon - $player2GamesWon));
        
            if ($player1Points < 11){
                $player1Points += 11;
            }
        }

    } elseif ($_winner == 2) {
        if ($player1GamesWon > 10){
            $player1Points += 10;
        } else {
            $player1Points += $player1GamesWon;
        }
        
        if (($player1Rank - $player2Rank) >= 2){
            $player1Points += (10 + ($player2GamesWon - $player1GamesWon) + (($player2GamesWon - $player1GamesWon)/2));
        
            if ($player2GamesWon < 15){
                $player2Points += 15;
            }
            if ($player2GamesWon > 25){
                $player2Points += 25;
            }
        } else {
            $player2Points += (10 + ($player2GamesWon - $player1GamesWon));
        
            if ($player2GamesWon < 11){
                $player2Points += 11;
            }
        }
    } else {
        $player1Points = $player1curPTS;
        $player2Points = $player2curPTS;
    }

    if ($_challenge == 1){
        $player1Points = ($player1Points / 3);
        $player2Points = ($player2Points / 3);
    }

    if ($_playoff == 1){
        $player1Points = $player1curPTS;
        $player2Points = $player2curPTS;
    }
    
    #endregion

    #region insert points
    // UPDATE `SGLSLADDER` SET `SGLS_POINTS` = '12' WHERE `SGLSLADDER`.`PLAYER_ID` = 1
    $updateSGLSScoresP1 = "UPDATE `SGLSLADDER` SET `SGLS_POINTS` = '".$player1Points."' WHERE `SGLSLADDER`.`PLAYER_ID` = '".$sglsMatchP1."'";
    if ($conn->query($updateSGLSScoresP1) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }
    $updateSGLSScoresP2 = "UPDATE `SGLSLADDER` SET `SGLS_POINTS` = '".$player2Points."' WHERE `SGLSLADDER`.`PLAYER_ID` = '".$sglsMatchP2."'";
    if ($conn->query($updateSGLSScoresP2) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }

    $dropPrimarySQL = "ALTER TABLE `SGLSLADDER` DROP COLUMN `ID`";
    @$conn->query($dropPrimarySQL);
    $sortTableSQL = "ALTER TABLE `SGLSLADDER` ORDER BY `SGLS_POINTS` DESC";
    @$conn->query($sortTableSQL);
    $addPrimarySQL = "ALTER TABLE `SGLSLADDER` ADD COLUMN `ID` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`ID`)";
    @$conn->query($addPrimarySQL);
    
    #endregion
}


if (isset($_POST['ntrSGLSMatchID'])){

    $SGLSMatchID = isset($_POST['ntrSGLSMatchID']) ? $_POST['ntrSGLSMatchID'] : 'No data found';
    $sglsp1s1 = isset($_POST['ntrSGLSS1P1']) ? $_POST['ntrSGLSS1P1'] : 'No data found';
    $sglsp1s2 = isset($_POST['ntrSGLSS2P1']) ? $_POST['ntrSGLSS2P1'] : 'No data found';
    $sglsp1s3 = isset($_POST['ntrSGLSS3P1']) ? $_POST['ntrSGLSS3P1'] : 'No data found';
    $sglsp2s1 = isset($_POST['ntrSGLSS1P2']) ? $_POST['ntrSGLSS1P2'] : 'No data found';
    $sglsp2s2 = isset($_POST['ntrSGLSS2P2']) ? $_POST['ntrSGLSS2P2'] : 'No data found';
    $sglsp2s3 = isset($_POST['ntrSGLSS3P2']) ? $_POST['ntrSGLSS3P2'] : 'No data found';
    $sglsPlayoff = isset($_POST['ntrSGLSPlayoff']) ? $_POST['ntrSGLSPlayoff'] : 'No data found';
    $sglsChallenge = isset($_POST['ntrSGLSChallenge']) ? $_POST['ntrSGLSChallenge'] : 'No data found';
    $sglsWinner = isset($_POST['ntrSGLSWinner']) ? $_POST['ntrSGLSWinner'] : 'No data found';


    ntrSGLSScores($SGLSMatchID, $sglsp1s1, $sglsp1s2, $sglsp1s3, $sglsp2s1, $sglsp2s2, $sglsp2s3,$sglsPlayoff,$sglsChallenge,$sglsWinner);

}


#endregion

#region Enter Doubles Scores

#endregion

#region Add Player

function addNewPlayer ($_fName,$_lName,$_email,$_phone,$_password,$_sglsPoints,$_dblsPoints,$_sglsPlayer,$_dblsPlayer){
    global $conn;
    global $sznID;
    global $SGLSroundID;
    global $options;

    $hashedPassword = password_hash($_password, PASSWORD_BCRYPT, $options);

    $insertPlayerSQL = "INSERT INTO `PLAYERS` (`ID`, `FIRST_NAME`, `LAST_NAME`, `EMAIL`, `PHONE_NUM`, `JOIN_DATE`, `SGLS_PLAYER`, `DBLS_PLAYER`, `SEASON_NUM`, `PASSWORD`) VALUES (NULL, '".$_fName."', '".$_lName."', '".$_email."', '".$_phone."', CURDATE(), '".$_sglsPlayer."', '".$_dblsPlayer."', '".$sznID."', '".$hashedPassword."')";
    @$conn->query($insertPlayerSQL);

    $selectInsertedSQL = "SELECT `ID` FROM `PLAYERS` WHERE `EMAIL` = '".$_email."'";
    $selectInsertedQuery = @$conn->query($selectInsertedSQL);
    #region error handling
    if (!$selectInsertedQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($selectInsertedRow = mysqli_fetch_assoc($selectInsertedQuery)) {
        $selectInsertedID = $selectInsertedRow["ID"];
    }

    if ($_sglsPlayer == 1){
        $insertStartingSGLSPointsSQL = "INSERT INTO `SGLSLADDER` (`PLAYER_ID`, `SGLS_POINTS`, `ID`) VALUES ('".$selectInsertedID."', '".$_sglsPoints."', NULL)";
        @$conn->query($insertStartingSGLSPointsSQL);
    
        $dropPrimarySGLSSQL = "ALTER TABLE `SGLSLADDER` DROP COLUMN `ID`";
        @$conn->query($dropPrimarySGLSSQL);
        $sortTableSGLSSQL = "ALTER TABLE `SGLSLADDER` ORDER BY `SGLS_POINTS` DESC";
        @$conn->query($sortTableSQL);
        $addPrimarySGLSSQL = "ALTER TABLE `SGLSLADDER` ADD COLUMN `ID` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`ID`)";
        @$conn->query($addPrimarySGLSSQL);
    }
    
    if($_dblsPlayer == 1){
        $insertStartingDBLSPointsSQL = "INSERT INTO `DBLSLADDER` (`PLAYER_ID`, `DBLS_POINTS`, `ID`) VALUES ('".$selectInsertedID."', '".$_dblsPoints."', NULL)";
        @$conn->query($insertStartingDBLSPointsSQL);
    
        $dropPrimaryDBLSSQL = "ALTER TABLE `DBLSLADDER` DROP COLUMN `ID`";
        @$conn->query($dropPrimaryDBLSSQL);
        $sortTableDBLSSQL = "ALTER TABLE `DBLSLADDER` ORDER BY `DBLS_POINTS` DESC";
        @$conn->query($sortTableDBLSSQL);
        $addPrimaryDBLSSQL = "ALTER TABLE `DBLSLADDER` ADD COLUMN `ID` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`ID`)";
        @$conn->query($addPrimaryDBLSSQL);
    }

}

if (isset($_POST['ntrNewFName'])){

    $newFName = isset($_POST['ntrNewFName']) ? $_POST['ntrNewFName'] : 'No data found';
    $newLName = isset($_POST['ntrNewLName']) ? $_POST['ntrNewLName'] : 'No data found';
    $newEmail = isset($_POST['ntrNewEmail']) ? $_POST['ntrNewEmail'] : 'No data found';
    $newPhone = isset($_POST['ntrNewPhone']) ? $_POST['ntrNewPhone'] : 'No data found';
    $newPassword = isset($_POST['ntrNewPassword']) ? $_POST['ntrNewPassword'] : 'No data found';
    $newSGLSPoints = isset($_POST['ntrNewSGLSPoints']) ? $_POST['ntrNewSGLSPoints'] : 'No data found';
    $newDBLSPoints = isset($_POST['ntrNewDBLSPoints']) ? $_POST['ntrNewDBLSPoints'] : 'No data found';
    $newSGLSPlayer = isset($_POST['ntrNewSGLSPlayer']) ? $_POST['ntrNewSGLSPlayer'] : 'No data found';
    $newDBLSPlayer = isset($_POST['ntrNewDBLSPlayer']) ? $_POST['ntrNewDBLSPlayer'] : 'No data found';


    addNewPlayer($newFName, $newLName, $newEmail, $newPhone, $newPassword, $newSGLSPoints, $newDBLSPoints, $newSGLSPlayer,$newDBLSPlayer);

}

#endregion

#region Add Announcement

function addAnnouncement($_annTitle,$_annContent,$_annDate,$_annLink){
    global $conn;
    // global $curDate;
    $eventDateSTR = strtotime($_annDate);

    $eventDate = date('Y-m-d',$eventDateSTR);


    $addLinkp1 = str_replace("/*","<a href=\'".$_annLink."\' target=\'_blank\'>",$_annContent);
    $addLinkp2 = str_replace("*/","</a>",$addLinkp1);

    $addAnnouncementSQL = "INSERT INTO `ANNOUNCEMENTS` (`ID`, `START_DATE`, `END_DATE`, `TITLE`, `CONTENT`) VALUES (NULL, CURDATE(), '".$eventDate."', '".$_annTitle."', '".$addLinkp2."')";
    //INSERT INTO `ANNOUNCEMENTS` (`ID`, `START_DATE`, `END_DATE`, `TITLE`, `CONTENT`) VALUES (NULL, '2018-11-20', '2018-11-21', 'test', 'content test')
    @$conn->query($addAnnouncementSQL);

    // echo "$_annTitle $addLinkp2 $eventDate $_annLink";
}

if (isset($_POST['ntrAnnounceTitle'])){

    $newAnnounceTitle = isset($_POST['ntrAnnounceTitle']) ? $_POST['ntrAnnounceTitle'] : 'No data found';
    $newAnnounceDesc = isset($_POST['ntrAnnounceDesc']) ? $_POST['ntrAnnounceDesc'] : 'No data found';
    $newAnnounceDate = isset($_POST['ntrAnnounceDate']) ? $_POST['ntrAnnounceDate'] : 'No data found';
    $newAnnounceLink = isset($_POST['ntrAnnounceLink']) ? $_POST['ntrAnnounceLink'] : 'No data found';

    addAnnouncement($newAnnounceTitle, $newAnnounceDesc, $newAnnounceDate, $newAnnounceLink);

}

#endregion

#region Update Password

function getAllPlayers(){
    global $conn;
    global $sznID;

    $playerListSQL = "SELECT `ID`,`FIRST_NAME`,`LAST_NAME`,`SEASON_NUM` FROM `PLAYERS` WHERE `SEASON_NUM` = '".$sznID."'";
    $playerListQuery = @$conn->query($playerListSQL);
    if (!$playerListQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($playerListRow = mysqli_fetch_assoc($playerListQuery)) {
        $playerID = $playerListRow["ID"];
        $playerFName = $playerListRow["FIRST_NAME"];
        $playerLName = $playerListRow["LAST_NAME"];
        
        // echo "<li>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</li>";
        echo "<option value='",$playerID,"'>",$playerLName,", ",$playerFName,"</option>";
    }

}

function getSinglePlayer($_userID){
    global $conn;
    global $sznID;

    $playerListSQL = "SELECT `ID`,`FIRST_NAME`,`LAST_NAME`,`SEASON_NUM` FROM `PLAYERS` WHERE `SEASON_NUM` = '".$sznID."' AND `ID` = '".$_userID."'";
    $playerListQuery = @$conn->query($playerListSQL);
    if (!$playerListQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($playerListRow = mysqli_fetch_assoc($playerListQuery)) {
        $playerID = $playerListRow["ID"];
        $playerFName = $playerListRow["FIRST_NAME"];
        $playerLName = $playerListRow["LAST_NAME"];
        
        // echo "<li>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</li>";
        echo "<option value='",$playerID,"'>",$playerLName,", ",$playerFName,"</option>";
    }

}

function updatePlayerPassword($_userID,$_pwUpdate){
    global $conn;
    global $options;

    $hashedUpdatePassword = password_hash($_pwUpdate, PASSWORD_BCRYPT, $options);

    $updatePWSQL = "UPDATE `PLAYERS` SET `PASSWORD` = '".$hashedUpdatePassword."' WHERE `PLAYERS`.`ID` = '".$_userID."'";
    @$conn->query($updatePWSQL);
}

if (isset($_POST['ntrUserNewPWID'])){

    $userNewPWID = isset($_POST['ntrUserNewPWID']) ? $_POST['ntrUserNewPWID'] : 'No data found';
    $newUserPW = isset($_POST['ntrNewUserPW']) ? $_POST['ntrNewUserPW'] : 'No data found';


    updatePlayerPassword($userNewPWID, $newUserPW);

}

#endregion

#region Update Email

function updatePlayerEmail($_userID,$_emUpdate){
    global $conn;

    $updateEMSQL = "UPDATE `PLAYERS` SET `EMAIL` = '".$_emUpdate."' WHERE `PLAYERS`.`ID` = '".$_userID."'";
    @$conn->query($updateEMSQL);
}

if (isset($_POST['ntrUserNewEMID'])){

    $userNewEMID = isset($_POST['ntrUserNewEMID']) ? $_POST['ntrUserNewEMID'] : 'No data found';
    $newUserEM = isset($_POST['ntrNewUserEM']) ? $_POST['ntrNewUserEM'] : 'No data found';

    updatePlayerEmail($userNewEMID, $newUserEM);

}

#endregion

#region Update Phone Number

function updatePlayerPhone($_userID,$_pnUpdate){
    global $conn;

    $updatePNSQL = "UPDATE `PLAYERS` SET `PHONE_NUM` = '".$_pnUpdate."' WHERE `PLAYERS`.`ID` = '".$_userID."'";
    @$conn->query($updatePNSQL);
}

if (isset($_POST['ntrUserNewPNID'])){

    $userNewPNID = isset($_POST['ntrUserNewPNID']) ? $_POST['ntrUserNewPNID'] : 'No data found';
    $newUserPN = isset($_POST['ntrNewUserPN']) ? $_POST['ntrNewUserPN'] : 'No data found';

    updatePlayerPhone($userNewPNID, $newUserPN);

}

#endregion

#region Logout
if(!empty($_POST["logout"])) {
    $_SESSION["userID"] = '';
    $_SESSION["userFN"] = '';
    $_SESSION["userLN"] = '';
    $_SESSION["userPIC"] = '';
    session_destroy();
    header("Location: index.php");
}
#endregion