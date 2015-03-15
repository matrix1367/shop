<?php
//najtañszy produkt w bazie danych w dowolnym sklepie
 header('Content-Type: text/html; charset=ISO-8859-2');

include_once('class/class_db.php');

if (isset($_POST['value_array']) && isset($_POST['action']))
{
	if ($_POST['action'] == 'minPrince') {
		echo '<li data-role="divider">Lista produktów</li>';
		$str = implode(',', $_POST['value_array']);
		$lisView = "";
		$result = DB::getInstance()->query("SELECT MIN( shop.price) as minPrice, product.*, shop.* ,company.name As shopName FROM shop RIGHT JOIN product ON product.productID = shop.productID RIGHT JOIN shopList ON shopList.shopListID = shop.shopListID RIGHT JOIN company ON company.companyID = shopList.companyID WHERE shopList.status = 3 AND  product.productID IN (" .$str. ")  group by shop.productid "   );
			 while($row = mysql_fetch_array($result)) {
			   $lisView .= " <li>";
			   $lisView .= ' <span><table><tr>';
			   $lisView .=    ' <td><img style=" border-style: solid;border-width: 1px;border-color: #989898 ;margin-left: 3px; margin-top: 3px;" width="70px" height="70px" src="'.$row["link_image"].'"></td>';
			   $lisView .=    ' <td><h2 style=";margin-left: 5px;">'.$row["name"].'</h2>';
			  	$lisView .=     ' <p style=";margin-left: 5px;"><a href="#">'.$row["shopName"].'</a></p>';
				$lisView .= '<td><p style=";margin-left: 5px;"> Ilo¶æ: '.$row["amount"] .' </p><a href="#"><p style=";margin-left: 5px;"> Cena: '.$row["minPrice"] .' z³</p></a></td>';
			   $lisView .=    '</td></tr></table> </span>';
			 	$lisView .= '</li>';

			 }
		echo 	  $lisView;
	}


}

?>
