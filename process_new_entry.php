<?php

include("mysql_connect.php");

$sched_req = "SELECT * FROM tbl_movies ORDER BY timeStart";
$schedule = $conn->query($sched_req);
$postDir = "uploads/"; //poster directory

$newMovie = "INSERT INTO tbl_movies (`movieName`, `rating`, `price`, `timeStart`, `runTime`, `moviePoster`) VALUES (";

$newMovie .= "'".$_POST['movieName']."','".$_POST['rating']."','".$_POST['price']."','".$_POST['timeStart']."','".$_POST['runTime']."'";
$conflict = false; // if there is a schedule conflict

$newEndTime = $_POST['timeStart'] + $_POST['runTime']; // end time of the new movie
while ($row = $schedule->fetch_assoc()) {
    
    $endTime = $row['timeStart'] + $row['runTime'];

    if ($row['timeStart'] <= $_POST['timeStart'] && $_POST['timeStart'] <= $endTime) { // is the starting time of the new movie inside another movie?
        $conflict = true;
    } else if ($row['timeStart'] <= $newEndTime && $newEndTime <= $endTime) { // is the ending of the new movie inside another movie?
        $conflict = true;
    }
}

file_put_contents('php://stderr', print_r(($_POST['moviePoster'] === NULL) ? "empty\n" : "not empty: ".$_POST['moviePoster'].'\n', TRUE));

try  { // if this is truly an image
    getimagesize($_FILES['moviePoster']['tmp_name']);
    $poster = $postDir.basename($_FILES['moviePoster']['tmp_name']);
    move_uploaded_file($_FILES['moviePoster']['tmp_name'], $poster);
    $newMovie .= ", '$poster')";
} catch (Error $e) {
    file_put_contents('php://stderr', print_r("Fail from size\n", TRUE));
    $newMovie .= ", 'icons/missing.png')";
}

if (!$conflict) {
    $conn->query($newMovie);
}

header("location: edit_schedule.php");
die();