<?php 
    include('mysql_connect.php');

    $sched_req = "SELECT * FROM tbl_movies ORDER BY timeStart";
    $schedule = $conn->query($sched_req);
?>

<html>
    <body>
        <h1>Schedule For Today</h1>
        <h2>Welcome, <?=$_POST['name']?></h2>
        <div style="font-family: monospace;">
            <center>
                <table>
                    <tr>
                        <th>Time</th>
                        <th>Poster</th>
                        <th>Film</th>
                        <th>Rating</th>
                        <th>Sell</th>
                    </tr>
                    <?php while ($row = $schedule->fetch_assoc()) {?>
                        <tr>
                            <td><?=$row['timeStart'];?></td>
                            <td><img height=100 src="<?=$row['moviePoster']?>"></td>
                            <td><?=$row['movieName'];?></td>
                            <td>[<?=$row['rating'];?>]</td>
                            <td>
                                <form action="make_ticket.php" method="POST" onsubmit="return confirm('Sell ticket for <?=$row['movieName'];?>?');">
                                    <input type="hidden" name="movieID" value="<?=$row['movieID'];?>">
                                    <input type="hidden" name="amt"value=1>
                                    <input type="submit" value="Sell Ticket">
                                </form>
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </center>
        </div>
    </body>
</html>