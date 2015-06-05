<?php
    session_start();
    if(!isset($_SESSION['userid'])) {
        header( 'Location: loginPage.php' );
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Preferences and Suggestions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="viewMovies.css"/>
    <link rel="stylesheet" type="text/css" href="index.css">
    <script type="text/javascript">
function updateContextMenus() {
(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            // Open context menu
            $(this).on("contextmenu", function (e) {
                // return native menu if pressing control
                if (e.ctrlKey) return;
                
                //open menu
                $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .show()
                    .css({
                        position: "absolute",
                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
                        top: getMenuPosition(e.clientY, 'height', 'scrollTop')
                    })
                    .off('click')
                    .on('click', function (e) {
                        $(this).hide();
                
                        var $invokedOn = $(this).data("invokedOn");
                        var $selectedMenu = $(e.target);
                        
                        settings.menuSelected.call(this, $invokedOn, $selectedMenu);
                        return false;
                });
                
                return false;
            });

            //make sure menu closes on any click
            $(document).click(function () {
                $(settings.menuSelector).hide();
            });
        });
        
        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;
                        
            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse) 
                position -= menu;
            
            return position;
        }    

    };
})(jQuery, window);

$("div[name=liked], div[name=suggested], div[name=normal]").contextMenu({
    menuSelector: "#likeMenu",
    menuSelected: function (invokedOn, selectedMenu) {
        var domobj = invokedOn[0];
        var like = "like";
        while (domobj.parentNode) {
            if (domobj.getAttribute("name") == "liked") {
                like = "unlike";
                break;
            } else if (domobj.getAttribute("name") == "suggested" ||
                        domobj.getAttribute("name") == "normal") {
                break;
            }
            
            domobj = domobj.parentNode;
        }
        
        sendLike(domobj.id, like);
    }
});
}

var req;

function sendLike(movieId, isLike) {
    url = "likemovie.php?movieid=" + movieId + "&like=" + isLike;
    if (window.XMLHttpRequest)
    {
        req = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (req != null)
    {
        req.onreadystatechange = processData;
        req.open("GET", url, true);
        req.send(null);
    }
    else
    {
        alert("Brower doesn't support XMLHttp");
    }
}

function processData() {
    if (req.readyState == 4)
    {
        if (req.status == 200)
        {
            var theText = req.responseText;
            var byMovie = theText.split("\n");
            var index;
            for (index = 0; index < byMovie.length; index++) {
                var finalSplit = byMovie[index].split(",");
                if (finalSplit.length != 2) continue;
                document.getElementById(finalSplit[0]).setAttribute("name", finalSplit[1]);
            }
        }
        else
        {
            alert("There was a problem retrieving the XML data:\n" + req.statusText + " " + req.status);
        }
   }
}
    </script>
</head>

<body>

<ul id="likeMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" href="#">Toggle Like</a></li>
</ul>
<table class="rcorner" id="header">
<tr>
<td class="leftside"><form method="GET" action="doLogout.php">
<input type="submit" value="Logout"/>
</form></td>
<td class="rightside">Movie Tracker and Suggestions</td>
</tr>
</table>

<div class="row-fluid">
<?php
$dbName = 'php';
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
$userID = $_SESSION['userid'];

try
{
	$db = new PDO("mysql:host=$dbHost:$dbPort;dbname=$dbName", "test", "test");
	$statement = $db->prepare('CALL `getMoviesList` (:userid);');
    $statement->bindParam('userid', $userID);
	$statement->execute();
    
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-full-height" id="' . $row['id'] . '" name="';
        
        if ($row['liked'] == 1) {
            echo 'liked';
        } else if ($row['suggested'] == 1) {
            echo 'suggested';
        } else {
            echo 'normal';
        }
        echo '"><table><tr><td class="smallheader"><strong>' . $row['name'] . '</strong></td></tr>'
            . '<tr><td class="imgrow"><img src="movieposters/' . $row['image'] . '" width="200" height="300"/></td></tr>'
            . '<tr><td class="description">' . $row['description'] . "</td></tr></table></div>\n\n";
	}
}
catch (Exception $ex)
{
	echo "Can't connect to DB. Exception: $ex";
	die();
}

?>
</div>
<script type="text/javascript">updateContextMenus();</script>
</body>
</html>