<!DOCTYPE html>
<html>
<head>
	<title>Scripture List</title>
</head>

<body>
<h2>Scriptures:</h2>
<?php
$dbName = 'scriptureActivity';
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');

try
{
	$db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "testUser", "");
	$statement = $db->prepare('SELECT book, chapter, verse, content FROM scripture');
	$statement->execute();
    echo '<p>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<strong>' . $row['book'] . ' ' . $row['chapter'] . ':';
		echo $row['verse'] . '</strong>' . ' - ' . $row['content'] . '<br/>';
	}
    
    echo '</p>';
}
catch (Exception $ex)
{
	echo "Error connecting to DB. Details: $ex";
	die();
}

?>
</body>
</html>