<?php
include_once("class/class_login.php");
include_once('class/class_view.php');
include_once('class/class_db.php');

session_start();

$_SESSION["msg"] = "";
if (!isset($_SESSION['user'])) {
    $_SESSION["user"] = false;
}

if (isset($_POST['fullname']) && isset($_FILES["fileToUpload"]) && isset($_POST["description"]) && isset($_POST["category_add"])) {




    switch ($_FILES['fileToUpload']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $_SESSION['msg'] = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $_SESSION['msg'] = "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['msg'] = "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 999999999) {
        $_SESSION['msg'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['msg'] = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            //dodanie kategori do bazy danych
            $productID = Product::add($_POST['fullname'], $target_file, $_POST["description"]);

            $aCategory = $_POST['category_add'];
            $nCategory = count($_POST['category_add']);

            for ($i = 0; $i < $nCategory; $i++) {
                ProductCategory::add($productID, $aCategory[$i]);
            }
        } else {
            $_SESSION['msg'] = "Sorry, there was an error uploading your file.";
        }
    }
}

if (isset($_GET['deleteProduct'])) {
    Product::delete($_GET['deleteProduct']);
    ProductCategory::delete($_GET['deleteProduct']);
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
                    <style>
                        .message {
                            -webkit-border-radius: 50px;
                            -moz-border-radius: 50px;
                            border-radius: 50px;
                            background-color: #00BFFF;
                            padding-top: 8px;
                            padding-left: 15px; 
                            display: table;
                            height: 30px;
                            padding-right: 15px;
                        }
                    </style>

                    <div data-role="page" id="product_list">
                        <div data-role="header">
                            <a href="logout.php" data-icon="user">Wyloguj</a>

                            <h1>Produkty - lista</h1>
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
                            <?php if ($_SESSION['msg'] != "") echo '<div id="message" class="message">' . $_SESSION['msg'] . '</div>'; ?>  


                            <label for="category">Kategorie:</label>
                            <select name="category[]" id="category" multiple="multiple" data-native-menu="false">
                                <option>Kategorie</option>
                                <option value="0" >Wszystkie</option>
                                <?php
                                echo Category::getComboCategory();
                                ?>
                            </select>
                            <ul data-role="listview" data-inset="true" id="list_product">
                                <li data-role="divider">Lista produkt�w</li>

                                <?php
                                echo Product::getListCategory();
                                ?>
                            </ul>

                        </div>
                    </div>

                    <script>
                        
                            $("#category").bind("change", function (event, ui) {

                                list = document.getElementById("list_product");
                                if (list != null) {
                                    var value_list = new Array();
                                    $("select option:selected").each(function () {
                                        value_list.push($(this).val());
                                    });

                                    console.log(value_list);
                                    $.post("filtrProduct.php", {value_array: (value_list)}, function (result) {
                                        $("#list_product").html(result);
                                        $("#list_product").listview("refresh");
                                        console.log(result);
                                    });

                                }
                            });
                        
                    </script>


                </body>
                </html>