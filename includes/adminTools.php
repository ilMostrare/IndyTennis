<?php
/**
 * Created by PhpStorm.
 * User: bslabach
 * Date: 3/30/18
 * Time: 7:40 PM
 */

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



if (isset($_POST['createSGLSID'])){

    createSGLSMatches();

    //unset($_POST['createSGLSID']);

    //echo $_POST['createSGLSID'];
}

#endregion
