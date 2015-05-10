<?php
    session_start();
    if(isset($_SESSION['voted'])) {
        header( 'Location: surveyresults.php' ) ;
    }
?>

<!DOCTYPE html> 
<html lang="en-US">
<head>
    <link rel="stylesheet" type="text/css" href="index.css">
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
        function adjustSize() {
            var height = 0;
            var body = window.document.body;
            if (window.innerHeight) {
                height = window.innerHeight;
            } else if (body.parentElement.clientHeight) {
                height = body.parentElement.clientHeight;
            } else if (body && body.clientHeight) {
                height = body.clientHeight;
            }
            height = height - 260;
            document.getElementById('stretch').style.height = height + "px";
        }
    </script>
</head>
<body onload="adjustSize();" onresize="adjustSize();">
<table class="rcorner" id="header">
<tr>
<td class="leftside"></td>
<td class="rightside">Survey Page</td>
</tr>
</table>
<table class="bodytable" id="stretch">
<tr>
<td class="leftsidecoloredfixed" id="colorsquare"></td>
<td class="rightsidebody">
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
    <br/>
    See the <a href="surveyresults.php">results</a>!
</td></tr></table>
</body>
</html>