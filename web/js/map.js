function loadMap() {
  var map = new google.maps.Map(document.getElementById('mnv-mapBlock-map'), {
    zoom: 9,
    center: {lat: 43.605, lng: 1.445}
  });
  var url = "https://opendata.datainfogreffe.fr/api/records/1.0/search/?dataset=societes-immatriculees-2018&rows=1000&sort=date_immatriculation&facet=siren&facet=code_ape&facet=region&facet=greffe&facet=date_immatriculation&facet=statut";
  fetch(url).then(function(response) {
    return response.json();
  }).then(function(data) {
    data.records.forEach(element => {
      if (element.geometry !== undefined) {
        var coord = element.geometry.coordinates;
        var marker = new google.maps.Marker({
          map: map,
          position: {lat: coord[1], lng: coord[0]}
        });
        marker.setIcon('/assets/img/point-datainfogreffe.png');
      }
    });
  });
}

function initMap() {
  var mapId = document.getElementById('map');
  if (mapId) {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: {lat: 43.605, lng: 1.445}
    });

    var address = document.getElementById('address').value;
    getCommunities(address);
  }
}

$(document).ready(function() {
  initMap();
  $('#mnv-map').click(function() {
    var mapBlock = document.getElementById('mnv-mapBlock');
    if (mapBlock.classList.contains('hide')) {
      mapBlock.classList.remove('hide');
      loadMap();
    } else {
      mapBlock.classList.add('hide');
    }
  });
});

 function initMiniMap(geocoder) {
  var map = new google.maps.Map(document.getElementById('map-mini'), {
    zoom: 8,
    center: {lat: 43.605, lng: 1.445}
  });


  geocodeAddress(geocoder, map, 0);
}

// function initMap() {
//  var map = new google.maps.Map(document.getElementById('map'), {
//    zoom: 8,
//    center: {lat: 43.605, lng: 1.445}
//  });
//
//
//  var marker = geocodeAddress(geocoder, map, 0);
//
//  map.addListener('click', function(e) {
//    placeMarkerAndPanTo(e.latLng, eventMap);
//  });
//
//  $("#map").on( "resize", function() {
//    $(window).resize(function() {
//         google.maps.event.trigger(map, 'resize');
//    });
//    google.maps.event.trigger(map, 'resize');
//    map.panTo(marker.position);
//  });
//
//}

 function initEventMap(geocoder) {
  // event map
 var eventMap = new google.maps.Map(document.getElementById('map-event'), {
    zoom: 8,
    center: {lat: 43.605, lng: 1.445}
  });

  geocodeAddress(geocoder, eventMap, 1);

  eventMap.addListener('click', function(e) {
    placeMarkerAndPanTo(e.latLng, eventMap);
  });

  $("#map-event").on( "resize", function() {
    $(window).resize(function() {
         google.maps.event.trigger(eventMap, 'resize');
    });
    google.maps.event.trigger(eventMap, 'resize');
    eventMap.panTo(EventMarker.position);
  });
}

 function initEventPostMap(geocoder) {

  $('.event-post-map').each(function(e) {
    console.log(this);
    var myLatLng = {lat: $(this).data('lat')*1, lng: $(this).data('lng')*1 };

    var map = new google.maps.Map(this, {
    zoom: 8,
    center: myLatLng
    });

    var marker = new google.maps.Marker({
      map: map,
      position: myLatLng
    });

  });
}


function placeMarkerAndPanTo(latLng, map) {
    if (EventMarker) {
        EventMarker.setMap(null);
    }

    EventMarker = new google.maps.Marker({
    position: latLng,
    map: map
  });
  document.getElementById('event-lat-input').value = latLng.lat();
  document.getElementById('event-lng-input').value = latLng.lng();
  map.panTo(latLng);
}

function geocodeAddress(geocoder, resultsMap, event) {
  var address = document.getElementById('address').value;
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      resultsMap.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: resultsMap,
        position: results[0].geometry.location
      });
      if (event) {
        EventMarker = marker;
        document.getElementById('event-lat-input').value = results[0].geometry.location.lat();
        document.getElementById('event-lng-input').value = results[0].geometry.location.lng();
      }
    } else {
      console.log('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function loadData(data) {
  var url = "http://api.dila.fr/opendata/api-boamp/annonces/search?criterion=" + data;

  var headers = new Headers();
  headers.append('Accept', 'application/json');
  var init = { method: 'GET', headers: headers, mode: 'no-cors' };

  fetch(url, init).then(function(response) {
    return response;
  }).then(function(data) {
    // if (data.nbItemsRetournes > 0) {
      document.getElementById('mnv-directory-nbresults').innerText = '2 résultats trouvés.';
    // }
    // data.item.forEach(element => {
      var p = document.createElement("p");
      p.innerHTML = "<a href=\"\">Réalisation d'une oeuvre artistique pour le futur centre culturel Alban Minville dans le cadre du \"1% artistique\" à Toulouse.</a>";
      document.getElementById('mnv-directory-results').append(p);
      var p = document.createElement("p");
      p.innerHTML = "<a href=\"\">Fourniture d'un système d'analyse modale expérimentale, pour l'Ecole Nationale Supérieure d'Ingénieurs de Constructions Aéronautique, à Toulouse.</a>";
      document.getElementById('mnv-directory-results').append(p);
    // });
  });
}

jQuery(document).ready(function($) {

    var EventMarker = false;
    var geocoder = new google.maps.Geocoder();
    //initMap();
    initMiniMap(geocoder);
    //initEventMap(geocoder);
    //initEventPostMap(geocoder);
    if (document.getElementById('mnv-load-directory')) {
      new Vue({
        el: '#mnv-load-directory',
        methods: {
          loadDirectory: function(component)
          {
            document.getElementById('mnv-directory-nbresults').innerText = '';
            document.getElementById('mnv-directory-results').innerText = '';
            var md = document.getElementById('mnv-directory');
            md.classList.remove('hide');
            var mc = document.getElementById('mnv-community');
            mc.classList.add('hide');
            document.querySelector('.mnv-directory-title').innerText = 'Services : ' + component;
          }
        }
      });

      document.getElementById('mnv-directory-search').addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('mnv-directory-nbresults').innerText = '';
        document.getElementById('mnv-directory-results').innerText = '';
        var data = document.getElementById('mnv-directory-search-input').value;
        if (data.length > 0) {
          loadData(data);
        }
      });
    }

});
