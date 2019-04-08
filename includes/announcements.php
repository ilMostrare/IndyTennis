<?php
/**
 * Created by PhpStorm.
 * User: bslabach
 * Date: 3/28/18
 * Time: 1:32 PM
 */

function printAnnouncements()
{
    global $conn;

    $announceSQL = "SELECT * FROM `ANNOUNCEMENTS` WHERE `END_DATE` >= CURDATE() ORDER BY `END_DATE` ASC";
    $announceQuery = @$conn->query($announceSQL);
    if (!$announceQuery) {
        $errno = $conn->errno;
        $error = $conn->error;
        $conn->close();
        die("Selection failed: ($errno) $error.");
    }
    while ($announceRow = mysqli_fetch_assoc($announceQuery)) {
        $announceID = $announceRow["ID"];
        $announceStart = $announceRow["START_DATE"];
        $announceEnd = $announceRow["END_DATE"];
        $announceTitle = $announceRow["TITLE"];
        $announceContent = $announceRow["CONTENT"];

        echo "<h4>",$announceTitle,"</h4><p>- ",$announceContent,"</p><p id='announceDates'>Date: ",$announceEnd,"</p><br />";
    }
}

function displayAnnouncements(){

    global $conn;

    echo '<div class="hmRight" id="style-2">';
    echo '<br />';
    echo '<h3>Announcements / Upcoming</h3>';
    echo '<br />';

            $numAnnounceSQL = "SELECT * FROM `ANNOUNCEMENTS` WHERE `END_DATE` >= CURDATE() ORDER BY `END_DATE` ASC";
            $numAnnounceQuery = @$conn->query($numAnnounceSQL);
            $numAnnounce = mysqli_num_rows($numAnnounceQuery);

            if ($numAnnounce > 0){

                printAnnouncements();

            } else{

                echo "<p id='noAnnounce'>No new announcements!</p>";

            }

    echo '</div>';

}