<?php

include("mysql_connect.php");
include('time_handling.php');

$sched_req = "SELECT * FROM tbl_movies ORDER BY timeStart";
$schedule = $conn->query($sched_req);
$postDir = "uploads/"; //poster directory

$newMovie = "INSERT INTO tbl_movies (`movieName`, `rating`, `price`, `timeStart`, `runTime`, `timeEnd`, `moviePoster`) VALUES (";

$newMovie .= "'".$_POST['movieName']."','".$_POST['rating']."','".$_POST['price']."','".$_POST['timeStart']."','".$_POST['runTime']."','";
$conflict = false; // if there is a schedule conflict

$newMovie .= timeAdd($_POST['timeStart'], $_POST['runTime'])."'"; // calculate endTime
// file_put_contents('php://stderr', print_r([$start, $lengt, $endTime, $newMovie], TRUE));

while ($row = $schedule->fetch_assoc()) {
    if (isInRange($row['timeStart'], $row['timeEnd'], $_POST['timeStart'])) {
        $conflict = true;
    }
    if (isInRange($row['timeStart'], $row['timeEnd'], timeAdd($_POST['timeStart'], $_POST['runTime']))) {
        $conflict = true;
    }
}
$schedule->data_seek(0);

try  { // if this is truly an image
    getimagesize($_FILES['moviePoster']['tmp_name']);
    $poster = $postDir.basename($_FILES['moviePoster']['tmp_name']);
    move_uploaded_file($_FILES['moviePoster']['tmp_name'], $poster);
    $newMovie .= ", '$poster')";
} catch (Error $e) {
    $newMovie .= ", 'icons/missing.png')";
}

if (!$conflict) {
    $conn->query($newMovie);
}

header("location: edit_schedule.php");
die();