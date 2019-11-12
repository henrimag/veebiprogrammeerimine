<?php
$userName = "Henri Mägi";

$photoDir = "../photos/";
$photoTypes = ["image/jpeg", "image/png"];

$fullTimeNow = date("d.m.Y H:i:s");
$hourNow = date("H");
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

//semestri kulgemine

$semesterStart = new DateTime("2019-09-2");
$semesterEnd = new DateTime("2019-12-15");
$semesterDuration = $semesterStart -> diff($semesterEnd);
$today = new DateTime ("now");
$semesterElapsed = $semesterStart -> diff($today);

$semesterInfoHTML = null;
if ($semesterElapsed -> format ("%r%a") >= 0) {
	$semesterInfoHTML = "<p> Semester käib: ";
	$semesterInfoHTML = '"<meter min="0" max="' .$semesterDuration -> format("%r%a") .'" ';
	$semesterInfoHTML = 'value"' .$semesterElapsed -> format("%r%a") .'">';
	$semesterInfoHTML = round($semesterElapsed -> format("%r%a") / $semesterDuration -> format("%r%a") * 100, 1) . "%";
	$semesterInfoHTML = "</meter> </p>";
}

$fileList = array_slice(scandir($photoDir), 2);
  //var_dump($fileList);
  $photoList = [];
  foreach ($fileList as $file) {
	  $fileInfo = getImagesize($photoDir .$file);
	  //var_dump($fileInfo);
	  if (in_array($fileInfo["mime"], $photoTypes)) {
		  array_push($photoList, $file);
    }
  }
  
  //var_dump($photoList);
  $photoList = ["tlu_terra_600x400_1.jpg", "tlu_terra_600x400_2.jpg", "tlu_terra_600x400_3.jpg"]; //array e. massiiv (loend)
  $photoCount = count($photoList);
  $photoNum = mt_rand(0, $photoCount -1);
  //echo $photoList[$photoNum];
  //<img src="../photos/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">
  $randomImgHTML = '<img src="' .$photoDir . $photoList[$photoNum].'" alt="juhuslik foto">';

require ("header.php");

    echo "<h1>" .$userName .", veebiprogrammeerimine</h1>";
  ?>

  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <?php
    echo $semesterInfoHTML;
  ?>
  <hr>
  <?php
    echo "<p>Lehe avamise hetkel oli aeg: " .$fullTimeNow .", " .$partOfDay ."</p>";
	echo $randomImgHTML;
  ?>
  
</body>
</html>