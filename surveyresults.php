<html>
<head>
<?php 
if(isset($_POST['name'])) {
$name = $_POST['name'];
$email = $_POST['email'];
$gpa = $_POST['gpa'];
$pizza = $_POST['pizza'];
}
?>
</head>
<body>
<?php
if (isset($name) && !isset($_SESSION['voted'])) {
print "<h2>Thank you! Your vote has been recorded.</h2>\n";
// write it to the file
print "name: $name<br/>\n";
print "email: <a href=\"mailto:$email\">$email</a><br/>\n";
print "gpa: $gpa<br/>\n";
print "pizza: $pizza<br/><br/><br/>\n";
}
?>
<h3>Results of the voting:</h3>
<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

// read from the file
$data = array(3,4);
 
$graph = new PieGraph(350,300);
$graph->SetShadow();

$graph->title->Set("People that like pizza");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data);
$p1->SetLegends(array("Yes","No"));
$p1->SetCenter(0.25,0.32);
$p1->value->SetFont(FF_FONT0);

$graph->Add($p1);
$img = $graph->Stroke(_IMG_HANDLER);
ob_start();
imagepng($img);
$imageData = ob_get_contents();
ob_end_clean();
print '<img src="data:image/png;base64,' . (base64_encode($imageData)) . "\" />\n";

?>

<br/>
</body>
</html>