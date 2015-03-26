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
			<li><a href="shop_new_list.php">Nowa lista</a></li>
			<li><a href="index.php">Lista zakupów</a></li>
      	<li><a href="shop_archive.php">Archiwum</a></li>
		</ul></div>


		<div data-role="main" class="ui-content">

			<form enctype="multipart/form-data" action="index.php" method="POST" data-ajax='false'>
		  		<div class="ui-field-contain">

				<?php
					if ($_SESSION["user"] != false)  echo	$_SESSION["user"]->getHideInput();
				?>


				<?php
				  if ($_SESSION["user"] != false) {
				  echo '	<label for="name">Nazwa:</label>'	;
					echo '	<input type="text" name="name" id="name" value="Lista zakupów '	.ShopList::getCount() .'" >'	  ;

				echo '
				<label for="dataShop" class="input">Data zakupu:</label>
				<input type="date" name="dateShop" id="dateShop" value="" />


				</div>
				<input type="submit" data-inline="true" value="dodaj listę">
				';
				}
				?>
			</form>

		</div>
		<script type="text/javascript">
		$(document).ready( function() {
			var d = new Date();
			var mm =  (d.getMonth() + 1).toString();
			if (mm.length == 1) mm = "0" + mm;
			var dd = d.getDate().toString();
			if (dd.length == 1) dd = "0"+dd;
    		$('#dateShop').val(d.getFullYear() + "-" +mm+"-" + dd );
		});
		</script>
</div>

</body>
</html>