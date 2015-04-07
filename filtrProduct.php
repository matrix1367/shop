<?php
 header('Content-Type: text/html; charset=utf-8');

include_once('class/class_db.php');

if (isset($_POST['value_array']))
{
	echo '<li data-role="divider">Lista produktów</li>';
	echo Product::getListCategoryFromArray($_POST['value_array']);
}

?>