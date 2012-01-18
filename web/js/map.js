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
              infowindow.setContent('<a href="' + stepSubmissionData[step].stepUrl + '">' + stepSubmissionData[step].title + "</a>");
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
        
    google.maps.event.addListener(map, 'click', function(event) {            
        singleClick = true;
        setTimeout(function(){runIfNotDblClick(event);}, 500);
    });
    
    google.maps.event.addListener(map, 'dblclick', function(event) {
        clearSingleClick();
    });
}

function runIfNotDblClick(event) {
    if(singleClick){
        placeMarker(event.latLng);
    }
}

function clearSingleClick(){
    singleClick = false;
};

singleClick = false;

function initializeEditMap(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    var myOptions = {
        zoom: 11,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        scrollwheel: false
    };
    map = new google.maps.Map(document.getElementById("map-canvas"),
        myOptions);
    placeMarker(latlng);
    markerPlaced = true;
    
    
    google.maps.event.addListener(map, 'click', function(event) {            
        singleClick = true;
        setTimeout(function(){runIfNotDblClick(event);}, 500);
    });
    
    google.maps.event.addListener(map, 'dblclick', function(event) {
        clearSingleClick();
    });
}


function placeMarker(location) {
    if(!markerPlaced)
    {
        submittedMarker = new google.maps.Marker({
            position: location, 
            map: map,
            draggable: true
        });
        
        google.maps.event.addListener(submittedMarker, "dragend", function() {
            $('#form_latitude').attr('value', submittedMarker.position.lat());
            $('#form_longitude').attr('value', submittedMarker.position.lng());
        });
        google.maps.event.addListener(submittedMarker, 'click', function(point, source, overlay) {
            submittedMarker.setMap(null);
            markerPlaced = false;
            $('#form_latitude').attr('value', '');
            $('#form_longitude').attr('value', '');            
        });

        $('#form_latitude').attr('value', location.lat());
        $('#form_longitude').attr('value', location.lng());
    }
    
    markerPlaced = true;
}