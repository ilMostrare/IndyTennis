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

#region upcoming season
$nxtSZNsql = "SELECT `ID`,`START_DATE`,`END_DATE` FROM `SEASON` WHERE CURRENT_DATE < CAST(`START_DATE` AS date) ORDER BY `ID` LIMIT 1";
$nxtSZNQuery = @$conn->query($nxtSZNsql);
if (!$nxtSZNQuery) {
    $errno = $conn->errno;
    $error = $conn->error;
    $conn->close();
    die("Selection failed: ($errno) $error.");
}
while ($NXTsznRow = mysqli_fetch_assoc($nxtSZNQuery)){
    $NXTsznSTART = $NXTsznRow["START_DATE"];
}

$PRINTnxtSeasonST = date('M d, Y', strtotime($NXTsznSTART));

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

function printTeamDBLSRankings()
{
    global $conn;
    global $sznID;
    $i = 1;

    $curTDRankingsSQL = "SELECT `TDLADDER`.`TEAM_ID` AS `TEAM_ID`, `TDLADDER`.`PLYR1_ID` AS `P1_ID`, `P1`.`LAST_NAME` AS `P1_LNAME`, `TDLADDER`.`PLYR2_ID` AS `P2_ID`, `P2`.`LAST_NAME` AS `P2_LNAME`, `TDLADDER`.`TD_POINTS` AS `TD_POINTS` FROM `TDLADDER` LEFT JOIN `PLAYERS` AS `P1` ON `TDLADDER`.`PLYR1_ID` = `P1`.`ID` LEFT JOIN `PLAYERS` AS `P2` ON `TDLADDER`.`PLYR2_ID` = `P2`.`ID` WHERE `TDLADDER`.`TEAM_ID` != 11 AND `TDLADDER`.`INACTIVE` != 1 ORDER BY `TDLADDER`.`TD_POINTS` DESC, `TDLADDER`.`INACTIVE` ASC";
    
    $curTDRankingsQuery = @$conn->query($curTDRankingsSQL);
    if (!$curTDRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curTDRankingsRow = mysqli_fetch_assoc($curTDRankingsQuery)) {   
        $curTDTeamID = $curTDRankingsRow["TEAM_ID"];
        $curTDP1ID = $curTDRankingsRow["P1_ID"];
        $curTDP1LName = $curTDRankingsRow["P1_LNAME"];
        $curTDP2ID = $curTDRankingsRow["P2_ID"];
        $curTDP2LName = $curTDRankingsRow["P2_LNAME"];
        $curTDRankPoints = $curTDRankingsRow["TD_POINTS"];

        $teamRankSQL = "SELECT `TEAM_ID`,`Rank` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` WHERE `TEAM_ID` = '".$curTDTeamID."' AND `INACTIVE` != 1";
        $teamRankQuery = @$conn->query($teamRankSQL);
        while ($teamRankRow = mysqli_fetch_assoc($teamRankQuery)) {
            $teamRank = $teamRankRow["Rank"];
        }

        echo "<tr><td class='tableLeft'>", $teamRank, "</td><td class='tableCenter'><form><button type='submit' id='playerInfo' class='TD-player-name' name='viewPlayer' value='",$curTDP1ID,"'>", $curTDP1LName , "</button></form><form><button type='submit' id='playerInfo' class='TD-player-name' name='viewPlayer' value='",$curTDP2ID,"'>", $curTDP2LName , "</button></form></td><td class='tableRight'>", $curTDRankPoints, "</td></tr>";
        $i++;
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

function printTeamDBLSMatchups()
{
    global $conn;
    global $DBLSroundID;

    $curTDMatchupsSQL = "SELECT `TEAM1`,`TEAM2` FROM `TDMATCH` WHERE `ROUND_NUM` = '".$DBLSroundID."' ";
    $curTDMatchupsQuery = @$conn->query($curTDMatchupsSQL);
    if (!$curTDMatchupsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curTDMatchupsRow = mysqli_fetch_assoc($curTDMatchupsQuery)) {

        $dblsTeam1ID = $curTDMatchupsRow["TEAM1"];
        $viewTeam1Sql = "SELECT `TDLADDER`.`PLYR1_ID` AS `P1ID`,`TDLADDER`.`PLYR2_ID` AS `P2ID`,`P1`.`LAST_NAME` AS `P1LN`,`P2`.`LAST_NAME` AS `P2LN` FROM `TDLADDER` LEFT JOIN `PLAYERS` AS `P1` ON `P1`.`ID` = `TDLADDER`.`PLYR1_ID` LEFT JOIN `PLAYERS` AS `P2` ON `P2`.`ID` = `TDLADDER`.`PLYR2_ID` WHERE `TDLADDER`.`TEAM_ID` LIKE '".$dblsTeam1ID."'";
        $viewTeam1Query = @$conn->query($viewTeam1Sql);
        while ($viewTeam1Row=mysqli_fetch_assoc($viewTeam1Query)){
            $P1LN = $viewTeam1Row['P1LN'];
            $P2LN = $viewTeam1Row['P2LN'];
            $P1ID = $viewTeam1Row['P1ID'];
            $P2ID = $viewTeam1Row['P2ID'];
        }

        $dblsTeam2ID = $curTDMatchupsRow["TEAM2"];
        $viewTeam2Sql = "SELECT `TDLADDER`.`PLYR1_ID` AS `P3ID`,`TDLADDER`.`PLYR2_ID` AS `P4ID`,`P1`.`LAST_NAME` AS `P3LN`,`P2`.`LAST_NAME` AS `P4LN` FROM `TDLADDER` LEFT JOIN `PLAYERS` AS `P1` ON `P1`.`ID` = `TDLADDER`.`PLYR1_ID` LEFT JOIN `PLAYERS` AS `P2` ON `P2`.`ID` = `TDLADDER`.`PLYR2_ID` WHERE `TDLADDER`.`TEAM_ID` LIKE '".$dblsTeam2ID."'";
        $viewTeam2Query = @$conn->query($viewTeam2Sql);
        while ($viewTeam2Row=mysqli_fetch_assoc($viewTeam2Query)){
            $P3LN = $viewTeam2Row['P3LN'];
            $P4LN = $viewTeam2Row['P4LN'];
            $P3ID = $viewTeam2Row['P3ID'];
            $P4ID = $viewTeam2Row['P4ID'];
        }

        echo "<tr><td class='tableLeft'></td><td class='tableCenter'><form><button type='submit' id='playerInfo' class='TDMatch-player-name' name='viewPlayer' value='",$P1ID,"'>", $P1LN, "</button></form>/<form><button type='submit' id='playerInfo' class='TDMatch-player-name' name='viewPlayer' value='",$P2ID,"'>", $P2LN, "</button></form>vs<form><button type='submit' id='playerInfo' class='TDMatch-player-name' name='viewPlayer' value='",$P3ID,"'>", $P3LN, "</button></form>/<form><button type='submit' id='playerInfo' class='TDMatch-player-name' name='viewPlayer' value='",$P4ID,"'>", $P4LN, "</button></form></td><td class='tableRight'></td></tr>";
    }
}

#endregion