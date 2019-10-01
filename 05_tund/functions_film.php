<?php
function readAllFilms() {
//var_dump($GLOBALS);
//loeme andmebaasist filmide infot
//loome andmebaasiühenduse (mysqli  $conn)
$conn = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

 //valmistan ette päringu
$stmt = $conn -> prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
echo $conn -> error;
//$filmTitle = "Tühjus";
$filmInfoHTML = null;
$stmt -> bind_result($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector);
$stmt -> execute();
//sain pinu (stack) täie infot, hakkan ühekaupa võtma, kuni saab
while($stmt -> fetch()) {
	//echo "Pealkiri: " .$filmTitle;
	$filmInfoHTML .= "<h3>" .$filmTitle . "</h3>";
	$filmInfoHTML .= "<p>" ."Filmi aasta: " .$filmYear. ", ";
	$filmInfoHTML .= "Filmi kestvus: " .$filmDuration. ", ";
	$filmInfoHTML .= "Filmi žanr: " .$filmGenre . ", ";
	$filmInfoHTML .= "Filmi tootja: ".$filmStudio. ", ";
	$filmInfoHTML .= "Filmi lavastaja: ".$filmDirector. " .</p>";
	
	$filmHours = floor ($filmDuration / 60);
	$filmMinutes = $filmHours % 60;
	
	if ($filmHours > 1) {
		$filmInfoHTML .= "<p>" ."Filmi kestvus on: " .$filmHours . " tundi ja". $filmMinutes . " minutit</p>";
	}
	
	elseif ($filmHours < 1) {
		$filmInfoHTML .= "<p>" ."Filmi kestvus on: ". $filmMinutes . " minutit</p>";
	}
	
	elseif ($filmHours == 1) {
		$filmInfoHTML .= "<p>" ."Filmi kestvus on: ". $filmHours . " tund</p>";
	}
	
	if ($filmHours != 1) {
		$filmInfoHTML .= "<p>" ."Filmi kestvus on: " .$filmHours . " tundi ja". $filmMinutes . " minutit</p>";
	}
}
//sulgen ühenduse
$stmt -> close();
$conn -> close();
return $filmInfoHTML;

}
function storeFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector) {
$conn = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);	
$stmt = $conn -> prepare ("INSERT into film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
echo $conn -> error;
//andmetüübid: s -string, i - integr, d - decimal
$stmt -> bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector);
$stmt -> execute();

$stmt -> close();
$conn -> close();	
}