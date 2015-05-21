<!DOCTYPE html>
<html>
<head>
	<title>Team Scripture Activity</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<h2>Movies:</h2>
<div class="row-fluid">
<?php
$dbName = 'php';
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
$userID = 1;

try
{
	$db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
	$statement = $db->prepare('select movies.id, movies.name, movies.image, movies.description, (likes.id IS NOT NULL) as liked, (suggestions.id IS NOT NULL) as suggested
from movies
left join (
    select likes.id, likes.movie_id
    from likes
    where likes.user_id=1)
as likes
on movies.id=likes.movie_id
left join (
    select suggestions.id, suggestions.suggestion_id, suggestions.source_id
    from suggestions
    left join likes
    on likes.movie_id=suggestions.source_id
    where likes.user_id=1)
as suggestions
on suggestions.suggestion_id=movies.id');#'CALL getMoviesList(' . $userID . ')');
	$statement->execute();
    
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2" id="' . $row['id'] . '" name="';
        
        if ($row['liked'] == 1) {
            echo 'liked';
        } else if ($row['suggested'] == 1) {
            echo 'suggested';
        } else {
            echo 'normal';
        }
        
        echo '"><b>' . $row['name'] . '</b><br/><img src="movieposters/' . $row['image']
            . '" width="200" height="300"/><p>' . $row['description'] . '</p></div>' . "\n\n";
	}
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