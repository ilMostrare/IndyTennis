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

    echo "<div class='header'><h1>", $playerInfoFN, " ", $playerInfoLN ,"</h1>";
    echo "<h4>", $playerInfoEM, " - (", substr($playerInfoPN, 0, 3) ,") ",substr($playerInfoPN, 3, 3),"-",substr($playerInfoPN, 6, 4),"</h4>";

    if ($playerInfoSGLS != 1 && $playerInfoDBLS = 1){
        echo "<div class='rankings'><h3 class='left'></h3><h3 class='right'>Doubles: #",$curDBLSRank," (",$curDBLSRankPoints," PTS, ",$curDBLSWins,"-",$curDBLSLosses,")</h3></div></div>";
    } elseif ($playerInfoDBLS != 1 && $playerInfoSGLS = 1){
        echo "<div class='rankings'><h3 class='left'>Singles: #",$curSGLSRank," (",$curSGLSRankPoints," PTS, ",$curSGLSWins,"-",$curSGLSLosses,")</h3><h3 class='right'></h3></div></div>";
    } else {
        echo "<div class='rankings'><h3 class='left'>Singles: #",$curSGLSRank," (",$curSGLSRankPoints," PTS, ",$curSGLSWins,"-",$curSGLSLosses,")</h3><h3 class='right'>Doubles: #",$curDBLSRank," (",$curDBLSRankPoints," PTS, ",$curDBLSWins,"-",$curDBLSLosses,")</h3></div></div>";
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
                        if($matchPlayoff == 1){echo "<td>Win</td>";} else {echo "<td>No</td>";}
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
                        if($matchPlayoff == 1){echo "<td>Win</td>";} else {echo "<td>No</td>";}
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
                echo "<td>No matches to display</td>";
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
                        echo "<td><button class='viewPlayer' value='".$opponent1."'>",$dblsOpponent1FName,", ",$dblsOpponent1LName," (",$dblsOpponent1Rank,")</button></td>";
                        if($matchPlayoff == 1){echo "<td rowspan='3'>Win</td>";} else {echo "<td rowspan='3'>No</td>";}
                        echo "<td rowspan='3'>",$matchEndDate,"</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><button class='viewPlayer' value='".$opponent2."'>",$dblsOpponent2FName,", ",$dblsOpponent2LName," (",$dblsOpponent2Rank,")</button></td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><button class='viewPlayer' value='".$opponent3."'>",$dblsOpponent3FName,", ",$dblsOpponent3LName," (",$dblsOpponent3Rank,")</button></td>";
                    echo "</tr>";
                echo "</table>";
            echo "</div>";


        } 
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

    $pastMatchesSQL = "SELECT * FROM ( (SELECT CONCAT('SG',`SGLSMATCH`.`ID`) AS `ID`, `SGLSMATCH`.`LAST_MODIFIED` AS `LASTMODIFIED` FROM `SGLSMATCH` WHERE (`SGLSMATCH`.`PLAYER1` = '".$playerID."' OR `SGLSMATCH`.`PLAYER2` = '".$playerID."') AND `SGLSMATCH`.`MATCHWINNER` != 0) UNION ALL (SELECT CONCAT('DB',`DBLSMATCH`.`ID`) AS `ID`, `DBLSMATCH`.`LAST_MODIFIED` AS `LASTMODIFIED` FROM `DBLSMATCH` WHERE (`DBLSMATCH`.`PLAYER1` = '".$playerID."' OR `DBLSMATCH`.`PLAYER2` = '".$playerID."' OR `DBLSMATCH`.`PLAYER3` = '".$playerID."' OR `DBLSMATCH`.`PLAYER4` = '".$playerID."') AND `DBLSMATCH`.`SET1WINNER` != 0) ) `RESULTS` ORDER BY `LASTMODIFIED` ASC";
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
        } else {
            // do nothing
        }
    }
    

    #endregion
    
}
#endregion