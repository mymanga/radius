  var initialLatitude = parseFloat(document.currentScript.getAttribute("data-latitude"));
  var initialLongitude = parseFloat(document.currentScript.getAttribute("data-longitude"));

  var mymap = L.map('map').setView([initialLatitude, initialLongitude], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(mymap);

  // Add a draggable marker
  var marker = L.marker([initialLatitude, initialLongitude], {
    draggable: true
  }).addTo(mymap);

  // Add an event listener to update the hidden fields when the marker is dragged
  marker.on('dragend', function (e) {
    document.getElementById('location-lat').value = e.target.getLatLng().lat;
    document.getElementById('location-lng').value = e.target.getLatLng().lng;
  });

  var searchControl = L.Control.geocoder({
    geocoder: L.Control.Geocoder.nominatim(),
    defaultMarkGeocode: false, // Disable the default marker added by geocoder
  })
    .on('markgeocode', function (e) {
      // Move the draggable marker to the geocoded location
      marker.setLatLng(e.geocode.center);

      // Set the zoom level for a specific search
      mymap.setView(e.geocode.center, 13); // Adjust the zoom level as needed

      // Update the latitude and longitude inputs
      document.getElementById('location-lat').value = e.geocode.center.lat;
      document.getElementById('location-lng').value = e.geocode.center.lng;

      // Make the marker draggable again after searching
      marker.dragging.enable();
    })
    .addTo(mymap);

  // Check if latitude and longitude are not set or zero, then attempt to get the user's location
  if (!initialLatitude || !initialLongitude) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        var userLocation = [position.coords.latitude, position.coords.longitude];

        // Set the map view to the user's location
        mymap.setView(userLocation, 13);

        // Move the draggable marker to the user's location
        marker.setLatLng(userLocation);

        // Update the latitude and longitude inputs
        document.getElementById('location-lat').value = userLocation[0];
        document.getElementById('location-lng').value = userLocation[1];
      },
      function (error) {
        console.error(error.message);
      }
    );
  }

  // Add an event listener to update the hidden fields when the map is clicked
  mymap.on('click', function (e) {
    // Move the draggable marker to the clicked location
    marker.setLatLng(e.latlng);
    document.getElementById('location-lat').value = e.latlng.lat;
    document.getElementById('location-lng').value = e.latlng.lng;
  });
