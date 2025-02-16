@extends('dashboard.layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('edit')</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{route('dashboard.states.update' , $state->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="name_ar" value="{{$state->name_ar}}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="name_en" value="{{$state->name_en}}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-9">
                                                        <input type="hidden" id="lat" class="form-control" name="lat" value="{{$state->lat}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-9">
                                                        <input type="hidden" id="lang" class="form-control" name="lng" value="{{$state->lng}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group" id="map" style="height: 250px"></div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" style="width: 100%" class="btn btn-primary mr-1">@lang('edit')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Horizontal form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    @push('scripts')
        <script>
            var map;
            var markers = [];

            function initMap() {
                var mapCenter = {
                    lat: {{$state->lat}},
                    lng: {{$state->lng}}
                };

                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: mapCenter,
                    mapTypeId: 'terrain'
                });
                geocoder = new google.maps.Geocoder();
                addMarker(mapCenter);
                // This event listener will call addMarker() when the map is clicked.
                map.addListener('click', function(event) {
                    addMarker(event.latLng);
                    var latitude = event.latLng.lat();
                    var longitude = event.latLng.lng();

                    $('#lat').val(latitude);
                    $('#lang').val(longitude);
                });

                // Adds a marker at the center of the map.
            }

            // Adds a marker to the map and push to the array.
            function addMarker(location) {
                clearMarkers();
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
                markers.push(marker);
            }

            // Sets the map on all markers in the array.
            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);
                }
            }

            // Removes the markers from the map, but keeps them in the array.
            function clearMarkers() {
                setMapOnAll(null);
            }

            // Shows any markers currently in the array.
            function showMarkers() {
                setMapOnAll(map);
            }

            // Deletes all markers in the array by removing references to them.
            function deleteMarkers() {
                clearMarkers();
                markers = [];
            }
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWr3ACfKVkWFBl9pAFhmunLHQtK0UjMVY&libraries=places&callback=initMap">
        </script>
    @endpush
@endsection
