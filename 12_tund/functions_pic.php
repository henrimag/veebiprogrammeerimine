<?php
	function setPicSize($myTempImage, $imageW, $imageH, $imageNewW, $imageNewH){
		$myNewImage = imagecreatetruecolor($imageNewW, $imageNewH);
		imagecopyresampled($myNewImage, $myTempImage, 0, 0, 0, 0, $imageNewW, $imageNewH, $imageW, $imageH);
		return $myNewImage;
	}

	function readuserPic($photoId){
		$html = "<p>Korras!</p>";
		return $html;
	}
  function addPicData($fileName, $altText, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userID"], $fileName, $altText, $privacy);  #userId muudetud
		if($stmt->execute()){
			$notice = " Pildi andmed salvestati andmebaasi!";
		} else {
			$notice = " Pildi andmete salvestamine ebaönnestus tehnilistel põhjustel! " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readgalleryImages($privacy, $page, $limit){
		$html = null;
		$skip = ($page -1) * $limit;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($fileNameFromDb, $altTextFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			//<img src="kataloog/pildifail" alt="tekst" data-fn="failinimi">
			$html .= '<img src="' .$GLOBALS ["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="';
			if($altTextFromDb == null){
				$html .= "Foto";
			} else {
				$html .= $altTextFromDb;
			}
			$html .= '" data-fn="' .$fileNameFromDb .'">' ."\n";
		}
		if ($html == null) {
			$html = "<p>Kahjuks avalike pilte ei leitud</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $html;
	}
	
	function countPics ($privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(id) FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($count);
		$stmt->execute();
		$stmt->fetch();
		$notice = $count;
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readAllPublicPicsPage($privacy, $page, $limit){
		$html = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT id, filename, alttext FROM vpphotos3 WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?");
		$stmt = $conn->prepare("SELECT vpphotos.id, vpusers.firstname, vpusers.lastname, vpphotos.filename, vpphotos.alttext, AVG(vpphotoratings.rating) as AvgValue FROM vpphotos JOIN vpusers ON vpphotos.userid = vpusers.id LEFT JOIN vpphotoratings ON vpphotoratings.photoid = vpphotos.id WHERE vpphotos.privacy <= ? AND deleted IS NULL GROUP BY vpphotos.id DESC LIMIT ?, ?");
		echo $conn->error;
		$skip = ($page - 1) * $limit;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($idFromDb, $firstNameFromDb, $lastNameFromDb, $fileNameFromDb, $altTextFromDb, $avgFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			//<img src="thumbs_kataloog/pilt" alt=""> \n
			//<img src="thumbs_kataloog/pilt" alt="" data-fn="failinimi"> \n
			$html .= '<div class="thumbGallery">' ."\n";
			$html .= '<img class="thumbs" src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="';
			if(empty($altTextFromDb)){
				$html .= "Illustreeriv foto";
			} else {
				$html .= $altTextFromDb;
			}
			$html .= '" data-fn="' .$fileNameFromDb .'"';
			$html .= ' data-id="' .$idFromDb .'"';
			$html .= '>' ."\n";
			$html .= "<p>" .$firstNameFromDb ." " .$lastNameFromDb ."</p> \n";
			$html .= '<p id="score' .$idFromDb .'">';
			if($avgFromDb == 0){
				$html .="Pole hinnatud";
			} else {
				$html .= "Hinne: " .round($avgFromDb, 2);
			}
			$html .= "</p> \n";
			$html .= "</div>";
		}
		if($html == null){
			$html = "<p>Kahjuks avalikke pilte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $html;
	}
		
		
/* 		<div class="thumbGallery">
	 	<img src="" alt="" class="thumbs" data-fn="" data-id=""> // "" vahed peab täitma
	 	 <p>Autorinimi</p> 
	 	 <p id="score86">Hinne: 3.33</p> //id 86 on pildi nimi
		</div>  */