<?php
    include('mysql_connect.php');

    if (isset($_COOKIE['movieID'])) {
        $movieQuery = "SELECT movieName, price FROM tbl_movies WHERE movieID = ".$_COOKIE['movieID'];
        $movieInfo = $conn->query($movieQuery)->fetch_assoc();
    } else {
        header('location: schedule.php');
        die();
    }

    // log the transaction in tbl_transactions
    $conn->query("INSERT INTO tbl_transactions (`movieName`, `transactionAmt`) VALUES ('".$movieInfo['movieName']."','".$_COOKIE['total']."')");
?>

<html>
    <head>
        <title>Ticket<?= ($_COOKIE['total'] > $movieInfo['price']) ? 's':'';?> for <?=$movieInfo['movieName']?></title>
        <link rel="stylesheet" href="styles.css">
    </head>    
    <body style="font-family: monospace; font-size: 16pt;">
            <center>
                <div id="ticketBox">
                    <p>
                        <b>Ticket<?= ($_COOKIE['total'] > $movieInfo['price']) ? 's':'';?> for:</b> <br>
                        <?=$movieInfo['movieName']?>&#09;<?=$_COOKIE['amt']?>
                        <span style="text-align: right">* ₱<?=sprintf("%.2f", $movieInfo['price'])?> ₱<?=sprintf("%.2f", $_COOKIE['total'])?></span>
                    </p>
                </div>
                <input type="button" name="back" value="Return to Schedule" onclick="window.location.replace('schedule.php')">
            </center>
    </body>
</html>