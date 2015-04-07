<?php
include_once("class/class_login.php");
include_once('class/class_view.php');
include_once('class/class_db.php');

session_start();
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
                <script src="tools.js" ></script>

                <script type="text/javascript"
                        src="https://maps.googleapis.com/maps/api/js?sensor=false">
                </script>

                <script type="text/javascript">
                    var map;
                    var geocoder;
                    var address = <?php echo '"' .$_GET['address'] .'";'; ?>
                    var lat = 52.173931692568;
                    var lng = 18.8525390625;
                    var zoom = 15;

                    function initialize() { 
                        geocoder = new google.maps.Geocoder();
                        var myOptions = {
                            zoom: zoom,
                            center: new google.maps.LatLng(lat, lng),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        map = new google.maps.Map(document.getElementById('moja-mapa'), myOptions);
                        
                        codeAdress();
                    }
                    
                    function codeAdress() {
                        
                        geocoder.geocode( { 'address': address}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                          map.setCenter(results[0].geometry.location);
                          var marker = new google.maps.Marker({
                              map: map,
                              position: results[0].geometry.location
                          });
                        } else {
                          alert('Geocode was not successful for the following reason: ' + status);
                        }
                      });

                    }

                    google.maps.event.addDomListener(window, 'load', initialize);
                </script>

                </head>

                </head>
                <body>


                    <div data-role="page" id="maps_firma">
                        <div data-role="header">
                            <?php
                            if ($_SESSION["user"] == false) {
                                echo '<a href="login.php" data-icon="user">Zaloguj</a>';
                            } else {
                                echo '<a href="logout.php" data-icon="user">Wyloguj</a>';
                            }
                            ?>
                            <h1>Mapa</h1>
                        </div>
                        <?php
                        if ($_SESSION["user"] != false) {
                            echo View::getInstance()->getNavigationBars($_SESSION["user"]->getRole());
                        }
                        ?>

                        <div data-role="main" class="ui-content">

                        <div id="moja-mapa" style="width: 640px; height: 480px;"></div>

                        </div>
                    </div>




                </body>
                </html>