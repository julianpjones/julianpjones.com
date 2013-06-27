<?php /* Template name: Contact */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" role="main" class="site-content">

            <script type="text/javascript">
            function initialize() {

                var leeds = new google.maps.LatLng(47.626260, -122.356206);

                var firstLatlng = new google.maps.LatLng(47.626260, -122.356206);              

                var firstOptions = {
                    zoom: 15,
                    center: firstLatlng,
                    streetViewControl: false,
                    mapTypeControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: [
  {
    "featureType": "water",
    "stylers": [
      { "color": "#000000" }
    ]
  },{
    "featureType": "landscape.man_made",
    "stylers": [
      { "color": "#ffffff" }
    ]
  },{
    "featureType": "road.arterial",
    "elementType": "geometry.fill",
    "stylers": [
      { "color": "#000000" },
      { "weight": 0.4 }
    ]
  },{
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry",
    "stylers": [
      { "color": "#000000" },
      { "weight": 0.9 }
    ]
  },{
    "featureType": "transit",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "road.arterial",
    "elementType": "labels",
    "stylers": [
      { "visibility": "simplified" }
    ]
  },{
    "featureType": "road.local",
    "elementType": "geometry.stroke",
    "stylers": [
      { "color": "#c8c8c8" },
      { "visibility": "on" },
      { "lightness": 7 },
      { "weight": 0.7 }
    ]
  },{
    "featureType": "road.highway",
    "elementType": "geometry.fill",
    "stylers": [
      { "color": "#000000" },
      { "visibility": "on" },
      { "weight": 4.9 },
      { "lightness": -100 }
    ]
  },{
    "featureType": "road.highway",
    "elementType": "labels.text",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "poi",
    "stylers": [
      { "color": "#000000" },
      { "visibility": "simplified" },
      { "lightness": 83 }
    ]
  }
]
                };

                var map = new google.maps.Map(document.getElementById("map_leeds"), firstOptions);

                firstmarker = new google.maps.Marker({
                    map:map,
                    draggable:false,
                    animation: google.maps.Animation.DROP,
                    title: 'Your Client',
                    position: leeds
                });

                var contentString1 = '<p><b>Julian Jones</b><br>Queen Anne Ave N & Valley St<br>Seattle, WA 98109</p>';


                var infowindow1 = new google.maps.InfoWindow({
                    content: contentString1
                });

                google.maps.event.addListener(firstmarker, 'click', function() {
                    infowindow1.open(map,firstmarker);
                });

            }
            </script>

            <div class="map">

                <div id="map_leeds" style="width: 100%; height: 275px"></div>  

            </div>
            <?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
				<?php endwhile; // end of the loop. ?>
        </div> 
				
		</div>
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>