<?php
	include_once("class/class_login.php");
	include_once('class/class_view.php');

	session_start();


	if (!isset($_SESSION['user'])) {
		$_SESSION["user"] = false;
	}


?>

<!DOCTYPE html>
<html>
	<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1250" />
	<title>Wiem co jem</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

<div data-role="page" id="login">
	<div data-role="header">
	<a href="index.php" data-icon="home">Home</a>
	<h1>Zaloguj</h1>
	</div>
  <div data-role="main" class="ui-content">
       <form method="post" action="index.php">
      <div class="ui-field-contain">
        <label for="fullname">Login:</label>
        <input type="text" name="fullname" id="fullname">

        <label for="pass">Hasło:</label>
       <input type="password" name="pass" id="pass">
      </div>
      <input type="submit" data-inline="true" value="Zaloguj">
    </form>
  </div>
</div><!-- /page -->

</body>
</html>