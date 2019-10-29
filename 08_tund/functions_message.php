<?php

function storeMessage ($myMessage) {
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vpmsg (userid, message) VALUES (?,?)");	#  "->" pöördumine muutuja poole
	echo $conn->error;
	$stmt -> bind_param("is", $_SESSION["userId"], $myMessage);   #s = string, i = integral, d = decimal
	if ($stmt->execute()){
		$notice = "Sõnum salvestati";
	} else {
		$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	}
	
	$stmt -> close();
	$conn -> close(); #connection
	return $notice;
}

function readAllMessages() {
	$messagesHTML = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	#$stmt = $conn->prepare ("SELECT message, created FROM vpmsg");
	$stmt = $conn->prepare ("SELECT message, created FROM vpmsg WHERE deleted IS NULL");
	echo $conn->error;
	$stmt->bind_result($messageFromDb, $createdFromDb);
	$stmt->execute();
	while($stmt->fetch()){
	$messagesHTML .= "<li>" .$messageFromDb ."lisatud: " .$createdFromDb ."</li> \n"; 			#.=  juurde lisamine
	}
		if (!empty ($messagesHTML)) {
			$messagesHTML = "<ul> \n" .$messagesHTML - "</ul> \n";
	}else{
			$messagesHTML = "<p>Sõnumeid pole</p> \n";
	}
	
	
	$stmt -> close();
	$conn -> close();
	return $messagesHTML;
}

function readMyMessages() {
	$messagesHTML = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	#$stmt = $conn->prepare ("SELECT message, created FROM vpmsg");
	$stmt = $conn->prepare ("SELECT message, created FROM vpmsg WHERE userif 0 ? AND deleted IS NULL ORDER BY created DESC LIMIT ?");
	echo $conn->error;
	$stmt->bind_param("ii", $_SESSION["userid"], $limit);
	$stmt->bind_result($messageFromDb, $createdFromDb);
	$stmt->execute();
	while($stmt->fetch()){
	$messagesHTML .= "<li>" .$messageFromDb ."lisatud: " .$createdFromDb ."</li> \n"; 			#.=  juurde lisamine
	}
		if (!empty ($messagesHTML)) {
			$messagesHTML = "<ul> \n" .$messagesHTML - "</ul> \n";
	}else{
			$messagesHTML = "<p>Sõnumeid pole</p> \n";
	}
	
	
	$stmt -> close();
	$conn -> close();
	return $messagesHTML;
}