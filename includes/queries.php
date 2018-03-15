<?php
/**
 * Created by PhpStorm.
 * User: BSlabach
 * Date: 3/14/2018
 * Time: 7:40 AM
 */

$curDate = date("M jS, Y");

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
    $SGLSroundID = $SGLSroundRow["ID"];
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
    $DBLSroundID = $DBLSroundRow["ID"];
    $DBLSroundSTART = $DBLSroundRow["START_DATE"];
    $DBLSroundEND = $DBLSroundRow["END_DATE"];
    $DBLSroundSZNID = $DBLSroundRow["SEASON_NUM"];
    $DBLSroundPLAYOFF = $DBLSroundRow["PLAYOFF"];
}

#endregion

function getSGLSRankings()
{
    global $conn;
    global $sznID;

    $setRankVarSQL = "SET @rank := 0";
    $curSGLSRankingsSQL = "SELECT @rank := @rank + 1 AS Rank, `ID`,`FIRST_NAME`,`LAST_NAME`,`SGLS_POINTS` FROM `PLAYERS` WHERE `SEASON_NUM` = '".$sznID."' AND `SGLS_PLAYER` = 1 ORDER BY `SGLS_POINTS` DESC, `LAST_NAME` ASC";
    @$conn->query($setRankVarSQL);
    $curSGLSRankingsQuery = @$conn->query($curSGLSRankingsSQL);
    if (!$curSGLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curSGLSRankingsRow = mysqli_fetch_assoc($curSGLSRankingsQuery)) {
        $sglsPlayerID = $curSGLSRankingsRow["ID"];
        $curSGLSRank = $curSGLSRankingsRow["Rank"];
        $curSGLSRankFName = $curSGLSRankingsRow["FIRST_NAME"];
        $curSGLSRankLName = $curSGLSRankingsRow["LAST_NAME"];
        $curSGLSRankPoints = $curSGLSRankingsRow["SGLS_POINTS"];

        echo "<p>", $curSGLSRank, " - ", $curSGLSRankLName, ", ", $curSGLSRankFName, " - ", $curSGLSRankPoints, "</p>";
    }
}

function getDBLSRankings()
{
    global $conn;
    global $sznID;

    $setRankVarSQL = "SET @rank := 0";
    $curDBLSRankingsSQL = "SELECT @rank := @rank + 1 AS Rank, `ID`,`FIRST_NAME`,`LAST_NAME`,`DBLS_POINTS` FROM `PLAYERS` WHERE `SEASON_NUM` = '".$sznID."' AND `DBLS_PLAYER` = 1 ORDER BY `DBLS_POINTS` DESC, `LAST_NAME` ASC";
    @$conn->query($setRankVarSQL);
    $curDBLSRankingsQuery = @$conn->query($curDBLSRankingsSQL);
    if (!$curDBLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curDBLSRankingsRow = mysqli_fetch_assoc($curDBLSRankingsQuery)) {
        $dblsPlayerID = $curDBLSRankingsRow["ID"];
        $curDBLSRank = $curDBLSRankingsRow["Rank"];
        $curDBLSRankFName = $curDBLSRankingsRow["FIRST_NAME"];
        $curDBLSRankLName = $curDBLSRankingsRow["LAST_NAME"];
        $curDBLSRankPoints = $curDBLSRankingsRow["DBLS_POINTS"];

        echo "<p>", $curDBLSRank, " - ", $curDBLSRankLName, ", ", $curDBLSRankFName, " - ", $curDBLSRankPoints, "</p>";
    }
}