 <?php
	include_once("class/class_login.php");
	include_once('class/class_view.php');
	include_once('class/class_db.php');

	session_start();


	if (!isset($_SESSION['user'])) {
		$_SESSION["user"] = false;
	}

	if (isset($_GET['Product']) && isset($_GET['addComponent']) ) {
		ProductComponent::add($_GET['Product'], $_GET['addComponent']);
	}

    if (isset($_GET['Product']) && isset($_GET['deleteComponent']) ) {
		ProductComponent::delete($_GET['Product'], $_GET['deleteComponent']);
	}
?>

<?xml version="1.0" encoding="iso-8859-2"?>
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


<div data-role="page" id="product_edit">
		<div data-role="header">
			<a href="logout.php" data-icon="user">Wyloguj</a>

		<h1>Produkt</h1>
		</div>
		<?php
		if ($_SESSION["user"] != false) {
		 	echo View::getInstance()->getNavigationBars(	$_SESSION["user"]->getRole());
		}
		?>
		<div data-role="navbar"><ul>
	  		<li><a href="product_add.php">Dodaj</a></li>
			<li><a href="product.php">Lista</a></li>
		</ul></div>
		<div data-role="main" class="ui-content">
		 <div>  </div>
		  <ul data-role="listview" data-inset="true" id="list_component" style="margin: 0px;padding: 0px;">
		   <li data-filtertext="fav"> Lista składników produktu</li>
		  <?php
				echo ProductComponent::getListProductComponent($_GET['Product']);

			 ?>
		   </ul>

		  <ul data-role="listview" data-filter="true" data-inset="true" id="list_add_component">
		    <li data-role="divider"> <li data-filtertext="fav"> Lista składników</li>
			 <?php

			  echo	Component::getListCompanyForEdit($_GET['Product']);

			 ?>
		 </ul>
		</div>
</div>

<table border="0" ></table>

</body>
</html>