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

        echo "<tr><td class='tableLeft'>", $curSGLSRank, "</td><td class='tableCenter'><form><button type='button' id='playerInfo' class='singles-player-name' name='viewPlayer' value='",$sglsPlayerID,"'>", $curSGLSRankLName, ", ", $curSGLSRankFName, "</button></form></td><td class='tableRight'>", $curSGLSRankPoints, "</td></tr>";
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

#region Print out weekly matchups

function printSGLSMatchups()
{
    global $conn;
    global $SGLSroundID;


    $curSGLSMatchupsSQL = "SELECT `PLAYER1`,`PLAYER2` FROM `SGLSMATCH` INNER JOIN `PLAYERS` ON `PLAYERS`.`ID` = `SGLSMATCH`.`PLAYER1` WHERE `ROUND_NUM` = '".$SGLSroundID."'";
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

/* function printDBLSMatchups()
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
} */

#endregion