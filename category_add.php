<?php
	include_once("class/class_login.php");
	include_once('class/class_view.php');
	include_once('class/class_db.php');

	session_start();


	if (!isset($_SESSION['user'])) {
		$_SESSION["user"] = false;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-
transitional.dtd">
<html>
	<head>
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-2" />
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



<div data-role="page" id="category_add">
		<div data-role="header">
			<a href="logout.php" data-icon="user">Wyloguj</a>

		<h1>Kategorie - dodaj</h1>
		</div>
		<?php
		if ($_SESSION["user"] != false) {
		 	echo View::getInstance()->getNavigationBars(	$_SESSION["user"]->getRole());
		}
		?>
		<div data-role="navbar"><ul>
			<li><a href="category_add.php">Dodaj</a></li>
			<li><a href="category.php">Lista</a></li>
		</ul></div>
		<div data-role="main" class="ui-content">
			<form enctype="multipart/form-data" action="category.php" method="POST" data-ajax='false'>
		  		<div class="ui-field-contain">
				<input type="hidden" name="MAX_FILE_SIZE" value="999999999" />
				<label for="fullname">Nazwa:</label>
				<input type="text" name="fullname" id="fullname">
				<label for="description">Opis:</label>
				<input type="text" name="description" id="description">
				<label for="fileToUpload">Obraz:</label>
			   <input type="file" name="fileToUpload" >
				</div>
				<input type="submit" data-inline="true" value="Zapisz">
			</form>
		</div>
</div>



</body>
</html>