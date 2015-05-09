<?php
    session_start();
    if(isset($_SESSION['voted'])) {
        header( 'Location: assignment.php' ) ;
    }
?>

<!DOCTYPE html> 
<html lang="en-US">
<head>
    <title>Survey Form</title>
    <script>
        function checkValues() {
            if (isNaN(document.getElementById('gpa').value)) {
                alert('GPA must be a number between 0 and 4');
                return false;
            }
            
            var num = document.getElementById('gpa').value;
            if (num >= 0 && num <= 4) {
                return true;
            }
            
            alert('GPA must be a number between 0 and 4');
            return false;
        }
    </script>
</head>
<body>
    <h2>Take the Survey:</h2>
    <form method="post" action="surveyresults.php" onsubmit="return checkValues();">
        <table>
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="name" size="30" required="true"/></td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td><input type="email" name="email" id="email" size="30" required="true"/></td>
        </tr>
        <tr>
            <td>GPA</td>
            <td><input type="text" name="gpa" id="gpa" size="5" maxlength="5" required="true"/></td>
        </tr>
        <tr>
            <td>Do you like pizza</td>
            <td>
                <table>
                <tr>
                    <td><input type="radio" name="pizza" value="Yes" checked="checked"/></td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td><input type="radio" name="pizza" value="No"/></td>
                    <td>No</td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><input type="submit"/></td>
        </tr>
        </table>
    </form>
</body>
</html>