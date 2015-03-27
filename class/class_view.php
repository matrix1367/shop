<?php

class View {

    private static $Instance = false;

    public static function getInstance() {
        if (self::$Instance == false) {
            self::$Instance = new View();
        }
        return self::$Instance;
    }

    public function getNavigationBars($role) {
        $bar = "";

        if ($role == 1) {
            //admin
            $bar = ' <div data-role="navbar"><ul>';
            $bar .= '<li><a href="index.php">Lista</a></li>';
            //	$bar .= '<li><a href="shop.php">Zakupy</a></li>';
            $bar .= '<li><a href="company.php">Firmy</a></li>';
            $bar .= '<li><a href="category.php">Kategorie</a></li>';
            $bar .= '<li><a href="component.php">Sk³adniki</a></li>';
            $bar .= '<li><a href="product.php">Produkty</a></li>';
            $bar .= '</ul></div>';
        } else if ($role == 2) {
            //user
            $bar = ' <div data-role="navbar"><ul>';
            $bar .= '<li><a href="index.php">Wyszukiwarka</a></li>';
            $bar .= '<li><a href="company.php">Firmy</a></li>';
            $bar .= '<li><a href="product.php">Produkty</a></li>';
            $bar .= '</ul></div>';
        }
        return $bar;
    }

    public function viewLogin() {
        echo '       <form method="post" action="index.php">
                        <div class="ui-field-contain">
                          <label for="fullname">Login:</label>
                          <input type="text" name="fullname" id="fullname">

                          <label for="pass">Has³o:</label>
                         <input type="password" name="pass" id="pass">
                        </div>
                        <input type="submit" data-inline="true" value="Zaloguj">
                      </form>';
    }

    public function checkAddProduct($listShopID, $productID) {
        $result = DB::getInstance()->query("SELECT * FROM shop WHERE shopListID = " . $listShopID);
        while ($row = mysql_fetch_array($result)) {
            if ($productID == $row['productID']) {
                return true;
            }
        }
        return false;
    }

    public static function getGrupsProductArchive($listShopID) {
        $result = DB::getInstance()->query("SELECT * FROM product Left join shop ON product.productID = shop.productID WHERE shop.shopListID = " . $listShopID);
        $resultCompany = DB::getInstance()->query("SELECT company.*, shopList.name AS nameShop  FROM company LEFT JOIN shopList ON company.companyID = shopList.companyID WHERE shopList.shopListID = " . $listShopID);
        while ($rowCompany = mysql_fetch_array($resultCompany)) {
            $view = '<div> <b>' . $rowCompany['name'] . '</b>, Ul. ' . $rowCompany['street'] . ' ' . $rowCompany['nr_house'] . ', ' . $rowCompany['zipCode'] . ' ' . $rowCompany['city'] . '</div>';
            $view .= ' <ul data-role="listview" data-inset="true" id="list_product">   <li data-role="divider">Lista produktów: <b>' . $rowCompany['nameShop'] . '</b> </li>';
        }


        while ($row = mysql_fetch_array($result)) {
            if (!file_exists($row["link_image"]))
                $row["link_image"] = "images/default-no-image.png";
            $view .= " <li>";
            $view .= ' <a href="product.php?Product=' . $row["productID"] . '">';
            $view .= ' <img style=" border-style: solid;border-width: 1px;border-color: #989898 ;margin-left: 3px; margin-top: 3px;" width="70px" height="70px" src="' . $row["link_image"] . '">';
            $view .= ' <h2>' . $row["name"] . '</h2>';
            $view .= ' <p> Iloœæ: ' . $row["amount"] . ' Cena: ' . $row["price"] . ' z³</p>';
            $view .= ' </a>';
            //	 	$view .=     ' <a href="product.php?deleteProduct='.$row["productID"].'" data-transition="pop" data-icon="delete">Usuñ produkt</a>';
            $view .= '</li>';
        }
        $view .= "</ul></div>";
        return $view;
    }

    /*
      public function getGrupsProductArchive($listShopID) {
      //	$products= 	 Product::getProductFormCategory(1)

      $result = DB::getInstance()->query("SELECT * FROM category;");
      $view = '<div>Lista: ' .ShopList::getNameList($listShopID) .'</div>';
      $view .= '<form action="schop_archive.php" method="post"><div data-role="collapsibleset">';
      $view .= '<input type="hidden" name="listShopID" value="'.$listShopID. '" />';
      while($row = mysql_fetch_array($result)) {
      $view .= '<div data-role="collapsible">';
      $view .= '<h1>'. $row["name"].'</h1>';
      $resultProduct = Product::getProductFormCategory($row["categoryID"]);
      $view .= '<fieldset data-role="controlgroup" data-type="horizontal">';
      $i = 1;
      while($rowProduct = mysql_fetch_array($resultProduct)) {
      if ($this->checkAddProduct($listShopID, $rowProduct["productID"])	) {
      $view .= '<input type="checkbox" name="products[]" value="'.$rowProduct["productID"] .'" id="check'.$row["categoryID"] .$i. '" checked> <label for="check'.$row["categoryID"] .$i. '"> <img  width="60px" height="60px" src="'.$rowProduct["link_image"].'" /> </label>';
      } else {
      $view .= '<input type="checkbox" name="products[]" value="'.$rowProduct["productID"] .'" id="check'.$row["categoryID"] .$i. '"> <label for="check'.$row["categoryID"] .$i. '"> <img  width="60px" height="60px" src="'.$rowProduct["link_image"].'" /> </label>';
      }

      $i += 1;
      }

      $view .= ' </div>';
      }
      $view .= '</div><a href="schop_archive.php" class="ui-btn">Powrót</a></form>';
      return $view;
      }
     */

    public function getGrupsProduct($listShopID) {
        //	$products= 	 Product::getProductFormCategory(1)

        $result = DB::getInstance()->query("SELECT * FROM category;");
        $view = '<div>Lista: ' . ShopList::getNameList($listShopID) . '</div>';
        $view .= '<form action="index.php" method="post"><div data-role="collapsibleset">';
        $view .= '<input type="hidden" name="listShopID" value="' . $listShopID . '" />';
        while ($row = mysql_fetch_array($result)) {
            $view .= '<div data-role="collapsible">';
            $view .= '<h1>' . $row["name"] . '</h1>';
            $resultProduct = Product::getProductFormCategory($row["categoryID"]);
            $view .= '<fieldset data-role="controlgroup" data-type="horizontal">';
            $i = 1;
            while ($rowProduct = mysql_fetch_array($resultProduct)) {
                if ($this->checkAddProduct($listShopID, $rowProduct["productID"])) {
                    $view .= '<input type="checkbox" name="products[]" value="' . $rowProduct["productID"] . '" id="check' . $row["categoryID"] . $i . '" checked> <label for="check' . $row["categoryID"] . $i . '"> <img  width="60px" height="60px" src="' . $rowProduct["link_image"] . '" /> </label>';
                } else {
                    $view .= '<input type="checkbox" name="products[]" value="' . $rowProduct["productID"] . '" id="check' . $row["categoryID"] . $i . '"> <label for="check' . $row["categoryID"] . $i . '"> <img  width="60px" height="60px" src="' . $rowProduct["link_image"] . '" /> </label>';
                }

                $i += 1;
            }

            $view .= ' </div>';
        }
        $view .= '</div><fieldset data-role="controlgroup" data-type="horizontal"><a href="index.php" class="ui-btn">Powrót</a><input type="submit" value="Zapisz listê" /></form>';
        return $view;
    }

    /*
      public function viewBuyList($ShopListID) {

      $result = DB::getInstance()->query("SELECT * FROM shop LEFT JOIN product ON product.productID = shop.productID  WHERE  shopListID = " .$ShopListID  );
      $listView = '  <ul data-role="listview" data-inset="true"> <li data-role="divider">Produkty</li>';
      while($row = mysql_fetch_array($result)) {
      if (!file_exists($row["link_image"])) $row["link_image"] = "images/default-no-image.png";
      $listView .= " <li><span>";
      $listView .= ' <table border="1"><tr><td>';
      $listView .=    ' <img style=" border-style: solid;border-width: 1px;border-color: #989898 ;margin-left: 3px; margin-top: 3px;" width="70px" height="70px" src="'.$row["link_image"].'">';
      $listView .=    ' </td><td>';

      $listView .=    ' <h2>'.$row["name"].'</h2>';
      $listView .=     ' <p>   <input type="text" name="fname" id="fname"> </p>';
      $listView .=    ' </td></tr></table></span>';
      //	$listView .=     ' <a style="clear:both;" href="product.php?deleteProduct='.$row["shopID"].'" data-transition="pop" data-icon="check">Kupiono</a>';
      $listView .= '</li>';
      }
      $listView .= ' </ul></div>';
      return $listView;
      }
     */

    public function viewBuyList($ShopListID) {

        $result = DB::getInstance()->query("SELECT * FROM shop LEFT JOIN product ON product.productID = shop.productID  WHERE  shopListID = " . $ShopListID);
        $listView = '<form action="index.php" method="post"><div>Lista produktów:</div>   <table   data-role="table" class="ui-responsive" id="myTable"><thead><tr><th></th><th></th><th></th></tr></thead> <tbody>';
        $listView .= '<input type="hidden" name="listShopID" value="' . $ShopListID . '" />';
        $listView .= '	 <label for="companyID" class="select">Sklep:</label>';
        $listView .= ' <select name="companyID" id="companyID">';

        $listView .= Company::getComboContent();

        $listView .= ' </select>';
        while ($row = mysql_fetch_array($result)) {
            $listView .=' <tr>';
            $listView .= '<td><input type="checkbox" name="productsBuy[]" value="' . $row["productID"] . '" id="check' . $row["productID"] . '" > <label for="check' . $row["productID"] . '">
		  <img  width="60px" height="60px" src="' . $row["link_image"] . '" /></td> </label>';
            $listView .= ' <td> <label for="amount">Iloœæ: </label> <input  type="text" name="amount[]" id="amount"> </td>  ';
            $listView .= ' <td><label for="price">Cena: </label> <input  type="text" name="price[]" id="price"></td></tr> ';
        }
        $listView .= '    </tbody></table>';
        $listView .=' <input type="submit" value="Zakoñcz zakupy" /></form>';
        //	 $listView .= ' </ul></div>';
        return $listView;
    }

    public function viewProduct($productID) {
        $result = DB::getInstance()->query("SELECT * FROM product  WHERE  productID = " . $productID);
        $view = "";
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                if (!file_exists($row["link_image"]))
                    $row["link_image"] = "images/default-no-image.png";
                $view .= '<div><img src="' . $row["link_image"] . '" /></div><div style="text-align: center;"><b>' . $row["name"] . '</b></div><div><b>Opis:</b></div><div>' . $row["description"] . '</div>';
                $view .= '<div><b>Sk³adniki:</b></div>';
            }
        }

        return $view;
    }

}
?>
<span style="padding-left: 5px;text-align: center;"></span>
<img src="" width=""  />
