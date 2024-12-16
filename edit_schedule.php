<?php 
    include('mysql_connect.php');
    include('time_handling.php');
    include('login_check.php');
    if (!$_SESSION['admin?']) {
        header("location: index.php");
        die();
    }
    

    $sched_req = "SELECT * FROM tbl_movies ORDER BY timeStart";
    $schedule = $conn->query($sched_req);

?>

<html>
    <head>
        <title>Prepare Schedule</title>
        <script>
            function shift_movie(action, id) {
                var target = document.getElementById(id);

                document.getElementById("action"+id).value = action;
                target.submit();
            }
        </script>
    </head>
    <body>
        <h1>Schedule For Today</h1>
        <h2>Welcome, <?=$_SESSION['name']?></h2>

        <div style="font-family: monospace;">
            <center>
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
                        <label for="timeStart">Time Slot:</label>
                        <input type="time" required id="timeStart" name="timeStart"><br>
                        <label for="runTime">Runtime (hh:mm):</label>
                        <input type="text" required id="runTime" name="runTime"><br>

                        <input type="hidden" name="name" value="<?=$_POST['name']?>"> <!-- preserve the username -->

                        <input type="submit" value="Add">
                    </fieldset>
                </form>
                <table>
                    <tr>
                        <th>Time</th>
                        <th>End</th>
                        <th>Poster</th>
                        <th>Film</th>
                        <th>Rating</th>
                        <th>Edit</th>
                    </tr>
                    <?php for ($i = 1; $row = $schedule->fetch_assoc(); $i++) {?>
                        <tr>
                            <td><?=preg_filter("`...$`", "", $row['timeStart']);?></td>
                            <td style="text-align: center;"><?=preg_filter("`...$`", "", $row['timeEnd']);?></td>
                            <td style="text-align: center;"><img height=100 src="<?=$row['moviePoster']?>"></td>
                            <td><?=$row['movieName'];?></td>
                            <td>[<?=$row['rating'];?>]</td>
                            <td style="text-align: center;">
                                <form id="<?=$row['movieID']?>" action="shift_movie.php" method="POST">
                                    <input type="hidden" name="movieID" value="<?=$row['movieID'];?>">
                                    <input type="hidden" id="action<?=$row['movieID']?>" name="action" value="">
                                    <?php if ($i > 1) {?>
                                        <input type="image" src="icons/up.png" onclick="shift_movie('up','<?=$row['movieID'];?>')" height=20>
                                    <?php }?>
                                    <?php if ($i < $schedule->num_rows) {?>
                                        <input type="image" src="icons/down.png" onclick="shift_movie('down','<?=$row['movieID'];?>')" height=20>
                                    <?php }?>
                                </form>
                                <form action="delete_movie.php" method="POST" onsubmit="return confirm('Delete <?=$row['movieName'];?>?');">
                                    <input type="hidden" name="movieID" value="<?=$row['movieID'];?>">
                                    <input type="hidden" name="amt"value=1>
                                    <input type="image" src="icons/trash.png" height=20>
                                </form>
                            </td>
                        </tr>
                    <?php } unset($i);?>
                </table>
            </center>
        </div>
    </body>
</html>