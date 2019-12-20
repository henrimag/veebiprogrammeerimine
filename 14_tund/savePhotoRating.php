<?php
require ("../../../config_vp2019.php");
require("functions_pic.php");
$database = "if19_henri_ma_1";
//session_start();

//saame saadetud väärtuse(d)

$rating = $_REQUEST["rating"];
$picId = $_REQUEST['picId'];
$userId = $_SESSION['userID'];

$saveRating = savePicRating($picId, $userId, $rating);

$response = "Läks hasti, hinne: " . $rating . " Pildi id on: " . $picId;
	
echo $rating * 2;