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
    
</head>

<body>

<ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" href="#">Action</a></li>
    <li><a tabindex="-1" href="#">Another action</a></li>
    <li><a tabindex="-1" href="#">Something else here</a></li>
    <li class="divider"></li>
    <li><a tabindex="-1" href="#">Separated link</a></li>
</ul>

<h2>Movies:</h2>
<form method="GET" action="doLogout.php">
<input type="submit" value="Logout"/>
</form>
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
<script type="text/javascript">
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

$("div[name=liked]").contextMenu({
    menuSelector: "#contextMenu",
    menuSelected: function (invokedOn, selectedMenu) {
        var domobj = invokedOn[0];
        while (domobj.parentNode) {
            domobj = domobj.parentNode;
            if (domobj.getAttribute("name")=="liked") { break; }
        }
        
        alert(domobj.id); 
    }
});

$("div[name=suggested]").contextMenu({
    menuSelector: "#contextMenu",
    menuSelected: function (invokedOn, selectedMenu) {
        var domobj = invokedOn[0];
        while (domobj.parentNode) {
            domobj = domobj.parentNode;
            if (domobj.getAttribute("name")=="suggested") { break; }
        }
        
        alert(domobj.id); 
    }
});

$("div[name=normal]").contextMenu({
    menuSelector: "#contextMenu",
    menuSelected: function (invokedOn, selectedMenu) {
        var domobj = invokedOn[0];
        while (domobj.parentNode) {
            domobj = domobj.parentNode;
            if (domobj.getAttribute("name")=="normal") { break; }
        }
        
        alert(domobj.id); 
    }
});
    
    </script>

</body>
</html>