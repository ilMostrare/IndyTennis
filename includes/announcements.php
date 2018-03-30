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

    $announceSQL = "SELECT * FROM `ANNOUNCEMENTS` WHERE CURRENT_DATE BETWEEN CAST(`START_DATE` AS date) AND CAST(`END_DATE` AS date) ORDER BY `END_DATE` ASC";
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

        echo "<h4>",$announceTitle,"</h4><p>- ",$announceContent,"</p><p id='announceDates'>exp: ",$announceEnd,"</p><br />";
    }
}