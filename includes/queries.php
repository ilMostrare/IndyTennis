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
    
    $viewPlayerSql = "SELECT * FROM `PLAYERS` WHERE `ID` LIKE '".$viewPlayer."'";
    $viewPlayerQuery = @$conn->query($viewPlayerSql);
    $viewPlayerRow=mysqli_fetch_assoc($viewPlayerQuery);

    $_SESSION['playerID'] = $viewPlayerRow["ID"];
    echo "", $_SESSION['playerID'],"";

}

if (!empty($_POST['viewMatchPlayerID'])){
    $viewPlayer = isset($_POST['viewMatchPlayerID']) ? $_POST['viewMatchPlayerID'] : 'No data found';
    
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

    $curSGLSRankingsSQL = "SELECT `SGLSLADDER`.`ID` AS `Rank`,`PLAYERS`.`ID` AS `PlayerID`,`PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` AS `LAST_NAME`,`SGLSLADDER`.`SGLS_POINTS` AS `SGLS_POINTS` FROM `SGLSLADDER` INNER JOIN `PLAYERS` ON `PLAYERS`.`ID` = `SGLSLADDER`.`PLAYER_ID` ORDER BY `SGLSLADDER`.`ID`";
    $curSGLSRankingsQuery = @$conn->query($curSGLSRankingsSQL);
    if (!$curSGLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curSGLSRankingsRow = mysqli_fetch_assoc($curSGLSRankingsQuery)) {
        // $rowNum = $curSGLSRankingsRow["ID"];
        $curSGLSRank = $curSGLSRankingsRow["Rank"];
        $sglsPlayerID = $curSGLSRankingsRow["PlayerID"];
        $curSGLSRankFName = $curSGLSRankingsRow["FIRST_NAME"];
        $curSGLSRankLName = $curSGLSRankingsRow["LAST_NAME"];
        $curSGLSRankPoints = $curSGLSRankingsRow["SGLS_POINTS"];

        echo "<tr><td class='tableLeft'>", $curSGLSRank, "</td><td class='tableCenter'><form><button type='button' id='playerInfo' class='singles-player-name' name='viewPlayer' value='",$sglsPlayerID,"'>", $curSGLSRankLName, ", ", $curSGLSRankFName, "</button></form></td><td class='tableRight'>", $curSGLSRankPoints, "</td></tr>";
    }
}

function printDBLSRankings()
{
    global $conn;
    global $sznID;

    //$setRowNumVarSQL = "SET @row_number := 0";
    $curDBLSRankingsSQL = "SELECT `DBLSLADDER`.`ID` AS `Rank`,`PLAYERS`.`ID` AS `PlayerID`,`PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` AS `LAST_NAME`,`DBLSLADDER`.`DBLS_POINTS` AS `DBLS_POINTS` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `PLAYERS`.`ID` = `DBLSLADDER`.`PLAYER_ID` ORDER BY `DBLSLADDER`.`ID`";
    //@$conn->query($setRowNumVarSQL);
    $curDBLSRankingsQuery = @$conn->query($curDBLSRankingsSQL);
    if (!$curDBLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curDBLSRankingsRow = mysqli_fetch_assoc($curDBLSRankingsQuery)) {
        //$rowNum = $curDBLSRankingsRow["RowNum"];
        $dblsPlayerID = $curDBLSRankingsRow["PlayerID"];
        $curDBLSRank = $curDBLSRankingsRow["Rank"];
        $curDBLSRankFName = $curDBLSRankingsRow["FIRST_NAME"];
        $curDBLSRankLName = $curDBLSRankingsRow["LAST_NAME"];
        $curDBLSRankPoints = $curDBLSRankingsRow["DBLS_POINTS"];

        echo "<tr><td class='tableLeft'>", $curDBLSRank, "</td><td class='tableCenter'><form><button type='submit' id='playerInfo' class='doubles-player-name' name='viewPlayer' value='",$dblsPlayerID,"'>", $curDBLSRankLName, ", ", $curDBLSRankFName, "</button></form></td><td class='tableRight'>", $curDBLSRankPoints, "</td></tr>";
    }
}
#endregion

#region Print out weekly matchups

function printSGLSMatchups()
{
    global $conn;
    global $SGLSroundID;


    $curSGLSMatchupsSQL = "SELECT `PLAYER1`,`PLAYER2` FROM `SGLSMATCH` WHERE `ROUND_NUM` = '".$SGLSroundID."'";
    $curSGLSMatchupsQuery = @$conn->query($curSGLSMatchupsSQL);
    if (!$curSGLSMatchupsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curSGLSMatchupsRow = mysqli_fetch_assoc($curSGLSMatchupsQuery)) {
        $sglsPlayer1ID = $curSGLSMatchupsRow["PLAYER1"];
        $viewPlayer1Sql = "SELECT `FIRST_NAME`, `LAST_NAME` FROM `PLAYERS` WHERE `ID` LIKE '".$sglsPlayer1ID."'";
        $viewPlayer1Query = @$conn->query($viewPlayer1Sql);
        while ($viewPlayer1Row=mysqli_fetch_assoc($viewPlayer1Query)){
            $P1FN = $viewPlayer1Row['FIRST_NAME'];
            $P1LN = $viewPlayer1Row['LAST_NAME'];
        }

        $sglsPlayer2ID = $curSGLSMatchupsRow["PLAYER2"];
        $viewPlayer2Sql = "SELECT `FIRST_NAME`, `LAST_NAME` FROM `PLAYERS` WHERE `ID` LIKE '".$sglsPlayer2ID."'";
        $viewPlayer2Query = @$conn->query($viewPlayer2Sql);
        while ($viewPlayer2Row=mysqli_fetch_assoc($viewPlayer2Query)){
            $P2FN = $viewPlayer2Row['FIRST_NAME'];
            $P2LN = $viewPlayer2Row['LAST_NAME'];
        }

        echo "<tr><td class='tableLeft'><form><button type='submit' id='playerInfo' class='singlesMatch-player1-name' name='viewPlayer' value='",$sglsPlayer1ID,"'>", $P1LN, ", ", $P1FN, "</button></form></td><td class='tableCenter'> vs </td><td class='tableRight'><form><button type='submit' id='playerInfo' class='singlesMatch-player2-name' name='viewPlayer' value='",$sglsPlayer2ID,"'>", $P2LN, ", ", $P2FN, "</button></form></td></tr>";
    }
}

function printDBLSMatchups()
{
    global $conn;
    global $DBLSroundID;

    $curDBLSMatchupsSQL = "SELECT `PLAYER1`,`PLAYER2`,`PLAYER3`,`PLAYER4` FROM `DBLSMATCH` WHERE `ROUND_NUM` = '".$DBLSroundID."'";
    $curDBLSMatchupsQuery = @$conn->query($curDBLSMatchupsSQL);
    if (!$curDBLSMatchupsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curDBLSMatchupsRow = mysqli_fetch_assoc($curDBLSMatchupsQuery)) {
        $dblsPlayer1ID = $curDBLSMatchupsRow["PLAYER1"];
        $viewPlayer1Sql = "SELECT `LAST_NAME` FROM `PLAYERS` WHERE `ID` LIKE '".$dblsPlayer1ID."'";
        $viewPlayer1Query = @$conn->query($viewPlayer1Sql);
        while ($viewPlayer1Row=mysqli_fetch_assoc($viewPlayer1Query)){
            $P1LN = $viewPlayer1Row['LAST_NAME'];
        }

        $dblsPlayer2ID = $curDBLSMatchupsRow["PLAYER2"];
        $viewPlayer2Sql = "SELECT `LAST_NAME` FROM `PLAYERS` WHERE `ID` LIKE '".$dblsPlayer2ID."'";
        $viewPlayer2Query = @$conn->query($viewPlayer2Sql);
        while ($viewPlayer2Row=mysqli_fetch_assoc($viewPlayer2Query)){
            $P2LN = $viewPlayer2Row['LAST_NAME'];
        }

        $dblsPlayer3ID = $curDBLSMatchupsRow["PLAYER3"];
        $viewPlayer3Sql = "SELECT `LAST_NAME` FROM `PLAYERS` WHERE `ID` LIKE '".$dblsPlayer3ID."'";
        $viewPlayer3Query = @$conn->query($viewPlayer3Sql);
        while ($viewPlayer3Row=mysqli_fetch_assoc($viewPlayer3Query)){
            $P3LN = $viewPlayer3Row['LAST_NAME'];
        }

        $dblsPlayer4ID = $curDBLSMatchupsRow["PLAYER4"];
        $viewPlayer4Sql = "SELECT `LAST_NAME` FROM `PLAYERS` WHERE `ID` LIKE '".$dblsPlayer4ID."'";
        $viewPlayer4Query = @$conn->query($viewPlayer4Sql);
        while ($viewPlayer4Row=mysqli_fetch_assoc($viewPlayer4Query)){
            $P4LN = $viewPlayer4Row['LAST_NAME'];
        }

        echo "<tr><td class='tableLeft'></td><td class='tableCenter'><form><button type='submit' id='playerInfo' class='doublesMatch-player-name' name='viewPlayer' value='",$dblsPlayer1ID,"'>", $P1LN, "</button></form>-<form><button type='submit' id='playerInfo' class='doublesMatch-player-name' name='viewPlayer' value='",$dblsPlayer2ID,"'>", $P2LN, "</button></form>-<form><button type='submit' id='playerInfo' class='doublesMatch-player-name' name='viewPlayer' value='",$dblsPlayer3ID,"'>", $P3LN, "</button></form>-<form><button type='submit' id='playerInfo' class='doublesMatch-player-name' name='viewPlayer' value='",$dblsPlayer4ID,"'>", $P4LN, "</button></form></td><td class='tableRight'></td></tr>";
    }
}

#endregion