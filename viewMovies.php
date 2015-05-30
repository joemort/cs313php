<?php
    session_start();
    if(!isset($_SESSION['userid'])) {
        header( 'Location: loginPage.php' );
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Preferences and Suggestions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="viewMovies.css"/>
</head>

<body>
<h2>Movies:</h2>
<form method="GET" action="doLogout.php">
<input type="submit" value="Logout"/>
</form>
<div class="row-fluid">
<?php
$dbName = 'php';
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
$userID = $_SESSION['userid'];

try
{
	$db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
	$statement = $db->prepare('CALL `getMoviesList` (:userid);');
    $statement->bindParam('userid', $userID);
	$statement->execute();
    
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-full-height" id="' . $row['id'] . '" name="';
        
        if ($row['liked'] == 1) {
            echo 'liked';
        } else if ($row['suggested'] == 1) {
            echo 'suggested';
        } else {
            echo 'normal';
        }
        echo '"><table><tr><td class="smallheader"><strong>' . $row['name'] . '</strong></td></tr>'
            . '<tr><td class="imgrow"><img src="movieposters/' . $row['image'] . '" width="200" height="300"/></td></tr>'
            . '<tr><td class="description">' . $row['description'] . "</td></tr></table></div>\n\n";
	}
    
    $statement->close();
    $db->close();
}
catch (Exception $ex)
{
	echo "Can't connect to DB. Exception: $ex";
	die();
}

?>
</div>
</body>
</html>