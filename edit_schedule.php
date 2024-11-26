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
                        <td>
                            <table>
                                <tr>
                                    <th>Time</th>
                                    <th>Poster</th>
                                    <th>Film</th>
                                    <th>Rating</th>
                                    <th>Edit</th>
                                </tr>
                                <?php while ($row = $schedule->fetch_assoc()) {?>
                                    <tr>
                                        <td><?=$row['timeStart'];?></td>
                                        <td><img height=100 src="<?=$row['moviePoster']?>"></td>
                                        <td><?=$row['movieName'];?></td>
                                        <td>[<?=$row['rating'];?>]</td>
                                        <td>
                                            <form action="shift_movie.php" method="POST">
                                                <input type="hidden" name="movieID" value="<?=$row['movieID'];?>">
                                                <input type="hidden" name="action"value="up">
                                                <input type="submit" value="↑">
                                            </form>
                                            <form action="shift_movie.php" method="POST"></form>
                                                <input type="hidden" name="movieID" value="<?=$row['movieID'];?>">
                                                <input type="hidden" name="amt"value="down">
                                                <input type="submit" value="↓">
                                            </form>
                                            <form action="delete_movie.php" method="POST" onsubmit="return confirm('Delete <?=$row['movieName'];?>?');">
                                                <input type="hidden" name="movieID" value="<?=$row['movieID'];?>">
                                                <input type="hidden" name="amt"value=1>
                                                <input type="submit" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                <?php }?>
                            </table>
                        </td>
                        <td>
                            <form method="POST" action="process_new_entry.php" enctype="multipart/form-data">
                                <fieldset>
                                    <legend><b>Add Film:</b></legend>
                                    <label for="movieName">Title:</label>
                                    <input type="text" required id="movieName" name="movieName"><br>
                                    <label for="moviePoster">Poster (10MiB max):</label>
                                    <input type="file" id="moviePoster" name="moviePoster"><br>
                                    <label for="moviePoster">Ticket Price:</label>
                                    <input type="text" required id="price" name="price"><br>
                                    <label for="rating">Rating:</label>
                                    <select id="rating" name="rating">
                                        <option value="G">G</option>
                                        <option value="PG">PG</option>
                                        <option value="PG13">PG-13</option>
                                        <option value="R16">R-16</option>
                                        <option value="R">R</option>
                                    </select><br>
                                    <label for="timeStart">Time Slot (24H):</label>
                                    <input type="text" required id="timeStart" name="timeStart"><br>
                                    <label for="runTime">Runtime (min):</label>
                                    <input type="text" required id="runTime" name="runTime"><br>

                                    <input type="hidden" name="name" value="<?=$_POST['name']?>"> <!-- preserve the username -->

                                    <input type="submit" value="Add">
                                </fieldset>
                            </form>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
    </body>
</html>