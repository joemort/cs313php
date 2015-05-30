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
<title>Movie Tracker - Login</title>
</head>
<body>
<p>use test/test</p>
<?php
if (isset($_SESSION['failure'])) {
    echo "<p>" . $_SESSION['failure'] . "</p>\n";
    unset($_SESSION['failure']);
}
?>

<form method="POST" action="doLogin.php">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="user" id="user" size="30" maxlength="30" required="true"/></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password" size="30" maxlength="30" required="true"/></td>
        </tr>
    </table>
    <br/>
    <input type="submit" name="login" value="Login"/>
    <input type="submit" name="register" value="Register"/>
</form>
</form>
</body>
</html>