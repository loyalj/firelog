<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	    <title>Now That's a Fire!!</title>
        <link href="/r/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/r/fd/css/fd.css" rel="stylesheet" media="screen">
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/r/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALHnfhuJ8ehvKJbz91JI_uKbgL0z6d6f0&sensor=false"></script>
        <script type="text/javascript">
          $(document).ready(function () {
            var mapOptions = {
              center: new google.maps.LatLng(43.667, -79.420),
              zoom: 11,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            
            var map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
        });
      </script>
    </head>

    <body>
        <div class="container-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <a class="brand" href="/">Fire Log</a>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <?= $sidebarContent; ?>
                </div>
                <div class="span10">
                    <?= $docContent; ?>
                </div>
            </div>
        </div>
    </body>
</html>
