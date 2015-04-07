<?php

	include_once("class/class_login.php");
	include_once('class/class_view.php');
	include_once('class/class_db.php');

	session_start();


	if (!isset($_SESSION['user'])) {
		$_SESSION["user"] = false;
	}

	if(  isset($_POST['fullname']) &&   isset($_POST['code']) && isset($_POST['adi']) && isset($_POST['risik']) && isset($_POST['descryption'])  )
	{
		Component::add($_POST['fullname'], $_POST['descryption'], $_POST['code'], $_POST['adi'], $_POST['risik']);
	}

//	if (isset($_GET['deleteCategory'])) {
 //		Category::delete($_GET['deleteCategory']);
//	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-
transitional.dtd">
<html>
	<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Wiem co jem</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        
</head>
<body>
    
 
    
<style type="text/css">
.ui-li-divider  {
      text-decoration:  none;
      color: black !important;
   }
</style>

<div data-role="page" id="component_list">
		<div data-role="header">
			<a href="logout.php" data-icon="user">Wyloguj</a>

		<h1>Składniki - lista</h1>
		</div>
		<?php
		if ($_SESSION["user"] != false) {
		 	echo View::getInstance()->getNavigationBars(	$_SESSION["user"]->getRole());
		}
		?>
		<div data-role="navbar"><ul>
			<li><a href="component_add.php">Dodaj</a></li>
			<li><a href="component.php">Lista</a></li>
		</ul></div>
		<div data-role="main" class="ui-content">

		    <ul data-role="listview" data-inset="true" data-theme="d">
		      <li data-role="divider">Składniki produktów</li>

		        <?php
				  	echo Component::getListCategory();
				  ?>
		    </ul>

		</div>
</div>





</body>
</html>