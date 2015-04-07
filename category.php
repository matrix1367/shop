<?php
include_once("class/class_login.php");
include_once('class/class_view.php');
include_once('class/class_db.php');

session_start();


if (!isset($_SESSION['user'])) {
    $_SESSION["user"] = false;
}

if (isset($_POST['fullname']) && isset($_FILES["fileToUpload"]) && isset($_POST["description"])) {


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
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 999999999) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            //dodanie kategori do bazy danych
            Category::add($_POST['fullname'], $target_file, $_POST["description"]);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

if (isset($_GET['deleteCategory'])) {
    Category::delete($_GET['deleteCategory']);
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

                    <div data-role="page" id="category_list">
                        <div data-role="header">
                            <a href="logout.php" data-icon="user">Wyloguj</a>

                            <h1>Kategorie - lista</h1>
                        </div>
<?php
if ($_SESSION["user"] != false) 
{
    echo View::getInstance()->getNavigationBars($_SESSION["user"]->getRole());
}
?>
                        <div data-role="navbar"><ul>
                                <li><a href="category_add.php">Dodaj</a></li>
                                <li><a href="category.php">Lista</a></li>
                            </ul></div>
                        <div data-role="main" class="ui-content">

                            <ul data-role="listview" data-inset="true">
                                <li data-role="divider">Kategorie produktów</li>

<?php
echo Category::getListCategory();
?>
                            </ul>

                        </div>
                    </div>





                </body>
                </html>