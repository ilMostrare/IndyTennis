<?php
/**
 * Created by PhpStorm.
 * User: BSlabach
 * Date: 3/21/2018
 * Time: 7:53 AM
 */

#region Get Individual Player Ranks
function GetPlayerSGLSRank($playerID){
    global $conn;
    //global $sznID;

    $curSGLSRankingsSQL = "SELECT (COUNT(`ID`) + 1) AS Rank, (SELECT `ID` FROM PLAYERS WHERE `ID` = '".$playerID."') AS ID, (SELECT `FIRST_NAME` FROM PLAYERS WHERE `ID` = '".$playerID."') AS FIRST_NAME, (SELECT `LAST_NAME` FROM PLAYERS WHERE `ID` = '".$playerID."') AS LAST_NAME, (SELECT `SGLS_POINTS` FROM PLAYERS WHERE `ID` = '".$playerID."') AS SGLS_POINTS FROM PLAYERS WHERE (`SGLS_POINTS` > (SELECT `SGLS_POINTS` FROM PLAYERS WHERE `ID` = '".$playerID."'))";
    $curSGLSRankingsQuery = @$conn->query($curSGLSRankingsSQL);
    if (!$curSGLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curSGLSRankingsRow = mysqli_fetch_assoc($curSGLSRankingsQuery)) {
        $curSGLSRank = $curSGLSRankingsRow["Rank"];
        $curSGLSRankFName = $curSGLSRankingsRow["FIRST_NAME"];
        $curSGLSRankLName = $curSGLSRankingsRow["LAST_NAME"];
        $curSGLSRankPoints = $curSGLSRankingsRow["SGLS_POINTS"];

        echo "<p>", $curSGLSRank, " - ", $curSGLSRankLName, ", ", $curSGLSRankFName, " - ", $curSGLSRankPoints, "</p>";
    }
}

function GetPlayerDBLSRank($playerID){
    global $conn;
    //global $sznID;

    $curDBLSRankingsSQL = "SELECT (COUNT(`ID`) + 1) AS Rank, (SELECT `ID` FROM PLAYERS WHERE `ID` = '".$playerID."') AS ID, (SELECT `FIRST_NAME` FROM PLAYERS WHERE `ID` = '".$playerID."') AS FIRST_NAME, (SELECT `LAST_NAME` FROM PLAYERS WHERE `ID` = '".$playerID."') AS LAST_NAME, (SELECT `DBLS_POINTS` FROM PLAYERS WHERE `ID` = '".$playerID."') AS DBLS_POINTS FROM PLAYERS WHERE (`DBLS_POINTS` > (SELECT `DBLS_POINTS` FROM PLAYERS WHERE `ID` = '".$playerID."'))";
    $curDBLSRankingsQuery = @$conn->query($curDBLSRankingsSQL);
    if (!$curDBLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curDBLSRankingsRow = mysqli_fetch_assoc($curDBLSRankingsQuery)) {
        $curDBLSRank = $curDBLSRankingsRow["Rank"];
        $curDBLSRankFName = $curDBLSRankingsRow["FIRST_NAME"];
        $curDBLSRankLName = $curDBLSRankingsRow["LAST_NAME"];
        $curDBLSRankPoints = $curDBLSRankingsRow["DBLS_POINTS"];

        echo "<p>", $curDBLSRank, " - ", $curDBLSRankLName, ", ", $curDBLSRankFName, " - ", $curDBLSRankPoints, "</p>";
    }
}

#endregion