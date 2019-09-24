<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>
   <?php
   $userName = "Julius Caesar";
   $fullTimeNow = date("d.m.Y H:i:s");
   $dayNow = date ("d");
   $weekDayNow = date ("N");
   $weekDaysET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "põhapäev"];
   $monthNow = Date ("m");
   $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
   $yearNow = Date ("Y");
   
   ?>
   Leht<title>
   
</head>
<body>

<p>Lehe avamise hetkel on aeg:

<?php
 echo $weekDaysET [$weekDayNow-1];
 echo ", ";
 echo $dayNow;
 echo ". ";
 echo $monthsET [$monthNow-1];
 echo ". ";
 ?>
</p>