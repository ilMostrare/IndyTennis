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

    $resultSet = array();

    $allSinglesPlayersSQL = "SELECT `ID` FROM `PLAYERS` WHERE `SGLS_PLAYER`=1 AND `SEASON_NUM`='" . $sznID . "' ORDER BY `SGLS_POINTS` DESC";
    $allSinglesPlayersQuery = @$conn->query($allSinglesPlayersSQL);
    while ($all_SGLS_Players_Row = mysqli_fetch_assoc($allSinglesPlayersQuery)) {
        $resultSet[] = $all_SGLS_Players_Row;
    }

    foreach($resultSet as &$player){
        $j = rand(1, 3);
        $player2 = $player + $j;

        $existsSQL = "SELECT * FROM `SGLSMATCH` WHERE ((`PLAYER1` = '" . $player . "') OR (`PLAYER2` = '" . $player . "')) AND `ROUND_NUM` = '" . $currentRound . "'";
        $existsQRY = @$conn->query($existsSQL);
        $alreadyExistsROW = mysqli_num_rows(($existsQRY));


        $totalSGLSplayersSQL = "SELECT * FROM `PLAYERS` WHERE `SGLS_PLAYER`=1 AND `SEASON_NUM`='" . $sznID . "'";
        $totalSGLSplayersQRY = @$conn->query($totalSGLSplayersSQL);
        $totalSGLSplayersROW = mysqli_num_rows($totalSGLSplayersQRY);

        if ($alreadyExistsROW > 0) {
            //$i++;
            echo "Player exists, do nothing";
        } else {
            if ($player2 > $totalSGLSplayersROW) {
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '" . $player . "', NULL, " . $currentRound . ", " . $sznID . ", '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                //$i++;
            } else {
                $createMatchSQL = "INSERT INTO `SGLSMATCH` (`ID`, `PLAYER1`, `PLAYER2`, `ROUND_NUM`, `SEASON_NUM`, `P1_SET1`, `P1_SET2`, `P1_SET3`, `P2_SET1`, `P2_SET2`, `P2_SET3`, `MATCHWINNER`, `CHALLENGE`, `PLAYOFF`) VALUES (NULL, '" . $player . "', '" . $player2 . "', '" . $currentRound . "', '" . $sznID . "', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                @$conn->query($createMatchSQL);
                //$i++;
            }
        }
    }
}



if (isset($_POST['createSGLSID'])){

    createSGLSMatches();

}

#endregion

#