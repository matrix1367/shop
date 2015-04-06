<?php
	include_once("class/class_login.php");
	include_once('class/class_view.php');

	session_start();


	$_SESSION["user"] = Login::getInstance()->logout();

?>

<!DOCTYPE html>
<html>
	<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Wiem co jem</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Include jQuery Mobile stylesheets -->
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

	<!-- Include the jQuery library -->
	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>

	<!-- Include the jQuery Mobile library -->
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>


</head>
<body>

<div data-role="page" id="logout">
		<div data-role="header">
		<?php
				echo 	'<a href="login.php" data-icon="user">Zaloguj</a>';
		?>
		<h1>Wylogowanie</h1>
		</div>

		<div data-role="main" class="ui-content">
		Zostałeś pomyślnie wylogowany,    <a href="index.php">przejdź do strony głównej</a>
		</div>
</div>

<?php
session_unset();
session_destroy();
?>
</body>
</html>