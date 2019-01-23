<?php
/**
 * Created by PhpStorm.
 * User: BSlabach
 * Date: 3/21/2018
 * Time: 7:53 AM
 */

#region get player info
function GetPlayerInfo($playerID){
    global $conn;

    $curSGLSRankingsSQL = "SELECT `SGLSLADDER`.`ID` AS `Rank`,`PLAYERS`.`ID` AS `PlayerID`,`PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` AS `LAST_NAME`,`SGLSLADDER`.`SGLS_POINTS` AS `SGLS_POINTS`,`SGLSLADDER`.`SGLS_WINS` AS `SGLS_WINS`,`SGLSLADDER`.`SGLS_LOSSES` AS `SGLS_LOSSES` FROM `SGLSLADDER` INNER JOIN `PLAYERS` ON `PLAYERS`.`ID` = `SGLSLADDER`.`PLAYER_ID` WHERE `SGLSLADDER`.`PLAYER_ID` =  '".$playerID."'";
    $curSGLSRankingsQuery = @$conn->query($curSGLSRankingsSQL);
    if (!$curSGLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curSGLSRankingsRow = mysqli_fetch_assoc($curSGLSRankingsQuery)) {
        $curSGLSRank = $curSGLSRankingsRow["Rank"];
        $curSGLSRankPoints = $curSGLSRankingsRow["SGLS_POINTS"];
        $curSGLSWins = $curSGLSRankingsRow["SGLS_WINS"];
        $curSGLSLosses = $curSGLSRankingsRow["SGLS_LOSSES"];
    }

    $curDBLSRankingsSQL = "SELECT `DBLSLADDER`.`ID` AS `Rank`,`PLAYERS`.`ID` AS `PlayerID`,`PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` AS `LAST_NAME`,`DBLSLADDER`.`DBLS_POINTS` AS `DBLS_POINTS`,`DBLSLADDER`.`DBLS_WINS` AS `DBLS_WINS`,`DBLSLADDER`.`DBLS_LOSSES` AS `DBLS_LOSSES` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `PLAYERS`.`ID` = `DBLSLADDER`.`PLAYER_ID` WHERE `DBLSLADDER`.`PLAYER_ID` =  '".$playerID."'";
    $curDBLSRankingsQuery = @$conn->query($curDBLSRankingsSQL);
    if (!$curDBLSRankingsQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($curDBLSRankingsRow = mysqli_fetch_assoc($curDBLSRankingsQuery)) {
        $curDBLSRank = $curDBLSRankingsRow["Rank"];
        $curDBLSRankPoints = $curDBLSRankingsRow["DBLS_POINTS"];
        $curDBLSWins = $curDBLSRankingsRow["DBLS_WINS"];
        $curDBLSLosses = $curDBLSRankingsRow["DBLS_LOSSES"];
    }

    $playerInfoSql = "SELECT * FROM `PLAYERS` WHERE `ID` LIKE '".$playerID."'";
    $playerInfoQuery = @$conn->query($playerInfoSql);

    if (!$playerInfoQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($playerInfoRow = mysqli_fetch_assoc($playerInfoQuery)) {
        $playerInfoID = $playerInfoRow["ID"];
        $playerInfoFN = $playerInfoRow["FIRST_NAME"];
        $playerInfoLN = $playerInfoRow["LAST_NAME"];
        $playerInfoEM = $playerInfoRow["EMAIL"];
        $playerInfoPN = $playerInfoRow["PHONE_NUM"];
        $playerInfoSGLS = $playerInfoRow["SGLS_PLAYER"];
        $playerInfoDBLS = $playerInfoRow["DBLS_PLAYER"];
    }

    $teamDBLSCheckSQL = "SELECT COUNT(*) as `COUNT` FROM `TDLADDER` WHERE `PLYR1_ID` LIKE '".$playerID."' OR `PLYR2_ID` LIKE '".$playerID."'";
    $teamDBLSCheckQuery = @$conn->query($teamDBLSCheckSQL);
    while ($teamDBLSCheckRow = mysqli_fetch_assoc($teamDBLSCheckQuery)) {
        $teamDBLSCheckVal = $teamDBLSCheckRow["COUNT"];
    }
    if($teamDBLSCheckVal > 0){
        $isTDPlayer = 1;
    } else {
        $isTDPlayer = 0;
    }

    echo "<div class='header'><h1>", $playerInfoFN, " ", $playerInfoLN ,"</h1>";
    echo "<h4>", $playerInfoEM, " - (", substr($playerInfoPN, 0, 3) ,") ",substr($playerInfoPN, 3, 3),"-",substr($playerInfoPN, 6, 4),"</h4>";

    if($isTDPlayer == 1){
        //select partner, points, wins, losses, rank
        $TDplayerInfoSQL = "SELECT `Rank`.`TEAM_ID`, `Rank`.`Rank`, `Rank`.`TD_POINTS`, `Rank`.`TD_WINS`, `Rank`.`TD_LOSSES`, `P`.`LAST_NAME`, `P`.`FIRST_NAME` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` LEFT JOIN `PLAYERS` AS `P` ON `P`.`ID` = (CASE WHEN `Rank`.`PLYR1_ID` = '".$playerID."' THEN `Rank`.`PLYR2_ID` ELSE `Rank`.`PLYR1_ID` END) WHERE (`PLYR1_ID` = '".$playerID."' OR `PLYR2_ID` = '".$playerID."')";
        $TDplayerInfoQuery = @$conn->query($TDplayerInfoSQL);
        while ($TDPlayerInfoRow = mysqli_fetch_assoc($TDplayerInfoQuery)){
            $TDRank = $TDPlayerInfoRow["Rank"];
            $TDPoints = $TDPlayerInfoRow["TD_POINTS"];
            $TDWins = $TDPlayerInfoRow["TD_WINS"];
            $TDLosses = $TDPlayerInfoRow["TD_LOSSES"];
            $TDPartnerLN = $TDPlayerInfoRow["LAST_NAME"];
            $TDPartnerFN = $TDPlayerInfoRow["FIRST_NAME"];
        }

        if ($playerInfoSGLS != 1 && $playerInfoDBLS == 1){
            echo "<div class='rankings'><h3 class='left'></h3><h3 class='right'>Doubles: #",$curDBLSRank," (",$curDBLSRankPoints," PTS, ",$curDBLSWins,"-",$curDBLSLosses,")</h3></div>";
            echo "<div class='rankings'><h3 class='bottom'>Team Doubles: #",$TDRank," (",$TDPoints," PTS, ",$TDWins,"-",$TDLosses,", Partner: ",$TDPartnerLN,", ",$TDPartnerFN,")</h3></div></div>"; ////////////////////////////////////////
        } elseif ($playerInfoDBLS != 1 && $playerInfoSGLS == 1){
            echo "<div class='rankings'><h3 class='left'>Singles: #",$curSGLSRank," (",$curSGLSRankPoints," PTS, ",$curSGLSWins,"-",$curSGLSLosses,")</h3><h3 class='right'></h3></div>";
            echo "<div class='rankings'><h3 class='bottom'>Team Doubles: #",$TDRank," (",$TDPoints," PTS, ",$TDWins,"-",$TDLosses,", Partner: ",$TDPartnerLN,", ",$TDPartnerFN,")</h3></div></div>"; ////////////////////////////////////////
        } else {
            echo "<div class='rankings'><h3 class='left'>Singles: #",$curSGLSRank," (",$curSGLSRankPoints," PTS, ",$curSGLSWins,"-",$curSGLSLosses,")</h3><h3 class='right'>Doubles: #",$curDBLSRank," (",$curDBLSRankPoints," PTS, ",$curDBLSWins,"-",$curDBLSLosses,")</h3></div>";
            echo "<div class='rankings'><h3 class='bottom'>Team Doubles: #",$TDRank," (",$TDPoints," PTS, ",$TDWins,"-",$TDLosses,", Partner: ",$TDPartnerLN,", ",$TDPartnerFN,")</h3></div></div>"; ////////////////////////////////////////
        }
    } else {
        if ($playerInfoSGLS != 1 && $playerInfoDBLS == 1){
            echo "<div class='rankings'><h3 class='left'></h3><h3 class='right'>Doubles: #",$curDBLSRank," (",$curDBLSRankPoints," PTS, ",$curDBLSWins,"-",$curDBLSLosses,")</h3></div></div>";
        } elseif ($playerInfoDBLS != 1 && $playerInfoSGLS == 1){
            echo "<div class='rankings'><h3 class='left'>Singles: #",$curSGLSRank," (",$curSGLSRankPoints," PTS, ",$curSGLSWins,"-",$curSGLSLosses,")</h3><h3 class='right'></h3></div></div>";
        } else {
            echo "<div class='rankings'><h3 class='left'>Singles: #",$curSGLSRank," (",$curSGLSRankPoints," PTS, ",$curSGLSWins,"-",$curSGLSLosses,")</h3><h3 class='right'>Doubles: #",$curDBLSRank," (",$curDBLSRankPoints," PTS, ",$curDBLSWins,"-",$curDBLSLosses,")</h3></div></div>";
        }
    }

    

}
#endregion

#region get player current matches
function GetPlayerCurrentMatches($playerID){
    global $conn;

    $playerInfoSql = "SELECT `ID`,`SGLS_PLAYER`,`DBLS_PLAYER` FROM `PLAYERS` WHERE `ID` LIKE '".$playerID."'";
    $playerInfoQuery = @$conn->query($playerInfoSql);
    #region error handling
    if (!$playerInfoQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($playerInfoRow = mysqli_fetch_assoc($playerInfoQuery)) {
        $playerInfoID = $playerInfoRow["ID"];
        $playerInfoSGLS = $playerInfoRow["SGLS_PLAYER"];
        $playerInfoDBLS = $playerInfoRow["DBLS_PLAYER"];
    }

    $teamDBLSCheckSQL = "SELECT COUNT(*) as `COUNT` FROM `TDLADDER` WHERE `PLYR1_ID` LIKE '".$playerID."' OR `PLYR2_ID` LIKE '".$playerID."'";
    $teamDBLSCheckQuery = @$conn->query($teamDBLSCheckSQL);
    while ($teamDBLSCheckRow = mysqli_fetch_assoc($teamDBLSCheckQuery)) {
        $teamDBLSCheckVal = $teamDBLSCheckRow["COUNT"];
    }
    if($teamDBLSCheckVal > 0){
        $isTDPlayer = 1;
    } else {
        $isTDPlayer = 0;
    }

    #region get current singles matches
    if( ($playerInfoSGLS == 1) ){
        $plyrSGLSMatchesSQL = "SELECT `SGLSMATCH`.`ID`,`SGLSMATCH`.`PLAYER1`,`SGLSMATCH`.`PLAYER2`,`SGLSMATCH`.`ROUND_NUM`,`SGLSMATCH`.`SEASON_NUM`,`SGLSMATCH`.`PLAYOFF`,`SGLSROUND`.`END_DATE` FROM `SGLSMATCH` INNER JOIN `SGLSROUND` ON `SGLSMATCH`.`ROUND_NUM` = `SGLSROUND`.`ID` WHERE (`SGLSMATCH`.`PLAYER1` = '".$playerID."' OR `SGLSMATCH`.`PLAYER2` = '".$playerID."') AND `SGLSMATCH`.`MATCHWINNER` = 0 AND `SGLSMATCH`.`DNP` != 1 ORDER BY `SGLSMATCH`.`ROUND_NUM`";
        $plyrSGLSMatchesQuery = @$conn->query($plyrSGLSMatchesSQL);
        #region error handling
        if (!$plyrSGLSMatchesQuery) {
            $errno = $conn->errno;
            $error = $conn->error;
            $conn->close();
            die("Selection failed: ($errno) $error.");
        }
        #endregion
        while ($plyrSGLSMatchesRow = mysqli_fetch_assoc($plyrSGLSMatchesQuery)) {
            $matchPlayer1 = $plyrSGLSMatchesRow["PLAYER1"];
            $matchPlayer2 = $plyrSGLSMatchesRow["PLAYER2"];
            $matchRoundNum = $plyrSGLSMatchesRow["ROUND_NUM"];
            $matchSeasonNum = $plyrSGLSMatchesRow["SEASON_NUM"];
            $matchPlayoff = $plyrSGLSMatchesRow["PLAYOFF"];
            $matchEndDate = $plyrSGLSMatchesRow["END_DATE"];

            if ($matchPlayer1 == $playerID){
                $sglsOpponentSQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`SGLSLADDER`.`ID` as `RANK` FROM `SGLSLADDER` INNER JOIN `PLAYERS` ON `SGLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$matchPlayer2."'";
                $sglsOpponentQuery = @$conn->query($sglsOpponentSQL);
                #region error handling
                if (!$sglsOpponentQuery) {
                    $errno = $conn->errno;
                    $error = $conn->error;
                    $conn->close();
                    die("Selection failed: ($errno) $error.");
                }
                #endregion
                while ($sglsOpponentRow = mysqli_fetch_assoc($sglsOpponentQuery)) {
                    $sglsOpponentFName = $sglsOpponentRow["FIRST_NAME"];
                    $sglsOpponentLName = $sglsOpponentRow["LAST_NAME"];
                    $sglsOpponentRank = $sglsOpponentRow["RANK"];
                }

                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<td>SG",$matchRoundNum,"</td>";
                        echo "<td><button class='viewPlayer' value='".$matchPlayer2."'>",$sglsOpponentLName,", ",$sglsOpponentFName," (",$sglsOpponentRank,")</button></td>";
                        if($matchPlayoff == 1){echo "<td>Yes</td>";} else {echo "<td>No</td>";}
                        echo "<td>",$matchEndDate,"</td>";
                    echo "</table>";
                echo "</div>";                

            } else if ($matchPlayer2 == $playerID) {
                $sglsOpponentSQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`SGLSLADDER`.`ID` as `RANK` FROM `SGLSLADDER` INNER JOIN `PLAYERS` ON `SGLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$matchPlayer1."'";
                $sglsOpponentQuery = @$conn->query($sglsOpponentSQL);
                #region error handling
                if (!$sglsOpponentQuery) {
                    $errno = $conn->errno;
                    $error = $conn->error;
                    $conn->close();
                    die("Selection failed: ($errno) $error.");
                }
                #endregion
                while ($sglsOpponentRow = mysqli_fetch_assoc($sglsOpponentQuery)) {
                    $sglsOpponentFName = $sglsOpponentRow["FIRST_NAME"];
                    $sglsOpponentLName = $sglsOpponentRow["LAST_NAME"];
                    $sglsOpponentRank = $sglsOpponentRow["RANK"];
                }

                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<td>SG",$matchRoundNum,"</td>";
                        echo "<td><button class='viewPlayer' value='".$matchPlayer1."'>",$sglsOpponentLName,", ",$sglsOpponentFName," (",$sglsOpponentRank,")</button></td>";
                        if($matchPlayoff == 1){echo "<td>Yes</td>";} else {echo "<td>No</td>";}
                        echo "<td>",$matchEndDate,"</td>";
                    echo "</table>";
                echo "</div>";       

            } else {
                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<td>No matches to display</td>";
                    echo "</table>";
                echo "</div>";                
            }
            
        }

    } else {
        echo "<div class='printMatch'>";
            echo "<table>";
                echo "<td>No Singles matches to display</td>";
            echo "</table>";
        echo "</div>";                
    }
    #endregion

    #region get current doubles matches
    if( ($playerInfoDBLS == 1) ){
        $plyrDBLSMatchesSQL = "SELECT `DBLSMATCH`.`ID`,`DBLSMATCH`.`PLAYER1`,`DBLSMATCH`.`PLAYER2`,`DBLSMATCH`.`PLAYER3`,`DBLSMATCH`.`PLAYER4`,`DBLSMATCH`.`ROUND_NUM`,`DBLSMATCH`.`SEASON_NUM`,`DBLSMATCH`.`PLAYOFF`,`DBLSROUND`.`END_DATE` FROM `DBLSMATCH` INNER JOIN `DBLSROUND` ON `DBLSMATCH`.`ROUND_NUM` = `DBLSROUND`.`ID` WHERE (`DBLSMATCH`.`PLAYER1` = '".$playerID."' OR `DBLSMATCH`.`PLAYER2` = '".$playerID."' OR `DBLSMATCH`.`PLAYER3` = '".$playerID."' OR `DBLSMATCH`.`PLAYER4` = '".$playerID."') AND `DBLSMATCH`.`SET1WINNER` = 0 AND `DBLSMATCH`.`DNP` != 1 ORDER BY `DBLSMATCH`.`ROUND_NUM`";
        $plyrDBLSMatchesQuery = @$conn->query($plyrDBLSMatchesSQL);
        #region error handling
        if (!$plyrDBLSMatchesQuery) {
            $errno = $conn->errno;
            $error = $conn->error;
            $conn->close();
            die("Selection failed: ($errno) $error.");
        }
        #endregion
        while ($plyrDBLSMatchesRow = mysqli_fetch_assoc($plyrDBLSMatchesQuery)) {
            $matchID = $plyrDBLSMatchesRow["ID"];
            $matchPlayer1 = $plyrDBLSMatchesRow["PLAYER1"];
            $matchPlayer2 = $plyrDBLSMatchesRow["PLAYER2"];
            $matchPlayer3 = $plyrDBLSMatchesRow["PLAYER3"];
            $matchPlayer4 = $plyrDBLSMatchesRow["PLAYER4"];
            $matchRoundNum = $plyrDBLSMatchesRow["ROUND_NUM"];
            $matchPlayoff = $plyrDBLSMatchesRow["PLAYOFF"];
            $matchEndDate = $plyrDBLSMatchesRow["END_DATE"];

            if ($matchPlayer1 == $playerID){                
                $opponent1 = $matchPlayer2;
                $opponent2 = $matchPlayer3;
                $opponent3 = $matchPlayer4;
            } else if ($matchPlayer2 == $playerID){
                $opponent1 = $matchPlayer1;
                $opponent2 = $matchPlayer3;
                $opponent3 = $matchPlayer4;   
            } else if ($matchPlayer3 == $playerID){
                $opponent1 = $matchPlayer1;
                $opponent2 = $matchPlayer2;
                $opponent3 = $matchPlayer4;   
            } else if ($matchPlayer4 == $playerID){
                $opponent1 = $matchPlayer1;
                $opponent2 = $matchPlayer2;
                $opponent3 = $matchPlayer3;      
            } else {
                // do nothing
            }

            $dblsOpponent1SQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`DBLSLADDER`.`ID` as `RANK` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `DBLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$opponent1."'";
            $dblsOpponent1Query = @$conn->query($dblsOpponent1SQL);
            while ($dblsOpponent1Row = mysqli_fetch_assoc($dblsOpponent1Query)) {
                $dblsOpponent1FName = $dblsOpponent1Row["FIRST_NAME"];
                $dblsOpponent1LName = $dblsOpponent1Row["LAST_NAME"];
                $dblsOpponent1Rank = $dblsOpponent1Row["RANK"];
            }

            $dblsOpponent2SQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`DBLSLADDER`.`ID` as `RANK` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `DBLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$opponent2."'";
            $dblsOpponent2Query = @$conn->query($dblsOpponent2SQL);
            while ($dblsOpponent2Row = mysqli_fetch_assoc($dblsOpponent2Query)) {
                $dblsOpponent2FName = $dblsOpponent2Row["FIRST_NAME"];
                $dblsOpponent2LName = $dblsOpponent2Row["LAST_NAME"];
                $dblsOpponent2Rank = $dblsOpponent2Row["RANK"];
            }

            $dblsOpponent3SQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`DBLSLADDER`.`ID` as `RANK` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `DBLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$opponent3."'";
            $dblsOpponent3Query = @$conn->query($dblsOpponent3SQL);
            while ($dblsOpponent3Row = mysqli_fetch_assoc($dblsOpponent3Query)) {
                $dblsOpponent3FName = $dblsOpponent3Row["FIRST_NAME"];
                $dblsOpponent3LName = $dblsOpponent3Row["LAST_NAME"];
                $dblsOpponent3Rank = $dblsOpponent3Row["RANK"];
            }

            echo "<div class='printMatch'>";
                echo "<table>";
                    echo "<tr>";
                        echo "<td rowspan='3'>DB",$matchRoundNum,"</td>";
                        echo "<td><button class='viewPlayer' value='".$opponent1."'>",$dblsOpponent1LName,", ",$dblsOpponent1FName," (",$dblsOpponent1Rank,")</button></td>";
                        if($matchPlayoff == 1){echo "<td rowspan='3'>Yes</td>";} else {echo "<td rowspan='3'>No</td>";}
                        echo "<td rowspan='3'>",$matchEndDate,"</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><button class='viewPlayer' value='".$opponent2."'>",$dblsOpponent2LName,", ",$dblsOpponent2FName," (",$dblsOpponent2Rank,")</button></td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><button class='viewPlayer' value='".$opponent3."'>",$dblsOpponent3LName,", ",$dblsOpponent3FName," (",$dblsOpponent3Rank,")</button></td>";
                    echo "</tr>";
                echo "</table>";
            echo "</div>";


        } 
    } else {
        echo "<div class='printMatch'>";
            echo "<table>";
                echo "<td>No Doubles matches to display</td>";
            echo "</table>";
        echo "</div>";                
    }
    #endregion

    #region get current team doubles matches
    if( ($isTDPlayer == 1) ){
        $plyrTDTeamSQL = "SELECT `TEAM_ID` FROM `TDLADDER` WHERE `PLYR1_ID` = '".$playerID."' OR `PLYR2_ID` = '".$playerID."'";
        $plyrTDTeamQuery = @$conn->query($plyrTDTeamSQL);
        #region error handling
        if (!$plyrTDTeamQuery) {
            $errno = $conn->errno;
            $error = $conn->error;
            $conn->close();
            die("Selection failed: ($errno) $error.");
        }
        #endregion
        while ($plyrTDTeamRow = mysqli_fetch_assoc($plyrTDTeamQuery)){
            $teamID = $plyrTDTeamRow["TEAM_ID"];
        }
        
        $plyrTDMatchesSQL = "SELECT `TDMATCH`.`TEAM1` AS `TM1`, `TDMATCH`.`TEAM2` AS `TM2`, `PL1`.`LAST_NAME` AS `P1LN`, `PL2`.`LAST_NAME` AS `P2LN`, `PL3`.`LAST_NAME` AS `P3LN`, `PL4`.`LAST_NAME` AS `P4LN`, `PL1`.`FIRST_NAME` AS `P1FN`, `PL2`.`FIRST_NAME` AS `P2FN`, `PL3`.`FIRST_NAME` AS `P3FN`, `PL4`.`FIRST_NAME` AS `P4FN`, `PL1`.`ID` AS `P1ID`, `PL2`.`ID` AS `P2ID`, `PL3`.`ID` AS `P3ID`, `PL4`.`ID` AS `P4ID`, `TDMATCH`.`ROUND_NUM`, `TDMATCH`.`PLAYOFF`, `DBLSROUND`.`END_DATE` FROM `TDMATCH` LEFT JOIN `DBLSROUND` ON `TDMATCH`.`ROUND_NUM` = `DBLSROUND`.`ID` LEFT JOIN `TDLADDER` AS `T1` ON `TDMATCH`.`TEAM1` = `T1`.`TEAM_ID` LEFT JOIN `TDLADDER` AS `T2` ON `TDMATCH`.`TEAM2` = `T2`.`TEAM_ID` LEFT JOIN `PLAYERS` AS `PL1` ON `T1`.`PLYR1_ID` = `PL1`.`ID` LEFT JOIN `PLAYERS` AS `PL2` ON `T1`.`PLYR2_ID` = `PL2`.`ID` LEFT JOIN `PLAYERS` AS `PL3` ON `T2`.`PLYR1_ID` = `PL3`.`ID` LEFT JOIN `PLAYERS` AS `PL4` ON `T2`.`PLYR2_ID` = `PL4`.`ID` WHERE (`TDMATCH`.`TEAM1` = '".$teamID."' OR `TDMATCH`.`TEAM2` = '".$teamID."') AND (`TDMATCH`.`MATCHWINNER` = 0 AND `TDMATCH`.`DNP` = 0)";
        $plyrTDMatchesQuery = @$conn->query($plyrTDMatchesSQL);

        while ($plyrTDMatchesRow = mysqli_fetch_assoc($plyrTDMatchesQuery)) {
            $TDTeam1 = $plyrTDMatchesRow["TM1"];
            $TDTeam2 = $plyrTDMatchesRow["TM2"];
            $matchPlayer1LN = $plyrTDMatchesRow["P1LN"];
            $matchPlayer2LN = $plyrTDMatchesRow["P2LN"];
            $matchPlayer3LN = $plyrTDMatchesRow["P3LN"];
            $matchPlayer4LN = $plyrTDMatchesRow["P4LN"];

            $matchPlayer1FN = $plyrTDMatchesRow["P1FN"];
            $matchPlayer2FN = $plyrTDMatchesRow["P2FN"];
            $matchPlayer3FN = $plyrTDMatchesRow["P3FN"];
            $matchPlayer4FN = $plyrTDMatchesRow["P4FN"];

            $matchPlayer1ID = $plyrTDMatchesRow["P1ID"];
            $matchPlayer2ID = $plyrTDMatchesRow["P2ID"];
            $matchPlayer3ID = $plyrTDMatchesRow["P3ID"];
            $matchPlayer4ID = $plyrTDMatchesRow["P4ID"];

            $matchRoundNum = $plyrTDMatchesRow["ROUND_NUM"];
            $matchPlayoff = $plyrTDMatchesRow["PLAYOFF"];
            $matchEndDate = $plyrTDMatchesRow["END_DATE"];

            if ($TDTeam1 == $teamID){
                $TDOpponentSQL = "SELECT `TEAM_ID`,`Rank` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` WHERE `TEAM_ID` = '".$TDTeam2."'";
                $TDOpponentQuery = @$conn->query($TDOpponentSQL);
                #region error handling
                if (!$TDOpponentQuery) {
                    $errno = $conn->errno;
                    $error = $conn->error;
                    $conn->close();
                    die("Selection failed: ($errno) $error.");
                }
                #endregion
                while ($TDOpponentRow = mysqli_fetch_assoc($TDOpponentQuery)) {
                    $TDOpponentRank = $TDOpponentRow["Rank"];
                }

                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td rowspan='2'>TD",$matchRoundNum,"</td>";
                            echo "<td><button class='viewPlayer' value='".$matchPlayer3ID."'>",$matchPlayer3LN,", ",$matchPlayer3FN," (",$TDOpponentRank,")</button></td>";
                            if($matchPlayoff == 1){echo "<td rowspan='2'>Yes</td>";} else {echo "<td rowspan='2'>No</td>";}
                            echo "<td rowspan='2'>",$matchEndDate,"</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td><button class='viewPlayer' value='".$matchPlayer4ID."'>",$matchPlayer4LN,", ",$matchPlayer4FN," (",$TDOpponentRank,")</button></td>";
                        echo "</tr>";
                    echo "</table>";
                echo "</div>";               

            } else if ($TDTeam2 == $teamID) {
                $TDOpponentSQL = "SELECT `TEAM_ID`,`Rank` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` WHERE `TEAM_ID` = '".$TDTeam1."'";
                $TDOpponentQuery = @$conn->query($TDOpponentSQL);
                #region error handling
                if (!$TDOpponentQuery) {
                    $errno = $conn->errno;
                    $error = $conn->error;
                    $conn->close();
                    die("Selection failed: ($errno) $error.");
                }
                #endregion
                while ($TDOpponentRow = mysqli_fetch_assoc($TDOpponentQuery)) {
                    $TDOpponentRank = $TDOpponentRow["Rank"];
                }

                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td rowspan='2'>TD",$matchRoundNum,"</td>";
                            echo "<td><button class='viewPlayer' value='".$matchPlayer1ID."'>",$matchPlayer1LN,", ",$matchPlayer1FN," (",$TDOpponentRank,")</button></td>";
                            if($matchPlayoff == 1){echo "<td rowspan='2'>Yes</td>";} else {echo "<td rowspan='2'>No</td>";}
                            echo "<td rowspan='2'>",$matchEndDate,"</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td><button class='viewPlayer' value='".$matchPlayer2ID."'>",$matchPlayer2LN,", ",$matchPlayer2FN," (",$TDOpponentRank,")</button></td>";
                        echo "</tr>";
                    echo "</table>";
                echo "</div>";        

            } else {
                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<td>No Team Doubles matches to display</td>";
                    echo "</table>";
                echo "</div>";                
            }
            
        }

    } else {
        // do nothing                
    }
    #endregion
    
}
#endregion

#region get player past matches
function GetPlayerPastMatches($playerID){
    global $conn;
    $playerInfoSql = "SELECT `ID`,`SGLS_PLAYER`,`DBLS_PLAYER` FROM `PLAYERS` WHERE `ID` LIKE '".$playerID."'";
    $playerInfoQuery = @$conn->query($playerInfoSql);
    #region error handling
    if (!$playerInfoQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    #endregion
    while ($playerInfoRow = mysqli_fetch_assoc($playerInfoQuery)) {
        $playerInfoID = $playerInfoRow["ID"];
        $playerInfoSGLS = $playerInfoRow["SGLS_PLAYER"];
        $playerInfoDBLS = $playerInfoRow["DBLS_PLAYER"];
    }

    #region /// get past matches

    $pastMatchesSQL = "SELECT * FROM ( (SELECT CONCAT('SG',`SGLSMATCH`.`ID`) AS `ID`, `SGLSMATCH`.`LAST_MODIFIED` AS `LASTMODIFIED` FROM `SGLSMATCH` WHERE (`SGLSMATCH`.`PLAYER1` = '". $playerID ."' OR `SGLSMATCH`.`PLAYER2` = '". $playerID ."') AND `SGLSMATCH`.`MATCHWINNER` != 0) UNION ALL (SELECT CONCAT('DB',`DBLSMATCH`.`ID`) AS `ID`, `DBLSMATCH`.`LAST_MODIFIED` AS `LASTMODIFIED` FROM `DBLSMATCH` WHERE (`DBLSMATCH`.`PLAYER1` = '". $playerID ."' OR `DBLSMATCH`.`PLAYER2` = '". $playerID ."' OR `DBLSMATCH`.`PLAYER3` = '". $playerID ."' OR `DBLSMATCH`.`PLAYER3` = '". $playerID ."') AND `DBLSMATCH`.`SET1WINNER` != 0) UNION ALL (SELECT CONCAT('TD',`TDMATCH`.`ID`) AS `ID`, `TDMATCH`.`LAST_MODIFIED` AS `LASTMODIFIED` FROM `TDMATCH` LEFT JOIN `TDLADDER` AS `T1` ON `T1`.`TEAM_ID` = `TDMATCH`.`TEAM1` LEFT JOIN `TDLADDER` AS `T2` ON `T2`.`TEAM_ID` = `TDMATCH`.`TEAM2` WHERE (`T1`.`PLYR1_ID` = '". $playerID ."' OR `T1`.`PLYR2_ID` = '". $playerID ."' OR `T2`.`PLYR1_ID` = '". $playerID ."' OR `T2`.`PLYR2_ID` = '". $playerID ."') AND `TDMATCH`.`MATCHWINNER` != 0) ) `RESULTS` ORDER BY `LASTMODIFIED` ASC";
    $pastMatchesQuery = @$conn->query($pastMatchesSQL);
    while ($pastMatchesRow = mysqli_fetch_assoc($pastMatchesQuery)) {
        $pastMatchID = $pastMatchesRow["ID"];
        $pastMatchLM = $pastMatchesRow["LAST_MODIFIED"];
        
        $mID = (int)substr($pastMatchID,2,2);
        $identifier = substr($pastMatchID,0,2);
        // echo $mID;

        if ($identifier == 'SG'){
            #region past singles matches
            $pastSGLSMatchSQL = "SELECT `SGLSMATCH`.`ID`,`SGLSMATCH`.`PLAYER1`,`SGLSMATCH`.`PLAYER2`,`SGLSMATCH`.`P1_SET1`,`SGLSMATCH`.`P1_SET2`,`SGLSMATCH`.`P1_SET3`,`SGLSMATCH`.`P2_SET1`,`SGLSMATCH`.`P2_SET2`,`SGLSMATCH`.`P2_SET3`,`SGLSMATCH`.`ROUND_NUM`,`SGLSMATCH`.`MATCHWINNER`,`SGLSMATCH`.`PLAYOFF`,`SGLSROUND`.`END_DATE` FROM `SGLSMATCH` INNER JOIN `SGLSROUND` ON `SGLSMATCH`.`ROUND_NUM` = `SGLSROUND`.`ID` WHERE `SGLSMATCH`.`ID` = '".$mID."'";
            $pastSGLSMatchesQuery = @$conn->query($pastSGLSMatchSQL);
            while ($pastSGLSMatchesRow = mysqli_fetch_assoc($pastSGLSMatchesQuery)) {
                $matchPlayer1 = $pastSGLSMatchesRow["PLAYER1"];
                $matchPlayer2 = $pastSGLSMatchesRow["PLAYER2"];
                $matchP1S1 = $pastSGLSMatchesRow["P1_SET1"];
                $matchP1S2 = $pastSGLSMatchesRow["P1_SET2"];
                $matchP1S3 = $pastSGLSMatchesRow["P1_SET3"];
                $matchP2S1 = $pastSGLSMatchesRow["P2_SET1"];
                $matchP2S2 = $pastSGLSMatchesRow["P2_SET2"];
                $matchP2S3 = $pastSGLSMatchesRow["P2_SET3"];
                $matchRoundNum = $pastSGLSMatchesRow["ROUND_NUM"];
                $matchWinner = $pastSGLSMatchesRow["MATCHWINNER"];
                $matchPlayoff = $pastSGLSMatchesRow["PLAYOFF"];
                $matchEndDate = $pastSGLSMatchesRow["END_DATE"];

                if ($matchPlayer1 == $playerID){
                    $sglsOpponentSQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`SGLSLADDER`.`ID` as `RANK` FROM `SGLSLADDER` INNER JOIN `PLAYERS` ON `SGLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$matchPlayer2."'";
                    $sglsOpponentQuery = @$conn->query($sglsOpponentSQL);
                    #region error handling
                    if (!$sglsOpponentQuery) {
                        $errno = $conn->errno;
                        $error = $conn->error;
                        $conn->close();
                        die("Selection failed: ($errno) $error.");
                    }
                    #endregion
                    while ($sglsOpponentRow = mysqli_fetch_assoc($sglsOpponentQuery)) {
                        $sglsOpponentFName = $sglsOpponentRow["FIRST_NAME"];
                        $sglsOpponentLName = $sglsOpponentRow["LAST_NAME"];
                        $sglsOpponentRank = $sglsOpponentRow["RANK"];
                    }

                    if ($matchWinner == 1){
                        $matchSGResult = "Win";
                    } else {
                        $matchSGResult = "Loss";
                    } 
    
                    echo "<div class='printMatch'>";
                        echo "<table>";
                            echo "<td>SG",$matchRoundNum,"</td>";
                            echo "<td><button class='viewPlayer' value='".$matchPlayer2."'>",$sglsOpponentLName,", ",$sglsOpponentFName," (",$sglsOpponentRank,")</button></td>";
                            echo "<td class='mid2'>",$matchSGResult,"</td>";
                            echo "<td class='mid2'>",$matchP1S1," - ",$matchP2S1,"</td>";
                            echo "<td class='mid2'>",$matchP1S2," - ",$matchP2S2,"</td>";
                            echo "<td class='mid2'>",$matchP1S3," - ",$matchP2S3,"</td>";
                        echo "</table>";
                    echo "</div>";                
                    
                } else if ($matchPlayer2 == $playerID){
                    $sglsOpponentSQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`SGLSLADDER`.`ID` as `RANK` FROM `SGLSLADDER` INNER JOIN `PLAYERS` ON `SGLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$matchPlayer1."'";
                    $sglsOpponentQuery = @$conn->query($sglsOpponentSQL);
                    #region error handling
                    if (!$sglsOpponentQuery) {
                        $errno = $conn->errno;
                        $error = $conn->error;
                        $conn->close();
                        die("Selection failed: ($errno) $error.");
                    }
                    #endregion
                    while ($sglsOpponentRow = mysqli_fetch_assoc($sglsOpponentQuery)) {
                        $sglsOpponentFName = $sglsOpponentRow["FIRST_NAME"];
                        $sglsOpponentLName = $sglsOpponentRow["LAST_NAME"];
                        $sglsOpponentRank = $sglsOpponentRow["RANK"];
                    }

                    if ($matchWinner == 1){
                        $matchSGResult = "Loss";
                    } else {
                        $matchSGResult = "Win";
                    } 

                    echo "<div class='printMatch'>";
                        echo "<table>";
                            echo "<td>SG",$matchRoundNum,"</td>";
                            echo "<td><button class='viewPlayer' value='".$matchPlayer1."'>",$sglsOpponentLName,", ",$sglsOpponentFName," (",$sglsOpponentRank,")</button></td>";
                            echo "<td class='mid2'>",$matchSGResult,"</td>";
                            echo "<td class='mid2'>",$matchP2S1," - ",$matchP1S1,"</td>";
                            echo "<td class='mid2'>",$matchP2S2," - ",$matchP1S2,"</td>";
                            echo "<td class='mid2'>",$matchP2S3," - ",$matchP1S3,"</td>";
                        echo "</table>";
                    echo "</div>";   
                } else {
                    // do nothing
                }
            } 
            #endregion               
        } else if ($identifier == 'DB'){
            #region past doubles matches
            $pastDBLSMatchSQL = "SELECT `DBLSMATCH`.`ID`,`DBLSMATCH`.`PLAYER1`,`DBLSMATCH`.`PLAYER2`,`DBLSMATCH`.`PLAYER3`,`DBLSMATCH`.`PLAYER4`,`DBLSMATCH`.`T1_SET1`,`DBLSMATCH`.`T1_SET2`,`DBLSMATCH`.`T1_SET3`,`DBLSMATCH`.`T2_SET1`,`DBLSMATCH`.`T2_SET2`,`DBLSMATCH`.`T2_SET3`,`DBLSMATCH`.`ROUND_NUM`,`DBLSMATCH`.`SET1WINNER`,`DBLSMATCH`.`SET2WINNER`,`DBLSMATCH`.`SET3WINNER` FROM `DBLSMATCH` INNER JOIN `DBLSROUND` ON `DBLSMATCH`.`ROUND_NUM` = `DBLSROUND`.`ID` WHERE `DBLSMATCH`.`ID` = '".$mID."'";
            $pastDBLSMatchesQuery = @$conn->query($pastDBLSMatchSQL);

            while ($pastDBLSMatchesRow = mysqli_fetch_assoc($pastDBLSMatchesQuery)) {
                $DBPlayer1 = $pastDBLSMatchesRow["PLAYER1"];
                $DBPlayer2 = $pastDBLSMatchesRow["PLAYER2"];
                $DBPlayer3 = $pastDBLSMatchesRow["PLAYER3"];
                $DBPlayer4 = $pastDBLSMatchesRow["PLAYER4"];
                $DBT1S1 = $pastDBLSMatchesRow["T1_SET1"];
                $DBT1S2 = $pastDBLSMatchesRow["T1_SET2"];
                $DBT1S3 = $pastDBLSMatchesRow["T1_SET3"];
                $DBT2S1 = $pastDBLSMatchesRow["T2_SET1"];
                $DBT2S2 = $pastDBLSMatchesRow["T2_SET2"];
                $DBT2S3 = $pastDBLSMatchesRow["T2_SET3"];
                $DBRoundNum = $pastDBLSMatchesRow["ROUND_NUM"];
                $DBset1Winner = $pastDBLSMatchesRow["SET1WINNER"];
                $DBset2Winner = $pastDBLSMatchesRow["SET2WINNER"];
                $DBset3Winner = $pastDBLSMatchesRow["SET3WINNER"];

                #region player assignments
                if ($DBPlayer1 == $playerID){                
                    $set1Partner = $DBPlayer2;
                    $set2Partner = $DBPlayer3;
                    $set3Partner = $DBPlayer4;
                    $set1Score = $DBT1S1." - ".$DBT2S1;
                    $set2Score = $DBT1S2." - ".$DBT2S2;
                    $set3Score = $DBT1S3." - ".$DBT2S3;

                    if ($DBset1Winner == 1){
                        $set1Result = "Win";
                    } else {
                        $set1Result = "Loss";
                    }

                    if ($DBset2Winner == 1){
                        $set2Result = "Win";
                    } else {
                        $set2Result = "Loss";
                    }

                    if ($DBset3Winner == 1){
                        $set3Result = "Win";
                    } else {
                        $set3Result = "Loss";
                    }

                } else if ($DBPlayer2 == $playerID){
                    $set1Partner = $DBPlayer1;
                    $set2Partner = $DBPlayer4;
                    $set3Partner = $DBPlayer3;
                    $set1Score = $DBT1S1." - ".$DBT2S1;
                    $set2Score = $DBT2S2." - ".$DBT1S2;
                    $set3Score = $DBT2S3." - ".$DBT1S3;                    

                    if ($DBset1Winner == 1){
                        $set1Result = "Win";
                    } else {
                        $set1Result = "Loss";
                        $set1Score = $DBT1S1." - ".$DBT2S1;
                    }

                    if ($DBset2Winner == 2){
                        $set2Result = "Win";
                    } else {
                        $set2Result = "Loss";
                    }

                    if ($DBset3Winner == 2){
                        $set3Result = "Win";
                    } else {
                        $set3Result = "Loss";
                        $set3Score = $DBT2S3." - ".$DBT1S3;
                    }
                       
                } else if ($DBPlayer3 == $playerID){
                    $set1Partner = $DBPlayer4;
                    $set2Partner = $DBPlayer1;
                    $set3Partner = $DBPlayer2;
                    $set1Score = $DBT2S1." - ".$DBT1S1;
                    $set2Score = $DBT1S2." - ".$DBT2S2;
                    $set3Score = $DBT2S3." - ".$DBT1S3;

                    if ($DBset1Winner == 2){
                        $set1Result = "Win";
                    } else {
                        $set1Result = "Loss";
                    }

                    if ($DBset2Winner == 1){
                        $set2Result = "Win";
                    } else {
                        $set2Result = "Loss";
                    }

                    if ($DBset3Winner == 2){
                        $set3Result = "Win";
                    } else {
                        $set3Result = "Loss";
                    }
                    
                } else {
                    $set1Partner = $DBPlayer3;
                    $set2Partner = $DBPlayer2;
                    $set3Partner = $DBPlayer1;
                    $set1Score = $DBT2S1." - ".$DBT1S1;
                    $set2Score = $DBT2S2." - ".$DBT1S2;
                    $set3Score = $DBT1S3." - ".$DBT2S3;

                    if ($DBset1Winner == 2){
                        $set1Result = "Win";
                    } else {
                        $set1Result = "Loss";
                    }

                    if ($DBset2Winner == 2){
                        $set2Result = "Win";
                    } else {
                        $set2Result = "Loss";
                    }

                    if ($DBset3Winner == 1){
                        $set3Result = "Win";
                    } else {
                        $set3Result = "Loss";
                    }
                }
                #endregion
    
                #region opponent ranks
                $dblsOpponent1SQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`DBLSLADDER`.`ID` as `RANK` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `DBLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$set1Partner."'";
                $dblsOpponent1Query = @$conn->query($dblsOpponent1SQL);
                while ($dblsOpponent1Row = mysqli_fetch_assoc($dblsOpponent1Query)) {
                    $dblsOpponent1FName = $dblsOpponent1Row["FIRST_NAME"];
                    $dblsOpponent1LName = $dblsOpponent1Row["LAST_NAME"];
                    $dblsOpponent1Rank = $dblsOpponent1Row["RANK"];
                }
    
                $dblsOpponent2SQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`DBLSLADDER`.`ID` as `RANK` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `DBLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$set2Partner."'";
                $dblsOpponent2Query = @$conn->query($dblsOpponent2SQL);
                while ($dblsOpponent2Row = mysqli_fetch_assoc($dblsOpponent2Query)) {
                    $dblsOpponent2FName = $dblsOpponent2Row["FIRST_NAME"];
                    $dblsOpponent2LName = $dblsOpponent2Row["LAST_NAME"];
                    $dblsOpponent2Rank = $dblsOpponent2Row["RANK"];
                }
    
                $dblsOpponent3SQL = "SELECT `PLAYERS`.`FIRST_NAME` as `FIRST_NAME`,`PLAYERS`.`LAST_NAME` as `LAST_NAME`,`DBLSLADDER`.`ID` as `RANK` FROM `DBLSLADDER` INNER JOIN `PLAYERS` ON `DBLSLADDER`.`PLAYER_ID` = `PLAYERS`.`ID` WHERE `PLAYERS`.`ID` = '".$set3Partner."'";
                $dblsOpponent3Query = @$conn->query($dblsOpponent3SQL);
                while ($dblsOpponent3Row = mysqli_fetch_assoc($dblsOpponent3Query)) {
                    $dblsOpponent3FName = $dblsOpponent3Row["FIRST_NAME"];
                    $dblsOpponent3LName = $dblsOpponent3Row["LAST_NAME"];
                    $dblsOpponent3Rank = $dblsOpponent3Row["RANK"];
                }
                #endregion

                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td rowspan='3'>DB",$DBRoundNum,"</td>";
                            echo "<td><button class='viewPlayer' value='".$set1Partner."'>",$dblsOpponent1LName,", ",$dblsOpponent1FName," (",$dblsOpponent1Rank,")</button></td>";
                            echo "<td class='mid2'>",$set1Result,"</td>";
                            echo "<td class='mid2' rowspan='3'>",$set1Score,"</td>";
                            echo "<td class='mid2' rowspan='3'>",$set2Score,"</td>";
                            echo "<td class='mid2' rowspan='3'>",$set3Score,"</td>";
                        echo "</tr>";
                            echo "<td><button class='viewPlayer' value='".$set2Partner."'>",$dblsOpponent2LName,", ",$dblsOpponent2FName," (",$dblsOpponent2Rank,")</button></td>";
                            echo "<td class='mid2'>",$set2Result,"</td>";
                        echo "<tr>";
                            echo "<td><button class='viewPlayer' value='".$set3Partner."'>",$dblsOpponent3LName,", ",$dblsOpponent3FName," (",$dblsOpponent3Rank,")</button></td>";
                            echo "<td class='mid2'>",$set3Result,"</td>";
                        echo "</tr>";
                    echo "</table>";
                echo "</div>";    
            }
            #endregion
        } else if ($identifier == 'TD') {
            $TDMatchID = substr($pastMatchID,-11);

            $TDMatchInfoSQL = "SELECT t.`ID`, t.`TEAM1`, t.`TEAM2`, (CASE WHEN `T1`.`PLYR1_ID` = '". $playerID ."' OR `T1`.`PLYR2_ID` = '". $playerID ."' THEN `T2`.`TEAM_ID` ELSE `T1`.`TEAM_ID` END) AS `OPP_TEAM`, t.`ROUND_NUM`, t.`T1_SET1`, t.`T1_SET2`, t.`T1_SET3`, t.`T2_SET1`, t.`T2_SET2`, t.`T2_SET3`, t.`MATCHWINNER` FROM `TDMATCH` AS t LEFT JOIN `TDLADDER` AS `T1` ON t.`TEAM1` = `T1`.`TEAM_ID` LEFT JOIN `TDLADDER` AS `T2` ON t.`TEAM2` = `T2`.`TEAM_ID` WHERE t.`ID` = '". $TDMatchID ."'";
            $TDMatchInfoQuery = @$conn->query($TDMatchInfoSQL);
            while ($TDMatchInfoRow = mysqli_fetch_assoc($TDMatchInfoQuery)) {
                $team1ID = $TDMatchInfoRow["TEAM1"];
                $team2ID = $TDMatchInfoRow["TEAM2"];
                $oppTeamID = $TDMatchInfoRow["OPP_TEAM"];
                $TDRoundNum = $TDMatchInfoRow["ROUND_NUM"];
                $T1Set1 = $TDMatchInfoRow["T1_SET1"];
                $T1Set2 = $TDMatchInfoRow["T1_SET2"];
                $T1Set3 = $TDMatchInfoRow["T1_SET3"];
                $T2Set1 = $TDMatchInfoRow["T2_SET1"];
                $T2Set2 = $TDMatchInfoRow["T2_SET2"];
                $T2Set3 = $TDMatchInfoRow["T2_SET3"];
                $TDwinner = $TDMatchInfoRow["MATCHWINNER"];

                $oppInfoSQL = "SELECT `Rank`.`TEAM_ID`, `Rank`.`Rank`, `P1`.`LAST_NAME` as `p1ln`, `P1`.`FIRST_NAME` as `p1fn`,`P1`.`ID` as `p1ID`, `P2`.`LAST_NAME` as `p2ln`, `P2`.`FIRST_NAME` as `p2fn`, `P2`.`ID` as `p2ID` FROM ( SELECT * , (@rank := @rank + 1) AS `Rank` FROM `TDLADDER` CROSS JOIN( SELECT @rank := 0 ) AS `SETVAR` ORDER BY `TDLADDER`.`TD_POINTS` DESC ) AS `Rank` LEFT JOIN `PLAYERS` AS `P1` ON `P1`.`ID` = `Rank`.`PLYR1_ID` LEFT JOIN `PLAYERS` AS `P2` ON `P2`.`ID` = `Rank`.`PLYR2_ID` WHERE (`Rank`.`TEAM_ID` = '". $oppTeamID ."')";
                $oppInfoQuery = @$conn->query($oppInfoSQL);
                while ($oppInfoRow = mysqli_fetch_assoc($oppInfoQuery)) {
                    $TDoppRank = $oppInfoRow["Rank"];
                    $TDopp1FN = $oppInfoRow["p1fn"];
                    $TDopp1LN = $oppInfoRow["p1ln"];
                    $TDopp1ID = $oppInfoRow["p1ID"];
                    $TDopp2FN = $oppInfoRow["p2fn"];
                    $TDopp2LN = $oppInfoRow["p2ln"];
                    $TDopp2ID = $oppInfoRow["p2ID"];
                }

                if( (($team1ID != $oppTeamID) && ($TDwinner == 1)) || (($team2ID != $oppTeamID) && ($TDwinner == 2)) ){
                    $TDresult = "Win";
                    $set1Score = $T1Set1." - ".$T2Set1;
                    $set2Score = $T1Set2." - ".$T2Set2;
                    $set3Score = $T1Set3." - ".$T2Set3;
                } else {
                    $TDresult = "Loss";
                    $set1Score = $T2Set1." - ".$T1Set1;
                    $set2Score = $T2Set2." - ".$T1Set2;
                    $set3Score = $T2Set3." - ".$T1Set3;
                }

                echo "<div class='printMatch'>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td rowspan='2'>TD",$TDRoundNum,"</td>";
                            echo "<td><button class='viewPlayer' value='".$TDopp1ID."'>",$TDopp1LN,", ",$TDopp1FN," (",$TDoppRank,")</button></td>";
                            echo "<td class='mid2' rowspan='2'>",$TDresult,"</td>";
                            echo "<td class='mid2' rowspan='2'>",$set1Score,"</td>";
                            echo "<td class='mid2' rowspan='2'>",$set2Score,"</td>";
                            echo "<td class='mid2' rowspan='2'>",$set3Score,"</td>";
                        echo "</tr>";
                            echo "<td><button class='viewPlayer' value='".$TDopp2ID."'>",$TDopp2LN,", ",$TDopp2FN," (",$TDoppRank,")</button></td>";
                        echo "<tr>";
                    echo "</table>";
                echo "</div>"; 

            }

            
        } else {
            // do nothing
        }
    }
    

    #endregion
    
}
#endregion