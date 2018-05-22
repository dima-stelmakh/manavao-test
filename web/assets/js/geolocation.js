window.placeInfo = [];
function init() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            setLocationData(position.coords.latitude, position.coords.longitude);
        }, function() {
            getPositionByIp();
        });
    } else {
        getPositionByIp();
    }
}

function getPositionByIp(){
    jQuery.get( getipajax, function( data ) {
        if(data.lat && data.lng) {
            setLocationData(data.lat, data.lng);
        }
    }, "json");
}

function setLocationData(lat, lng){
    var pyrmont = {
        lat: lat,
        lng: lng
    };
    var request = {
        location: pyrmont,
        radius: '500'
    };
    var el = $('#map').get(0);
    var service = new google.maps.places.PlacesService(el);
    service.nearbySearch(request, function(results, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            console.debug(results);
            if(results[0].photos){
                window.placeInfo['src'] = results[0].photos[0].getUrl({'maxWidth': 1600, 'maxHeight': 1600});
            }
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'location': pyrmont}, function(results, status) {
                var city = '';
                if(window.placeInfo['src'] != undefined){
                    for (var i in results) {
                        if(($.inArray( "locality", results[i].types ) != -1) &&
                            ($.inArray( "political", results[i].types ) != -1)) {
                            city = results[i].address_components[0].long_name;
                        }
                    }
                    $('#header input[name="city"]').val(city);
                    // $('body.mnv-homeBlock #header').css('background-image', 'url("'+window.placeInfo['src']+'")');
                }else{

                }
            });

        }
    });
}