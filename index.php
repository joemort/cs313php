<!doctype html>
<html lang="en">
<head>
<title>Joseph's Home Page</title>
<style>
table.rcorner {
    border-radius: 45px 45px 0px 0px;
    background: url(http://www.pulsarwallpapers.com/data/media/3/Alien%20Ink%202560X1600%20Abstract%20Background.jpg);
    background-position: top left;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 20px;
    width: 99%;
    margin: 10px auto 0px auto;
    height: 250px;
    color: black;
    table-layout: fixed;
}

table.bodytable {
    color: black;
    width: 100%;
}

td.leftside {
    width: 250px;
}

td.rightside {
    padding: 0px 0px 0px 30px;
    text-align: left;
    font-size: 25px;
    font-family: Impact, Charcoal, sans-serif;
}

td.leftsidecolored {
    background: #3924b3;
    padding: 0px;
    border: 0px;
    margin: 0px;
    height: 100%;
}

td.rightsidebody {
    border: 0px;
    margin: 0px;
    padding: 15px 15px 0px 15px;
    text-align: left;
    vertical-align: top;
}

tr {
    border: 0px;
    margin: 0px;
    padding: 0px;
}

body {
    background-color: #bdd9b1;
    color: #3924b3;
    padding: 0px;
    margin: 0px;
}

img {
    width: 250px;
}
</style>

<script type="text/javascript">
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
            var width = 250 + document.getElementById('pic').getBoundingClientRect().left;
            document.getElementById('colorsquare').style.width = width + "px";
        }
</script>

</head>
<body onload="adjustSize();" onresize="adjustSize();">
<table class="rcorner" id="header">
<tr>
<td class="leftside"><img id="pic" src="us.jpg" onmouseover="this.src='jellyfish.jpg'" onmouseout="this.src='us.jpg'"/></td>
<td class="rightside">Joseph Mortensen</td>
</tr>
</table>
<table class="bodytable" id="stretch">
<tr>
<td class="leftsidecolored" id="colorsquare"></td>
<td class="rightsidebody">Hi, I'm Joseph Mortensen. I'm a Computer Science student and I graduate this
semester. I interned with Google doing Internal Privacy, and at Bungie doing Infrastructure Tools. After
much prayer and thought, I decided that I would take the job offer from Bungie instead of Google, so I'll
be starting there right after I graduate. Feel free to ask me about my experiences with either company,
though I'm severely limited in what I can talk about when it comes to what I actually did at Google.
<br/><br/>
<a href="assignments.html">My Assignments</a></td>
</tr>
</table>
</body>
</html>
