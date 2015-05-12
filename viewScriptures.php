<!DOCTYPE html>
<html>
<head>
	<title>Scripture List</title>
</head>

<body>
<h2>Scriptures:</h2>
<?php
$dbUser
$dbName = 'scriptureActivity';
$dbHost = '127.0.0.1';

try
{
	$db = new PDO("mysql:host=$dbHost;dbname=$dbName", "stuff", "");
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
catch (PDOException $ex)
{
	echo "Error connecting to DB. Details: $ex";
	die();
}

?>
</body>
</html>