<?php
include_once("class/class_login.php");
include_once('class/class_view.php');
include_once('class/class_db.php');

session_start();


if (!isset($_SESSION['user'])) {
    $_SESSION["user"] = false;
}
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


                    <div data-role="page" id="productID">
                        <div data-role="header">
                            <a href="logout.php" data-icon="user">Wyloguj</a>

                            <h1>Produkt</h1>
                        </div>
                        <?php
                        if ($_SESSION["user"] != false) {
                            echo View::getInstance()->getNavigationBars($_SESSION["user"]->getRole());
                        }
                        ?>
                        <div data-role="navbar"><ul>
                                <li><a href="product_add.php">Dodaj</a></li>
                                <li><a href="product.php">Lista</a></li>
                            </ul></div>
                        <div data-role="main" class="ui-content">
                            <div>
                                <?php
                                echo '		 <a href="product_edit.php?Product=' . $_GET['Product'] . '" class="ui-btn">Edytuj</a>'
                                ?>
                            </div>
                            <?php
                            if (isset($_GET['Product'])) {
                                echo View::getInstance()->viewProduct($_GET['Product']);
                            }
                            ?>
                        </div>
                    </div>



                </body>
                </html>