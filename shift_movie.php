<?php

include("mysql_connect.php");

$sched_req = "SELECT * FROM tbl_movies ORDER BY timeStart";
$schedule = $conn->query($sched_req);
$buffer = ["", "", ""]; // buffer to contain 3 row entries: the one before the target, the target, and the one after the target
$beforeID = 0; // id of movie before target
$afterID = 0;  // id of movie after target

$action = $_POST['action'];
// file_put_contents('php://stderr', print_r($_POST, TRUE));

while ($row = $schedule->fetch_assoc()) { // send rows through the buffer until target is in the index [1] 
    array_push($buffer, $row['movieID']);

    if (count($buffer) >= 4) {
        $buffer = array_slice($buffer, 1);
    }

// file_put_contents('php://stderr', print_r($buffer, TRUE));
    if ($buffer[1] == $_POST['movieID']) {
        break;
    }
}

if ($buffer[2] == $_POST['movieID']) { // if target is at the end of the schedule
    $beforeID = $buffer[1];
} else if ($buffer[0] == "") { // if target is at the start of the schedule
    $afterID = $buffer[2];
} else {
    $beforeID = $buffer[0];
    $afterID = $buffer[2];
}
// file_put_contents('php://stderr', print_r([$beforeID, $afterID], TRUE));

$targetTime = $conn->query("SELECT timeStart FROM tbl_movies WHERE movieID = ".$_POST['movieID'])->fetch_column();

if ($action == "up") { // swap target with before
    $beforeTime = $conn->query("SELECT timeStart FROM tbl_movies WHERE movieID = ".$beforeID)->fetch_column();
    $conn->query("UPDATE tbl_movies SET timeStart = '".$beforeTime."' WHERE movieID = ".$_POST['movieID']);
    $conn->query("UPDATE tbl_movies SET timeStart = '".$targetTime."' WHERE movieID = ".$beforeID);
} else if ($action == "down") { // swap target with after
    $afterTime= $conn->query("SELECT timeStart FROM tbl_movies WHERE movieID = ".$afterID)->fetch_column();
    $conn->query("UPDATE tbl_movies SET timeStart = '".$afterTime."' WHERE movieID = ".$_POST['movieID']);
    $conn->query("UPDATE tbl_movies SET timeStart = '".$targetTime."' WHERE movieID = ".$afterID);
}

header("location: edit_schedule.php");
die();