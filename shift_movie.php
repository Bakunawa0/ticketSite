<?php

include("mysql_connect.php");
include("time_handling.php");

$sched_req = "SELECT movieID, timeStart, timeEnd FROM tbl_movies ORDER BY timeStart";
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

$targetTime = $conn->query("SELECT timeStart, runTime, timeEnd FROM tbl_movies WHERE movieID = ".$_POST['movieID']);
$targetStart = $targetTime->fetch_column();
$targetTime->data_seek(0);
$targetRun = $targetTime->fetch_column(1);

if ($action == "up") { // swap target with before
    $beforeTime = $conn->query("SELECT timeStart, runTime, timeEnd FROM tbl_movies WHERE movieID = ".$beforeID);
    $beforeStart = $beforeTime->fetch_column();
    $beforeTime->data_seek(0);
    $beforeRun = $beforeTime->fetch_column(1);
    $beforeTime->data_seek(0);

    // set start of target to start of before 
    $conn->query("UPDATE tbl_movies SET timeStart = '".$beforeStart."' WHERE movieID = ".$_POST['movieID']);
    // recompute end of target
    $newTargetEnd = timeAdd($beforeStart, $targetRun);
    $conn->query("UPDATE tbl_movies SET timeEnd = '".$newTargetEnd."' WHERE movieID = ".$_POST['movieID']);
    // set start of before to end of target 
    $conn->query("UPDATE tbl_movies SET timeStart = '".$newTargetEnd."' WHERE movieID = ".$beforeID);
    // recompute end of before
    $conn->query("UPDATE tbl_movies SET timeEnd = '".timeAdd($newTargetEnd, $beforeRun)."' WHERE movieID = ".$beforeID);

} else if ($action == "down") { // swap target with after
    $afterTime = $conn->query("SELECT timeStart, runTime, timeEnd FROM tbl_movies WHERE movieID = ".$afterID);
    $afterStart = $afterTime->fetch_column();
    $afterTime->data_seek(0);
    $afterRun = $afterTime->fetch_column(1);
    $afterTime->data_seek(0);
// file_put_contents('php://stderr', print_r([$afterID,$afterStart], TRUE));
//     $afterTime->data_seek(0);

    // set start of after to start of target
    $conn->query("UPDATE tbl_movies SET timeStart = '".$targetStart."' WHERE movieID = ".$afterID);
    // recompute end of after
    $newAfterEnd = timeAdd($targetStart, $afterRun);
    $conn->query("UPDATE tbl_movies SET timeEnd = '".$newAfterEnd."' WHERE movieID = ".$afterID);
    // set start of target to end of after
    $conn->query("UPDATE tbl_movies SET timeStart = '".$newAfterEnd."' WHERE movieID = ".$_POST['movieID']);
    // recompute end of target
    $conn->query("UPDATE tbl_movies SET timeEnd = '".timeAdd($newAfterEnd, $targetRun)."' WHERE movieID = ".$_POST['movieID']);
}

header("location: edit_schedule.php");
die();