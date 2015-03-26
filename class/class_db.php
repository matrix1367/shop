<?php

/**
 * @author dragon
 * @copyright 2015
 */

class DB {
    private static $Instance = false;
    public static function getInstance()
    {
        if( self::$Instance == false )
        {
            self::$Instance = new DB();
        }
        return self::$Instance;
    }

   private $link;

   private $host;
   private $name;
   private $user;
   private $password;

   private function __construct() {
    $this->name = "shop";
    $this->user = "root";
    $this->host = "localhost";
    $this->password = "dred1367";

    $this->open();

    if (!$this->isExist()) {
        $this->create();
    }

   }

   public function open() {
    $this->link = mysql_connect($this->host, $this->user, $this->password);
    if (!$this->link) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($this->name, $this->link); //or die('Could not select: ' . mysql_error());
   }

   public function close() {
        mysql_close($this->link);
   }

   public function isExist() {
        if ($this->link) {
            return  mysql_select_db($this->name, $this->link);
        }
        return false;
   }

   public function create() {
       // mysql_create_db($this->name);
        $this->query('CREATE DATABASE ' . $this->name);
        mysql_select_db($this->name, $this->link) or die('Could not select: ' . mysql_error());
		  $this->query('CREATE TABLE users (usersID int NOT NULL AUTO_INCREMENT , name char(30) , password char(30), role int,  PRIMARY KEY(usersID)  )');
        $this->query('CREATE TABLE product (productID  int NOT NULL AUTO_INCREMENT, name char(30),  link_image char(255), description char(255), PRIMARY KEY(productID))');
        $this->query('CREATE TABLE category (categoryID  int NOT NULL AUTO_INCREMENT, name char(30),  link_image char(255), description char(255), PRIMARY KEY(categoryID))');
		  $this->query('CREATE TABLE productCategory (productcategoryID int NOT NULL AUTO_INCREMENT, productID int, categoryID int, PRIMARY KEY(productcategoryID))');
		  $this->query('CREATE TABLE company (companyID int NOT NULL AUTO_INCREMENT ,name char(30), nip char(30), zipCode char(30), city char(30), street char(30), nr_house int, PRIMARY KEY(companyID))');

		  $this->query('CREATE TABLE shopList  (shopListID int NOT NULL AUTO_INCREMENT ,name char(30), companyID int, usersID int, date DATE, status int, PRIMARY KEY(shopListID))');
		  $this->query('CREATE TABLE shop (shopID int NOT NULL AUTO_INCREMENT, shopListID int, productID int, price REAL, amount REAL,  PRIMARY KEY(shopID))');

		  $this->query('CREATE TABLE 	component (componentshopID int NOT NULL AUTO_INCREMENT, name char(30), description text, Eno char(10), ADI REAL, risk int,  PRIMARY KEY (componentshopID))');
		  $this->query('CREATE TABLE 	productComponent (productComponentID int NOT NULL AUTO_INCREMENT, product int, componentshopID int,  PRIMARY KEY (productComponentID))');

		  Category::add("Nabia³", "uploads/Nabial.jpg" , "Produkty wyrobu mlecznego");
		  Category::add("Warzywa", "uploads/warzywa.jpeg" , "Produkty rolnicze");
                  Category::add("Owoce", "uploads/owoce.jpeg" , "Produkty rolnicze");
                  Category::add("Pieczywo", "uploads/pieczywo.jpeg" , "Produkty wypiekane");
                  Category::add("Miêso", "uploads/mieso.jpeg" , "Produkty p[ochodzenia zwierzecego");

		  Users::add('admin' , 'admin', 1);
 		  Users::add('zielony' , 'zielony', 2);
   }



   public function query($msg)
   {
       echo '<script> console.log("query: ' .$msg . '"); </script>';
        return mysql_query($msg);
   }

}


class Component {
	public static function add($name, $description, $eno, $adi, $risk) {

		DB::getInstance()->query("INSERT INTO  component (name , description, Eno, ADI, risk) VALUES ('".$name."', '".$description  ."', '".$eno ."', " .$adi.  " , ". $risk ." )");
	}

	public static function getColor($value, $maxValue) {
	    $d =floor(($value / $maxValue)*255);
		$r = $d;
		$g = 255-$d;
		$b =  0;

		return 'rgb(' .$r .' , '. $g .' , '.$b .')';
	}

   public static function getListCategory() {
	 	 $result = DB::getInstance()->query("SELECT * FROM component;");
		 $lisView = "";
		 if (!$result) return "";
		 while($row = mysql_fetch_array($result)) {
		 // if (!file_exists($row["link_image"])) $row["link_image"] = "images/default-no-image.png";
		 	$lisView .=  '<li style= "background-color: ' . Component::getColor($row["risk"], 100) .' ";>';
		   $lisView .= ' <span>';
		   $lisView .= ' <h2>'.$row["name"].'</h2>';
		  	$lisView .= ' <p><b>'.$row["Eno"] .', Dzienna dawka : ' .$row["ADI"].' mg/kg</b></p>';
		   $lisView .= ' </span>';

		 	$lisView .= '</li>';
        }

		  return $lisView;
	 }
}

class ShopList {
	public static function add($name, $company, $userID, $date) {
	  	 	DB::getInstance()->query("INSERT INTO  shopList (name , companyID, usersID, date) VALUES ('".$name. "', ".$company .", " .$userID.  " , '". $date ."' )");
	}

	public static function getShopList($userID) {
	 	 $result = DB::getInstance()->query("SELECT * FROM shopList WHERE status < 2 and usersID = ".$userID);
		 $lisView = '<div data-role="main" class="ui-content">    <ul data-role="listview" data-inset="true">    <li data-role="divider">Listy zakupów</li>';
		 while($row = mysql_fetch_array($result)) {
		 // if (!file_exists($row["link_image"])) $row["link_image"] = "images/default-no-image.png";
		 	$lisView .= " <li>";
		   $lisView .= ' <a href="index.php?ShopList='.$row["shopListID"].'">';

		   $lisView .=    ' <h2>'.$row["name"].'</h2>';
		  	$lisView .=     ' <p>Data: '.$row["date"] .' Produkty: '.Shop::getCountProduct($row["shopListID"]) .'</p>';


		   $lisView .=    ' </a>';

			if ($row['status'] == 0) {
					$lisView .= ' <a href="index.php?buyShopList='.$row["shopListID"].'" data-transition="pop" data-icon="tag">Rozpocznij zakupy</a>';
			} else if ($row['status'] == 1) {
			 	$lisView .= ' <a href="index.php?archiveShopList='.$row["shopListID"].'" data-transition="pop" data-icon="edit">Archwizuj listê zakupów</a>';
			}

		 	$lisView .= '</li>';
        }
			$lisView .= "</ul>			</div>";
		  return $lisView;
	 }

	 	public static function getShopListArchive($userID) {
	 	 $result = DB::getInstance()->query("SELECT * FROM shopList WHERE status = 3 and usersID = " .$userID);
		 $lisView = '<div data-role="main" class="ui-content">    <ul data-role="listview" data-inset="true">    <li data-role="divider">Archiwalne listy zakupów</li>';
		 while($row = mysql_fetch_array($result)) {

		 	$lisView .= " <li>";
		   $lisView .= ' <a href="shop_archive.php?ShopList='.$row["shopListID"].'">';

		   $lisView .=    ' <h2>'.$row["name"].'</h2>';
		  	$lisView .=     ' <p>Data: '.$row["date"] .' Produkty: '.Shop::getCountProduct($row["shopListID"]) .'</p>';


		   $lisView .=    ' </a>';

			if ($row['status'] == 0) {
					$lisView .= ' <a href="index.php?buyShopList='.$row["shopListID"].'" data-transition="pop" data-icon="tag">Rozpocznij zakupy</a>';
			} else if ($row['status'] == 1) {
			 	$lisView .= ' <a href="index.php?archiveShopList='.$row["shopListID"].'" data-transition="pop" data-icon="edit">Archwizuj listê zakupów</a>';
			}

		 	$lisView .= '</li>';
        }
			$lisView .= "</ul>			</div>";
		  return $lisView;
	 }

	 public static function getCount() {

	  $result = mysql_fetch_array(DB::getInstance()->query("SELECT COUNT(*) as count FROM shopList;")	);
		  return  1+ (int) $result['count'];
	 }



	 public static function delete($shopListID) {

		DB::getInstance()->query("DELETE FROM shopList WHERE shopListID =(" .$shopListID   .")");
	}

	public static function getNameList($shopListID) {
		$result = DB::getInstance()->query("SELECT * FROM shopList WHERE shopListID = ".$shopListID);
		 while($row = mysql_fetch_array($result)) {
		 	return $row['name'];
		 }
		 return "brak nazwy";
	}

	public static function updateStatus($shopListID, $status) {
		DB::getInstance()->query("UPDATE shopList SET status = " .$status." WHERE shopListID = " .$shopListID  );
	}
}

class Shop {
	public static function add($shopListID, $productID, $prince, $amount) {
		DB::getInstance()->query("INSERT INTO  shop (shopListID , productID, price, amount) VALUES (".$shopListID. " , ".$productID ." , " .$prince.  " ," .$amount ." )");
	}

	public static function deleteAllShopToIDList($shopListID) {
		DB::getInstance()->query("DELETE FROM shop WHERE shopListID = " .$shopListID   );
	}

	public static function getCountProduct($shopListID) {
		$array = DB::getInstance()->query("SELECT COUNT(*) as count FROM shop WHERE shopListID = " .$shopListID	);
		if (isset($array )) {
	  		$result = mysql_fetch_array($array);
		  return   $result['count'];
		} else return 0;

	 }

	 public static function updateShop($companyID, $shopListID, $productID, $prince, $amount) {
	 	DB::getInstance()->query("UPDATE shop SET  price = " .$prince." , amount = " .$amount ." WHERE shopListID = " .$shopListID ." and productID = " .$productID );
		DB::getInstance()->query("UPDATE shopList SET status = 1 ,  companyID = " .$companyID." WHERE shopListID = " .$shopListID  );
	 }
}

class Users {
	public static function add($name, $password, $role) {
  	 	DB::getInstance()->query("INSERT INTO  users (name , password, role) VALUES ('".$name. "','".$password ."', " .$role.  "   )");
	}
}

class Company {
	public static function add($name, $nip, $zipCode, $city, $street, $nrHouse) {
	 $msg = "INSERT INTO `company` (name, nip, zipCode, city, street, nr_house) VALUES ('" .$name ."','" .$nip  ."' , '" .$zipCode ."','" .$city ."','" .$street ."'," .$nrHouse   .")";
//	 echo $msg;
	 	DB::getInstance()->query($msg);
	}

	public static function delete($id) {
		echo $id;
		DB::getInstance()->query("DELETE FROM company WHERE companyID =" .$id  );
	}

	public static function getListCategory() {
	 	 $result = DB::getInstance()->query("SELECT * FROM company;");
		 $lisView = "";
		 while($row = mysql_fetch_array($result)) {
		 // if (!file_exists($row["link_image"])) $row["link_image"] = "images/default-no-image.png";
		 	$lisView .= " <li>";
		   $lisView .= ' <a href="company.php?Company='.$row["companyID"].'">';

		   $lisView .=    ' <h2>'.$row["name"].'</h2>';
		  	$lisView .=     ' <p>NIP: '.$row["nip"] .', Ul. '    .$row["street"].' ' .$row["nr_house"].', ' .$row["zipCode"].' ' .$row["city"].'</p>';
		   $lisView .=    ' </a>';
		 	$lisView .=     ' <a href="company.php?deleteCompany='.$row["companyID"].'" data-transition="pop" data-icon="delete">Usuñ Firme</a>';
		 	$lisView .= '</li>';
        }

		  return $lisView;
	 }

	 public static function getComboContent() {
	 	$rows = DB::getInstance()->query("SELECT * FROM company;");
		$comboContent = "";

		  while($row = mysql_fetch_array($rows)) {
			  $comboContent .=	'<option value="'.$row["companyID"].'">'.$row["name"].'</option>';
			}

		return 	$comboContent;
	 }


}

class ProductCategory {
	public static function add($productID, $categoryID) {
		  DB::getInstance()->query("INSERT INTO productCategory (productID, categoryID) VALUES (" .$productID ."," .$categoryID  .")");
	}

	public static function delete($productID) {
		DB::getInstance()->query("DELETE FROM productCategory WHERE productID =(" .$productID   .")");
	}
}


class Product {
    public function __construct()
    {
    }

    public static  function add($name, $link_file, $description) {
        $query = "INSERT INTO product (name, link_image, description) VALUES ('".$name."' , '". $link_file. "', '".$description."' );";
        DB::getInstance()->query($query);

		  $result = mysql_fetch_array(DB::getInstance()->query("SELECT COUNT(*) as count FROM product;")	);
		  return (int) $result['count'];
    }

	public static function getListCategory() {
	 	 $result = DB::getInstance()->query("SELECT * FROM product;");
		 $lisView = "";
		 while($row = mysql_fetch_array($result)) {
		  if (!file_exists($row["link_image"])) $row["link_image"] = "images/default-no-image.png";
		 	$lisView .= " <li>";
		   $lisView .= ' <a href="productid.php?Product='.$row["productID"].'">';
		   $lisView .=    ' <img style=" border-style: solid;border-width: 1px;border-color: #989898 ;margin-left: 3px; margin-top: 3px;" width="70px" height="70px" src="'.$row["link_image"].'">';
		   $lisView .=    ' <h2>'.$row["name"].'</h2>';
		  	$lisView .=     ' <p>'.$row["description"].'</p>';
		   $lisView .=    ' </a>';
		 	$lisView .=     ' <a href="product.php?deleteProduct='.$row["productID"].'" data-transition="pop" data-icon="delete">Usuñ produkt</a>';
		 	$lisView .= '</li>';
        }

		  return $lisView;
	 }

	// public static function gets($array_list) {}

	 public static function getListCategoryFromArray($array_category) {
	 $str = implode(',', $array_category);
		$query = "";
		if ($array_category[0] == 0 ) {
			$query .= "select * FROM product;" ;
		} else {
	 		$query .= "select product.* , c.categoryID  from product join   (select  productCategory.productID, productCategory.categoryID FROM productCategory GROUP BY productCategory.productID) c on c.productID = product.productID where c.categoryID IN (".$str.")";
		}


	 	 $result = DB::getInstance()->query($query);
		 $lisView = "";
		 while($row = mysql_fetch_array($result)) {
		  if (!file_exists($row["link_image"])) $row["link_image"] = "images/default-no-image.png";
		 	$lisView .= " <li>";
		   $lisView .= ' <a href="product.php?Product='.$row["productID"].'">';
		   $lisView .=    ' <img style=" border-style: solid;border-width: 1px;border-color: #989898 ;margin-left: 3px; margin-top: 3px;" width="70px" height="70px" src="'.$row["link_image"].'">';
		   $lisView .=    ' <h2>'.$row["name"].'</h2>';
		  	$lisView .=     ' <p>'.$row["description"].'</p>';
		   $lisView .=    ' </a>';
		 	$lisView .=     ' <a href="product.php?deleteProduct='.$row["productID"].'" data-transition="pop" data-icon="delete">Usuñ produkt</a>';
		 	$lisView .= '</li>';
        }

		  return $lisView;

	 }

	public static function getFilePath($id) {
			  $row = mysql_fetch_array( DB::getInstance()->query("SELECT link_image FROM product WHERE productID = ".$id));
			  return  $row['link_image'];
	 }

	 public static function delete($id) {
		if (file_exists(Product::getFilePath($id))) { unlink(Product::getFilePath($id)) ; }
		DB::getInstance()->query("DELETE FROM product WHERE productID = ".$id);
	 }

	 public static function getProductFormCategory($categoryID) {
	 	$query = "select product.* , c.categoryID  from product join   (select  productcategory.productID, productcategory.categoryID FROM productcategory GROUP BY productcategory.productID) c on c.productID = product.productID where c.categoryID IN (".$categoryID.")";
		return DB::getInstance()->query($query);

	 }

}


class Category
{
    public function __construct(){

    }

    public static  function add($name, $link_file, $description) {
        $query = "INSERT INTO category (name, link_image,description ) VALUES ('".$name."' , '". $link_file. "', '".$description."');";
        DB::getInstance()->query($query);
    }

	 public static function getFilePath($id) {
			  $row = mysql_fetch_array( DB::getInstance()->query("SELECT link_image FROM category WHERE categoryID = ".$id));
			  return  $row['link_image'];
	 }

	 public static function delete($id) {
		if (file_exists(Category::getFilePath($id))) { unlink(Category::getFilePath($id)) ; }
		DB::getInstance()->query("DELETE FROM category WHERE categoryID = ".$id);
	 }

	 public static function getListCategory() {
	 	 $result = DB::getInstance()->query("SELECT * FROM category;");
		 $lisView = "";
		 while($row = mysql_fetch_array($result)) {
		  if (!file_exists($row["link_image"])) $row["link_image"] = "images/default-no-image.png";
		 	$lisView .= " <li>";
		   $lisView .= ' <a href="product.php?Category='.$row["categoryID"].'">';
		   $lisView .=    ' <img style=" border-style: solid;border-width: 1px;border-color: #989898 ;margin-left: 3px; margin-top: 3px;" width="70px" height="70px" src="'.$row["link_image"].'">';
		   $lisView .=    ' <h2>'.$row["name"].'</h2>';
		  	$lisView .=     ' <p>'.$row["description"].'</p>';
		   $lisView .=    ' </a>';
		 	$lisView .=     ' <a href="category.php?deleteCategory='.$row["categoryID"].'" data-transition="pop" data-icon="delete">Usuñ kategoriê</a>';
		 	$lisView .= '</li>';
        }

		  return $lisView;
	 }

	 public static function getComboCategory() {
	 	$result = DB::getInstance()->query("SELECT * FROM category;");
		$comboCategory = "";

       while($row = mysql_fetch_array($result)) {
				$comboCategory .= '<option value="'.$row["categoryID"].'">'.$row["name"].'</option>';
        }
		return $comboCategory;
	 }

    public static function getCategory() {
        $result = DB::getInstance()->query("SELECT * FROM category;");


       while($row = mysql_fetch_array($result)) {
            echo "id: " . $row["categoryID"]. "  Name: " . $row["name"]. "<br>";
        }

    }

    public static function getButtonCategory() {
        $result = DB::getInstance()->query("SELECT * FROM category;");
        $button = "";
        $scrypt = "";

        while($row = mysql_fetch_array($result)) {
          $button .= "<input type='checkbox' id='check_".$row["categoryID"]."'><label for='check_".$row["categoryID"] ."'>".$row["name"]."</label> ";
          $scrypt .= " $( '#check_".$row["categoryID"] ."' ).button(); \n";
        }

        echo "<script> $(function() {   ". $scrypt ."  }); </script>";
        echo $button;
    }

    public static function getTable() {
        $result = DB::getInstance()->query("SELECT * FROM category;");
        $table ="<table><tr><td>Lp.</td><td></td><td>Nazwa</td></tr>";
        while($row = mysql_fetch_array($result)) {
         $table .= "<tr><td>" .$row["categoryID"]  ."</td><td><a href='?index.php?page=Category&action=deleteCategory&categoryId=".$row["categoryID"]  ."'><img src='./images/delete.png' /></a></td><td>" .$row["name"] ."</td></tr>";
        }
        $table .= "</table>";

        return $table;
    }
}

?>