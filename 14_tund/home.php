<?php
  require ("../../../config_vp2019.php");
  //require("functions_main.php");
  //require("functions_user.php");
  require("functions_news.php");
  $database = "if19_henri_ma_1";
  
   //sessioonihaldus
  require("classes/Session.class.php");
  SessionManager::sessionStart("vp", 0, "/~henrimag/", "greeny.cs.tlu.ee");
  
  //kui pole sisseloginud
  if(!isset($_SESSION["userId"])){
	  //siis jõuga sisselogimise lehele
	  header("Location: page.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  // cookie ehk küpsis
  // nimi, väärtus, aegumisaeg, path ehk kataloogid, domeen, kas https, kas üle http ehk üle veebi
  setcookie("vpusername", $_SESSION["userFirstname"] .$_SESSION["userLastname"], time() + (86400 * 31), "/~henrimag/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
  if (isset($_COOKIE["vpusername"])){
	  echo "Leiti küpsis: " . $_COOKIE["vpusername"];
  } else {
	  echo "Küpsist ei leitud";
  }
  //count ($_COOKIE) vaatab kas arvutis on cookie
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  
  $newsHTML = latestNews(5);
  
  require("header.php");
?>


<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a></p>
  <ul>
    <li><a href="userprofile.php">Kasutajaprofiil</a></li>
	<li><a href="messages.php">Sõnumid</a></li>
	<li><a href="picupload.php">Piltide üleslaadimine</a></li>
	<li><a href="showfilminfo.php">Filmid</a></li>
	<li><a href="gallery.php">Pildigalerii</a></li>
	<li><a href="uudis.php">Uudise lisamine</a></p></li>
	<!-- userpics.php -->
  </ul>
  
   <?php
   echo $newsHTML;
  ?>
  
</body>
</html>