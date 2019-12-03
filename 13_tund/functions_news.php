<?php 
function storeNews($title, $content, $expire){	
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vpuudis (userid, title, content, expire) VALUES (?, ?)");
	echo $conn->error;

	$stmt->bind_param("isss", $_SESSION["userID"],$title, $content, $expire);
	if($stmt->execute()) {
		$notice = "Uudis on salvestatud";
	} else {
		$notice = "Uudist ei õnnestunud tehniliselt põhjusel salvestada! " . $stmt->error;
	}

	$stmt->close();
	$conn->close();
	return $notice;
}

function readAllNews(){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT message, created FROM vpmsg3");
	$stmt = $conn->prepare("SELECT title, content, expire FROM vpuudis WHERE deleted IS NULL");
	echo $conn->error;
	$stmt->bind_result($titleFromDb, $contentFromDb, $expireFromDb);
	$stmt->execute();
	while ($stmt->fetch()) {
		$notice .= "<p>" .$titleFromDb . " " . $contentFromDb . " (Aegub: " .$expireFromDb .")</p>\n";
	}
	if (empty($notice)) {
		$notice = "<p>Otsitud uudiseid pole!</p> \n";
	}

	$stmt->close();
	$conn->close();
	return $notice;	
}
 ?>