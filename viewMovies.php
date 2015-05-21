<!DOCTYPE html>
<html>
<head>
	<title>Team Scripture Activity</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<h2>Scriptures:</h2>
<div class="row-fluid">
<?php
$dbName = 'scriptureActivity';
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
$userID = 1;

try
{
	$db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
	$statement = $db->prepare('CALL getMoviesList(' . $userID . ')');
	$statement->execute();
    
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2" id="' . $row['id'] . '" name="';
        
        if ($row['liked'] == 1) {
            echo 'liked';
        } else if ($row['suggestion'] == 1) {
            echo 'suggested';
        } else {
            echo 'normal';
        }
        
        echo '"><b>' . $row['name'] . '</b><br/><img src="' . $row['image']
            . '"/><p>' . $row['description'] . '</p></div>\n';
	}
    
    echo '</p>';
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