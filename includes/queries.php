<?php
/**
 * Created by PhpStorm.
 * User: BSlabach
 * Date: 3/14/2018
 * Time: 7:40 AM
 */


$curDate = date("M jS, Y");

$isLadderLiveSQL = "SELECT `IS_LADDER_LIVE` FROM `CONTROL`";
$isLadderLiveQRY = @$conn->query($isLadderLiveSQL);
while ($isLadderLiveROW = mysqli_fetch_assoc($isLadderLiveQRY)){
    $isLadderLive = $isLadderLiveROW['IS_LADDER_LIVE'];
}


#region View Player

if (!empty($_POST['viewPlayerID'])){
    $viewPlayer = isset($_POST['viewPlayerID']) ? $_POST['viewPlayerID'] : 'No data found';


//    echo "Data: ",$logEmail,", ",$logPass,"";

    // send login info to database
    $viewPlayerSql = "SELECT * FROM `PLAYERS` WHERE `ID` LIKE '".$viewPlayer."'";
    $viewPlayerQuery = @$conn->query($viewPlayerSql);
    $viewPlayerRow=mysqli_fetch_assoc($viewPlayerQuery);

    $_SESSION['playerID'] = $viewPlayerRow["ID"];
    echo "", $_SESSION['playerID'],"";

}

#endregion


#region Get Current Season and Round
$curSZNsql = "SELECT * FROM `SEASON` WHERE CURRENT_DATE BETWEEN CAST(`START_DATE` AS date) AND CAST(`END_DATE` AS date)";
$curSZNQuery = @$conn->query($curSZNsql);
if (!$curSZNQuery) {
    $errno = $conn->errno;
    $error = $conn->error;
    $conn->close();
    die("Selection failed: ($errno) $error.");
}
while ($sznRow = mysqli_fetch_assoc($curSZNQuery)){
    $sznID = $sznRow["ID"];
    $sznSTART = $sznRow["START_DATE"];
    $sznEND = $sznRow["END_DATE"];
}

$curSGLSRNDsql = "SELECT * FROM `SGLSROUND` WHERE CURRENT_DATE BETWEEN CAST(`START_DATE` AS date) AND CAST(`END_DATE` AS date)";
$curSGLSRNDQuery = @$conn->query($curSGLSRNDsql);
if (!$curSGLSRNDQuery) {
    $errno = $conn->errno;
    $error = $conn->error;
    $conn->close();
    die("Selection failed: ($errno) $error.");
}
while ($SGLSroundRow = mysqli_fetch_assoc($curSGLSRNDQuery)){
    $SGLSroundID = $SGLSroundRow["ROUND_NUM"];
    $SGLSroundSTART = $SGLSroundRow["START_DATE"];
    $SGLSroundEND = $SGLSroundRow["END_DATE"];
    $SGLSroundSZNID = $SGLSroundRow["SEASON_NUM"];
    $SGLSroundPLAYOFF = $SGLSroundRow["PLAYOFF"];
}

$curDBLSRNDsql = "SELECT * FROM `DBLSROUND` WHERE CURRENT_DATE BETWEEN CAST(`START_DATE` AS date) AND CAST(`END_DATE` AS date)";
$curDBLSRNDQuery = @$conn->query($curDBLSRNDsql);
if (!$curDBLSRNDQuery) {
    $errno = $conn->errno;
    $error = $conn->error;
    $conn->close();
    die("Selection failed: ($errno) $error.");
}
while ($DBLSroundRow = mysqli_fetch_assoc($curDBLSRNDQuery)){
    $DBLSroundID = $DBLSroundRow["ROUND_NUM"];
    $DBLSroundSTART = $DBLSroundRow["START_DATE"];
    $DBLSroundEND = $DBLSroundRow["END_DATE"];
    $DBLSroundSZNID = $DBLSroundRow["SEASON_NUM"];
    $DBLSroundPLAYOFF = $DBLSroundRow["PLAYOFF"];
}

#endregion


#region Print out Ladder Standings
function printSGLSRankings()
{
    global $conn;
    global $sznID;

    $setRowNumVarSQL = "SET @row_number := 0";
    $curSGLSRankingsSQL = "SELECT (@row_number:=@row_number + 1) AS RowNum, `ID`, `FIRST_NAME`, `LAST_NAME`, `SGLS_POINTS`, Rank FROM (SELECT `ID`, `FIRST_NAME`, `LAST_NAME`, `SGLS_POINTS`, @curRank := IF(@prevRank = `SGLS_POINTS`, @curRank, @incRank) AS rank, @incRank := @incRank + 1, @prevRank := `SGLS_POINTS` FROM PLAYERS p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r WHERE `SEASON_NUM` = '".$sznID."' AND `SGLS_PLAYER` = 1 ORDER BY `SGLS_POINTS` DESC) s ORDER BY Rank ASC, `LAST_NAME` ASC";
    @$conn->query($setRowNumVarSQL);
    $curSGLSRankingsQuery = @$conn->query($curSGLSRankingsSQL);
    if (!$curSGLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curSGLSRankingsRow = mysqli_fetch_assoc($curSGLSRankingsQuery)) {
        $rowNum = $curSGLSRankingsRow["RowNum"];
        $sglsPlayerID = $curSGLSRankingsRow["ID"];
        $curSGLSRank = $curSGLSRankingsRow["Rank"];
        $curSGLSRankFName = $curSGLSRankingsRow["FIRST_NAME"];
        $curSGLSRankLName = $curSGLSRankingsRow["LAST_NAME"];
        $curSGLSRankPoints = $curSGLSRankingsRow["SGLS_POINTS"];

        echo "<tr><td class='tableLeft'>", $curSGLSRank, "</td><td class='tableCenter'><form><button type='submit' id='playerInfo' class='singles-player-name' name='viewPlayer' value='",$sglsPlayerID,"'>", $curSGLSRankLName, ", ", $curSGLSRankFName, "</button></form></td><td class='tableRight'>", $curSGLSRankPoints, "</td></tr>";
    }
}

function printDBLSRankings()
{
    global $conn;
    global $sznID;

    $setRowNumVarSQL = "SET @row_number := 0";
    $curDBLSRankingsSQL = "SELECT (@row_number:=@row_number + 1) AS RowNum, `ID`, `FIRST_NAME`, `LAST_NAME`, `DBLS_POINTS`, Rank FROM (SELECT `ID`, `FIRST_NAME`, `LAST_NAME`, `DBLS_POINTS`, @curRank := IF(@prevRank = `DBLS_POINTS`, @curRank, @incRank) AS rank, @incRank := @incRank + 1, @prevRank := `DBLS_POINTS` FROM PLAYERS p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r WHERE `SEASON_NUM` = '".$sznID."' AND `DBLS_PLAYER` = 1 ORDER BY `DBLS_POINTS` DESC) s ORDER BY Rank ASC, `LAST_NAME` ASC";
    @$conn->query($setRowNumVarSQL);
    $curDBLSRankingsQuery = @$conn->query($curDBLSRankingsSQL);
    if (!$curDBLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curDBLSRankingsRow = mysqli_fetch_assoc($curDBLSRankingsQuery)) {
        $rowNum = $curDBLSRankingsRow["RowNum"];
        $dblsPlayerID = $curDBLSRankingsRow["ID"];
        $curDBLSRank = $curDBLSRankingsRow["Rank"];
        $curDBLSRankFName = $curDBLSRankingsRow["FIRST_NAME"];
        $curDBLSRankLName = $curDBLSRankingsRow["LAST_NAME"];
        $curDBLSRankPoints = $curDBLSRankingsRow["DBLS_POINTS"];

        echo "<tr><td class='tableLeft'>", $curDBLSRank, "</td><td class='tableCenter'><form><button type='submit' id='playerInfo' class='doubles-player-name' name='viewPlayer' value='",$dblsPlayerID,"'>", $curDBLSRankLName, ", ", $curDBLSRankFName, "</button></form></td><td class='tableRight'>", $curDBLSRankPoints, "</td></tr>";
    }
}
#endregion


#region Create Matches Function

function createSGLSMatches(){
    global $conn;
    global $sznID;
    global $currentRound;

    $i = 1;

    $j = rand(1, 3);

    $numberOfSinglesPlayersSQL = "SELECT COUNT(*) as TOTAL FROM `PLAYERS` WHERE `SGLS_PLAYER`=1";
    $numberOfSinglesPlayersQuery = @$conn->query($numberOfSinglesPlayersSQL);
    //$num_SGLS_Players = mysqli_fetch_object($numberOfSinglesPlayersQuery);
    while ($num_SGLS_Players_Row = mysqli_fetch_assoc($numberOfSinglesPlayersQuery)){
        $num_SGLS_Players = $num_SGLS_Players_Row['TOTAL'];
        echo "NumPlayers ",$num_SGLS_Players;
    }

    while ($i <= $num_SGLS_Players){

        $setRowNumVarSQL = "SET @row_number := 0";
        @$conn->query($setRowNumVarSQL);
        $getPlayer1IDSQL = "SELECT * FROM (SELECT `ID`, `FIRST_NAME`, `LAST_NAME`, `SGLS_POINTS`, @curRank := IF(@prevRank = `SGLS_POINTS`, @curRank, @incRank) AS rank, @incRank := @incRank + 1, @prevRank := `SGLS_POINTS` FROM PLAYERS p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r WHERE `SEASON_NUM` = '".$sznID."' AND `SGLS_PLAYER` = 1 ORDER BY `SGLS_POINTS` DESC) s WHERE (@row_number:=@row_number+1) = '".$i."' ORDER BY Rank ASC, `LAST_NAME` ASC";
        $player1QRY = @$conn->query($getPlayer1IDSQL);
        while ($player1Row = mysqli_fetch_assoc($player1QRY)){
            $player1 = $player1Row['ID'];
            echo "P1 ",$player1;
        }

        $setRowNumVarSQL2 = "SET @row_number := 0";
        @$conn->query($setRowNumVarSQL2);
        $getPlayer2IDSQL = "SELECT * FROM (SELECT `ID`, `FIRST_NAME`, `LAST_NAME`, `SGLS_POINTS`, @curRank := IF(@prevRank = `SGLS_POINTS`, @curRank, @incRank) AS rank, @incRank := @incRank + 1, @prevRank := `SGLS_POINTS` FROM PLAYERS p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r WHERE `SEASON_NUM` = '".$sznID."' AND `SGLS_PLAYER` = 1 ORDER BY `SGLS_POINTS` DESC) s WHERE (@row_number:=@row_number+1) = '".($i+$j)."' ORDER BY Rank ASC, `LAST_NAME` ASC";
        $player2QRY = @$conn->query($getPlayer2IDSQL);
        while ($player2Row = mysqli_fetch_assoc($player2QRY)){
            $player2 = $player2Row['ID'];
            echo "P2 ",$player2;
        }

        $existsSQL = "SELECT COUNT(*) as TOTAL FROM `SGLSMATCH` WHERE ((`PLAYER1` = '".$player1."') OR (`PLAYER2` = '".$player1."')) AND `ROUND_NUM` = '".$currentRound."'";
        $existsQRY = @$conn->query($existsSQL);
        //$alreadyExists = mysqli_fetch_assoc($existsQRY);
        while ($alreadyExistsROW = mysqli_fetch_assoc($existsQRY)){
            $alreadyExists = $alreadyExistsROW['TOTAL'];
            echo "Exists ",$alreadyExists;
        }

        if ($alreadyExists > 0){
            $i++;
        } else {
            if ($player2 > $num_SGLS_Players){
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '".$player1."', NULL, ".$currentRound.", ".$sznID.", '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                $i++;
            } else {
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '".$player1."', '".$player2."', '".$currentRound."', '".$sznID."', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                $i++;
            }
        }
    }
}

#endregion