<?php

    require 'password.php';
    
    function loginExisting() {
        $dbName = 'scriptureActivity';
        $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
        $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
        $username = $_POST['user'];
        $password = $_POST['password'];
        try {
            $db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
            $statement = $db->prepare("select id, password from users where username=:name");
            $statement->bindParam(':name', $username);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            if (isset($row) && isset($row['id']) && password_verify($password, $row['password']))
            {
                $_SESSION['userid'] = $row['id'];
                $_SESSION['username'] = $username;
                header( 'Location: homepage.php');
            }
            else
            {
                $_SESSION['failure'] = "Username/Password was not correct. Please try again.";
                header( 'Location: loginPage.php');
            }
            
        }
        catch (Exception $ex)
        {
            echo "Can't connect to DB. Exception: $ex";
            die();
        }
    }
    
    session_start();
    if(!isset($_POST['user']) || !isset($_POST['password'])) {
        $_SESSION['failure'] = "Username/Password was not correct. Please try again.";
        header( 'Location: loginPage.php');
    }
    
    loginExisting();
?>