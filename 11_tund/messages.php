<?php
  require ("../../../config_vp2019.php");
  require("functions_main.php");
  require("functions_user.php");
  require("functions_message.php");
  $database = "if19_henri_ma_1";
  
  //kontrollime, kas on sisse logitud
  if(!isset($_SESSION["userID"])){
	  header("Location: page.php");
	  exit();
  }
  
  //logime välja
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  
  $notice = null;
  $myMessage = null;
  
  if(isset($_POST["submitMessage"])){
	$myMessage = (test_input($_POST["message"]));
	#$myMessage = ($_POST["message"]);
	#if(!empty ($_POST[myMessage])) {
		if(!empty ($_POST["message"])) {
		$notice = storeMessage($myMessage);
	}else{
		$notice = " Tühja sõnumit ei salvestata!";		
	}
  }
  $messagesHTML = readAllMessages();
	 	require("header.php");
  ?>
   
<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele</a></p>

  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu sõnum (256 märki)</label><br>
	  <textarea rows="5" cols="50" name="message" placeholder="Lisa siia oma sõnum ..."><?php ?></textarea>
	  <br>
	  <input name="submitMessage" type="submit" value="Salvesta sõnum"><span><?php echo $notice; ?></span>
	</form>
	<br>
	<h2>Senised sõnumid</h2>
	<?php
	echo $messagesHTML;
	?>
	
</body>

</html>