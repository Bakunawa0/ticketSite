<?php 
    include('mysql_connect.php');

    $movieQuery = "SELECT movieName, price FROM tbl_movies WHERE movieID = ".$_POST['movieID'];
    $movieInfo = $conn->query($movieQuery)->fetch_assoc();

    if ($_POST && array_key_exists("action", $_POST)) {
        switch ($_POST['action']) {
            case 'increment':
                $_POST['amt']++;
                break;
            case 'decrement':
                if ($_POST['amt'] >= 1) 
                    $_POST['amt']--;
                break;
            default:
                break;
        }
    }
?>

<html>
    <head>
        <title><?=$movieInfo['movieName']?> Tickets</title>
        <script>
            function performAction(action) {
                document.getElementById('action').value = action;
                document.amountForm.submit();
            }
        </script>
    </head>
    <body>
        <center>
            <h2>"<?=$movieInfo['movieName']?>"</h2> <br>
            <span style="display: flex;height: 16pt;justify-content: center;">
                <form id="amountForm" name="amountForm" method="POST" action="make_ticket.php">
                    <input type="button" name="decrement" value="-" onclick="performAction('decrement')">
                    <input type="text" name="amt" size=1 min=0 max=99 value="<?=$_POST['amt']?>">
                    <input type="button" name="increment" value="+" onclick="performAction('increment')">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" name="movieID" value="<?=$_POST['movieID']?>">
                </form>
                   * ₱<?=$movieInfo['price']?> = ₱<?php echo $_POST['amt'] * $movieInfo['price']?>
            </span>
        </center>
    </body>
</html>