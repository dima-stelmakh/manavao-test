//jQuery(document).ready(function($) {

    var markers = {};
    var map;
    
    // Google Maps API
    //initMap();
    
    function updateCommunityList(country) {
        $.ajax({
            type: "GET",
            url: '/ajax-get-urban-areas/'+ country,
            success: function(data)
            {
                var areas = $('#community-area');
                areas
                    .find('option')
                    .remove()
                    .end()
                    .append('<option></option>')
                    .prop( "disabled", false )
                ;         

                $.each(data, function(key, value) { 
                areas
                    .append($("<option></option>")
                    .attr("value",value.name)
                    .text(value.name)); 
                });
            }
        });
    }

//load urbar area by country
    $( "#community-country" ).change(function() {
        var country = this.value;
        updateCommunityList(country);
    });

//load Communities by urbar area
    $( "#community-area" ).change(function() {
        var area = this.value;
        getCommunities(area);
    });
    
    //select communities new
    
    function selectCommunity(marker){
        
        checkMarker(marker);
        
        if (document.getElementById('selected-community-list')) {
        var selectedCommunityList = $("#selected-community-list");
        $("#selected-title").html(window.youAlreadySelected);
        
        $('<input>').attr({
            type: 'hidden',
            name: 'communities[]'
        }).val(marker.community.id).appendTo('#add-community-form');
        
        var element = $('<li data-community-id="'+ marker.community.id +'">').text(marker.community.name);
        selectedCommunityList.append(element);
        }
		
		$('#registration-communities-submit').removeAttr("disabled");
        
        if (document.getElementById('comm-list-editable')) {
            addComm(marker.community.id);
        }
        
    }

//delete community
    $("#selected-community-list").click(function(event) {
        var id=event.target.getAttribute('data-community-id');
        $(event.target).remove();

        $("input[name='communities[]'][value='"+id+"']").remove();
        $("#community-list li[data-community-id='"+id+"']").show('fast');
        
        
        marker = markers[id];
        uncheckMarker(marker);
        
    });
    
    function checkMarker(marker)
    {
        var image = '/assets/img/point3.png';
        marker.setIcon(image);
        marker.checked = 1;
        google.maps.event.clearListeners(marker, 'click');
        
    }
    
    function uncheckMarker(marker)
    {
        var image = '/assets/img/point2.png';
        marker.setIcon(image);
        marker.addListener('click', function() {
            selectCommunity(this);
        });
        marker.checked = 0;
    }
    
    function getCommunities(area)
    {
        $.ajax({
            type: "GET",
            url: '/ajax-get-communities-by-area/'+ area,
            success: function(data)
            {
                initialize(data);
                //showCommunities(data);
            }
        });
    }
    
    //Key Part Here!!! These should be cached somewhere rather than querying every page refresh like here though.
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: 43.605, lng: 1.445}
      });
      
      var address = document.getElementById('address').value;
      getCommunities(address);
//   var geocoder = new google.maps.Geocoder();
//      geocoder.geocode({'address': address}, function(results, status) {
//        if (status === google.maps.GeocoderStatus.OK) {
//          map.setCenter(results[0].geometry.location);
//          var marker = new google.maps.Marker({
//            map: map,
//            position: results[0].geometry.location
//          });
//        }
//      });
    }

    // Standard google maps function
    function initialize(data) {
        if (data && data.city && data.communities) {
            var myLatlng = new google.maps.LatLng(data.city.lat, data.city.lng);
            var myOptions = {
                zoom: 7,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map'), myOptions);            
            setMarkers(data.communities);
        }
    }

    // Function for adding a marker to the page.
    function addMarker(community) {
        
        var location = new google.maps.LatLng(community.lat, community.lng);
        
        if (community.enable)
            var image = '/assets/img/point2.png';
        else
            var image = '/assets/img/point2-1.png';
        
        marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: image,
            checked: 0,
            community: community
        });
        
        var savedMarker = markers[community.id];

        if (community.enable) {
            marker.addListener('click', function() {
                selectCommunity(this);
            });
        } else {
            marker.addListener('click', function() {
                alert("This community isn't enabled.");
            });
        }
      //  console.log(myCommIds);
      //  console.log(myCommIds.indexOf(community.id));
        if (savedMarker && savedMarker.checked === 1) {
            savedMarker.setMap(null);
            checkMarker(marker);
        } else if(window.myCommIds && myCommIds.indexOf(community.id) > 0) {
            //marker.setMap(null);
            checkMarker(marker);
        }
        

        markers[community.id] = marker;
    }

    // Testing the addMarker function
    function setMarkers(communities) {
        
        $.each(communities, function(key, value) {
           addMarker(value);
        });
    }

//});

jQuery(document).ready(function($) {
    $('#community-country').val('10');
    updateCommunityList('10');
});