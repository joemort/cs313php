<?php
$userID = "1";//$_SESSION['userid'];
$movieid = "1";//$_GET['movieid'];
$likeornot = $_GET['like']; // true for like, false for dislike
$dbName = 'php';
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
try
{
	$db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
    
    if ($likeornot == "like") {
        $statement = $db->prepare('insert into likes (user_id, movie_id) values (:userid, :movieid);');
    } else {
        $statement = $db->prepare('delete from likes where user_id=:userid and movie_id=:movieid;');
    }
    
    $statement->bindParam('userid', $userID);
    $statement->bindParam('movieid', $movieid);
    $statement->execute();
    
    $statement = $db->prepare('CALL `getMoviesList` (:userid);');
    $statement->bindParam('userid', $userID);
	$statement->execute();
    $newValues = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
        $val = 'normal';
        if ($row['liked'] == 1) {
            $val = 'liked';
        } else if ($row['suggested'] == 1) {
            $val = 'suggested';
        }
        
        array_push($newValues, $row['id'] . "," . $val);
    }
}
catch (Exception $ex)
{
	echo "Can't connect to DB. Exception: $ex";
	die();
}

print_r($newValues);

?>