<?php
	include_once("class/class_login.php");
	include_once('class/class_view.php');
	include_once('class/class_db.php');

	session_start();

	DB::getInstance();

	if (!isset($_SESSION['user'])) {
		$_SESSION["user"] = false;
	}

	if (isset($_POST['fullname']) && isset($_POST['pass']))
	{
		$_SESSION["user"] = Login::getInstance()->login($_POST['fullname'], $_POST['pass']);
	}

	if (isset($_POST['usersID']) && isset($_POST['name']) && isset($_POST['dateShop'])) {
		ShopList::add($_POST['name'], 0 ,$_POST['usersID'], $_POST['dateShop']);
	}

	if (isset($_GET['deleteShopList'])) {
		ShopList::delete($_GET['deleteShopList']);
	}

	if (isset($_GET['archiveShopList'])) {
		ShopList::updateStatus($_GET['archiveShopList'], 3);
	}


	if  (isset($_POST['listShopID']) && isset($_POST['products'])  )
	{
					Shop::deleteAllShopToIDList($_POST['listShopID']);

	 				$aProduct = $_POST['products'];
				   $nProduct =  count($_POST['products']);

				  for($i=0; $i < $nProduct; $i++)	{
				  		Shop::add($_POST['listShopID'] , $aProduct[$i], 0, 0);
				  }
	}

	if  (isset($_POST['listShopID']) && isset($_POST['productsBuy'])   && isset($_POST['amount'])   && isset($_POST['price'])   && isset($_POST['companyID'])  )
	{


	 				$aProduct = $_POST['productsBuy'];
						$aAmount = $_POST['amount'];
							$aPrice = $_POST['price'];

				   $nProduct =  count($_POST['productsBuy']);

				  for($i=0; $i < $nProduct; $i++)	{
				  		Shop::updateShop($_POST['companyID'], $_POST['listShopID'] , $aProduct[$i], $aAmount[$i],$aPrice[$i]);
				  }
	}
?>


<!DOCTYPE html>
<html>
	<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Wiem co jem</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<style>
th {
    border-bottom: 1px solid #d6d6d6;
}

tr:nth-child(even) {
    background: #e9e9e9;
}

table {
	margin: 0px;
}
</style>
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
			<li><a href="shop_new_list.php">Nowa lista</a></li>
			<li><a href="index.php">Lista zakupów</a></li>
			<li><a href="shop_archive.php">Archiwum</a></li>
		</ul></div>


		<div data-role="main" class="ui-content">

	  			<?php

					if (isset($_GET['ShopList']) ) {
						echo View::getInstance()->getGrupsProductArchive($_GET['ShopList']);
					} else {
							if ($_SESSION["user"] != false) {
										echo ShopList::getShopListArchive($_SESSION["user"]->getId());
							}

					}




				?>


		</div>
		<script type="text/javascript">

		</script>
</div>

</body>
</html>