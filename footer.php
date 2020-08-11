<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Ayvo
 * @since 1.0
 * @version 1.0
 */
?>
<?php
$enable_back_to_top = Ayvo_Functions::get_option( 'enable_back_to_top', 0 );
?>
<?php if ( $enable_back_to_top == 1 ): ?>
    <a href="#" class="backtotop"><i class="fa fa-angle-up"></i></a>
<?php endif; 
if(is_page('store-locations')){ ?>
<script>
if (!('remove' in Element.prototype)) {
  Element.prototype.remove = function() {
    if (this.parentNode) {
      this.parentNode.removeChild(this);
    }
  };
}	
mapboxgl.accessToken = '';
// This adds the map to your page
var map = new mapboxgl.Map({
  // container id specified in the HTML
  container: 'map',
  // style URL
  style: 'mapbox://styles/shobra/cjuae2kz158wt1fqsnhfghweh',
  // initial position in [lon, lat] format
  center: [39.214066, 21.578402],
  // initial zoom
  zoom: 10
});
	

var stores = {
    "type": "FeatureCollection",
    "features": [
      {
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [
            39.214066,
            21.578402
          ]
        },
        "properties": {
          "phoneFormatted": "+966 12 271 0150",
          "phone": "+966 12 271 0150",
          "address": "Al Safa, Jeddah 23454, Saudi Arabia",
          "city": "Jeddah",
          "country": "Saudi Arabia",
          "crossStreet": "H6H7+9J Al Safa, Jeddah ",
          "postalCode": "23454",
          "state": "Saudi Arabia",
			"hour": "Opening Hours: <br>Everyday 9AM–12AM"
        }
      },
      {
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [
            39.206221,
            21.584727
          ]
        },
        "properties": {
          "phoneFormatted": "+966 12 271 0150",
          "phone": "+966 12 271 0150",
          "address": "7470 Jabal Satihah Gharb, As Safa District, Jeddah 23451 2761, Saudi Arabia",
          "city": "Jeddah",
          "country": "Saudi Arabia",
          "crossStreet": "7470 Jabal Satihah Gharb",
          "postalCode": "7470",
          "state": "Saudi Arab",
			"hour": "Opening Hours: <br>Everyday 9:30AM–12AM"
        }
      },
	{
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [
            39.185278,
            21.578342
          ]
        },
        "properties": {
          "phoneFormatted": "+966 12 691 3000",
          "phone": "+966 12 691 3000",
          "address": "Prince Saud Al Faisal, Al Faisaliyyah, Jeddah 23445, Saudi Arabia",
          "city": "Jeddah",
          "country": "United States",
          "crossStreet": "Prince Saud Al Faisal",
          "postalCode": "23445",
          "state": "Saudi Arabia",
			"hour": "Opening Hours: <br>Sat-Thu 9:30AM–2PM & 4PM–12AM <br>Friday 4PM - 1AM"
        }
      }]
    };
  // This adds the data to the map
  map.on('load', function (e) {
    // This is where your '.addLayer()' used to be, instead add only the source without styling a layer
    map.addSource("places", {
      "type": "geojson",
      "data": stores
    });
    // Initialize the list
    buildLocationList(stores);

  });

  // This is where your interactions with the symbol layer used to be
  // Now you have interactions with DOM markers instead
  stores.features.forEach(function(marker, i) {
    // Create an img element for the marker
    var el = document.createElement('div');
    el.id = "marker-" + i;
    el.className = 'marker';
    // Add markers to the map at all points
    new mapboxgl.Marker(el, {offset: [0, -23]})
        .setLngLat(marker.geometry.coordinates)
        .addTo(map);

    el.addEventListener('click', function(e){
        // 1. Fly to the point
        flyToStore(marker);

        // 2. Close all other popups and display popup for clicked store
        createPopUp(marker);

        // 3. Highlight listing in sidebar (and remove highlight for all other listings)
        var activeItem = document.getElementsByClassName('active');

        e.stopPropagation();
        if (activeItem[0]) {
           activeItem[0].classList.remove('active');
        }

        var listing = document.getElementById('listing-' + i);
        listing.classList.add('active');

    });
  });


  function flyToStore(currentFeature) {
    map.flyTo({
        center: currentFeature.geometry.coordinates,
        zoom: 12
      });
  }

  function createPopUp(currentFeature) {
    var popUps = document.getElementsByClassName('mapboxgl-popup');
    if (popUps[0]) popUps[0].remove();


    var popup = new mapboxgl.Popup({closeOnClick: false})
          .setLngLat(currentFeature.geometry.coordinates)
          .setHTML('<h3>Shobra Store</h3>' +
            '<h4>' + currentFeature.properties.address + '</h4>' +
            '<h4>' + currentFeature.properties.hour + '</h4>')
          .addTo(map);
  }


  function buildLocationList(data) {
    for (i = 0; i < data.features.length; i++) {
      var currentFeature = data.features[i];
      var prop = currentFeature.properties;

      var listings = document.getElementById('listings');
      var listing = listings.appendChild(document.createElement('div'));
      listing.className = 'item';
      listing.id = "listing-" + i;

      var link = listing.appendChild(document.createElement('a'));
      link.href = '#';
      link.className = 'title';
      link.dataPosition = i;
      link.innerHTML = prop.address;

      var details = listing.appendChild(document.createElement('div'));
      details.innerHTML = prop.city;
      if (prop.phone) {
        details.innerHTML += ' &middot; ' + prop.phoneFormatted;
      }



      link.addEventListener('click', function(e){
        // Update the currentFeature to the store associated with the clicked link
        var clickedListing = data.features[this.dataPosition];

        // 1. Fly to the point
        flyToStore(clickedListing);

        // 2. Close all other popups and display popup for clicked store
        createPopUp(clickedListing);

        // 3. Highlight listing in sidebar (and remove highlight for all other listings)
        var activeItem = document.getElementsByClassName('active');

        if (activeItem[0]) {
           activeItem[0].classList.remove('active');
        }
        this.parentNode.classList.add('active');

      });
    }
  }

</script>   

<?php } 
if(is_page('store-locations-2')){ ?>
<script>
if (!('remove' in Element.prototype)) {
  Element.prototype.remove = function() {
    if (this.parentNode) {
      this.parentNode.removeChild(this);
    }
  };
}	
mapboxgl.accessToken = '';
// This adds the map to your page
var map = new mapboxgl.Map({
  // container id specified in the HTML
  container: 'map',
  // style URL
  style: 'mapbox://styles/shobra/cjuae2kz158wt1fqsnhfghweh',
  // initial position in [lon, lat] format
  center: [39.214066, 21.578402],
  // initial zoom
  zoom: 10
});
	
var stores = {
    "type": "FeatureCollection",
    "features": [
      {
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [
            39.214066,
            21.578402
          ]
        },
        "properties": {
          "phoneFormatted": "+966 12 271 0150",
          "phone": "+966 12 271 0150",
          "address": "الصفا، جدة 23454",
          "city": "Jeddah",
          "country": "Saudi Arabia",
          "crossStreet": "H6H7+9J Al Safa, Jeddah ",
          "postalCode": "23454",
          "state": "Saudi Arabia",
			"hour": "Opening Hours: <br>Everyday 9AM–12AM"
        }
      },
      {
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [
            39.206221,
            21.584727
          ]
        },
        "properties": {
          "phoneFormatted": "+966 12 271 0150",
          "phone": "+966 12 271 0150",
          "address": "7470 جبل سطيحه غرب، حي الصفا، As Safa District, جدة 23451 2761",
          "city": "Jeddah",
          "country": "Saudi Arabia",
          "crossStreet": "7470 Jabal Satihah Gharb",
          "postalCode": "7470",
          "state": "Saudi Arab",
			"hour": "Opening Hours: <br>Everyday 9:30AM–12AM"
        }
      },
	{
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [
            39.185278,
            21.578342
          ]
        },
        "properties": {
          "phoneFormatted": "+966 12 691 3000",
          "phone": "+966 12 691 3000",
          "address": "سعود الفيصل، الفيصلية، جدة 23445",
          "city": "Jeddah",
          "country": "United States",
          "crossStreet": "سعود الفيصل، الفيصلية، جدة 23445",
          "postalCode": "23445",
          "state": "Saudi Arabia",
			"hour": "Opening Hours: <br>Sat-Thu 9:30AM–2PM & 4PM–12AM <br>Friday 4PM - 1AM"
        }
      }]
    };	

  // This adds the data to the map
  map.on('load', function (e) {
    // This is where your '.addLayer()' used to be, instead add only the source without styling a layer
    map.addSource("places", {
      "type": "geojson",
      "data": stores
    });
    // Initialize the list
    buildLocationList(stores);

  });

  // This is where your interactions with the symbol layer used to be
  // Now you have interactions with DOM markers instead
  stores.features.forEach(function(marker, i) {
    // Create an img element for the marker
    var el = document.createElement('div');
    el.id = "marker-" + i;
    el.className = 'marker';
    // Add markers to the map at all points
    new mapboxgl.Marker(el, {offset: [0, -23]})
        .setLngLat(marker.geometry.coordinates)
        .addTo(map);

    el.addEventListener('click', function(e){
        // 1. Fly to the point
        flyToStore(marker);

        // 2. Close all other popups and display popup for clicked store
        createPopUp(marker);

        // 3. Highlight listing in sidebar (and remove highlight for all other listings)
        var activeItem = document.getElementsByClassName('active');

        e.stopPropagation();
        if (activeItem[0]) {
           activeItem[0].classList.remove('active');
        }

        var listing = document.getElementById('listing-' + i);
        listing.classList.add('active');

    });
  });


  function flyToStore(currentFeature) {
    map.flyTo({
        center: currentFeature.geometry.coordinates,
        zoom: 12
      });
  }

  function createPopUp(currentFeature) {
    var popUps = document.getElementsByClassName('mapboxgl-popup');
    if (popUps[0]) popUps[0].remove();


    var popup = new mapboxgl.Popup({closeOnClick: false})
          .setLngLat(currentFeature.geometry.coordinates)
          .setHTML('<h3>شركة شبرا للملابس الجاهزة</h3>' +
            '<h4>' + currentFeature.properties.address + '</h4>' +
            '<h4>' + currentFeature.properties.hour + '</h4>')
          .addTo(map);
  }


  function buildLocationList(data) {
    for (i = 0; i < data.features.length; i++) {
      var currentFeature = data.features[i];
      var prop = currentFeature.properties;

      var listings = document.getElementById('listings');
      var listing = listings.appendChild(document.createElement('div'));
      listing.className = 'item';
      listing.id = "listing-" + i;

      var link = listing.appendChild(document.createElement('a'));
      link.href = '#';
      link.className = 'title';
      link.dataPosition = i;
      link.innerHTML = prop.address;

      var details = listing.appendChild(document.createElement('div'));
      details.innerHTML = prop.city;
      if (prop.phone) {
        details.innerHTML += ' &middot; ' + prop.phoneFormatted;
      }



      link.addEventListener('click', function(e){
        // Update the currentFeature to the store associated with the clicked link
        var clickedListing = data.features[this.dataPosition];

        // 1. Fly to the point
        flyToStore(clickedListing);

        // 2. Close all other popups and display popup for clicked store
        createPopUp(clickedListing);

        // 3. Highlight listing in sidebar (and remove highlight for all other listings)
        var activeItem = document.getElementsByClassName('active');

        if (activeItem[0]) {
           activeItem[0].classList.remove('active');
        }
        this.parentNode.classList.add('active');

      });
    }
  }

</script>   

<?php }
if(is_page('checkout') || is_page('checkout-2')){ ?>
 <script>
	 document.getElementById("map-location-target").addEventListener("click", geolocate);
	 
	  var autocomplete;
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13
    });
    var searchBox = document.getElementById('searchInput');
	var input = new google.maps.places.SearchBox('searchBox');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('searchInput'), {types: ['geocode']});;
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });
  var geocoder = new google.maps.Geocoder();

        document.getElementById('msubmit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
    
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
      
        //Location details
        //for (var i = 0; i < place.address_components.length; i++) {
           //  if(place.address_components[i].types[0] == 'postal_code'){
              //   document.getElementById('postal_code').value = place.address_components[i].long_name;
            // }
             //if(place.address_components[i].types[0] == 'locality'){
                // document.getElementById('billing_city').value = place.address_components[i].long_name;
            // }
			 //if(place.address_components[i].types[0] == 'administrative_area_level_1'){
                // document.getElementById('billing_state').value = place.address_components[i].long_name;
            // }
        // }
        document.getElementById('billing_address_1').value = place.formatted_address;
    });
	document.getElementById("map-location-target").addEventListener("click", function(){
	infoWindow = new google.maps.InfoWindow;

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      infoWindow.open(map);
      map.setCenter(pos);
		var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		  
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          "location": userLatLng
        },
        function(results, status) {
          if (status == google.maps.GeocoderStatus.OK)
            document.getElementById("billing_address_1").value = results[0].formatted_address;
         
        });
      

   
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
});
}
	 function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
 function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('searchInput').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initAutocomplete"
        async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initMap" async defer></script>
<?php }
?>
<?php wp_footer(); ?>
</body>
</html>

