<?php
    session_start();
    if(!isset($_POST['user']) || !isset($_POST['password'])) {
        $_SESSION['failure'] = true;
        header( 'Location: loginPage.php');
    }
    
    $dbName = 'php';
    $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
    $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
    $username = $_POST['user'];
    $password = $_POST['password'];
    try {
        $db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
        $statement = $db->prepare("select id from users where name=:name and password=:password");
        $statement->bindParam(':name', $username);
        $statement->bindParam(':password', $password);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (isset($row) && isset($row['id']))
        {
            $_SESSION['userid'] = $row['id'];
            header( 'Location: viewMovies.php');
        }
        else
        {
            $_SESSION['failure'] = true;
            header( 'Location: loginPage.php');
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