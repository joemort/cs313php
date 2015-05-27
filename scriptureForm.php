<html>

<body>

<h1>Add a Scripture</h1>

<hr>
<form action="insertScripture.php" method="post">
<table>
	<tr>
		<td>Book: </td>
		<td><input type="text" name="book" /></td>
	</tr>
	<tr>
		<td>Chapter: </td>
		<td><input  type="number" name="chapter" min="0"/></td>
	</tr>
	<tr>
		<td>Verse: </td>
		<td><input  type="number" name="verse" min="0"/></td>
	</tr>
	<tr>
		<td>Content: </td>
		<td><textarea name="content" rows=10 cols=22></textarea></td>
	</tr>
	</table>
	
	<table>
		<?php
			try
			{

				$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
				$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');

				$dbName = 'scriptureActivity';

				$db = new PDO("mysql:host=$dbHost;dbname=$dbName", "test", "test");

				$statement = $db->prepare("SELECT id, name FROM topic");
				$statement->execute();
				
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$topicID = $row['id'];
					$name = $row['name'];
		
					echo "<tr><td><input type='checkbox' value='$topicID' name='topics[]'></td><td>";
					print "$name";
					echo "</td></tr>\n";
				}
			}
			catch (PDOException $ex)
			{
				echo "Error connecting to DB. Details: $ex";
				die();
			}
	?>
	</table>
	<input type="submit" value="Submit"/>
	</form>
	
</body>
</html>