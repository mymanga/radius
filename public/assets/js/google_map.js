// Access the latitude and longitude variables from the script tag's data attributes
var latitude = parseFloat(document.currentScript.dataset.latitude);
var longitude = parseFloat(document.currentScript.dataset.longitude);

// Initialize the map with the latitude and longitude
var map = new google.maps.Map(document.getElementById("map"), {
    center: {
        lat: latitude,
        lng: longitude
    },
    zoom: 16,
});

var locationLat = document.getElementById("location-lat");
var locationLng = document.getElementById("location-lng");
var locationInput = document.getElementById("location");

var autocomplete = new google.maps.places.Autocomplete(locationInput);
autocomplete.setFields(["geometry"]);

var marker = new google.maps.Marker({
    position: {
        lat: latitude,
        lng: longitude
    },
    map: map,
    draggable: true,
});

google.maps.event.addListener(marker, "dragend", function(event) {
    locationLat.value = event.latLng.lat();
    locationLng.value = event.latLng.lng();

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        location: marker.getPosition()
    }, function(results, status) {
        if (status === "OK") {
            if (results[0]) {
                let placeName = '';
                for (let i = 0; i < results[0].address_components.length; i++) {
                    const component = results[0].address_components[i];
                    if (component.types.includes('natural_feature') ||
                        component.types.includes('point_of_interest') ||
                        component.types.includes('park') ||
                        component.types.includes('airport') ||
                        component.types.includes('establishment') ||
                        component.types.includes('business') ||
                        component.types.includes('premise') ||
                        component.types.includes('subpremise') ||
                        component.types.includes('route') ||
                        component.types.includes('street_number') ||
                        component.types.includes('postal_town') ||
                        component.types.includes('locality') ||
                        component.types.includes('administrative_area_level_3') ||
                        component.types.includes('administrative_area_level_2') ||
                        component.types.includes('administrative_area_level_1')) {
                        placeName = component.long_name;
                        break;
                    }
                }
                locationInput.value = placeName;
            }
        }
    });
});

// Update the marker position based on the user's input
locationInput.addEventListener("input", function() {
    var place = autocomplete.getPlace();
    if (place && place.geometry) {
        var position = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng(),
        };
        marker.setPosition(position);
        map.panTo(position);
        map.setZoom(16); // set a custom zoom level
        locationLat.value = position.lat;
        locationLng.value = position.lng;
    }
});

// Update the marker position when a place is selected from the dropdown
autocomplete.addListener("place_changed", function() {
    var place = autocomplete.getPlace();
    if (place && place.geometry) {
        var position = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng(),
        };
        marker.setPosition(position);
        map.panTo(position);
        map.setZoom(16); // set a custom zoom level
        locationLat.value = position.lat;
        locationLng.value = position.lng;
    }
});