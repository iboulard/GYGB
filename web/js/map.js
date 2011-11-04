var map;
var markerPlaced = false;
var submittedMarker;

function initializeCommunityMap() {
    var latlng = new google.maps.LatLng(42.457575, -76.501665);
    var myOptions = {
        zoom: 11,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        scrollwheel: false
    };
    map = new google.maps.Map(document.getElementById("map-canvas"),
        myOptions);
        
    for(var step in stepSubmissionData)
    {
        var story = stepSubmissionData[step].story;
        var latitude = stepSubmissionData[step].latitude;
        var longitude = stepSubmissionData[step].longitude;
        var markerLatLng = new google.maps.LatLng(latitude, longitude);
        
        var infowindow = new google.maps.InfoWindow();
        
        var marker = new google.maps.Marker({
            position: markerLatLng, 
            map: map
        });    

        google.maps.event.addListener(marker, 'click', (function(marker, step) {
            return function() {
              infowindow.setContent(stepSubmissionData[step].story);
              infowindow.open(map, marker);
            }
        })(marker, step));

    }
        

}

function initializeSubmissionMap() {
    var latlng = new google.maps.LatLng(42.457575, -76.501665);
    var myOptions = {
        zoom: 11,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        scrollwheel: false
    };
    map = new google.maps.Map(document.getElementById("map-canvas"),
        myOptions);
        
    google.maps.event.addListener(map, 'dblclick', function(event) {
    });
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
}

function placeMarker(location) {
    if(!markerPlaced)
    {
        submittedMarker = new google.maps.Marker({
            position: location, 
            map: map,
            title: "Test",
            draggable: true
        });
        google.maps.event.addListener(submittedMarker, "dragend", function() {
            $('#form_latitude').attr('value', submittedMarker.position.Na);
            $('#form_longitude').attr('value', submittedMarker.position.Oa);
        });
        
        $('#form_latitude').attr('value', location.Na);
        $('#form_longitude').attr('value', location.Oa);
    }
    
    markerPlaced = true;
}