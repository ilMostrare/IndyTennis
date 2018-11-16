<?php
/**
 * Created by PhpStorm.
 * User: bslabach
 * Date: 3/30/18
 * Time: 7:40 PM
 */

#region Create Matches Function

function createSGLSMatches(){
    global $conn;
    global $sznID;
    global $currentRound;

    $resultSet = array();

    $allSinglesPlayersSQL = "SELECT `ID` FROM `PLAYERS` WHERE `SGLS_PLAYER`=1 AND `SEASON_NUM`='" . $sznID . "' ORDER BY `SGLS_POINTS` DESC";
    $allSinglesPlayersQuery = @$conn->query($allSinglesPlayersSQL);
    while ($all_SGLS_Players_Row = mysqli_fetch_assoc($allSinglesPlayersQuery)) {
        $resultSet[] = $all_SGLS_Players_Row;
    }

    foreach($resultSet as &$player){
        $j = rand(1, 3);
        $player2 = $player + $j;

        $existsSQL = "SELECT * FROM `SGLSMATCH` WHERE ((`PLAYER1` = '" . $player . "') OR (`PLAYER2` = '" . $player . "')) AND `ROUND_NUM` = '" . $currentRound . "'";
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
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '" . $player . "', NULL, " . $currentRound . ", " . $sznID . ", '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                //$i++;
            } else {
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '" . $player . "', '" . $player2 . "', '" . $currentRound . "', '" . $sznID . "', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                //$i++;
            }
        }
    }
}



if (isset($_POST['createSGLSID'])){

    createSGLSMatches();

}

#endregion

#region Enter Scores

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
    $player1RankSQL = "SELECT (COUNT(`ID`) + 1) AS Rank FROM PLAYERS WHERE (`SGLS_POINTS` > (SELECT `SGLS_POINTS` FROM PLAYERS WHERE `ID` = '".$sglsMatchP1."'))";
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
    $player2RankSQL = "SELECT (COUNT(`ID`) + 1) AS Rank FROM PLAYERS WHERE (`SGLS_POINTS` > (SELECT `SGLS_POINTS` FROM PLAYERS WHERE `ID` = '".$sglsMatchP2."'))";
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

    $player1curPTSSQL = "SELECT `SGLS_POINTS` FROM `PLAYERS` WHERE `ID` = '".$sglsMatchP1."'";
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

    $player2curPTSSQL = "SELECT `SGLS_POINTS` FROM `PLAYERS` WHERE `ID` = '".$sglsMatchP2."'";
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
    // $sglsMatchPlayersQuery = @$conn->query($sglsMatchPlayersSQL);
    

    if ($conn->query($insrtSGLSScores) === TRUE) {
        echo "Records added successfully.";
        header("Location: Admin.php");
    }
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

    $updateSGLSScoresP1 = "UPDATE `PLAYERS` SET `SGLS_POINTS` = '".$player1Points."' WHERE `PLAYERS`.`ID` = '".$sglsMatchP1."'";
    if ($conn->query($updateSGLSScoresP1) === TRUE) {
        echo "Records added successfully.";
        // header("Location: Admin.php");
    }

    $updateSGLSScoresP2 = "UPDATE `PLAYERS` SET `SGLS_POINTS` = '".$player2Points."' WHERE `PLAYERS`.`ID` = '".$sglsMatchP2."'";
    if ($conn->query($updateSGLSScoresP2) === TRUE) {
        echo "Records added successfully.";
        // header("Location: Admin.php");
    }
    
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

function addNewPlayer (){

}

if (isset($_POST['ntrNewFName'])){

    $SGLSMatchID = isset($_POST['ntrSGLSMatchID']) ? $_POST['ntrSGLSMatchID'] : 'No data found';
    $sglsp1s1 = isset($_POST['ntrSGLSS1P1']) ? $_POST['ntrSGLSS1P1'] : 'No data found';
    $sglsp1s2 = isset($_POST['ntrSGLSS2P1']) ? $_POST['ntrSGLSS2P1'] : 'No data found';
    $sglsp1s3 = isset($_POST['ntrSGLSS3P1']) ? $_POST['ntrSGLSS3P1'] : 'No data found';
    $sglsp2s1 = isset($_POST['ntrSGLSS1P2']) ? $_POST['ntrSGLSS1P2'] : 'No data found';
    $sglsp2s2 = isset($_POST['ntrSGLSS2P2']) ? $_POST['ntrSGLSS2P2'] : 'No data found';
    $sglsp2s3 = isset($_POST['ntrSGLSS3P2']) ? $_POST['ntrSGLSS3P2'] : 'No data found';
    $sglsPlayoff = isset($_POST['ntrSGLSPlayoff']) ? $_POST['ntrSGLSPlayoff'] : 'No data found';


    addNewPlayer($SGLSMatchID, $sglsp1s1, $sglsp1s2, $sglsp1s3, $sglsp2s1, $sglsp2s2, $sglsp2s3,$sglsPlayoff);

}

#endregion