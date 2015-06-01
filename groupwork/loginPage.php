<?php
    session_start();
    if(isset($_SESSION['userid'])) {
        header( 'Location: viewMovies.php' );
    }
    
    if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "") {
        $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header("Location: $redirect");
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>Group Work - Login</title>
</head>
<body>
<?php
if (isset($_SESSION['failure'])) {
    echo "<p>" . $_SESSION['failure'] . "</p>\n";
    unset($_SESSION['failure']);
}
?>
<p>Login as an existing user:</p>
<form method="POST" action="dologin.php">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="user" id="user" size="30" maxlength="20" required="true"/></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password" size="30" maxlength="30" required="true"/></td>
        </tr>
    </table>
    <br/>
    <input type="submit" name="login" value="Login"/>
</form>
</form>
</body>
</html>