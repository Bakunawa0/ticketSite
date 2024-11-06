<?php 
    include('mysql_connect.php');

    if(isset($_POST['username']) && isset($_POST['password'])) {
        $acctQuery = "SELECT * FROM tbl_users";
        $accounts = $conn->query($acctQuery);
        $accountMatch = false;
        $matchedAccount = '';

        while($account = $accounts->fetch_assoc()) {
            if ($account['username'] == $_POST['username'] && $account['password'] == $_POST['password']) {
                $accountMatch = true;
                $matchedAccount = $account;
            } 
        }

        if ($accountMatch) {
            // inject POST data into the next page
            echo "
                <form method='POST' name='transmitName' id='transmitName' action=''>
                    <input type='hidden' name='name' value='".$matchedAccount['firstName']." ".$matchedAccount['lastName']."'>
                </form>
            ";
            if ($matchedAccount['admin?']) {
                echo '<script>document.getElementById("transmitName").action="edit_schedule.php"; document.transmitName.submit();</script>';
            }
                echo '<script>document.getElementById("transmitName").action="schedule.php"; document.transmitName.submit();</script>';
        } else {
            echo '<h2>Nonsuch acct deetos; capping possible?</h2>';
        }
    }
?>

<html>
    <head>
        <title>Login</title>
        <script>
            function clearField(target) {
                if(target === "password")
                    document.getElementById(target).type="password";
                document.getElementById(target).value="";
            }
        </script>
    </head>

    <body>
        <center>
            <h1><marquee scrollamount="16">LOGIN</marquee></h1>
            <form method="POST" id="loginForm" action="index.php">
                <input type="text" name="username" id="username" value="Username" onclick="clearField('username')"><br>
                <input type="text" name="password" id="password" value="Password" onclick="clearField('password')"><br>
                <input type="submit" value="Login">
            </form>
        </center>
    </body>
</html>