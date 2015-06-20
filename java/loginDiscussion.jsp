<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>login to discussion board</title>
    </head>
    <body>
        <form method="post" action="LoginDiscussion">
            <label for="user">Username:</label>
            <input type="text" id="user" name="user"></input>
            <br />
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass"></input>
            <br />
            <input type="submit" value="Login" />
        </form>
    </body>
</html>
