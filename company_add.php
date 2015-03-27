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
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>


<div data-role="page" id="company_add">
		<div data-role="header">
			<a href="logout.php" data-icon="user">Wyloguj</a>

		<h1>Produkty - dodaj</h1>
		</div>
		<?php
		if ($_SESSION["user"] != false) {
		 	echo View::getInstance()->getNavigationBars(	$_SESSION["user"]->getRole());
		}
		?>
		<div data-role="navbar"><ul>
	  		<li><a href="company_add.php">Dodaj</a></li>
			<li><a href="company.php">Lista</a></li>
		</ul></div>
		<div data-role="main" class="ui-content">
			<form enctype="multipart/form-data" action="company.php" method="POST" data-ajax='false'>
		  		<div class="ui-field-contain">

				<label for="name">Nazwa:</label>
				<input type="text" name="name" id="name">

				<label for="nip">NIP:</label>
				<input type="text" name="nip" id="nip">

  				<label for="zipCode">Kod pocztowy:</label>
				<input type="text" name="zipCode" id="zipCode">

				<label for="city">Miasto:</label>
				<input type="text" name="city" id="city">

				<label for="street">Ulica:</label>
				<input type="text" name="street" id="street">

				<label for="nr_house">Nr mieszkania:</label>
				<input type="text" name="nr_house" id="nr_house">

				</div>
				<input type="submit" data-inline="true" value="Zapisz">
			</form>
		</div>
</div>



</body>
</html>