<?php
    session_start();
    if(!isset($_POST['user']) || !isset($_POST['password'])) {
        header( 'Location: loginPage.php');
    }
    
    $dbName = 'php';
    $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
    $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
    $username = $_POST['user'];
    $password = $_POST['password'];
    // lol not sanitizing my strings, super vulnerable to sql injection here.
    try {
        $db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
        $statement = $db->prepare("select id from users where name='" . $username . "' and password='"
                        . $password . "'");
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (isset($row) && isset($row['id']))
        {
            $_SESSION['userid'] = $row['id'];
            header( 'Location: viewMovies.php');
        }
        else
        {
            header( 'Location: loginPage.php');
        }
    }
    catch (Exception $ex)
    {
        echo "Can't connect to DB. Exception: $ex";
        die();
    }
?>