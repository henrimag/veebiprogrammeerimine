<?php

$userName = "Henri Mägi";
$fullTimeNow = date("d.m.Y H:i:s");
$hourNow = date("h");
$partOfDay = "hägune aeg";

if ($hourNow < 8){
	$partOfDay = "hommik";
}
	
if ($hourNow > 17){
	$partOfDay = "õhtu";
}

if ($hourNow >= 15 && $hourNow <= 16){
	$partOfDay = "söögiaeg";
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>
	<?php
	echo $userName;
	?>
	veebileht</title>

</head>
<body>


<?php

echo "<h1>" .$userName .", veebileht</h1>";

?>

<h1>Esimene pealkiri</h1>
<p>Veebileht õppimiseks</p>
<hr>
<p>PHP serveri seadistust näeb lehel <a href="serverinfo.php"></a></p>
<p>Esimene veebileht <a href="esimene.php">siin</a></p>

<?php

	echo "<p>Lehe avamise hetkel oli aeg: " .$fullTimeNow .", " .$partOfDay .".</p>";

?>

</body>
</html>