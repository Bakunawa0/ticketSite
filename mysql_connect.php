<?php 
    $servername = 'localhost';
    $username = 'root';
    $dbname = 'movie_ticketing';

    $conn = mysqli_connect($servername, $username, '', $dbname);

    if (!$conn) {
        die("VBAD: ".mysqli_connect_error());
    }