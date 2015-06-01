<?php
    session_start();
    if(!isset($_SESSION['userid'])) {
        header( 'Location: dologin.php' );
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>Group Work - home page</title>
</head>
<body>
<?php
echo "<p> Hello " . $_SESSION['username'] . "</p>";
?>
</body>
</html>