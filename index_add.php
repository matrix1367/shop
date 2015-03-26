<?php
	include_once("class/class_login.php");
	include_once('class/class_view.php');
	include_once('class/class_db.php');

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

<div data-role="page" id="search">
		<div data-role="header">
		<?php
			if ($_SESSION["user"] == false) {
				echo 	'<a href="login.php" data-icon="user">Zaloguj</a>';
			} else echo	'<a href="logout.php" data-icon="user">Wyloguj</a>';
		?>
		<h1>Wyszukaj</h1>
		</div>
		<?php
		if ($_SESSION["user"] != false) {
		 	echo View::getInstance()->getNavigationBars(	$_SESSION["user"]->getRole());
		}
		?>

		<div data-role="navbar"><ul>
			<li><a href="shop_add.php">Nowa lista</a></li>
			<li><a href="index.php">Lista zakupów</a></li>
		</ul></div>

		<div data-role="main" class="ui-content">

			<form enctype="multipart/form-data" action="product.php" method="POST" data-ajax='false'>
		  		<div class="ui-field-contain">

				<label for="fullname">Nazwa:</label>
				<input type="text" name="fullname" id="fullname" value="lista zakupów" >





				</div>
				<input type="submit" data-inline="true" value="Wybierz produkty">
			</form>

		</div>
</div>

</body>
</html>