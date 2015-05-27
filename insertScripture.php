<?php
if (isset($_POST['book']))
{
    $book = $_POST['book'];
    $chapter = $_POST['chapter'];
    $verse = $_POST['verse'];
    $content = $_POST['content'];
    $topicIds = $_POST['topics'];

    echo "book=$book\n";
    echo "chapter=$chapter\n";
    echo "verse=$verse\n";
    echo "content=$content\n";

    $dbName = 'scriptureActivity';
    $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
    $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');

    try
    {
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", "test", "test");

        $statement = $db->prepare('INSERT INTO scripture(book, chapter, verse, content) VALUES(:book, :chapter, :verse, :content)');
        $statement->bindParam(':content', $content);
        $statement->bindParam(':book', $book);
        $statement->bindParam(':verse', $verse);
        $statement->bindParam(':chapter', $chapter);
        $statement->execute();

        $scriptureId = $db->lastInsertId();

        foreach ($topicIds as $topicId)
        {
            $statement = $db->prepare('INSERT INTO scripture_topic(scriptureId, topicId) VALUES(:scriptureId, :topicId)');

            $statement->bindParam(':topicId', $topicId);
            $statement->bindParam(':scriptureId', $scriptureId);
            $statement->execute();
        }
    }
    catch (Exception $ex)
    {
        echo "Error: $ex";
        die(); // :(
    }
}
?>

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
	$statement = $db->prepare('SELECT id, book, chapter, verse, content FROM scripture');
	$statement->execute();
    echo '<p>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<b>' . $row['book'] . ' ' . $row['chapter'] . ':';
		echo $row['verse'] . '</b>' . ' - "' . $row['content'] . '"<br/>';
        echo "\nTopics: ";

		$stmtTopics = $db->prepare('SELECT name FROM topic topic'
			. ' INNER JOIN scripture_and_topic sat ON sat.topicId = topic.id'
			. ' WHERE sat.scriptureId = :scriptureId');

		$stmtTopics->bindParam(':scriptureId', $row['id']);

		$stmtTopics->execute();

		while ($topicRow = $stmtTopics->fetch(PDO::FETCH_ASSOC))
		{
			echo $topicRow['name'] . ' ';
		}
        
        echo "<br/>\n";
	}
    
    echo '</p>';
}
catch (Exception $ex)
{
	echo "Error: $ex";
	die(); // :(
}

?>
</body>
</html>