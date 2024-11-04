<?php 
    include('mysql_connect.php');

    if(isset($_POST['username']) && isset($_POST['password'])) {
        $acctQuery = "SELECT * FROM tbl_users";
        $accounts = $conn->query($acctQuery);

        while($account = $accounts->fetch_assoc()) {
            if ($account['username'] == $_POST['username']) {
                if ($account['password'] == $_POST['password']) {
                    header("location: schedule.php");
                    die();
                } else {
                    echo '<h2>Badmatch password; type better</h2>';
                }
            } else {
                echo '<h2>Nonsuch name value; fuck off</h2>';
            }
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