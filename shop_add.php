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
		<h1>Zakupy - dodaj</h1>
		</div>
		<?php
		if ($_SESSION["user"] != false) {
		 	echo View::getInstance()->getNavigationBars(	$_SESSION["user"]->getRole());
		}
		?>

		<div data-role="navbar"><ul>
	 	   <li><a href="shop_add.php">Dodaj</a></li>
			<li><a href="shop.php">Lista</a></li>
		</ul></div>

		<div data-role="main" class="ui-content">

			<form enctype="multipart/form-data" action="shop.php" method="POST" data-ajax='false'>
		  		<div class="ui-field-contain">

				<?php
				  echo	$_SESSION["user"]->getHideInput();
				?>

				 <label for="select-choice-1" class="select">Sklep:</label>
				 <select name="select-choice-1" id="select-choice-1">
  			    <?php
				 	echo Company::getComboContent();
				 ?>
			   </select>
				 <label for="dataShop" class="input">Data zakupu:</label>
				<input type="date" name="date" id="date" value="" />
				 <label for="prince" class="input">Cena:</label>
			 	<input type="text" name="prince" id="prince" value="0" />
				 <label for="amount" class="input">Ilość:</label>
				<input type="text" name="amount" id="amount" value="1" />
				</div>
				<input type="submit" data-inline="true" value="Zapisz">
			</form>

		</div>

</div>

</body>
</html>