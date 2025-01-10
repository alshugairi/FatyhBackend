@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.settings') }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('admin.partial.settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <form action="{{ route('admin.settings.map.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.map') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.map') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @php
                                        $longitude = $settings->where('key', 'map_longitude')->first()?->value;
                                        $latitude = $settings->where('key', 'map_latitude')->first()?->value;
                                    @endphp
                                    <x-form.input col="col-md-6" name="map_longitude" key="longitude" labelName="{{ trans('admin.longitude') }}" value="{{ $longitude }}"/>
                                    <x-form.input col="col-md-6" name="map_latitude" key="latitude" labelName="{{ trans('admin.latitude') }}" value="{{ $latitude }}"/>
                                    <x-form.input col="col-md-6" name="map_google_map_key" labelName="{{ trans('admin.google_map_key') }}" value="{{ $settings->where('key', 'map_google_map_key')->first()?->value }}"/>
                                    <x-form.select col="col-md-6" name="map_visible" required="true" :options="[1 => __('admin.yes'), 0 => __('admin.no')]" labelName="{{ trans('admin.map_visible_on_website') }}" value="{{ $settings->where('key', 'map_visible')->first()?->value }}"/>
                                </div>
                                <x-form.input col="col-md-12" name="map_address" key="mapAddressInput" labelName="{{ trans('admin.address') }}" value="{{ $settings->where('key', 'map_address')->first()?->value }}"/>
                                <div id="map" style="height: 500px;"></div>
                                <button type="button" id="setCurrentPosition" class="btn btn-primary mt-3">{{ __('admin.set_current_position') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ get_setting('map_google_map_key') }}&libraries=places"></script>
    <script>
        function initMap() {
            var initialLocation = { lat: parseFloat("{{ $latitude }}"), lng: parseFloat("{{ $longitude }}") };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: initialLocation,
                zoom: 17
            });

            var marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                draggable: true
            });

            var inputLatitude = document.querySelector('input[name="map_latitude"]');
            var inputLongitude = document.querySelector('input[name="map_longitude"]');
            var inputAddress = document.getElementById('mapAddressInput');

            // Update lat, lng, and address on marker drag
            marker.addListener('dragend', function(event) {
                var newPosition = event.latLng;
                inputLatitude.value = newPosition.lat();
                inputLongitude.value = newPosition.lng();
                reverseGeocode(newPosition, inputAddress);
            });

            // Initialize autocomplete for address input
            var autocomplete = new google.maps.places.Autocomplete(inputAddress);
            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    console.log("Autocomplete's returned place contains no geometry");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                inputLatitude.value = place.geometry.location.lat();
                inputLongitude.value = place.geometry.location.lng();
            });

            // Reverse geocoding function
            function reverseGeocode(latlng, inputAddress) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'location': latlng }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        inputAddress.value = results[0].formatted_address;
                    } else {
                        console.log('Geocoder failed due to: ' + status);
                    }
                });
            }

            document.getElementById('setCurrentPosition').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            var currentLocation = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };

                            map.setCenter(currentLocation);
                            marker.setPosition(currentLocation);

                            inputLatitude.value = currentLocation.lat;
                            inputLongitude.value = currentLocation.lng;

                            reverseGeocode(currentLocation, inputAddress);
                        },
                        function(error) {
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    alert("Location access denied by user.");
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    alert("Location information is unavailable.");
                                    break;
                                case error.TIMEOUT:
                                    alert("The request to get user location timed out.");
                                    break;
                                default:
                                    alert("An unknown error occurred.");
                                    break;
                            }
                        }
                    );
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });

        }

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
@endpush


