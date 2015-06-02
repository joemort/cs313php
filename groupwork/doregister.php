<?php

    require 'password.php';
    
    function registerNew() {
        $dbName = 'scriptureActivity';
        $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
        $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
        $username = $_POST['user'];
        $password = $_POST['password'];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
            //TODO: change this to a sproc.
            $statement = $db->prepare("insert into users (username, password) values (:name, :password);");
            $statement->bindParam(':name', $username);
            $statement->bindParam(':password', $passwordHash);
            $statement->execute();
            $insertedId = $db->lastInsertId();
            
            if ($insertedId > 0)
            {
                $_SESSION['failure'] = "Registration successful. Please log in.";
                header( 'Location: loginPage.php');
            }
            else
            {
                $_SESSION['failure'] = "Username exists, please try a different one.";
                header( 'Location: registerPage.php');
            }
        
            $statement->close();
            $db->close();
        }
        catch (Exception $ex)
        {
            echo "Can't connect to DB. Exception: $ex";
            die();
        }
    }
    
    session_start();
    if(!isset($_POST['user']) || !isset($_POST['password'])) {
        $_SESSION['failure'] = "Username/Password missing. Please try again.";
        header( 'Location: registerPage.php');
    }
    
    registerNew();
?>