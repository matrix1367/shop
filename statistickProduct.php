<?php
//najta�szy produkt w bazie danych w dowolnym sklepie
 header('Content-Type: text/html; charset=utf-8');

include_once('class/class_db.php');

if (isset($_POST['value_array']) && isset($_POST['action']))
{
	if ($_POST['action'] == 'minPrince') {
		echo '<li data-role="divider">Lista produktów</li>';
		$str = implode(',', $_POST['value_array']);
		$lisView = "";
                $query = "SELECT product.* , shop.price, MAX(shop.amount) as max_amount , company.name As shopName
                            FROM shop join
                            (SELECT shop.productid , MIN(shop.price) as min_price FROM `shop` WHERE shop.productid IN (" .$str. ")  group by shop.productid) shop_prince_min
                                ON shop.productid = shop_prince_min.productid and shop.price = shop_prince_min.min_price
                                JOIN shopList ON shopList.shopListID = shop.shopListID 
                                JOIN product ON product.productID = shop.productID 
                                JOIN company ON company.companyID = shopList.companyID 
                                WHERE shopList.status = 3
                                group by shop.productid , shop.price";
                
		$result = DB::getInstance()->query($query); // "SELECT MIN( shop.price) as minPrice, product.*, shop.* ,company.name As shopName FROM shop RIGHT JOIN product ON product.productID = shop.productID RIGHT JOIN shopList ON shopList.shopListID = shop.shopListID RIGHT JOIN company ON company.companyID = shopList.companyID WHERE shopList.status = 3 AND  product.productID IN (" .$str. ")  group by shop.productid "   );
			 while($row = mysql_fetch_array($result)) {
			   $lisView .= " <li>";
			   $lisView .= ' <span><table><tr>';
			   $lisView .=    ' <td><img style=" border-style: solid;border-width: 1px;border-color: #989898 ;margin-left: 3px; margin-top: 3px;" width="70px" height="70px" src="'.$row["link_image"].'"></td>';
			   $lisView .=    ' <td><h2 style=";margin-left: 5px;">'.$row["name"].'</h2>';
			  	$lisView .=     ' <p style=";margin-left: 5px;"><a href="map.php">'.$row["shopName"].'</a></p>';
				$lisView .= '<td><p style=";margin-left: 5px;"> Ilość: '.$row["max_amount"] .' </p><a href="#"><p style=";margin-left: 5px;"> Cena: '.$row["price"] .' zł</p></a></td>';
			   $lisView .=    '</td></tr></table> </span>';
			 	$lisView .= '</li>';

			 }
		echo 	  $lisView;
	}


}

?>
