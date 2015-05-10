<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="index.css">
<?php 
if(isset($_POST['name'])) {
$name = $_POST['name'];
$email = $_POST['email'];
$gpa = $_POST['gpa'];
$pizza = $_POST['pizza'];
}

try {
$fileContents = file_get_contents("surveyresults.txt");
} catch (Exception $e) {
    fclose(fopen("surveyresults.txt", "w"));
    $fileContents = "";
}
?>

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
        }
</script>

</head>
<body onload="adjustSize();" onresize="adjustSize();">
<table class="rcorner" id="header">
<tr>
<td class="leftside"></td>
<td class="rightside">Survey Results Page</td>
</tr>
</table>
<table class="bodytable" id="stretch">
<tr>
<td class="leftsidecoloredfixed" id="colorsquare"></td>
<td class="rightsidebody">
<?php
if (isset($name) && !isset($_SESSION['voted'])) {
    print "<h2>Thank you! Your vote has been recorded:</h2>\n";
    print "Name: $name<br/>\n";
    print "Email: <a href=\"mailto:$email\">$email</a><br/>\n";
    print "Note: Your name and email will be sold to spammers.<br/><br/>\n";
    print "GPA: $gpa<br/>\n";
    print "Like Pizza: $pizza<br/><br/><br/><br/><br/><br/>\n";
    $fileContents = $fileContents . "\r\n$name\n$email\n$gpa\n$pizza";
    file_put_contents("surveyresults.txt", $fileContents);
    $_SESSION['voted'] = true;
}

$personListArray = explode("\r\n", $fileContents);
$likesPizza = 0;
$hatesPizza = 0;
$gpas = array();
foreach ($personListArray as $person) {
    $split = explode("\n", $person);
    if (sizeof($split) == 4) {
        array_push($gpas, $split[2]);
        if ($split[3] == "Yes") {
            $likesPizza++;
        } else {
            $hatesPizza++;
        }
    }
}

$count = count($gpas);
rsort($gpas);
$median = $gpas[(round($count / 2) - 1)];
$mean = round(array_sum($gpas) / $count, 3);
$v = array_count_values($gpas); 
arsort($v); 
foreach($v as $k => $v){$mode = $k; break;}
$smallest = $gpas[$count - 1];
$largest = $gpas[0];
?>
<table>
<tr>
<th>Percentages of Pizza Enjoyment</th>
<th>Statistics about GPAs</th>
</tr>
<tr><td colspan="2"><hr/></td></tr>
<tr>
<td><?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

$data = array($likesPizza,$hatesPizza);
 
$graph = new PieGraph(250,170);
$graph->SetMarginColor('#bdd9b1');
$graph->SetShadow();

$p1 = new PiePlot($data);
$p1->SetLegends(array("Yes","No"));
$p1->SetCenter(0.25,0.32);
$p1->value->SetFont(FF_FONT1);

$graph->Add($p1);
$img = $graph->Stroke(_IMG_HANDLER);
ob_start();
imagepng($img);
$imageData = ob_get_contents();
ob_end_clean();
print '<img src="data:image/png;base64,' . (base64_encode($imageData)) . "\" />\n";
?>
</td>
<td class="alignTop"><br/>
<table>
<tr><td># of People:</td><td><?php echo $count; ?></td></tr>
<tr><td>Average:</td><td><?php echo $mean; ?></td></tr>
<tr><td>Median:</td><td><?php echo $median; ?></td></tr>
<tr><td>Most Frequent:</td><td><?php echo $mode; ?></td></tr>
<tr><td>Range:</td><td><?php echo "$smallest - $largest"; ?></td></tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>