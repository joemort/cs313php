<!DOCTYPE html>
<html>
<head>
	<title>Team Scripture Activity</title>
</head>

<body>
<h2>Scriptures:</h2>
<?php
$dbName = 'scriptureActivity';
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');

try
{
	$db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
	$statement = $db->prepare('SELECT book, chapter, verse, content FROM scripture');
	$statement->execute();
    echo '<p>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<b>' . $row['book'] . ' ' . $row['chapter'] . ':';
		echo $row['verse'] . '</b>' . ' - "' . $row['content'] . '"<br/>';
	}
    
    echo '</p>';
}
catch (Exception $ex)
{
	echo "Can't connect to DB. Exception: $ex";
	die();
}

?>
</body>
</html>