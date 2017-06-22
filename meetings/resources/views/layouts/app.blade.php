<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Meetings') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Meetings') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right valign-wrapper">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li style="color: #5e5d5d; font-size: 14px;">
                                <span class="right" style="padding-top: 8px;"><i class="fa fa-user-circle"></i> {{ $user['first_name'] }}</span>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
//        function initMap() {
//
//            var map = new google.maps.Map(document.getElementById('map'), {
//                center: {lat: 44.012122, lng: -92.480199},
//                zoom: 13
//            });
//
//
//            var input = document.getElementById('pac-input');
//
//            var autocomplete = new google.maps.places.Autocomplete(input);
//            autocomplete.bindTo('bounds', map);
//
//            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
//
//            var infowindow = new google.maps.InfoWindow();
//            var infowindowContent = document.getElementById('infowindow-content');
//            infowindow.setContent(infowindowContent);
//            var marker = new google.maps.Marker({
//                map: map
//            });
//            marker.addListener('click', function() {
//                infowindow.open(map, marker);
//            });
//
//            autocomplete.addListener('place_changed', function() {
//                infowindow.close();
//                var place = autocomplete.getPlace();
//                if (!place.geometry) {
//                    return;
//                }
//
//                if (place.geometry.viewport) {
//                    map.fitBounds(place.geometry.viewport);
//                } else {
//                    map.setCenter(place.geometry.location);
//                    map.setZoom(17);
//                }
//
//                // Set the position of the marker using the place ID and location.
//                marker.setPlace({
//                    placeId: place.place_id,
//                    location: place.geometry.location
//                });
//                marker.setVisible(true);
//
//                infowindowContent.children['place-name'].textContent = place.name;
//                infowindowContent.children['place-id'].textContent = place.place_id;
//                infowindowContent.children['place-address'].textContent =
//                        place.formatted_address;
//                infowindow.open(map, marker);
//            });
//
//
//            var geocoder = new google.maps.Geocoder;
//            var infowindow = new google.maps.InfoWindow;
//
//            if(document.getElementById('place-id2'))
//            {
//            window.addEventListener('load', function() {
//                geocodePlaceId(geocoder, map, infowindow);
//            });
//            }
//        }
//

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -33.8688, lng: 151.2195},
        zoom: 13
    });

    var input = document.getElementById('pac-input');

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
        map: map
    });
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();

        console.log(place);
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        // Set the position of the marker using the place ID and location.
        marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location
        });
        marker.setVisible(true);

        infowindowContent.children['place-name'].textContent = place.name;

        if (document.getElementById('place-id2')){
            infowindowContent.children['place-id2'].textContent = place.place_id;
            document.getElementById('newplace').value = place.place_id;
        }else{

            infowindowContent.children['place-id'].textContent = place.place_id;
        }
       // infowindowContent.children['test'].textContent = place.place_id;

        infowindowContent.children['place-address'].textContent = place.formatted_address;
        infowindow.open(map, marker);

    });
    window.addEventListener('load', function() {
        if (document.getElementById('place-id2')){
            if (document.getElementById('place-id2').value) {
                // infowindowContent.children['place-id2'].textContent = place.place_id;
                var geocoder = new google.maps.Geocoder;
                var infowindow = new google.maps.InfoWindow;

                geocodePlaceId(geocoder, map, infowindow);

            }
    }
    });





}

        function geocodeLatLng(geocoder, map, infowindow) {
            var input = document.getElementById('latlng').value;
            var latlngStr = input.split(',', 2);
            var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[1]) {
                        map.setZoom(11);
                        var marker = new google.maps.Marker({
                            position: latlng,
                            map: map
                        });
                        infowindow.setContent(results[1].formatted_address);
                        infowindow.open(map, marker);
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }


        function geocodePlaceId(geocoder, map, infowindow) {

            if(document.getElementById('place-id2').value != "")
            {
                var placeId = document.getElementById('place-id2').value;
            }
            var placeId = document.getElementById('place-id').value;
            geocoder.geocode({'placeId': placeId}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        map.setZoom(11);
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }



    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApLD4SYV2l1nSmOaSYJ-Mhzyh1kQASm_Q&libraries=places&callback=initMap"></script>

</body>
</html>
