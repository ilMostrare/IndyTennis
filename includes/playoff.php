<?php

    function playoffs($_roundID){
        global $conn;
        
        $playerCountSql = "SELECT COUNT(*) as 'COUNT' FROM `SGLSLADDER`";
        $playerCountQuery = @$conn->query($playerCountSql);
        while ($playerInfoRow = mysqli_fetch_assoc($playerCountQuery)) {
            $playerCount = $playerInfoRow["COUNT"];
        }
        $bracketCount = round($playerCount / 8);
        /*
        $playoffPlayersSql = "SELECT COUNT(*) as 'COUNT' FROM `SGLSLADDER` WHERE `PLAYOFF = 1`";
        $playerCountQuery = @$conn->query($playerCountSql);
        while ($playerInfoRow = mysqli_fetch_assoc($playerCountQuery)) {
            $playerCount = $playerInfoRow["COUNT"];
        }
        $bracketCount = round($playerCount / 8);
        */
        
        $alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $matchups = array
            (
            array(1,8),
            array(4,5),
            array(3,6),
            array(2,7)
            );

        for ($b = 1; $b <= $bracketCount; $b++){
            echo "<p><b>Bracket ".$alpha[($b-1)]."</b></p>";

            for ($row = 0; $row < 4; $row++) {
                // echo "<p><b>Row number $row</b></p>";
                echo "<ul>";

                $test = $matchups[$row][$col] % 8;
                $topPlayer = $matchups[$row][0];
                $botPlayer = $matchups[$row][1];
                echo "<li>".$topPlayer." - ".$botPlayer."</li>";
                echo "<tr><td class='tableLeft'></td><td class='tableCenter'> vs </td><td class='tableRight'><form><button type='submit' id='playerInfo' class='singlesMatch-player2-name' name='viewPlayer' value=''>", $botPlayer, "</button></form></td></tr>";

                echo "</ul>";
            }
        }
        

    }
    
    /*
    public function getPlayer(){
        global $conn;
        
        $output = "<li class='spacer'>&nbsp;</li>";
        $output .= "<li class='game game-top' id='A1a'><span>79</span></li>";
        $output .= "<li class='spacer'>&nbsp;</li>";
        $output .= "<li class='game game-bottom' id='A1a'><span>79</span></li>";
        $output .= "<li class='spacer'>&nbsp;</li>";

        return $output;
    }*/
    

?>