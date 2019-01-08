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

    // $resultSet = array();

    $allSinglesPlayersSQL = "SELECT `PLAYER_ID` FROM `SGLSLADDER`  ORDER BY `ID`";
    $allSinglesPlayersQuery = @$conn->query($allSinglesPlayersSQL);
    while ($all_SGLS_Players_Row = mysqli_fetch_array($allSinglesPlayersQuery)) {
        $resultSet[] = $all_SGLS_Players_Row;
        // echo $resultSet;
    }
    foreach ($resultSet as &$player) {
        $player1 = $player[0];
        echo $player1," vs ";

        $player1SQL = "SELECT `ID` FROM `SGLSLADDER` WHERE `PLAYER_ID` = '" . $player1 . "'";
        $player1Query = @$conn->query($player1SQL);
        while ($p1_Players_Row = mysqli_fetch_array($player1Query)) {
            $player1Rank = $p1_Players_Row["ID"];
            // echo $player1Rank;
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
        // echo $player2Rank," ";

        $player2SQL = "SELECT `PLAYER_ID` FROM `SGLSLADDER` WHERE `ID` = '" . $player2Rank . "'";
        $player2Query = @$conn->query($player2SQL);
        while ($p2_Players_Row = mysqli_fetch_array($player2Query)) {
            $player2 = $p2_Players_Row["PLAYER_ID"];
            echo $player2;
        }

        $existsSQL = "SELECT COUNT(*) as 'COUNT' FROM `SGLSMATCH` WHERE ((`PLAYER1` = '" . $player1 . "') OR (`PLAYER2` = '" . $player1 . "')) AND `ROUND_NUM` = '" . $SGLSroundID . "'";
        $existsQRY = @$conn->query($existsSQL);
        while ($exists_Row = mysqli_fetch_assoc($existsQRY)) {
            $exists = $exists_Row["COUNT"];
        }
        echo "exists",$exists;

        $totalSGLSplayersSQL = "SELECT * FROM `SGLSLADDER`";
        $totalSGLSplayersQRY = @$conn->query($totalSGLSplayersSQL);
        $totalSGLSplayersROW = mysqli_num_rows($totalSGLSplayersQRY);
        echo "rows",$totalSGLSplayersROW," \n";

        if ($exists > 0) {
            echo "Player exists, do nothing\n";
        } else {
            if ($player2 > $totalSGLSplayersROW) {
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
            if ($player2 > $totalDBLSplayersROW) {
                $createMatchSQL = "INSERT INTO `DBLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `PLAYER3`, `PLAYER4`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '11', '11', '11'," . $DBLSroundID . ", " . $sznID . ")";
                @$conn->query($createMatchSQL);
            } else if ($player3 > $totalDBLSplayersROW) {
                $createMatchSQL = "INSERT INTO `DBLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `PLAYER3`, `PLAYER4`, `ROUND_NUM`, `SEASON_NUM`) VALUES (NULL, '" . $player1 . "', '" . $player2 . "', '11', '11'," . $DBLSroundID . ", " . $sznID . ")";
                @$conn->query($createMatchSQL);
            } else if ($player4 > $totalDBLSplayersROW) {
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

            $editMatchSQL = "UPDATE `SGLSMATCH` SET `PLAYER2` = '".$_player2."' WHERE `SGLSMATCH`.`ID` = '".$_matchID."'";
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

    $player1curPTSSQL = "SELECT `SGLS_POINTS`,`SGLS_WINS`,`SGLS_LOSSES` FROM `SGLSLADDER` WHERE `PLAYER_ID` = '".$sglsMatchP1."'";
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
        $player1curWins = $player1curPTSRow["SGLS_WINS"];
        $player1curLosses = $player1curPTSRow["SGLS_LOSSES"];
    }

    $player2curPTSSQL = "SELECT `SGLS_POINTS`,`SGLS_WINS`,`SGLS_LOSSES` FROM `SGLSLADDER` WHERE `PLAYER_ID` = '".$sglsMatchP2."'";
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

function ntrDBLSScores($_MatchID, $_T1s1, $_T1s2, $_T1s3, $_T2s1, $_T2s2, $_T2s3,$_Playoff,$_Challenge,$_Set1Winner,$_Set2Winner,$_Set3Winner,$_DNP){
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
    $dblsChallenge = isset($_POST['ntrDBLSChallenge']) ? $_POST['ntrDBLSChallenge'] : 'No data found';
    $dblsSet1Winner = isset($_POST['ntrDBLSSet1Winner']) ? $_POST['ntrDBLSSet1Winner'] : 'No data found';
    $dblsSet2Winner = isset($_POST['ntrDBLSSet2Winner']) ? $_POST['ntrDBLSSet2Winner'] : 'No data found';
    $dblsSet3Winner = isset($_POST['ntrDBLSSet3Winner']) ? $_POST['ntrDBLSSet3Winner'] : 'No data found';
    $dblsDNP = isset($_POST['ntrDBlsDNP']) ? $_POST['ntrDBlsDNP'] : 'No data found';


    ntrDBLSScores($DBLSMatchID, $dblsT1s1, $dblsT1s2, $dblsT1s3, $dblsT2s1, $dblsT2s2, $dblsT2s3,$dblsPlayoff,$dblsChallenge,$dblsSet1Winner,$dblsSet2Winner,$dblsSet3Winner,$dblsDNP);

}

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

    $emSubject = "Welcome to IndyTennis!";
    $emHeaders = "MIME-Version: 1.0" . "\r\n";
    $emHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $emHeaders .= 'From: contact@indytennis.com' . "\r\n" .
    'Reply-To: contact@indytennis.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $emContents = 
    "<html>
        <head>
        <title>Welcome to IndyTennis</title>
        </head>
        <body>
            <h3>You've been registered for the 2019 season!</h3>
            <p><i>Please change your password upon first login (Settings -> Change Password)</i></p>
            <table>
            <tr>
                <th>Firstname</th>
                <td>".$_fName."</td>
            </tr>
            <tr>
                <th>Lastname</th>
                <td>".$_lName."</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>".$_email."</td>
            </tr>
            <tr>
                <th>Password</th>
                <td>".$_password."</td>
            </tr>
            </table>
        </body>
    </html>";

    mail($_email,$emSubject,$emContents,$emHeaders);

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