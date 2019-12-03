<?php
require ("../../../config_vp2019.php");
require ("functions_film.php");
//echo $serverHost;
$userName = "Henri Mägi";
$database = "if19_henri_ma_1";


$filmInfoHTML = readAllFilms();

//$stmt -> fetch();
//echo "Pealkiri: " .$filmTitle;


require ("header.php");

    echo "<h1>" .$userName .", veebiprogrammeerimine</h1>";
?>

  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>

  <hr>
  <hr2>Eesti filmid</hr>
  <p>Praegu meie andebaasis on järgmised filmid:</p>
  <?php
    
	echo $filmInfoHTML;
  ?>
  
</body>
</html>