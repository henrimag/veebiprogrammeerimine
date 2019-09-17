<?php
  $userName = "Andrus van der Rinde";
  $fullTimeNow = date("d.m.Y H:i:s");
  $hourNow = date ("H");
  $partOfDay = "hägune aeg";
  
  if($hourNow < 8) {
	  $partOfDay = "hommik";
	  }
	  
  if($hourNow > 17) {
	  $partOfDay = "õhtu";
      }
  if($hourNow <= 14 ) {
	  $partOfDay = "pärastlõuna";
      }
  if($hourNow == 21 ) {
	  $partOfDay = "AK aeg";
      }
  #if($hourNow >= 15 && <= 16) {
	  #$partOfDay = "söögiaeg";
  #}
?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>
  <?php
    echo $userName;
  ?>
   programmeerib veebi</title>

</head>
<body>
  <?php
    echo "<h1>" .$userName .", veebiprogrammeerimine</h1>";
  ?>

  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <hr>
  <?php
  echo "<p>Lehe avamise hetkel oli aeg: " .$fullTimeNow .", " .$partOfDay ."</p>";
  ?>

</body>
</html>