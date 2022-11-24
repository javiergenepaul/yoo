@extends('layouts.layout_management')

@section('title', 'Shop List Page')

@push('css')
    <style>
        .pagination .page-item .page-link {
            color: #8C27FF;
        }

        .pagination .page-item.active .page-link {
            color: white;
            background-color: #8C27FF;
            border-color: #8C27FF;
        }

        div.dataTables_wrapper div.dataTables_paginate ul.pagination .page-item.active .page-link:focus {
            color: white;
            background-color: #8C27FF;
        }

        .pagination .page-item.active .page-link:hover {
            background-color: #8C27FF;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }

        .nav>li>a:focus,
        .nav>li>a:hover {
            color: #8C27FF;
        }

        .nav-tabs>li>a {
            color: #8C27FF;
        }

        #map {
            height: 300px;
            width: 100%;
        }

        .pac-container {
            background-color: #FFF;
            z-index: 20;
            position: fixed;
            display: inline-block;
            float: left;
        }

        .modal {
            z-index: 20;
        }

        .modal-backdrop {
            z-index: 10;
        }

        .accordion-button:not(.collapsed) {
            color: black;
            background-color: rgba(255, 255, 255, 13%);
        }

        .accordion-button:(.collapsed) {
            color: rgb(255, 0, 0);
            background-color: rgba(255, 255, 255, 13%);
        }

        .accordion-button:focus {
            z-index: 3;
            border-color: white;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 0%);
            box-shadow: inset 0 -1px 0 rgb(0 0 0 / 13%);
        }

        .accordion-item {
            background-color: rgba(255, 255, 255, 0);
            border: 1px solid rgba(255, 255, 255, 0);
        }

        .accordion-button {
            background-color: rgba(255, 255, 255, 0);
            box-shadow: inset 0 -1px 0 rgb(0 0 0 / 13%);
        }

        .accordion-button:after {
            background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23859488'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important;
        }

        .shop-type-header {
            color: #555e58;
            font-size: 24px
        }

        .dt-buttons {
            margin-top: 24px;
        }

        .dataTables_filter {
            margin-top: 24px;
        }

        #table-view {
            display: none;
        }

        #grid-view {
            display: none;
        }

        #custom-days {
            display: none;
        }

        .link-primary:hover {
            color: red;
            text-decoration: none;
            -webkit-transition: all .5s ease;
            -moz-transition: all .5s ease;
            transition: all .5s ease;
        }

        .form-switch .form-check-input {
            height: 20px;
            width: 40px;
        }

        .form-switch .form-check-input:focus {
            border-color: rgba(0, 0, 0, 0.25);
            outline: 0;
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }

        .form-switch .form-check-input:checked {
            background-color: #8C27FF;
            border: none;
        }

        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }

        #clear-address {
            display: none;
            top: 18px;
            right: 5px;
            background-color: #E9ECEF;
        }

        .edit-btn {
            cursor: pointer;
        }

        .edit-shop-image-preview {
            width: 100%;
            height: 400px;
        }

    </style>
@endpush

@push('modal')
    <div class="modal fade" id="add-shop-modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-shop-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="place_id" id="place_id">
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lng" id="lng">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="search_input" name="address" placeholder=" ">
                            <label for="search_input">Address</label>
                            <button id="clear-address" type="button"
                                class="btn-close position-absolute close-btn"></button>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder=" ">
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="shop_code" id="shop_code" placeholder=" ">
                            <label for="name">Shop Code</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="shop_type_id" name="shop_type_id"
                                aria-label="Floating label select example">
                                <option selected value="0">Open this select menu</option>
                                @foreach ($shop_type as $type)
                                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                                @endforeach
                            </select>
                            <label for="shop_type_id">Shop Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="shop_days" name="shop_days"
                                aria-label="Floating label select example">
                                <option selected value="0">Open this select menu</option>
                                <option value="1">Everyday</option>
                                <option value="2">Weekdays</option>
                                <option value="3">Custom</option>
                            </select>
                            <label for="shop_type_id">Opening Days</label>
                        </div>
                        <div id="default-days">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="time" class="form-control" name="opening" id="opening"
                                            placeholder=" ">
                                        <label for="name">Opening hours</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="time" class="form-control" name="closing" id="closing"
                                            placeholder=" ">
                                        <label for="name">Closing hours</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="custom-days">
                            @foreach ($shop_day as $day)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" name="{{ $day->day }}_opening"
                                                id="{{ $day->day }}_opening" placeholder=" ">
                                            <label for="name">{{ substr($day->day, 0, 3) }} opening hours</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" name="{{ $day->day }}_closing"
                                                id="{{ $day->day }}_closing" placeholder=" ">
                                            <label for="name">{{ substr($day->day, 0, 3) }} closing hours</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="input-group mb-3" id="error">
                            <label class="input-group-text">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div id="map"></div>
                        <div id="infowindow-content">
                            <span id="place-name" class="title"></span><br />
                            <span id="place-address"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="add-shop-submit-btn" type="submit" form="add-shop-form" class="btn btn-primary">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toggle-shop-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="toggle-shop-modal-label">Publish Shop</h5>
                </div>
                <div class="modal-body">
                    <form id="toggle-shop-form" action="" method="POST">
                        @csrf
                        <input type="hidden" id="toggle_shop_info_id" name="shop_info_id" value="">
                        <input type="hidden" id="toggle_status" name="status" value="">
                        <span id="toggle-message"></span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="toggle-shop-btn" form="toggle-shop-form" class="btn btn-primary"
                        id="add-item-submit-btn">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-shop-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-shop-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shop_info_id" id="edit-shop-info-id">


                        <img class="edit-shop-image-preview img-fluid mb-3" src="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="edit-shop-name"
                                placeholder=" ">
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="shop_code" id="edit-shop-code"
                                placeholder=" ">
                            <label for="name">Shop Code</label>
                        </div>
                        <div class="input-group mt-3" id="error">
                            <input type="file" class="form-control" name="image" id="edit-shop-image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="edit-shop-btn" form="edit-shop-form"
                        class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div id="content">
        @include('include.management_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="header-title border-end pe-3">SHOP</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span class="material-icons ps-2">home</span>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Shop</span>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Published</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center header-btns">
                        {{-- <button class="btn btn-primary me-2 grid-btn" id="view-type">
                            Grid view
                        </button> --}}

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-shop-modal">
                            <div class="d-flex align-items-center">
                                Add new shop
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mt-3" id="grid-view">
                <div class="accordion">
                    @foreach ($shop_type as $type)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="header-{{ $type->id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#body-{{ $type->id }}" aria-expanded="true"
                                    aria-controls="body-sample">
                                    <div id="acc-btn-{{ $type->id }}" class="shop-type-header"
                                        style="text-transform: capitalize">
                                        {{ $type->type }}
                                    </div>
                                </button>
                            </h2>
                            <div id="body-{{ $type->id }}" class="accordion-collapse collapse show"
                                aria-labelledby="header-{{ $type->id }}">
                                <div class="accordion-body">
                                    <div class="row" id="content-{{ $type->id }}">
                                        @if ($type->shopInfos->isNotEmpty())
                                            @foreach ($type->shopInfos->whereIn('shop_status_id', [3, 4])->sortByDesc('id') as $shop)
                                                <div class="col-lg-2 col-md-3 col-sm-5 col-xs-6" id="shop-id-{{ $shop->id }}">
                                                    <div class="card">
                                                        <div class="position-relative">
                                                            <img class="shop-image" src="{{ asset('storage/shop_image/' . $shop->image) }}" class="img-fluid rounded-top" style="height: 200px; width: 100%;">
                                                            @switch($shop->shop_status_id)
                                                                @case(1)
                                                                    <div class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                                        <span class="badge rounded-pill text-capitalize p-2" style="background-color: #6C757D; font-size: 13px;">{{ $shop->shopStatus->status }}</span>
                                                                    </div>
                                                                    @break
                                                                @case(2)
                                                                    <div class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                                        <span class="badge rounded-pill text-capitalize p-2" style="background-color: #FFC107; font-size: 13px;">{{ $shop->shopStatus->status }}</span>
                                                                    </div>
                                                                    @break
                                                                @case(3)
                                                                    <div class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                                        <span class="badge rounded-pill text-capitalize p-2" style="background-color: #198754; font-size: 13px;">{{ $shop->shopStatus->status }}</span>
                                                                    </div>

                                                                    <div class="form-check form-switch position-absolute top-0 end-0 p-2">
                                                                        <input class="form-check-input toggler" type="checkbox" id="flexSwitchCheckChecked" checked value="{{ $shop->id }}">
                                                                    </div>
                                                                    @break
                                                                @case(4)
                                                                    <div class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                                        <span class="badge rounded-pill text-capitalize p-2" style="background-color: #DC3545; font-size: 13px;">{{ $shop->shopStatus->status }}</span>
                                                                    </div>

                                                                    <div class="form-check form-switch position-absolute top-0 end-0 p-2">
                                                                        <input class="form-check-input toggler" type="checkbox" id="flexSwitchCheckChecked"  value="{{ $shop->id }}">
                                                                    </div>
                                                                    @break
                                                                @case(5)
                                                                    <div class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                                        <span class="badge rounded-pill text-capitalize p-2" style="background-color: #DC3545; font-size: 13px;">{{ $shop->shopStatus->status }}</span>
                                                                    </div>
                                                                    @break
                                                                @default
                                                            @endswitch

                                                            <div class="position-absolute top-0 start-0 p-2">
                                                                <span class="edit-btn material-icons text-primary" value="{{ $shop->id }}" style="font-size: 30px;">edit</span>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="card-title">
                                                                <div>
                                                                    <h5 class="text-truncate align-items-center mb-0" id="shop-name"
                                                                        style="font-weight: 500;">{{ $shop->name }}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="card-text">
                                                                <div class="d-flex justify-content-between">
                                                                    {{-- <a href="#" style="color: rgb(140, 39, 255); font-size: 12px;">Reviews: 100</a> --}}
                                                                    {{-- <div class="star-rating">
                                                                        @for ($i = 0; $i < 5; $i++)
                                                                            <span class="material-icons" style="color: rgb(140, 39, 255); font-size: 20px;">star</span>
                                                                        @endfor
                                                                    </div> --}}
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <small class="text-truncate">{{ $shop->address }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="çard-footer p-3">
                                                            <a class="btn btn-primary" href="{{ route('shopadmin.shopInfo', ['type' => 'my', 'id' => $shop->id]) }}" style="font-size: 15px;">
                                                                View More
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="empty-shop-{{ $type->id }}">Shop List Empty...</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row mt-3" id="table-view">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="p-2">
                                        <div class="card-content">
                                            <table class="table table-hover table-responsive-xl" id="shop-list-table"
                                                style="width: 100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>NAME</th>
                                                        <th>TYPE</th>
                                                        <th>RATING</th>
                                                        <th>STATUS</th>
                                                        <th>UPDATED DATE</th>
                                                        <th>CREATED DATE</th>
                                                        <th>action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBL60hAErq0z9XPnxE17_SVW3sUFnMBB3w&callback=initMap&libraries=places"
        async></script>

    <script>
        var marker;
        let infowindow;
        var thisToggle;
        let shop_type = @json($shop_type, JSON_PRETTY_PRINT);
        let view = @json($view, JSON_PRETTY_PRINT);

        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 10.42166821693739,
                    lng: 123.88690408418918
                },
                zoom: 13,
                mapTypeControl: false,
                mapTypeId: "roadmap",
            });

            // const card = document.getElementById("pac-card");
            const input = document.getElementById("search_input");
            const biasInputElement = document.getElementById("use-location-bias");
            const strictBoundsInputElement = document.getElementById("use-strict-bounds");
            const options = {
                fields: ["place_id", "formatted_address", "geometry", "name"],
                strictBounds: false,
                types: ["establishment"],
            };

            const autocomplete = new google.maps.places.Autocomplete(input, options);

            autocomplete.bindTo("bounds", map);

            infowindow = new google.maps.InfoWindow();
            infowindowContent = document.getElementById("infowindow-content");

            infowindow.setContent(infowindowContent);

            const marker = new google.maps.Marker({
                map,
                anchorPoint: new google.maps.Point(0, -29),
            });


            // if (navigator.geolocation) {
            //     navigator.geolocation.getCurrentPosition(
            //         (position) => {
            //             const pos = {
            //                 lat: position.coords.latitude,
            //                 lng: position.coords.longitude,
            //             };
            //             console.log(pos);
            //             infowindow.setPosition(pos);
            //             infowindow.setContent("Location found.");
            //             infowindow.open(map);
            //             map.setCenter(pos);
            //         },
            //         () => {
            //             handleLocationError(true, infowindow, map.getCenter());
            //         }
            //     );
            // } else {
            //     // Browser doesn't support Geolocation
            //     handleLocationError(false, infowindow, map.getCenter());
            // }

            autocomplete.addListener("place_changed", () => {
                infowindow.close();
                marker.setVisible(false);

                const place = autocomplete.getPlace();
                // console.log(place);

                if (!place.geometry || !place.geometry.location) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // console.log(placei image.png);
                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                $('#search_input').attr('readonly', true);
                $('#clear-address').fadeIn('fast');
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
                document.getElementById('place_id').value = place.place_id;

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                infowindowContent.children["place-name"].textContent = place.name;
                infowindowContent.children["place-address"].textContent =
                    place.formatted_address;
                infowindow.open(map, marker);
            });
        }

        function handleLocationError(browserHasGeolocation, infowindow, pos) {
            infowindow.setPosition(pos);
            infowindow.setContent(
                browserHasGeolocation ?
                "Error: The Geolocation service failed." :
                "Error: Your browser doesn't support geolocation."
            );
            infowindow.open(map);
        }

        $(document).ready(function() {
            $.validator.addMethod("notEqual", function(value, element, param) {
                return this.optional(element) || value != param;
            }, "This field is required.");

            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'File size must be less than 2mb');

            $.validator.addMethod("specialchars", function(value, element) {
                var regex = new RegExp("^[a-zA-Z0-9-]+$");
                var key = value;

                if (!regex.test(key)) {
                    return false;
                }
                return true;
            }, "Letters, numbers, and dashes only please");

            $.validator.addMethod('time', function(value, element, param) {
                return value == '' || value.match(/^([01][0-9]|2[0-3]):[0-5][0-9]$/);
            }, 'Enter a valid time: hh:mm');

            function shopCard(content, shop) {
                shop_image = "{{ asset('storage/shop_image/:img') }}";
                shop_image = shop_image.replace(':img', shop.image);
                shop_route = "{{ route('shopadmin.shopInfo', ['type' => 'my', 'id' => ':id']) }}";
                shop_route = shop_route.replace(':id', shop.id);

                switch (shop.shop_status_id) {
                    case 1:
                        shop_status_color = '#6C757D';
                        break;
                    case 2:
                        shop_status_color = '#FFC107';
                        break;
                    case 3:
                        shop_status_color = '#198754';
                        break;
                    case 4:
                        shop_status_color = '#DC3545';
                        break;
                    case 5:
                        shop_status_color = '#DC3545';
                        break;
                    default:
                        break;
                }

                shop_card = `
                    <div class="col-lg-2 col-md-3 col-sm-5 col-xs-6" id="shop-id-${ shop.id }">
                        <div class="card">
                            <div class="position-relative">
                                <img src="${ shop_image }" class="img-fluid rounded-top" style="height: 200px; width: 100%;">
                                <div class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                    <span class="badge rounded-pill text-capitalize p-2" style="background-color: ${ shop_status_color }; font-size: 13px;">${ shop.shop_status.status }</span>
                                </div>

                                <div class="position-absolute top-0 start-0 p-2">
                                    <span class="edit-btn material-icons text-primary" value="${ shop.id }" style="font-size: 30px;">edit</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <div>
                                        <h5 class="text-truncate align-items-center mb-0" id="shop-name"
                                            style="font-weight: 500;">${ shop.name }</h5>
                                    </div>
                                </div>
                                <div class="card-text">
                                    <div class="d-flex align-items-center">
                                        <small class="text-truncate">${ shop.address }</small>
                                    </div>
                                </div>
                            </div>
                            <div class="çard-footer p-3">
                                <a class="btn btn-primary" href="${ shop_route }" style="font-size: 15px;">
                                    View More
                                </a>
                            </div>
                        </div>
                    </div>
                `
                content.prepend(shop_card);
            }

            function editShopBtn() {
                $('.edit-btn').off('click').on('click', function() {
                    var shop_fetch_url = "{{ route('shopadmin.editShopFetch', ':shop_info_id') }}";
                    shop_fetch_url = shop_fetch_url.replace(':shop_info_id', $(this).attr('value'));
                    $.ajax({
                        url: shop_fetch_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            shop_image = "{{ asset('storage/shop_image/:img') }}";
                            shop_image = shop_image.replace(':img', response.shop_info.image);
                            $('#edit-shop-name').val(response.shop_info.name);
                            $('#edit-shop-code').val(response.shop_info.shop_code);
                            $('#edit-shop-info-id').val(response.shop_info.id);
                            $('.edit-shop-image-preview').attr('src', shop_image);
                            $('#edit-shop-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            editShopBtn();

            $("input.toggler").on('click', function() {
                thisToggle = $(this);
                let status = $(this).prop('checked') == true ? 3 : 4;
                let t_url = "{{ route('shopadmin.shopInfoToggleFetch', ':id') }}";
                t_url = t_url.replace(':id', thisToggle.val());
                thisToggle.prop('disabled', true);
                $.ajax({
                    url: t_url,
                    method: "GET",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {

                        $('#toggle-shop-modal').modal('toggle');
                        $('#toggle_shop_info_id').val(response.shop.id);
                        $('#toggle_status').val(status);
                        if (status == 3) {
                            $('#toggle-shop-modal-label').text('Publish Shop')
                            $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                                    thisToggle.prop("checked", false);
                                    thisToggle.prop('disabled', false);
                                });
                            $('#toggle-message').text(response.shop.name + ' will be published. Proceed?');
                        } else if (status == 4) {
                            $('#toggle-shop-modal-label').text('Deactivate Shop');
                            $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                                thisToggle.prop("checked", true);
                                thisToggle.prop('disabled', false);
                            });
                            $('#toggle-message').text(response.shop.name + ' will be inactive. Proceed?');
                        }
                    },
                    error: function(response) {
                        alert('oops something went wrong');
                    }
                });
            });

            $("#view-type").on('click',function() {
                var $this = $(this);
                let view_type;
                if (view != 'table') {
                    // to table
                    shop_type.forEach(element => {
                        $("#content-" + element.id).load(location.href + " #content-" + element.id);
                    });
                    window.history.pushState({}, '',
                        "{{ route('shopadmin.shop', ['type' => 'publish', 'view' => 'table']) }}");
                    $this.text('table view');
                    shopListTable();
                    $("#grid-view").fadeOut('fast');
                    $("#table-view").fadeIn('fast');
                    view = 'table';
                } else {
                    // to grid
                    view = 'grid';
                    shop_type.forEach(element => {
                        getShopList(element.id);
                    });
                    $this.text('grid view');
                    $('#shop-list-table').DataTable().destroy();
                    $("#table-view").fadeOut('fast');
                    $("#grid-view").fadeIn('fast');
                    window.history.pushState({}, '',
                        "{{ route('shopadmin.shop', ['type' => 'publish', 'view' => 'grid']) }}");
                }
            });

            $('#clear-address').on('click', function() {
                $(this).fadeOut('fase');
                $('#search_input').val(null).attr('readonly', false);
                $('#place_id').val(null);
                $('#lat').val(null);
                $('#lng').val(null);
            });

            $("#shop_days").on('change', function() {
                if (this.value == 3) {
                    $("#default-days").fadeOut('fast', function() {
                        $("#custom-days").fadeIn('fast');
                    });
                } else {
                    $("#custom-days").fadeOut('fast', function() {
                        $("#default-days").fadeIn('fast');
                    });
                }
            });

            $('#edit-shop-image').on('change', function () {
                const file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(event){
                    $('.edit-shop-image-preview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            });

            $('#add-shop-form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    shop_type_id: {
                        notEqual: 0
                    },
                    image: {
                        required: true,
                        extension: "jpg|jpeg|png|JPG|JPEG|PN",
                        filesize: 1999000,
                    },
                    address: {
                        required: true,
                        remote: {
                            url: "{{ route('verify.placeId') }}",
                            type: "GET",
                            data: {
                                place_id: function() {
                                    return $('#place_id').val();
                                },
                            },
                        }
                    },
                    shop_code: {
                        required: true,
                        specialchars: true,
                        maxlength: 10,
                        remote: {
                            url: "{{ route('verify.shopCode') }}",
                            type: "GET",
                            data: {
                                shop_code: function() {
                                    return $('#shop_code').val();
                                },
                            },
                        }
                    },
                    shop_days: {
                        notEqual: 0,
                    },
                    opening: {
                        required: true,
                        time: true
                    },
                    closing: {
                        required: true,
                        time: true
                    }
                },
                messages: {
                    shop_code: {
                        remote: "This shop code has been used."
                    },
                    address: {
                        remote: "This shop has already registered."
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#add-shop-submit-btn').attr('disabled', true).text('please wait...');
                    $.ajax({
                        url: "{{ route('shopadmin.addShop') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#add-shop-submit-btn').attr('disabled', false).text(
                                'submit');
                        },
                        success: function(response) {
                            if (response.place_id_null) {
                                $("#add-shop-modal").modal('toggle');
                                $('#add-shop-form').trigger('reset');
                                Swal.fire({
                                    icon: response.icon,
                                    title: response.title,
                                    text: response.text,
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: response.icon,
                                    title: response.title,
                                    text: response.text,
                                    showCancelButton: true,
                                    confirmButtonColor: '#8C27FF',
                                    showConfirmButton: true,
                                    showCancelButtonText: 'Close',
                                    confirmButtonText: 'View added shop',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        var url =
                                            "{{ route('shopadmin.shopInfo', ['type' => 'publish', 'id' => ':id']) }}";
                                        url = url.replace(':id', response.shop_info
                                            .id);
                                        window.location.href = url;
                                    }
                                });
                                $("#add-shop-modal").modal('toggle');
                                $('#add-shop-form').trigger('reset');
                                $('#shop-list-table').DataTable().destroy();
                                shopListTable();
                            }

                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#toggle-shop-form').validate({
                submitHandler: function(form, event) {
                    $('#toggle-shop-btn').attr('disabled', true).text('processing');
                    event.preventDefault();;
                    $.ajax({
                        url: "{{ route('shopadmin.shopInfoToggleStatusUpdate') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            thisToggle.attr('disabled', false);
                            $('#toggle-shop-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            status_badge = $('#shop-id-' + response.shop.id).find('.badge');

                            $('#toggle-shop-modal').modal('toggle');
                            $('#toggle-shop-form').trigger('reset');
                            if (response.shop.shop_status_id == 3) {
                                status_badge.fadeOut('fast', function() {
                                    status_badge.css('background-color', '#198745').text('Published');
                                    status_badge.fadeIn('fast');
                                });
                                $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                                    thisToggle.prop("checked", true);
                                });
                            } else if (response.shop.shop_status_id == 4) {
                                status_badge.fadeOut('fast', function() {
                                    status_badge.css('background-color', '#DC3545').text('inactive');
                                    status_badge.fadeIn('fast');
                                });
                                $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                                    thisToggle.prop("checked", false);
                                });
                            }
                        },
                        error: function(response) {
                            alert(
                                'oops something went wrong'
                            );
                        }
                    });
                    return false;
                },
            });

            $('#edit-shop-form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    shop_type_id: {
                        notEqual: 0
                    },
                    image: {
                        extension: "jpg|jpeg|png"
                    },
                },
                messages: {
                    image: {
                        extension: "Please upload file in these format only (jpg, jpeg, png)."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-shop-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('shopadmin.editShop') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-shop-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#edit-shop-modal').modal('toggle');
                            $('#edit-shop-form').trigger('reset');
                            shop_image = "{{ asset('storage/shop_image/:img') }}";
                            shop_image = shop_image.replace(':img', response.shop_info.image);

                            shop_info = $('#shop-id-' + response.shop_info.id);
                            shop_info.find('#shop-name').text(response.shop_info.name);
                            shop_info.find('.shop-image').attr('src', shop_image);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            switch (view) {
                case 'grid':
                    shop_type.forEach(element => {
                        // getShopList(element.id);
                    });
                    $('#grid-view').show();
                    break;
                case 'table':
                    shopListTable();
                    $('#table-view').show();
                    break;

                default:
                    break;
            }
        });
    </script>

    @if (session()->has('status'))
        <script>
            Swal.fire({
                icon: '{{ session()->get('status') }}',
                title: '{{ session()->get('title') }}',
                text: '{{ session()->get('text') }}',
                timer: 3000,
                showCancelButton: false,
                showConfirmButton: false
            })
        </script>
    @endif
@endpush
