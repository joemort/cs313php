<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Group work login</title>
    </head>
    <body>
        <% if (session.getAttribute("failure") != null) { %>
         <%=session.getAttribute("failure").toString() %>
        <% } %>
        <form method="post" action="login">
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
