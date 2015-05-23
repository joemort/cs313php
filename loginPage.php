<?php
    session_start();
    if(isset($_SESSION['userid'])) {
        header( 'Location: viewMovies.php' );
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
    echo "<p>Username/Password was not correct. Please try again.</p>";
    unset($_SESSION['failure']);
}
?>

<form method="POST" action="doLogin.php">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="user" id="user" size="30" required="true"/></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password" size="30" required="true"/></td>
        </tr>
    </table>
    <br/>
    <input type="submit"/>
</form>
</form>
</body>
</html>