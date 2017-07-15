<?php
include("application/views/head.php");
include("application/views/header.php");
//$this->lang->load('main', $current_lang);
?>

    <!-- START MAIN-SECTION- -->

    <div class="main-wrapper">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="beadcrums">
                        <?php showBreadCrumbs(); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title"><?= $page['name'] ?></h1>
                </div>
            </div>

            <?=$page['content']?>

            <div class="row">
                <div class="col-md-12">
                    <div class="content-block map">
                        <div id="map_canvas" style="width:100%; height:600px">
                            <div id="googleMap" style="width:100%; height:600px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key= AIzaSyC7BqBx0IkXvuh4pdifpGhOXjRkhLwMm-8&sensor=false&region=UA"></script>
<script type="text/javascript">
    //<![CDATA[

    var map; // Global declaration of the map
    var lat_longs_map = new Array();
    var markers_map = new Array();
    var iw_map;

    iw_map = new google.maps.InfoWindow();

    function initialize_map() {

        var myLatlng = new google.maps.LatLng(46.4811305, 30.7452734);
        var myOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false}
        map = new google.maps.Map(document.getElementById("googleMap"), myOptions);

        var myLatlng = new google.maps.LatLng(46.4811305, 30.7452734);

        var marker_icon = {
            url: "/img/site/map-icon.png"};

        var markerOptions = {
            map: map,
            position: myLatlng,
            icon: marker_icon,
            animation:  google.maps.Animation.DROP
        };
        marker_0 = createMarker_map(markerOptions);

        marker_0.set("content", "<b>Морской бизнес центр</b><br />корпус №1<br />Бунина, 10");

        google.maps.event.addListener(marker_0, "click", function(event) {
            iw_map.setContent(this.get("content"));
            iw_map.open(map, this);

        });

        var myLatlng = new google.maps.LatLng(46.481803, 30.7455798);

        var marker_icon = {
            url: "/img/site/map-icon.png"};

        var markerOptions = {
            map: map,
            position: myLatlng,
            icon: marker_icon,
            animation:  google.maps.Animation.DROP
        };
        marker_1 = createMarker_map(markerOptions);

        marker_1.set("content", "<b>Морской бизнес центр</b><br />корпус №2<br />Польский спуск, 11");

        google.maps.event.addListener(marker_1, "click", function(event) {
            iw_map.setContent(this.get("content"));
            iw_map.open(map, this);

        });

        var myLatlng = new google.maps.LatLng(46.481393, 30.745537);

        var marker_icon = {
            url: "/img/site/map-icon.png"};

        var markerOptions = {
            map: map,
            position: myLatlng,
            icon: marker_icon,
            animation:  google.maps.Animation.DROP
        };
        marker_2 = createMarker_map(markerOptions);

        marker_2.set("content", "<b>Морской бизнес центр</b><br />корпус №4<br />Польский спуск, 13");

        google.maps.event.addListener(marker_2, "click", function(event) {
            iw_map.setContent(this.get("content"));
            iw_map.open(map, this);

        });


        fitMapToBounds_map();


    }


    function createMarker_map(markerOptions) {
        var marker = new google.maps.Marker(markerOptions);
        markers_map.push(marker);
        lat_longs_map.push(marker.getPosition());
        return marker;
    }

    function fitMapToBounds_map() {
        var bounds = new google.maps.LatLngBounds();
        if (lat_longs_map.length>0) {
            for (var i=0; i<lat_longs_map.length; i++) {
                bounds.extend(lat_longs_map[i]);
            }
            map.fitBounds(bounds);
        }
    }

    google.maps.event.addDomListener(window, "load", initialize_map);

    //]]>
</script>

<?php include("application/views/footer.php"); ?>
