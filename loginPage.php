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

<link rel="stylesheet" type="text/css" href="index.css">
<script type="text/javascript">
        function adjustSize() {
            var height = 0;
            var body = window.document.body;
            if (window.innerHeight) {
                height = window.innerHeight;
            } else if (body.parentElement.clientHeight) {
                height = body.parentElement.clientHeight;
            } else if (body && body.clientHeight) {
                height = body.clientHeight;
            }
            height = height - 260;
            document.getElementById('stretch').style.height = height + "px";
        }
</script>


</head>
<body onload="adjustSize();" onresize="adjustSize();">
<?php
if (isset($_SESSION['failure'])) {
    echo "<p>" . $_SESSION['failure'] . "</p>\n";
    unset($_SESSION['failure']);
}
?>
<table class="rcorner" id="header">
<tr>
<td class="leftside"></td>
<td class="rightside">Movie Tracker - Login</td>
</tr>
</table>
<table class="bodytable" id="stretch">
<tr>
<td class="leftsidecoloredfixed" id="colorsquare"></td>
<td class="rightsidebody">
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
</tr>
</table>
</body>
</html>