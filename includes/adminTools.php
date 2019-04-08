<?php
/**
 * User: bslabach
 * Date: 3/30/18
 * Time: 7:40 PM
 */
function generate_random_letters($length) {
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
    }
    return $random;
}

#region Create Matches Function

    #region singles
function createSGLSMatches(){
    global $conn;
    global $sznID;
    global $SGLSroundID;

    // $resultSet = array();

    $allSinglesPlayersSQL = "SELECT `PLAYER_ID` FROM `SGLSLADDER`  ORDER BY `ID`";
    $allSinglesPlayersQuery = @$conn->query($allSinglesPlayersSQL);
    while ($all_SGLS_Players_Row = mysqli_fetch_array($allSinglesPlayersQuery)) {
        $resultSet[] = $all_SGLS_Players_Row;
        // echo $resultSet;
    }
    foreach ($resultSet as &$player) {
        $player1 = $player[0];
        echo $player1," - ";

        $player1SQL = "SELECT `ID` FROM `SGLSLADDER` WHERE `PLAYER_ID` = '" . $player1 . "'";
        $player1Query = @$conn->query($player1SQL);
        while ($p1_Players_Row = mysqli_fetch_array($player1Query)) {
            $player1Rank = $p1_Players_Row["ID"];
            echo $player1Rank;
        }

        if ($SGLSroundID % 3 == 1){
            $j = 1;
        } else if ($SGLSroundID % 3 == 2){
            $j = 2;
        } else {
            $j = 3;
        }
        // $j = rand(1,3);
        
        $player2Rank = $player1Rank + $j;
        echo " vs ",$player2Rank," - ";

        $player2SQL = "SELECT `PLAYER_ID` FROM `SGLSLADDER` WHERE `ID` = '" . $player2Rank . "'";
        $player2Query = @$conn->query($player2SQL);
        while ($p2_Players_Row = mysqli_fetch_array($player2Query)) {
            $player2 = $p2_Players_Row["PLAYER_ID"];
            echo $player2," \n";
        }

        $existsSQL = "SELECT COUNT(*) as 'COUNT' FROM `SGLSMATCH` WHERE ((`PLAYER1` = '" . $player1 . "') OR (`PLAYER2` = '" . $player1 . "')) AND `ROUND_NUM` = '" . $SGLSroundID . "'";
        $existsQRY = @$conn->query($existsSQL);
        while ($exists_Row = mysqli_fetch_assoc($existsQRY)) {
            $exists = $exists_Row["COUNT"];
        }
        // echo "exists",$exists;

        $totalSGLSplayersSQL = "SELECT * FROM `SGLSLADDER`";
        $totalSGLSplayersQRY = @$conn->query($totalSGLSplayersSQL);
        $totalSGLSplayersROW = mysqli_num_rows($totalSGLSplayersQRY);
        // echo "rows",$totalSGLSplayersROW," \n";

        // /* $prefix = $sznID+'.'+$SGLSroundID+'.';
        // $SGLSmatchID = uniqid($prefix,FALSE); */

        if ($exists > 0) {
            echo "Player exists, do nothing\n";
        } else {
            if ($player2Rank > $totalSGLSplayersROW) {
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '11' ," . $SGLSroundID . ", " . $sznID . ")";
                @$conn->query($createMatchSQL);
            } else {
                $exists2SQL = "SELECT COUNT(*) as 'COUNT' FROM `SGLSMATCH` WHERE ((`PLAYER1` = '" . $player2 . "') OR (`PLAYER2` = '" . $player2 . "')) AND `ROUND_NUM` = '" . $SGLSroundID . "'";
                $exists2QRY = @$conn->query($exists2SQL);
                while ($exists2_Row = mysqli_fetch_assoc($exists2QRY)) {
                    $exists2 = $exists2_Row["COUNT"];
                }

                if($exists2 > 0){
                    $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '11' ," . $SGLSroundID . ", " . $sznID . ")";
                    @$conn->query($createMatchSQL);
                } else {
                    $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '" . $player2 . "', '" . $SGLSroundID . "', '" . $sznID . "')";
                    @$conn->query($createMatchSQL);
                }                
            }
        }

    }
}

if (isset($_POST['createSGLSID'])){

    createSGLSMatches();

}
    #endregion

    #region doubles
function createDBLSMatches(){
    global $conn;
    global $sznID;
    global $DBLSroundID;

    // $resultSet = array();

    $allDoublesPlayersSQL = "SELECT `PLAYER_ID` FROM `DBLSLADDER`  ORDER BY `ID`";
    $allDoublesPlayersQuery = @$conn->query($allDoublesPlayersSQL);
    while ($all_DBLS_Players_Row = mysqli_fetch_array($allDoublesPlayersQuery)) {
        $resultSet[] = $all_DBLS_Players_Row;
        // echo $resultSet;
    }
    foreach ($resultSet as &$player) {
        $player1 = $player[0];
        echo $player1," - ";

        $player1SQL = "SELECT `ID` FROM `DBLSLADDER` WHERE `PLAYER_ID` = '" . $player1 . "'";
        $player1Query = @$conn->query($player1SQL);
        while ($p1_Players_Row = mysqli_fetch_array($player1Query)) {
            $player1Rank = $p1_Players_Row["ID"];
            // echo $player1Rank;
        }
        
        $player2Rank = $player1Rank + 1;
        $player2SQL = "SELECT `PLAYER_ID` FROM `DBLSLADDER` WHERE `ID` = '" . $player2Rank . "'";
        $player2Query = @$conn->query($player2SQL);
        while ($p2_Players_Row = mysqli_fetch_array($player2Query)) {
            $player2 = $p2_Players_Row["PLAYER_ID"];
        }
        echo $player2," - ";

        $player3Rank = $player1Rank + 2;
        $player3SQL = "SELECT `PLAYER_ID` FROM `DBLSLADDER` WHERE `ID` = '" . $player3Rank . "'";
        $player3Query = @$conn->query($player3SQL);
        while ($p3_Players_Row = mysqli_fetch_array($player3Query)) {
            $player3 = $p3_Players_Row["PLAYER_ID"];
        }
        echo $player3," - ";

        $player4Rank = $player1Rank + 3;
        $player4SQL = "SELECT `PLAYER_ID` FROM `DBLSLADDER` WHERE `ID` = '" . $player4Rank . "'";
        $player4Query = @$conn->query($player4SQL);
        while ($p4_Players_Row = mysqli_fetch_array($player4Query)) {
            $player4 = $p4_Players_Row["PLAYER_ID"];
        }
        echo $player4,"\n";

        $existsSQL = "SELECT COUNT(*) as 'COUNT' FROM `DBLSMATCH` WHERE ((`PLAYER1` = '" . $player1 . "') OR (`PLAYER2` = '" . $player1 . "') OR (`PLAYER3` = '" . $player1 . "') OR (`PLAYER4` = '" . $player1 . "')) AND `ROUND_NUM` = '" . $DBLSroundID . "'";
        $existsQRY = @$conn->query($existsSQL);
        while ($exists_Row = mysqli_fetch_assoc($existsQRY)) {
            $exists = $exists_Row["COUNT"];
        }
        echo "exists",$exists;

        $totalDBLSplayersSQL = "SELECT * FROM `DBLSLADDER`";
        $totalDBLSplayersQRY = @$conn->query($totalDBLSplayersSQL);
        $totalDBLSplayersROW = mysqli_num_rows($totalDBLSplayersQRY);
        echo "rows",$totalDBLSplayersROW," \n";

        if ($exists > 0) {
            echo "Player exists, do nothing\n";
        } else {
            if ($player2Rank > $totalDBLSplayersROW) {
                $createMatchSQL = "INSERT INTO `DBLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `PLAYER3`, `PLAYER4`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '11', '11', '11'," . $DBLSroundID . ", " . $sznID . ")";
                @$conn->query($createMatchSQL);
            } else if ($player3Rank > $totalDBLSplayersROW) {
                $createMatchSQL = "INSERT INTO `DBLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `PLAYER3`, `PLAYER4`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '" . $player2 . "', '11', '11'," . $DBLSroundID . ", " . $sznID . ")";
                @$conn->query($createMatchSQL);
            } else if ($player4Rank > $totalDBLSplayersROW) {
                $createMatchSQL = "INSERT INTO `DBLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `PLAYER3`, `PLAYER4`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '" . $player2 . "', '" . $player3 . "', '11'," . $DBLSroundID . ", " . $sznID . ")";
                @$conn->query($createMatchSQL);
            } else {
                $createMatchSQL = "INSERT INTO `DBLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `PLAYER3`, `PLAYER4`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '" . $player2 . "', '" . $player3 . "', '" . $player4 . "', '" . $DBLSroundID . "', '" . $sznID . "')";
                @$conn->query($createMatchSQL);        
            }
        }

    }
}

if (isset($_POST['createDBLSID'])){

    createDBLSMatches();

}
#endregion

    #region team doubles
function createTDMatches(){
    global $conn;
    global $sznID;
    global $DBLSroundID;

    // $resultSet = array();

    $allTeamsSQL = "SELECT `TEAM_ID` FROM `TDLADDER` WHERE `TEAM_ID` != 11 AND `INACTIVE` != 1 ORDER BY `TD_POINTS` DESC";
    $allTeamsQuery = @$conn->query($allTeamsSQL);
    while ($all_TD_Teams_Row = mysqli_fetch_array($allTeamsQuery)) {
        $resultSet[] = $all_TD_Teams_Row;
        // echo $resultSet;
    }
    foreach ($resultSet as &$team) {
        $team1 = $team[0];
        echo $team1," - ";

        $team1curRankSQL = "SELECT `Rank` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` WHERE `TEAM_ID` = '".$team1."'";
        $team1curRankQuery = @$conn->query($team1curRankSQL);
        while ($team1curRankRow = mysqli_fetch_assoc($team1curRankQuery)) {
            $team1Rank = $team1curRankRow["Rank"];
            echo $team1Rank;
        }

        if ($DBLSroundID % 3 == 1){
            $j = 1;
        } else if ($DBLSroundID % 3 == 2){
            $j = 2;
        } else {
            $j = 3;
        }
        // $j = rand(1,3);
        
        $team2Rank = $team1Rank + $j;
        echo " vs ",$team2Rank," - ";

        $team2SQL = "SELECT `INACTIVE`,`TEAM_ID`, `Rank` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` WHERE `Rank` = '" . $team2Rank . "'";
        $team2Query = @$conn->query($team2SQL);
        while ($p2_Teams_Row = mysqli_fetch_array($team2Query)) {
            $team2 = $p2_Teams_Row["TEAM_ID"];
            $team2innact = $p2_Teams_Row["INACTIVE"];
            echo $team2," \n";
        }

        if($team2innact == 1){
            $team2 = 11;
        }

        $existsSQL = "SELECT COUNT(*) as 'COUNT' FROM `TDMATCH` WHERE ((`TEAM1` = '" . $team1 . "') OR (`TEAM2` = '" . $team1 . "')) AND `ROUND_NUM` = '" . $DBLSroundID . "'";
        $existsQRY = @$conn->query($existsSQL);
        while ($exists_Row = mysqli_fetch_assoc($existsQRY)) {
            $exists = $exists_Row["COUNT"];
        }
        // echo "exists",$exists;

        $totalTDteamsSQL = "SELECT * FROM `TDLADDER`";
        $totalTDteamsQRY = @$conn->query($totalTDteamsSQL);
        $totalTDteamsROW = mysqli_num_rows($totalTDteamsQRY);
        // echo "rows",$totalTDteamsROW," \n";

        // $prefix = $sznID+'.'+$DBLSroundID+'.';
        $TDmatchID = generate_random_letters(10);

        if ($exists > 0) {
            echo "Team exists, do nothing\n";
        } else {
            if (!($team2)) {
                $createMatchSQL = "INSERT INTO `TDMATCH` (`ID`, `TEAM1`, `TEAM2`, `ROUND_NUM`, `SEASON_NUM`) VALUES ('" . $TDmatchID . "', '" . $team1 . "', '11' ," . $DBLSroundID . ", " . $sznID . ")";
                @$conn->query($createMatchSQL);
            } else {
                $exists2SQL = "SELECT COUNT(*) as 'COUNT' FROM `TDMATCH` WHERE ((`TEAM1` = '" . $team2 . "') OR (`TEAM2` = '" . $team2 . "')) AND `ROUND_NUM` = '" . $DBLSroundID . "'";
                $exists2QRY = @$conn->query($exists2SQL);
                while ($exists2_Row = mysqli_fetch_assoc($exists2QRY)) {
                    $exists2 = $exists2_Row["COUNT"];
                }

                if($exists2 > 0){
                    $createMatchSQL = "INSERT INTO `TDMATCH` (`ID`, `TEAM1`, `TEAM2`, `ROUND_NUM`, `SEASON_NUM`) VALUES ('" . $TDmatchID . "', '" . $team1 . "', '11' ," . $DBLSroundID . ", " . $sznID . ")";
                    @$conn->query($createMatchSQL);
                } else {
                    $createMatchSQL = "INSERT INTO `TDMATCH` (`ID`, `TEAM1`, `TEAM2`, `ROUND_NUM`, `SEASON_NUM`) VALUES ('" . $TDmatchID . "', '" . $team1 . "', '" . $team2 . "', '" . $DBLSroundID . "', '" . $sznID . "')";
                    @$conn->query($createMatchSQL);
                }                
            }
        }

    }
}

if (isset($_POST['createTDID'])){

    createTDMatches();

}
#endregion

#endregion

#region Edit Matches

    #region Edit Singles Match
    function getAllSinglesPlayers(){
        global $conn;
        global $sznID;

        $playerListSQL = "SELECT `SGLSLADDER`.`PLAYER_ID` as `PLAYER_ID`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`PLAYERS`.`FIRST_NAME` as `FIRST_NAME` FROM `SGLSLADDER` INNER JOIN `PLAYERS` ON `SGLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` ORDER BY `PLAYERS`.`LAST_NAME`";
        $playerListQuery = @$conn->query($playerListSQL);
        if (!$playerListQuery) {
            $errno = $conn->errno;
            $error = $conn->error;
            $conn->close();
            die("Selection failed: ($errno) $error.");
        }
        while ($playerListRow = mysqli_fetch_assoc($playerListQuery)) {
            $playerID = $playerListRow["PLAYER_ID"];
            $playerFName = $playerListRow["FIRST_NAME"];
            $playerLName = $playerListRow["LAST_NAME"];
            
            // echo "<li>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</li>";
            echo "<option value='",$playerID,"'>",$playerLName,", ",$playerFName,"</option>";
        }

    }

    function editSinglesMatch($_matchID,$_player1,$_player2){
        global $conn;

        // echo $_matchID," ", $_player1," ", $_player2;

        if(($_player1 > 0) && ($_player2 == 0)){
            $editMatchSQL = "UPDATE `SGLSMATCH` SET `SGLSMATCH`.`PLAYER1` = '".$_player1."' WHERE `SGLSMATCH`.`ID` = '".$_matchID."'";
            @$conn->query($editMatchSQL);

            // echo $_matchID," ", $_player1," ", $_player2;

            $selectTBDSQL = "SELECT `ID`,`PLAYER1`,`PLAYER2` FROM `SGLSMATCH` WHERE (`PLAYER1` = '".$_player1."' OR `PLAYER2` = '".$_player1."') AND NOT `SGLSMATCH`.`ID` = '".$_matchID."'";
            $selectTBDQuery = @$conn->query($selectTBDSQL);
            if (!$selectTBDQuery) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }
            while ($selectTBDRow = mysqli_fetch_assoc($selectTBDQuery)) {
                $matchTBDID = $selectTBDRow["ID"];
                $matchTBDP1 = $selectTBDRow["PLAYER1"];
                $matchTBDP2 = $selectTBDRow["PLAYER2"];
            }

            // echo "matchtbdid ",$matchTBDID," p1 ",$matchTBDP1," p2 ",$matchTBDP2;

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_player1){
                    $setTBDSQL = "UPDATE `SGLSMATCH` SET `PLAYER1` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else if ($matchTBDP2 == $_player1){
                    $setTBDSQL = "UPDATE `SGLSMATCH` SET `PLAYER2` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }

            // echo $_matchID," ", $_player1," ", $_player2;

        } else if (($_player1 == 0) && ($_player2 > 0)){
            $editMatchSQL = "UPDATE `SGLSMATCH` SET `PLAYER2` = '".$_player2."' WHERE `SGLSMATCH`.`ID` = '".$_matchID."'";
            @$conn->query($editMatchSQL);

            $selectTBDSQL = "SELECT `ID`,`PLAYER1`,`PLAYER2` FROM `SGLSMATCH` WHERE (`PLAYER1` = '".$_player2."' OR `PLAYER2` = '".$_player2."') AND NOT `SGLSMATCH`.`ID` = '".$_matchID."'";
            $selectTBDQuery = @$conn->query($selectTBDSQL);
            if (!$selectTBDQuery) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }
            while ($selectTBDRow = mysqli_fetch_assoc($selectTBDQuery)) {
                $matchTBDID = $selectTBDRow["ID"];
                $matchTBDP1 = $selectTBDRow["PLAYER1"];
                $matchTBDP2 = $selectTBDRow["PLAYER2"];
            }

            // echo "matchtbdid ",$matchTBDID," p1 ",$matchTBDP1," p2 ",$matchTBDP2;

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_player2){
                    $setTBDSQL = "UPDATE `SGLSMATCH` SET `PLAYER1` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else if ($matchTBDP2 == $_player2){
                    $setTBDSQL = "UPDATE `SGLSMATCH` SET `PLAYER2` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }

        } else {
            $editMatchSQL = "UPDATE `SGLSMATCH` SET `PLAYER1` = '".$_player1."', `PLAYER2` = '".$_player2."' WHERE `SGLSMATCH`.`ID` = '".$_matchID."'";
            @$conn->query($editMatchSQL);

            $setTBD1SQL = "SELECT `ID`,`PLAYER1`,`PLAYER2` FROM `SGLSMATCH` WHERE (`PLAYER1` = '".$_player1."' OR `PLAYER2` = '".$_player1."') AND NOT `SGLSMATCH`.`ID` = '".$_matchID."'";
            $setTBD1Query = @$conn->query($setTBD1SQL);
            if (!$setTBD1Query) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }
            while ($setTBD1Row = mysqli_fetch_assoc($setTBD1Query)) {
                $matchTBDID = $setTBD1Row["ID"];
                $matchTBDP1 = $setTBD1Row["PLAYER1"];
                $matchTBDP2 = $setTBD1Row["PLAYER2"];
            }

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_player1){
                    $setTBD1SQL = "UPDATE `SGLSMATCH` SET `PLAYER1` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD1SQL);
                } else if ($matchTBDP2 == $_player1){
                    $setTBD1SQL = "UPDATE `SGLSMATCH` SET `PLAYER2` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD1SQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }

            $setTBD2SQL = "SELECT `ID`,`PLAYER1`,`PLAYER2` FROM `SGLSMATCH` WHERE `PLAYER1` = '".$_player2."' OR `PLAYER2` = '".$_player2."' AND NOT `SGLSMATCH`.`ID` = '".$_matchID."'";
            $setTBD2Query = @$conn->query($setTBD2SQL);
            if (!$setTBD2Query) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }
            while ($setTBD2Row = mysqli_fetch_assoc($setTBD2Query)) {
                $matchTBD2ID = $setTBD2Row["ID"];
                $matchTBD2P1 = $setTBD2Row["PLAYER1"];
                $matchTBD2P2 = $setTBD2Row["PLAYER2"];
            }

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_player2){
                    $setTBD2SQL = "UPDATE `SGLSMATCH` SET `PLAYER1` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD2SQL);
                } else if ($matchTBDP2 == $_player2){
                    $setTBD2SQL = "UPDATE `SGLSMATCH` SET `PLAYER2` = 11 WHERE `SGLSMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD2SQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }
        }
    }

    if (isset($_POST['ntrEditsglsMatchID'])){

        $editsglsMatchID = isset($_POST['ntrEditsglsMatchID']) ? $_POST['ntrEditsglsMatchID'] : 'No data found';
        $editSGLSP1 = isset($_POST['ntrEditSGLSP1']) ? $_POST['ntrEditSGLSP1'] : 'No data found';
        $editSGLSP2 = isset($_POST['ntrEditSGLSP2']) ? $_POST['ntrEditSGLSP2'] : 'No data found';    

        editSinglesMatch($editsglsMatchID, $editSGLSP1, $editSGLSP2);

    }

    #endregion

    #region Doubles Match Edit
    function getAllDoublesPlayers(){
        global $conn;
        global $sznID;

        $playerListSQL = "SELECT `DBLSLADDER`.`PLAYER_ID` as `PLAYER_ID`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`PLAYERS`.`FIRST_NAME` as `FIRST_NAME` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `DBLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` ORDER BY `PLAYERS`.`LAST_NAME`";
        $playerListQuery = @$conn->query($playerListSQL);
        if (!$playerListQuery) {
            $errno = $conn->errno;
            $error = $conn->error;
            $conn->close();
            die("Selection failed: ($errno) $error.");
        }
        while ($playerListRow = mysqli_fetch_assoc($playerListQuery)) {
            $playerID = $playerListRow["PLAYER_ID"];
            $playerFName = $playerListRow["FIRST_NAME"];
            $playerLName = $playerListRow["LAST_NAME"];
            
            // echo "<li>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</li>";
            echo "<option value='",$playerID,"'>",$playerLName,", ",$playerFName,"</option>";
        }

    }

    function editDoublesMatch($_matchID,$_player1,$_player2,$_player3,$_player4){
        global $conn;
        
        $player_arr = array($_player1,$_player2,$_player3,$_player4);

        foreach($player_arr as $key => $plyr){

            if($plyr > 0){
                if($key == 0){
                    $editMatchSQL = "UPDATE `DBLSMATCH` SET `DBLSMATCH`.`PLAYER1` = '".$plyr."' WHERE `DBLSMATCH`.`ID` = '".$_matchID."'";
                    @$conn->query($editMatchSQL);
                } else if ($key == 1) {
                    $editMatchSQL = "UPDATE `DBLSMATCH` SET `DBLSMATCH`.`PLAYER2` = '".$plyr."' WHERE `DBLSMATCH`.`ID` = '".$_matchID."'";
                    @$conn->query($editMatchSQL);
                } else if ($key == 2) {
                    $editMatchSQL = "UPDATE `DBLSMATCH` SET `DBLSMATCH`.`PLAYER3` = '".$plyr."' WHERE `DBLSMATCH`.`ID` = '".$_matchID."'";
                    @$conn->query($editMatchSQL);
                } else if ($key == 3){
                    $editMatchSQL = "UPDATE `DBLSMATCH` SET `DBLSMATCH`.`PLAYER4` = '".$plyr."' WHERE `DBLSMATCH`.`ID` = '".$_matchID."'";
                    @$conn->query($editMatchSQL);
                } else {
                    // do nothing
                }

                $selectTBDSQL = "SELECT `ID`,`PLAYER1`,`PLAYER2`,`PLAYER3`,`PLAYER4` FROM `DBLSMATCH` WHERE (`PLAYER1` = '".$plyr."' OR `PLAYER2` = '".$plyr."' OR `PLAYER3` = '".$plyr."' OR `PLAYER4` = '".$plyr."') AND NOT `DBLSMATCH`.`ID` = '".$_matchID."'";
                $selectTBDQuery = @$conn->query($selectTBDSQL);
                if (!$selectTBDQuery) {
                    $errno = $conn->errno;
                    $error = $conn->error;
                    $conn->close();
                    die("Selection failed: ($errno) $error.");
                }
                while ($selectTBDRow = mysqli_fetch_assoc($selectTBDQuery)) {
                    $matchTBDID = $selectTBDRow["ID"];
                    $matchTBDP1 = $selectTBDRow["PLAYER1"];
                    $matchTBDP2 = $selectTBDRow["PLAYER2"];
                    $matchTBDP3 = $selectTBDRow["PLAYER3"];
                    $matchTBDP4 = $selectTBDRow["PLAYER4"];
                }

                if ($matchTBDID != ''){
                    if ($matchTBDP1 == $plyr){
                        $setTBDSQL = "UPDATE `DBLSMATCH` SET `PLAYER1` = 11 WHERE `DBLSMATCH`.`ID` = '".$matchTBDID."'";
                        @$conn->query($setTBDSQL);
                    } else if ($matchTBDP2 == $plyr){
                        $setTBDSQL = "UPDATE `DBLSMATCH` SET `PLAYER2` = 11 WHERE `DBLSMATCH`.`ID` = '".$matchTBDID."'";
                        @$conn->query($setTBDSQL);
                    } else if ($matchTBDP3 == $plyr){
                        $setTBDSQL = "UPDATE `DBLSMATCH` SET `PLAYER3` = 11 WHERE `DBLSMATCH`.`ID` = '".$matchTBDID."'";
                        @$conn->query($setTBDSQL);
                    } else if ($matchTBDP4 == $plyr){
                        $setTBDSQL = "UPDATE `DBLSMATCH` SET `PLAYER4` = 11 WHERE `DBLSMATCH`.`ID` = '".$matchTBDID."'";
                        @$conn->query($setTBDSQL);
                    } else {
                        // do nothing
                    }
                } else {
                    echo "no secondary match to be updated";
                }
            } else {
                // do nothing
            }

            $i++;
            unset($matchTBDID,$matchTBDP1,$matchTBDP2,$matchTBDP3,$matchTBDP4);
        }

        unset($player_arr,$i);

    }

    if (isset($_POST['ntrEditdblsMatchID'])){

        $editdblsMatchID = isset($_POST['ntrEditdblsMatchID']) ? $_POST['ntrEditdblsMatchID'] : 'No data found';
        $editDBLSP1 = isset($_POST['ntrEditDBLSP1']) ? $_POST['ntrEditDBLSP1'] : 'No data found';
        $editDBLSP2 = isset($_POST['ntrEditDBLSP2']) ? $_POST['ntrEditDBLSP2'] : 'No data found';    
        $editDBLSP3 = isset($_POST['ntrEditDBLSP3']) ? $_POST['ntrEditDBLSP3'] : 'No data found';
        $editDBLSP4 = isset($_POST['ntrEditDBLSP4']) ? $_POST['ntrEditDBLSP4'] : 'No data found';  

        editDoublesMatch($editdblsMatchID, $editDBLSP1, $editDBLSP2, $editDBLSP3, $editDBLSP4);

    }
    #endregion

    #region Team Doubles Match Edit
    function getAllDoublesTeam(){
        global $conn;

        $teamListSQL = "SELECT `TDLADDER`.`TEAM_ID` as `TEAM_ID`,`P1`.`LAST_NAME` as `P1`,`P2`.`LAST_NAME` as `P2` FROM `TDLADDER` INNER JOIN `PLAYERS` AS `P1` ON `TDLADDER`.`PLYR1_ID` = `P1`.`ID` INNER JOIN `PLAYERS` AS `P2` ON `TDLADDER`.`PLYR2_ID` = `P2`.`ID` ORDER BY `P1`.`LAST_NAME`";
        $teamListQuery = @$conn->query($teamListSQL);
        if (!$teamListQuery) {
            $errno = $conn->errno;
            $error = $conn->error;
            $conn->close();
            die("Selection failed: ($errno) $error.");
        }
        while ($teamListRow = mysqli_fetch_assoc($teamListQuery)) {
            $teamID = $teamListRow["TEAM_ID"];
            $teamP1 = $teamListRow["P1"];
            $teamP2 = $teamListRow["P2"];
            
            // echo "<li>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</li>";
            echo "<option value='",$teamID,"'>",$teamP1," - ",$teamP2,"</option>";
        }

    }

    function getTDMatches(){
        global $conn;
        global $sznID;
        global $DBLSroundID;
    
        $optTDMatchupsSQL = "SELECT `TDMATCH`.`ID`,`P1`.`LAST_NAME` AS `PY1`,`P2`.`LAST_NAME` AS `PY2`,`P3`.`LAST_NAME` AS `PY3`,`P4`.`LAST_NAME` AS `PY4` FROM `TDMATCH` LEFT JOIN `TDLADDER` AS `T1` ON `TDMATCH`.`TEAM1` = `T1`.`TEAM_ID` LEFT JOIN `TDLADDER` AS `T2` ON `TDMATCH`.`TEAM2` = `T2`.`TEAM_ID` LEFT JOIN `PLAYERS` AS `P1` ON `T1`.`PLYR1_ID` = `P1`.`ID` LEFT JOIN `PLAYERS` AS `P2` ON `T1`.`PLYR2_ID` = `P2`.`ID` LEFT JOIN `PLAYERS` AS `P3` ON `T2`.`PLYR1_ID` = `P3`.`ID` LEFT JOIN `PLAYERS` AS `P4` ON `T2`.`PLYR2_ID` = `P4`.`ID` WHERE `TDMATCH`.`ROUND_NUM` = '".$DBLSroundID."' AND `TDMATCH`.`MATCHWINNER` = 0 AND `TDMATCH`.`DNP` = 0 ";
        $optTDMatchupsQuery = @$conn->query($optTDMatchupsSQL);
        if (!$optTDMatchupsQuery) {
            $errno = $conn->errno;
            $error = $conn->error;
            $conn->close();
            die("Selection failed: ($errno) $error.");
        }
        while ($optTDMatchupsRow = mysqli_fetch_assoc($optTDMatchupsQuery)) {
            $TDMatchID = $optTDMatchupsRow["ID"];
            $TDMatchPlayer1 = $optTDMatchupsRow["PY1"];
            $TDMatchPlayer2 = $optTDMatchupsRow["PY2"];
            $TDMatchPlayer3 = $optTDMatchupsRow["PY3"];
            $TDMatchPlayer4 = $optTDMatchupsRow["PY4"];
            
            echo "<option value='",$TDMatchID,"'>",$TDMatchPlayer1," / ",$TDMatchPlayer2," vs ",$TDMatchPlayer3," / ",$TDMatchPlayer4,"</option>";
        }
    
    }

    function editTeamDoublesMatch($_matchID,$_team1,$_team2){
        global $conn;

        // echo $_matchID," ", $_team1," ", $_team2;

        if(($_team1 != 0) && ($_team2 == 0)){
            // if changing team 1 and not team 2
            $editMatchSQL = "UPDATE `TDMATCH` SET `TDMATCH`.`TEAM1` = '".$_team1."' WHERE `TDMATCH`.`ID` = '".$_matchID."'";
            @$conn->query($editMatchSQL);

            // echo $_matchID," ", $_team1," ", $_team2;

            $selectTBDSQL = "SELECT `ID`,`TEAM1`,`TEAM2` FROM `TDMATCH` WHERE (`TEAM1` = '".$_team1."' OR `TEAM2` = '".$_team1."') AND NOT `TDMATCH`.`ID` = '".$_matchID."'";
            $selectTBDQuery = @$conn->query($selectTBDSQL);
            if (!$selectTBDQuery) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }
            while ($selectTBDRow = mysqli_fetch_assoc($selectTBDQuery)) {
                $matchTBDID = $selectTBDRow["ID"];
                $matchTBDP1 = $selectTBDRow["TEAM1"];
                $matchTBDP2 = $selectTBDRow["TEAM2"];
            }

            // echo "matchtbdid ",$matchTBDID," p1 ",$matchTBDP1," p2 ",$matchTBDP2;

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_team1){
                    $setTBDSQL = "UPDATE `TDMATCH` SET `TEAM1` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else if ($matchTBDP2 == $_team1){
                    $setTBDSQL = "UPDATE `TDMATCH` SET `TEAM2` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }

            // echo $_matchID," ", $_team1," ", $_team2;

        } else if (($_team1 == 0) && ($_team2 != 0)){
            // if changing team 2 and not team 1            
            $editMatchSQL = "UPDATE `TDMATCH` SET `TEAM2` = '".$_team2."' WHERE `TDMATCH`.`ID` = '".$_matchID."'";
            @$conn->query($editMatchSQL);

            $selectTBDSQL = "SELECT `ID`,`TEAM1`,`TEAM2` FROM `TDMATCH` WHERE (`TEAM1` = '".$_team2."' OR `TEAM2` = '".$_team2."') AND NOT `TDMATCH`.`ID` = '".$_matchID."'";
            $selectTBDQuery = @$conn->query($selectTBDSQL);
            if (!$selectTBDQuery) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }
            while ($selectTBDRow = mysqli_fetch_assoc($selectTBDQuery)) {
                $matchTBDID = $selectTBDRow["ID"];
                $matchTBDP1 = $selectTBDRow["TEAM1"];
                $matchTBDP2 = $selectTBDRow["TEAM2"];
            }

            echo "matchtbdid ",$matchTBDID," p1 ",$matchTBDP1," p2 ",$matchTBDP2;

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_team2){
                    $setTBDSQL = "UPDATE `TDMATCH` SET `TEAM1` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else if ($matchTBDP2 == $_team2){
                    $setTBDSQL = "UPDATE `TDMATCH` SET `TEAM2` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBDSQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }

        } else {
            // if changing both teams
            $editMatchSQL = "UPDATE `TDMATCH` SET `TEAM1` = '".$_team1."', `TEAM2` = '".$_team2."' WHERE `TDMATCH`.`ID` = '".$_matchID."'";
            @$conn->query($editMatchSQL);

            $setTBD1SQL = "SELECT `ID`,`TEAM1`,`TEAM2` FROM `TDMATCH` WHERE (`TEAM1` = '".$_team1."' OR `TEAM2` = '".$_team1."') AND NOT `TDMATCH`.`ID` = '".$_matchID."'";
            $setTBD1Query = @$conn->query($setTBD1SQL);
            if (!$setTBD1Query) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }

            while ($setTBD1Row = mysqli_fetch_assoc($setTBD1Query)) {
                $matchTBDID = $setTBD1Row["ID"];
                $matchTBDP1 = $setTBD1Row["TEAM1"];
                $matchTBDP2 = $setTBD1Row["TEAM2"];
            }

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_team1){
                    $setTBD1SQL = "UPDATE `TDMATCH` SET `TEAM1` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD1SQL);
                } else if ($matchTBDP2 == $_team1){
                    $setTBD1SQL = "UPDATE `TDMATCH` SET `TEAM2` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD1SQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }

            $setTBD2SQL = "SELECT `ID`,`TEAM1`,`TEAM2` FROM `TDMATCH` WHERE `TEAM1` = '".$_team2."' OR `TEAM2` = '".$_team2."' AND NOT `TDMATCH`.`ID` = '".$_matchID."'";
            $setTBD2Query = @$conn->query($setTBD2SQL);
            if (!$setTBD2Query) {
                $errno = $conn->errno;
                $error = $conn->error;
                $conn->close();
                die("Selection failed: ($errno) $error.");
            }
            while ($setTBD2Row = mysqli_fetch_assoc($setTBD2Query)) {
                $matchTBD2ID = $setTBD2Row["ID"];
                $matchTBD2P1 = $setTBD2Row["TEAM1"];
                $matchTBD2P2 = $setTBD2Row["TEAM2"];
            }

            if ($matchTBDID != ''){
                if ($matchTBDP1 == $_team2){
                    $setTBD2SQL = "UPDATE `TDMATCH` SET `TEAM1` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD2SQL);
                } else if ($matchTBDP2 == $_team2){
                    $setTBD2SQL = "UPDATE `TDMATCH` SET `TEAM2` = 11 WHERE `TDMATCH`.`ID` = '".$matchTBDID."'";
                    @$conn->query($setTBD2SQL);
                } else {
                    // do nothing
                }
            } else {
                echo "no secondary match to be updated";
            }
        }
    }

    if (isset($_POST['ntrEditTDMatchID'])){

        $editTDMatchID = isset($_POST['ntrEditTDMatchID']) ? $_POST['ntrEditTDMatchID'] : 'No data found';
        $editTDT1 = isset($_POST['ntrEditTDT1']) ? $_POST['ntrEditTDT1'] : 'No data found';
        $editTDT2 = isset($_POST['ntrEditTDT2']) ? $_POST['ntrEditTDT2'] : 'No data found';    

        editTeamDoublesMatch($editTDMatchID, $editTDT1, $editTDT2);

    }
    #endregion

#endregion

#region Insert Challenge Match
function addChallengeMatch($player1,$player2){
    global $conn;
    global $sznID;
    global $SGLSroundID;

    $insertChallengeSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`, `DNP`, `LAST_MODIFIED`) VALUES (NULL, '".$player1."', '".$player2."', '".$SGLSroundID."', '$sznID', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', CURRENT_TIMESTAMP)";
    @$conn->query($insertChallengeSQL);
}

if (isset($_POST['ntrAddChallengeP1'])){

    $addChallengeP1 = isset($_POST['ntrAddChallengeP1']) ? $_POST['ntrAddChallengeP1'] : 'No data found';
    $addChallengeP2 = isset($_POST['ntrAddChallengeP2']) ? $_POST['ntrAddChallengeP2'] : 'No data found';

    addChallengeMatch($addChallengeP1, $addChallengeP2);

}
#endregion

#region Enter Scores

    #region Enter Singles Scores

function getSGLSMatches(){
    global $conn;
    global $sznID;
    global $SGLSroundID;

    $optSGLSMatchupsSQL = "SELECT `SGLSMATCH`.`ID`, `P1`.`LAST_NAME` as `P_1`, `P2`.`LAST_NAME` as `P_2` FROM `SGLSMATCH` INNER JOIN `PLAYERS` as `P1` ON `P1`.`ID` = `SGLSMATCH`.`PLAYER1` INNER JOIN `PLAYERS` as `P2` ON `P2`.`ID` = `SGLSMATCH`.`PLAYER2` WHERE `SGLSMATCH`.`ROUND_NUM` = '".$SGLSroundID."' AND `SGLSMATCH`.`MATCHWINNER` = 0 AND `SGLSMATCH`.`DNP` = 0";
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
        
        echo "<option value='",$sglsMatchID,"'>",$sglsMatchPlayer1," vs. ",$sglsMatchPlayer2,"</option>";
    }

}

function ntrSGLSScores($_matchID, $_p1s1, $_p1s2, $_p1s3, $_p2s1, $_p2s2, $_p2s3,$_playoff,$_challenge,$_winner,$_DNP){
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
    
    $player1curPTSSQL = "SELECT `ID` AS `Rank`,`SGLS_POINTS`,`SGLS_WINS`,`SGLS_LOSSES` FROM `SGLSLADDER` WHERE `PLAYER_ID` = '".$sglsMatchP1."'";
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
        $player1Rank = $player1curPTSRow["Rank"];
        $player1curPTS = $player1curPTSRow["SGLS_POINTS"];
        $player1curWins = $player1curPTSRow["SGLS_WINS"];
        $player1curLosses = $player1curPTSRow["SGLS_LOSSES"];
    }

    $player2curPTSSQL = "SELECT `ID` AS `Rank`,`SGLS_POINTS`,`SGLS_WINS`,`SGLS_LOSSES` FROM `SGLSLADDER` WHERE `PLAYER_ID` = '".$sglsMatchP2."'";
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
        $player2Rank = $player2curPTSRow["Rank"];
        $player2curPTS = $player2curPTSRow["SGLS_POINTS"];
        $player2curWins = $player2curPTSRow["SGLS_WINS"];
        $player2curLosses = $player2curPTSRow["SGLS_LOSSES"];
    }
    #endregion
    
    #region Insert Scores

    if($_DNP == 1){
        $insrtSGLSDNP = "UPDATE `SGLSMATCH` SET `DNP` = '".$_DNP."' WHERE `SGLSMATCH`.`ID` = '".$_matchID."'";
        @$conn->query($insrtSGLSDNP);
    } else {
        $insrtSGLSScores = "UPDATE `SGLSMATCH` SET `P1_SET1` = '".$_p1s1."', `P1_SET2` = '".$_p1s2."', `P1_SET3` = '".$_p1s3."', `P2_SET1` = '".$_p2s1."', `P2_SET2` = '".$_p2s2."', `P2_SET3` = '".$_p2s3."', `MATCHWINNER` = '".$_winner."', `CHALLENGE` = '".$_challenge."', `PLAYOFF` = '".$_playoff."' WHERE `SGLSMATCH`.`ID` = '".$_matchID."'";
        @$conn->query($insrtSGLSScores);
    }

    #endregion

    #region Calculate # of games won
    $player1GamesWon = ($_p1s1 + $_p1s2 + $_p1s3);
    $player2GamesWon = ($_p2s1 + $_p2s2 + $_p2s3);

    #endregion

    #region calculate points
    $player1Points = $player1curPTS;
    $player2Points = $player2curPTS;
    $p1Wins = $player1curWins;
    $p2Wins = $player2curWins;
    $p1Losses = $player1curLosses;
    $p2Losses = $player2curLosses;

    if($_winner == 1){
        $p1Wins++;
        $p2Losses++;

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
        $p2Wins++;
        $p1Losses++;

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
        $p1Wins = $player1curWins;
        $p2Wins = $player2curWins;
        $p1Losses = $player1curLosses;
        $p2Losses = $player2curLosses;
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
    $updateSGLSScoresP1 = "UPDATE `SGLSLADDER` SET `SGLS_POINTS` = '".$player1Points."', `SGLS_WINS` = '".$p1Wins."', `SGLS_LOSSES` = '".$p1Losses."' WHERE `SGLSLADDER`.`PLAYER_ID` = '".$sglsMatchP1."'";
    if ($conn->query($updateSGLSScoresP1) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }
    $updateSGLSScoresP2 = "UPDATE `SGLSLADDER` SET `SGLS_POINTS` = '".$player2Points."', `SGLS_WINS` = '".$p2Wins."', `SGLS_LOSSES` = '".$p2Losses."' WHERE `SGLSLADDER`.`PLAYER_ID` = '".$sglsMatchP2."'";
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
    $sglsDNP = isset($_POST['ntrsglsDNP']) ? $_POST['ntrsglsDNP'] : 'No data found';


    ntrSGLSScores($SGLSMatchID, $sglsp1s1, $sglsp1s2, $sglsp1s3, $sglsp2s1, $sglsp2s2, $sglsp2s3,$sglsPlayoff,$sglsChallenge,$sglsWinner,$sglsDNP);

}


#endregion

    #region Enter Doubles Scores

function getDBLSMatches(){
    global $conn;
    global $sznID;
    global $DBLSroundID;

    $optDBLSMatchupsSQL = "SELECT `DBLSMATCH`.`ID`, `P1`.`LAST_NAME` as `P_1`, `P2`.`LAST_NAME` as `P_2`, `P3`.`LAST_NAME` as `P_3`, `P4`.`LAST_NAME` as `P_4` FROM `DBLSMATCH` INNER JOIN `PLAYERS` as `P1` ON `P1`.`ID` = `DBLSMATCH`.`PLAYER1` INNER JOIN `PLAYERS` as `P2` ON `P2`.`ID` = `DBLSMATCH`.`PLAYER2` INNER JOIN `PLAYERS` as `P3` ON `P3`.`ID` = `DBLSMATCH`.`PLAYER3` INNER JOIN `PLAYERS` as `P4` ON `P4`.`ID` = `DBLSMATCH`.`PLAYER4` WHERE `DBLSMATCH`.`ROUND_NUM` = '".$DBLSroundID."' AND `DBLSMATCH`.`SET1WINNER` = 0 AND `DBLSMATCH`.`SET2WINNER` = 0 AND `DBLSMATCH`.`SET3WINNER` = 0 AND `DBLSMATCH`.`DNP` = 0";
    $optDBLSMatchupsQuery = @$conn->query($optDBLSMatchupsSQL);
    if (!$optDBLSMatchupsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($optDBLSMatchupsRow = mysqli_fetch_assoc($optDBLSMatchupsQuery)) {
        $DBlsMatchID = $optDBLSMatchupsRow["ID"];
        $DBlsMatchPlayer1 = $optDBLSMatchupsRow["P_1"];
        $DBlsMatchPlayer2 = $optDBLSMatchupsRow["P_2"];
        $DBlsMatchPlayer3 = $optDBLSMatchupsRow["P_3"];
        $DBlsMatchPlayer4 = $optDBLSMatchupsRow["P_4"];
        
        echo "<option value='",$DBlsMatchID,"'>",$DBlsMatchPlayer1,", ",$DBlsMatchPlayer2,", ",$DBlsMatchPlayer3,", ",$DBlsMatchPlayer4,"</option>";
    }

}

function ntrDBLSScores($_MatchID, $_T1s1, $_T1s2, $_T1s3, $_T2s1, $_T2s2, $_T2s3,$_Playoff,$_Set1Winner,$_Set2Winner,$_Set3Winner,$_DNP){
    global $conn;
    global $sznID;
    global $DBLSroundID;


    #region get match players
    $dblsMatchPlayersSQL = "SELECT `ID`,`PLAYER1`,`PLAYER2`,`PLAYER3`,`PLAYER4` FROM `DBLSMATCH` WHERE `ID` = '".$_MatchID."'";
    $dblsMatchPlayersQuery = @$conn->query($dblsMatchPlayersSQL);
    #region error handling
    if (!$dblsMatchPlayersQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($dblsMatchPlayersRow = mysqli_fetch_assoc($dblsMatchPlayersQuery)) {
        $dblsMatchNum = $dblsMatchPlayersRow["ID"];
        $dblsMatchP1 = $dblsMatchPlayersRow["PLAYER1"];
        $dblsMatchP2 = $dblsMatchPlayersRow["PLAYER2"];
        $dblsMatchP3 = $dblsMatchPlayersRow["PLAYER3"];
        $dblsMatchP4 = $dblsMatchPlayersRow["PLAYER4"];
    }

    #endregion

    #region Insert Scores
    if($_DNP == 1){
        $insrtDBLSdnp = "UPDATE `DBLSMATCH` SET `DNP` = '".$_DNP."' WHERE `DBLSMATCH`.`ID` = '".$_MatchID."'";
        @$conn->query($insrtDBLSdnp);
    } else {
        $insrtDBLSScores = "UPDATE `DBLSMATCH` SET `T1_SET1` = '".$_T1s1."', `T1_SET2` = '".$_T1s2."', `T1_SET3` = '".$_T1s3."', `T2_SET1` = '".$_T2s1."', `T2_SET2` = '".$_T2s2."', `T2_SET3` = '".$_T2s3."', `SET1WINNER` = '".$_Set1Winner."', `SET2WINNER` = '".$_Set2Winner."', `SET3WINNER` = '".$_Set3Winner."' WHERE `DBLSMATCH`.`ID` = '".$_MatchID."'";
        @$conn->query($insrtDBLSScores);
    }
    #endregion

    #region Get Current Points
    $player1curDBLSPTSSQL = "SELECT `DBLS_POINTS`,`DBLS_WINS`,`DBLS_LOSSES` FROM `DBLSLADDER` WHERE `PLAYER_ID` = '".$dblsMatchP1."'";
    $player1curDBLSPTSQuery = @$conn->query($player1curDBLSPTSSQL);
    #region error handling
    if (!$player1curDBLSPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player1curDBLSPTSRow = mysqli_fetch_assoc($player1curDBLSPTSQuery)) {
        $player1curDBLSPTS = $player1curDBLSPTSRow["DBLS_POINTS"];
        $player1curWins = $player1curDBLSPTSRow["DBLS_WINS"];
        $player1curLosses = $player1curDBLSPTSRow["DBLS_LOSSES"];
    }

    $player2curDBLSPTSSQL = "SELECT `DBLS_POINTS`,`DBLS_WINS`,`DBLS_LOSSES` FROM `DBLSLADDER` WHERE `PLAYER_ID` = '".$dblsMatchP2."'";
    $player2curDBLSPTSQuery = @$conn->query($player2curDBLSPTSSQL);
    #region error handling
    if (!$player2curDBLSPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player2curDBLSPTSRow = mysqli_fetch_assoc($player2curDBLSPTSQuery)) {
        $player2curDBLSPTS = $player2curDBLSPTSRow["DBLS_POINTS"];
        $player2curWins = $player2curDBLSPTSRow["DBLS_WINS"];
        $player2curLosses = $player2curDBLSPTSRow["DBLS_LOSSES"];
    }

    $player3curDBLSPTSSQL = "SELECT `DBLS_POINTS`,`DBLS_WINS`,`DBLS_LOSSES` FROM `DBLSLADDER` WHERE `PLAYER_ID` = '".$dblsMatchP3."'";
    $player3curDBLSPTSQuery = @$conn->query($player3curDBLSPTSSQL);
    #region error handling
    if (!$player3curDBLSPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player3curDBLSPTSRow = mysqli_fetch_assoc($player3curDBLSPTSQuery)) {
        $player3curDBLSPTS = $player3curDBLSPTSRow["DBLS_POINTS"];
        $player3curWins = $player3curDBLSPTSRow["DBLS_WINS"];
        $player3curLosses = $player3curDBLSPTSRow["DBLS_LOSSES"];
    }

    $player4curDBLSPTSSQL = "SELECT `DBLS_POINTS`,`DBLS_WINS`,`DBLS_LOSSES` FROM `DBLSLADDER` WHERE `PLAYER_ID` = '".$dblsMatchP4."'";
    $player4curDBLSPTSQuery = @$conn->query($player4curDBLSPTSSQL);
    #region error handling
    if (!$player4curDBLSPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($player4curDBLSPTSRow = mysqli_fetch_assoc($player4curDBLSPTSQuery)) {
        $player4curDBLSPTS = $player4curDBLSPTSRow["DBLS_POINTS"];
        $player4curWins = $player4curDBLSPTSRow["DBLS_WINS"];
        $player4curLosses = $player4curDBLSPTSRow["DBLS_LOSSES"];
    }
    #endregion
    
    #region Calculate Points
    $player1Points = $player1curDBLSPTS;
    $player2Points = $player2curDBLSPTS;
    $player3Points = $player3curDBLSPTS;
    $player4Points = $player4curDBLSPTS;
    $p1Wins = $player1curWins;
    $p2Wins = $player2curWins;
    $p1Losses = $player1curLosses;
    $p2Losses = $player2curLosses;
    $p3Wins = $player3curWins;
    $p4Wins = $player4curWins;
    $p3Losses = $player3curLosses;
    $p4Losses = $player4curLosses;

    if ($_Set1Winner == 1){
        $player3Points += $_T2s1;
        $player4Points += $_T2s1;
        $p3Losses++;
        $p4Losses++;

        $player1Points += (6 + ($_T1s1 - $_T2s1) );
        $player2Points += (6 + ($_T1s1 - $_T2s1) );
        $p1Wins++;
        $p2Wins++;
    } else if ($_Set1Winner == 2){
        $player1Points += $_T1s1;
        $player2Points += $_T1s1;
        $p1Losses++;
        $p2Losses++;

        $player3Points += (6 + ($_T2s1 - $_T1s1) );
        $player4Points += (6 + ($_T2s1 - $_T1s1) );
        $p3Wins++;
        $p4Wins++;
    } else {
        $player1Points = $player1curPTS;
        $player2Points = $player2curPTS;
        $player3Points = $player3curPTS;
        $player4Points = $player4curPTS;
        $p1Wins = $player1curWins;
        $p2Wins = $player2curWins;
        $p1Losses = $player1curLosses;
        $p2Losses = $player2curLosses;
        $p3Wins = $player3curWins;
        $p4Wins = $player4curWins;
        $p3Losses = $player3curLosses;
        $p4Losses = $player4curLosses;
    }

    if($_Set2Winner == 1){
        $player2Points += $_T2s2;
        $player4Points += $_T2s2;
        $p2Losses++;
        $p4Losses++;

        $player1Points += (6 + ($_T1s2 - $_T2s2) );
        $player3Points += (6 + ($_T1s2 - $_T2s2) );
        $p1Wins++;
        $p3Wins++;
    } else if($_Set2Winner == 2){
        $player1Points += $_T1s2;
        $player3Points += $_T1s2;
        $p1Losses++;
        $p3Losses++;

        $player2Points += (6 + ($_T2s2 - $_T1s2) );
        $player4Points += (6 + ($_T2s2 - $_T1s2) );
        $p2Wins++;
        $p4Wins++;
    } else {
        $player1Points = $player1curDBLSPTS;
        $player2Points = $player2curDBLSPTS;
        $player3Points = $player3curDBLSPTS;
        $player4Points = $player4curDBLSPTS;
        $p1Wins = $player1curWins;
        $p2Wins = $player2curWins;
        $p1Losses = $player1curLosses;
        $p2Losses = $player2curLosses;
        $p3Wins = $player3curWins;
        $p4Wins = $player4curWins;
        $p3Losses = $player3curLosses;
        $p4Losses = $player4curLosses;
    }

    if($_Set3Winner == 1){
        $player2Points += $_T2s3;
        $player3Points += $_T2s3;
        $p2Losses++;
        $p3Losses++;

        $player1Points += (6 + ($_T1s3 - $_T2s3) );
        $player4Points += (6 + ($_T1s3 - $_T2s3) );
        $p1Wins++;
        $p4Wins++;
    } else if($_Set3Winner == 2){
        $player1Points += $_T1s3;
        $player4Points += $_T1s3;
        $p1Losses++;
        $p4Losses++;

        $player2Points += (6 + ($_T2s2 - $_T1s3) );
        $player3Points += (6 + ($_T2s2 - $_T1s3) );
        $p2Wins++;
        $p3Wins++;
    } else {
        $player1Points = $player1curPTS;
        $player2Points = $player2curPTS;
        $player3Points = $player3curPTS;
        $player4Points = $player4curPTS;
    }

    if ($_playoff == 1){
        $player1Points = $player1curDBLSPTS;
        $player2Points = $player2curDBLSPTS;
        $player3Points = $player3curDBLSPTS;
        $player4Points = $player4curDBLSPTS;
    }
    #endregion

    #region Insert Points
    $updateDBLSScoresP1 = "UPDATE `DBLSLADDER` SET `DBLS_POINTS` = '".$player1Points."',`DBLS_WINS` = '".$p1Wins."',`DBLS_LOSSES` = '".$p1Losses."' WHERE `DBLSLADDER`.`PLAYER_ID` = '".$dblsMatchP1."'";
    if ($conn->query($updateDBLSScoresP1) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }
    $updateDBLSScoresP2 = "UPDATE `DBLSLADDER` SET `DBLS_POINTS` = '".$player2Points."',`DBLS_WINS` = '".$p2Wins."',`DBLS_LOSSES` = '".$p2Losses."' WHERE `DBLSLADDER`.`PLAYER_ID` = '".$dblsMatchP2."'";
    if ($conn->query($updateDBLSScoresP2) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }
    $updateDBLSScoresP3 = "UPDATE `DBLSLADDER` SET `DBLS_POINTS` = '".$player3Points."',`DBLS_WINS` = '".$p3Wins."',`DBLS_LOSSES` = '".$p3Losses."' WHERE `DBLSLADDER`.`PLAYER_ID` = '".$dblsMatchP3."'";
    if ($conn->query($updateDBLSScoresP3) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }
    $updateDBLSScoresP4 = "UPDATE `DBLSLADDER` SET `DBLS_POINTS` = '".$player4Points."',`DBLS_WINS` = '".$p4Wins."',`DBLS_LOSSES` = '".$p4Losses."' WHERE `DBLSLADDER`.`PLAYER_ID` = '".$dblsMatchP4."'";
    if ($conn->query($updateDBLSScoresP4) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }

    $dropPrimarydblsSQL = "ALTER TABLE `DBLSLADDER` DROP COLUMN `ID`";
    @$conn->query($dropPrimarydblsSQL);
    $sortTabledblsSQL = "ALTER TABLE `DBLSLADDER` ORDER BY `DBLS_POINTS` DESC";
    @$conn->query($sortTabledblsSQL);
    $addPrimarydblsSQL = "ALTER TABLE `DBLSLADDER` ADD COLUMN `ID` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`ID`)";
    @$conn->query($addPrimarydblsSQL);
    #endregion
    
}

if (isset($_POST['ntrDBLSMatchID'])){

    $DBLSMatchID = isset($_POST['ntrDBLSMatchID']) ? $_POST['ntrDBLSMatchID'] : 'No data found';
    $dblsT1s1 = isset($_POST['ntrDBLSS1T1']) ? $_POST['ntrDBLSS1T1'] : 'No data found';
    $dblsT1s2 = isset($_POST['ntrDBLSS2T1']) ? $_POST['ntrDBLSS2T1'] : 'No data found';
    $dblsT1s3 = isset($_POST['ntrDBLSS3T1']) ? $_POST['ntrDBLSS3T1'] : 'No data found';
    $dblsT2s1 = isset($_POST['ntrDBLSS1T2']) ? $_POST['ntrDBLSS1T2'] : 'No data found';
    $dblsT2s2 = isset($_POST['ntrDBLSS2T2']) ? $_POST['ntrDBLSS2T2'] : 'No data found';
    $dblsT2s3 = isset($_POST['ntrDBLSS3T2']) ? $_POST['ntrDBLSS3T2'] : 'No data found';
    $dblsPlayoff = isset($_POST['ntrDBLSPlayoff']) ? $_POST['ntrDBLSPlayoff'] : 'No data found';
    $dblsSet1Winner = isset($_POST['ntrDBLSSet1Winner']) ? $_POST['ntrDBLSSet1Winner'] : 'No data found';
    $dblsSet2Winner = isset($_POST['ntrDBLSSet2Winner']) ? $_POST['ntrDBLSSet2Winner'] : 'No data found';
    $dblsSet3Winner = isset($_POST['ntrDBLSSet3Winner']) ? $_POST['ntrDBLSSet3Winner'] : 'No data found';
    $dblsDNP = isset($_POST['ntrDBlsDNP']) ? $_POST['ntrDBlsDNP'] : 'No data found';


    ntrDBLSScores($DBLSMatchID, $dblsT1s1, $dblsT1s2, $dblsT1s3, $dblsT2s1, $dblsT2s2, $dblsT2s3,$dblsPlayoff,$dblsSet1Winner,$dblsSet2Winner,$dblsSet3Winner,$dblsDNP);

}

#endregion

    #region Enter Team Doubles Scores

function ntrTDScores($_matchID, $_T1s1, $_T1s2, $_T1s3, $_T2s1, $_T2s2, $_T2s3,$_playoff,$_winner,$_DNP){
    global $conn;
    global $sznID;
    global $DBLSroundID;

    #region get match teams
    $TDMatchTeamsSQL = "SELECT `TEAM1`,`TEAM2` FROM `TDMATCH` WHERE `ID` = '".$_matchID."'";
    $TDMatchTeamsQuery = @$conn->query($TDMatchTeamsSQL);
    #region error handling
    if (!$TDMatchTeamsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($TDMatchTeamsRow = mysqli_fetch_assoc($TDMatchTeamsQuery)) {
        $TDMatchT1 = $TDMatchTeamsRow["TEAM1"];
        $TDMatchT2 = $TDMatchTeamsRow["TEAM2"];
    }
    #endregion

    #region Get Ranks

    $team1curRankSQL = "SELECT `Rank` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` WHERE `TEAM_ID` = '".$TDMatchT1."'";
    $team1curRankQuery = @$conn->query($team1curRankSQL);
    while ($team1curRankRow = mysqli_fetch_assoc($team1curRankQuery)) {
        $team1Rank = $team1curRankRow["Rank"];
    }
    $team2curRankSQL = "SELECT `Rank` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` WHERE `TEAM_ID` = '".$TDMatchT2."')";
    $team2curRankQuery = @$conn->query($team2curRankSQL);
    while ($team2curRankRow = mysqli_fetch_assoc($team2curRankQuery)) {
        $team2Rank = $team2curRankRow["Rank"];
    }
    
    $team1curPTSSQL = "SELECT `TD_POINTS`,`TD_WINS`,`TD_LOSSES` FROM `TDLADDER` WHERE `TEAM_ID` = '".$TDMatchT1."'";
    $team1curPTSQuery = @$conn->query($team1curPTSSQL);
    #region error handling
    if (!$team1curPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($team1curPTSRow = mysqli_fetch_assoc($team1curPTSQuery)) {
        $team1curPTS = $team1curPTSRow["TD_POINTS"];
        $team1curWins = $team1curPTSRow["TD_WINS"];
        $team1curLosses = $team1curPTSRow["TD_LOSSES"];
    }

    $team2curPTSSQL = "SELECT `TD_POINTS`,`TD_WINS`,`TD_LOSSES` FROM `TDLADDER` WHERE `TEAM_ID` = '".$TDMatchT2."'";
    $team2curPTSQuery = @$conn->query($team2curPTSSQL);
    #region error handling
    if (!$team2curPTSQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($team2curPTSRow = mysqli_fetch_assoc($team2curPTSQuery)) {
        $team2curPTS = $team2curPTSRow["TD_POINTS"];
        $team2curWins = $team2curPTSRow["TD_WINS"];
        $team2curLosses = $team2curPTSRow["TD_LOSSES"];
    }
    #endregion
    
    #region Insert Scores

    if($_DNP == 1){
        $insrtTDDNP = "UPDATE `TDMATCH` SET `DNP` = '".$_DNP."' WHERE `TDMATCH`.`ID` = '".$_matchID."'";
        @$conn->query($insrtTDDNP);
    } else {
        $insrtTDScores = "UPDATE `TDMATCH` SET `T1_SET1` = '".$_T1s1."', `T1_SET2` = '".$_T1s2."', `T1_SET3` = '".$_T1s3."', `T2_SET1` = '".$_T2s1."', `T2_SET2` = '".$_T2s2."', `T2_SET3` = '".$_T2s3."', `MATCHWINNER` = '".$_winner."', `PLAYOFF` = '".$_playoff."' WHERE `TDMATCH`.`ID` = '".$_matchID."'";
        @$conn->query($insrtTDScores);
    }

    #endregion

    #region Calculate # of games won
    $team1GamesWon = ($_T1s1 + $_T1s2 + $_T1s3);
    $team2GamesWon = ($_T2s1 + $_T2s2 + $_T2s3);

    #endregion

    #region calculate points
    $team1Points = $team1curPTS;
    $team2Points = $team2curPTS;
    $T1Wins = $team1curWins;
    $T2Wins = $team2curWins;
    $T1Losses = $team1curLosses;
    $T2Losses = $team2curLosses;

    if($_winner == 1){
        $T1Wins++;
        $T2Losses++;

        if ($team2GamesWon > 10){
            $team2Points += 10;
        } else {
            $team2Points += $team2GamesWon;
        }

        if (($team2Rank - $team1Rank) >= 2){
            $team1Points += (10 + ($team1GamesWon - $team2GamesWon) + (($team1GamesWon - $team2GamesWon)/2));

            if($team1Points < 15){
                $team1Points += 15;
            } 
            if ($team1Points > 25){
                $team1Points += 25;
            } 
        } else {
            $team1Points += (10 + ($team1GamesWon - $team2GamesWon));
        
            if ($team1Points < 11){
                $team1Points += 11;
            }
        }

    } elseif ($_winner == 2) {
        $T2Wins++;
        $T1Losses++;

        if ($team1GamesWon > 10){
            $team1Points += 10;
        } else {
            $team1Points += $team1GamesWon;
        }
        
        if (($team1Rank - $team2Rank) >= 2){
            $team1Points += (10 + ($team2GamesWon - $team1GamesWon) + (($team2GamesWon - $team1GamesWon)/2));
        
            if ($team2GamesWon < 15){
                $team2Points += 15;
            }
            if ($team2GamesWon > 25){
                $team2Points += 25;
            }
        } else {
            $team2Points += (10 + ($team2GamesWon - $team1GamesWon));
        
            if ($team2GamesWon < 11){
                $team2Points += 11;
            }
        }
    } else {
        $T1Wins = $team1curWins;
        $T2Wins = $team2curWins;
        $T1Losses = $team1curLosses;
        $T2Losses = $team2curLosses;
        $team1Points = $team1curPTS;
        $team2Points = $team2curPTS;
    }

    if ($_playoff == 1){
        $team1Points = $team1curPTS;
        $team2Points = $team2curPTS;
    }
    
    #endregion

    #region insert points
    $updateTDScoresT1 = "UPDATE `TDLADDER` SET `TD_POINTS` = '".$team1Points."', `TD_WINS` = '".$T1Wins."', `TD_LOSSES` = '".$T1Losses."' WHERE `TDLADDER`.`TEAM_ID` = '".$TDMatchT1."'";
    if ($conn->query($updateTDScoresT1) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }
    $updateTDScoresT2 = "UPDATE `TDLADDER` SET `TD_POINTS` = '".$team2Points."', `TD_WINS` = '".$T2Wins."', `TD_LOSSES` = '".$T2Losses."' WHERE `TDLADDER`.`TEAM_ID` = '".$TDMatchT2."'";
    if ($conn->query($updateTDScoresT2) === TRUE) {
        echo "Records added successfully.";
        //header("Location: Admin.php");
    }

    #endregion
}


if (isset($_POST['ntrTDMatchID'])){

    $TDMatchID = isset($_POST['ntrTDMatchID']) ? $_POST['ntrTDMatchID'] : 'No data found';
    $TDT1s1 = isset($_POST['ntrTDS1T1']) ? $_POST['ntrTDS1T1'] : 'No data found';
    $TDT1s2 = isset($_POST['ntrTDS2T1']) ? $_POST['ntrTDS2T1'] : 'No data found';
    $TDT1s3 = isset($_POST['ntrTDS3T1']) ? $_POST['ntrTDS3T1'] : 'No data found';
    $TDT2s1 = isset($_POST['ntrTDS1T2']) ? $_POST['ntrTDS1T2'] : 'No data found';
    $TDT2s2 = isset($_POST['ntrTDS2T2']) ? $_POST['ntrTDS2T2'] : 'No data found';
    $TDT2s3 = isset($_POST['ntrTDS3T2']) ? $_POST['ntrTDS3T2'] : 'No data found';
    $TDPlayoff = isset($_POST['ntrTDPlayoff']) ? $_POST['ntrTDPlayoff'] : 'No data found';
    $TDWinner = isset($_POST['ntrTDWinner']) ? $_POST['ntrTDWinner'] : 'No data found';
    $TDDNP = isset($_POST['ntrTDDNP']) ? $_POST['ntrTDDNP'] : 'No data found';


    ntrTDScores($TDMatchID, $TDT1s1, $TDT1s2, $TDT1s3, $TDT2s1, $TDT2s2, $TDT2s3,$TDPlayoff,$TDWinner,$TDDNP);

}

#endregion

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
        @$conn->query($sortTableSGLSSQL);
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

#region Add Team Doubles Team

function addTDTeam($_player1,$_player2,$_startingPoints){
    global $conn;
    global $sznID;

    $_teamID = generate_random_letters(10);
    
    $insertTDTeamSQL = "INSERT INTO `TDLADDER` (`ID`, `TEAM_ID`, `PLYR1_ID`, `PLYR2_ID`, `TD_LOSSES`, `TD_POINTS`, `TD_WINS`) VALUES (NULL, '".$_teamID."', '".$_player1."', '".$_player2."', 0, '".$_startingPoints."', 0)";
    // @$conn->query($insertTDTeamSQL);
    @$conn->query($insertTDTeamSQL);
    echo "$_teamID, $_player1, $_player2, $_startingPoints";

}

if (isset($_POST['ntrUserNewTDID1'])){

    $userNewTDID1 = isset($_POST['ntrUserNewTDID1']) ? $_POST['ntrUserNewTDID1'] : 'No data found';
    $userNewTDID2 = isset($_POST['ntrUserNewTDID2']) ? $_POST['ntrUserNewTDID2'] : 'No data found';
    $newTDPoints = isset($_POST['ntrNewTDPoints']) ? $_POST['ntrNewTDPoints'] : 'No data found';


    addTDTeam($userNewTDID1, $userNewTDID2, $newTDPoints);

}

#endregion

#region Drop Player from Ladder
function dropPlayer($_playerID,$_dropSingles,$_dropDubs,$_dropTeamDubs){
    global $conn;
    global $sznID;

    if($_dropSingles == 1){
        #region drop from ladder, re-evaluate ladder
        $dropSglsSQL = "DELETE FROM `SGLSLADDER` WHERE `SGLSLADDER`.`PLAYER_ID` = '".$_playerID."'";
        @$conn->query($dropSglsSQL);
    
        $dropPrimarySGLSSQL = "ALTER TABLE `SGLSLADDER` DROP COLUMN `ID`";
        @$conn->query($dropPrimarySGLSSQL);
        $sortTableSGLSSQL = "ALTER TABLE `SGLSLADDER` ORDER BY `SGLS_POINTS` DESC";
        @$conn->query($sortTableSGLSSQL);
        $addPrimarySGLSSQL = "ALTER TABLE `SGLSLADDER` ADD COLUMN `ID` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`ID`)";
        @$conn->query($addPrimarySGLSSQL);
        #endregion

        #region find current round matches with no winner, set to DNP
        $findDNPSglsSQL = "SELECT `ID` FROM `SGLSMATCH` WHERE (`PLAYER1` = '".$_playerID."' OR `PLAYER2` = '".$_playerID."') AND `MATCHWINNER` = 0";
        $findDNPSglsQuery = @$conn->query($findDNPSglsSQL);
        while ($findDNPSglsRow = mysqli_fetch_assoc($findDNPSglsQuery)) {
            $sglsMatchID = $findDNPSglsRow["ID"];
            
            $setSGLSDNP = "UPDATE `SGLSMATCH` SET `DNP` = 1 WHERE `SGLSMATCH`.`ID` = '".$sglsMatchID."'";
            @$conn->query($setSGLSDNP);
        }
        #endregion

        #region set "SGLSPlayer" in players table to 0
        $setSGLSPlayerSQL = "UPDATE `PLAYERS` SET `SGLS_PLAYER` = 0 WHERE `PLAYERS`.`ID` = '".$_playerID."'";
        @$conn->query($setSGLSPlayerSQL);
        #endregion
    }

    if($_dropDubs == 1){
        #region drop from ladder, re-evaluate ladder
        $dropDBlsSQL = "DELETE FROM `DBLSLADDER` WHERE `DBLSLADDER`.`PLAYER_ID` = '".$_playerID."'";
        @$conn->query($dropDBlsSQL);
    
        $dropPrimaryDBLSSQL = "ALTER TABLE `DBLSLADDER` DROP COLUMN `ID`";
        @$conn->query($dropPrimaryDBLSSQL);
        $sortTableDBLSSQL = "ALTER TABLE `DBLSLADDER` ORDER BY `DBLS_POINTS` DESC";
        @$conn->query($sortTableDBLSSQL);
        $addPrimaryDBLSSQL = "ALTER TABLE `DBLSLADDER` ADD COLUMN `ID` INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`ID`)";
        @$conn->query($addPrimaryDBLSSQL);
        #endregion

        #region find current round matches with no winner, set to DNP
        $findDNPDBlsSQL = "SELECT `ID` FROM `DBLSMATCH` WHERE (`PLAYER1` = '".$_playerID."' OR `PLAYER2` = '".$_playerID."'  OR `PLAYER3` = '".$_playerID."'  OR `PLAYER4` = '".$_playerID."') AND `SET1WINNER` = 0 AND `SET2WINNER` = 0 AND `SET3WINNER` = 0";
        $findDNPDBlsQuery = @$conn->query($findDNPDBlsSQL);
        while ($findDNPDBlsRow = mysqli_fetch_assoc($findDNPDBlsQuery)) {
            $dblsMatchID = $findDNPDBlsRow["ID"];
            
            $setDBLSDNP = "UPDATE `DBLSMATCH` SET `DNP` = 1 WHERE `DBLSMATCH`.`ID` = '".$dblsMatchID."'";
            @$conn->query($setDBLSDNP);
        }
        #endregion

        #region set "DBLSPlayer" in players table to 0
        $setDBLSPlayerSQL = "UPDATE `PLAYERS` SET `DBLS_PLAYER` = 0 WHERE `PLAYERS`.`ID` = '".$_playerID."'";
        @$conn->query($setDBLSPlayerSQL);
        #endregion
    }

    if($_dropTeamDubs == 1){
        #region drop team from ladder, re-evaluate ladder
        $findTDTeamSQL = "SELECT `TEAM_ID` FROM `TDLADDER` WHERE (`PLYR1_ID` = '".$_playerID."' OR `PLYR2_ID` = '".$_playerID."')";
        $findTDTeamQuery = @$conn->query($findTDTeamSQL);
        while ($findTDTeamRow = mysqli_fetch_assoc($findTDTeamQuery)) {
            $findTDTeamID = $findTDTeamRow["TEAM_ID"];
            echo $findTDTeamID;
            
            $dropTDSQL = "UPDATE `TDLADDER` SET `INACTIVE` = 1, `TD_POINTS` = 0 WHERE `TDLADDER`.`TEAM_ID` = '".$findTDTeamID."'";
            @$conn->query($dropTDSQL);
            echo "dropped";

            #region find current round matches with no winner, set to DNP
            $findTDMatchesSQL = "SELECT `ID` FROM `TDMATCH` WHERE (`TEAM1` = '".$findTDTeamID."' OR `TEAM2` = '".$findTDTeamID."') AND `MATCHWINNER` = 0";
            $findTDMatchesQuery = @$conn->query($findTDMatchesSQL);
            while ($findTDMatchesRow = mysqli_fetch_assoc($findTDMatchesQuery)) {
                $findTDMatchesID = $findTDMatchesRow["ID"];
                echo $findTDMatchesID;
            
                $setTDDNP = "UPDATE `TDMATCH` SET `DNP` = 1 WHERE `TDMATCH`.`ID` = '".$findTDMatchesID."'";
                @$conn->query($setTDDNP);
                echo "set to dnp";
            }
            #endregion
        }        
        #endregion
    }
}

if (isset($_POST['ntrDropPlayerID'])){

    $dropPlayerID = isset($_POST['ntrDropPlayerID']) ? $_POST['ntrDropPlayerID'] : 'No data found';
    $dropSingles = isset($_POST['ntrDropSGLS']) ? $_POST['ntrDropSGLS'] : 'No data found';
    $dropDubs = isset($_POST['ntrDropDBLS']) ? $_POST['ntrDropDBLS'] : 'No data found';    
    $dropTeamDubs = isset($_POST['ntrDropTD']) ? $_POST['ntrDropTD'] : 'No data found';


    dropPlayer($dropPlayerID, $dropSingles,$dropDubs,$dropTeamDubs);

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

    $playerListSQL = "SELECT `ID`,`FIRST_NAME`,`LAST_NAME`,`SEASON_NUM` FROM `PLAYERS` WHERE `SEASON_NUM` = '".$sznID."' AND NOT `ID` = 11 ORDER BY `LAST_NAME` ASC";
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