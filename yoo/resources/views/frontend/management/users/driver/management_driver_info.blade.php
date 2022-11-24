@extends('layouts.layout_management')

@section('title', 'Drivers Information')

@push('css')
    <style>
        .status-icon {
            color: #8C27FF;
            /* transition: 0.4s ease; */
            display: block
        }

        .circle.active {
            border: 3px solid #8C27FF;
        }

        .crop-profile {
            width: 100px;
            height: 100px;

            border-radius: 5px;
            overflow: hidden;
        }

        .crop-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .driver-image-container {
            width: 100%;
            height: 263px;
            overflow: hidden;
        }

        .driver-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .iconSample {
            font-size: 100-px;
        }

        .driver-name {
            font-size: 18px;

        }

        .driver-gmail {
            font-size: 14px;
            color: #6E6B7B;
        }

        .driver-left-title {
            font-size: 15px;
            color: #5e5873;
        }

        .driver-left-value {
            font-size: 12px;
            color: #6E6B7B;
        }

        .driver-right-title {
            font-size: 14px;
            color: #6E6B7B;
        }

        .driver-icon {
            color: #6E6B7B;
        }

        .card-header-title {
            font-size: 18px;
            color: #303030;

        }

        .vehicle-information-title {
            font-size: 14px;
            color: #6E6B7B;
        }

        .vehicle-information-body {
            font-size: 14px;
            color: #5e5873;
        }

        .icon-background-1 {
            background-color: #EEEDFD;
        }

        .icon-background-2 {
            background-color: #E5F8ED;
        }

        .icon-value-1 {
            color: #7367F0;
        }

        .icon-value-2 {
            color: #28C76F;
        }

        .container-bar {
            text-align: center;
        }

        .progress-container {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .progress-container::before {
            content: "";
            background-color: #8C27FF;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 0%;
            z-index: 1;
            transition: 0.4s ease;
        }

        .progress-gray {
            background-color: #999;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            z-index: 1;
            transition: 0.4s ease;
        }

        .progress {
            background-color: #8C27FF;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            z-index: 2;
            transition: 0.4s ease;
        }

        .status-text {
            position: absolute;
            bottom: 50px;
            color: #8C27FF;
        }

        .status-button {
            position: absolute;
            bottom: -50px;
        }

        .status-buttons {
            height: 50px;
        }

        .status-alert {
            position: absolute;
            bottom: -60px;
            width: 250px;
        }

        #status-alert-training {
            visibility: hidden;
        }

        #status-alert-pending {
            visibility: hidden;
        }

        #status-buttons-profile {
            /* visibility: hidden; */
            display: none;
            left: 0%;
        }

        #status-buttons-document {
            /* visibility: hidden; */
            display: none;
        }

        #status-buttons-kyc {
            /* visibility: hidden; */
            display: none;
        }

        #status-buttons-training {
            /* visibility: hidden; */
            display: none;
        }

        #status-buttons-pending {
            /* visibility: hidden; */
            display: none;
        }

        #status-buttons-verified {
            right: 0%;
            /* visibility: hidden; */
            display: none;
        }

        .verified-accept {
            /* visibility: hidden; */
            display: none;
            position: absolute;
        }

        .circle {
            z-index: 2;
            background-color: #fff;
            color: #999;
            border-radius: 50%;
            height: 50px;
            width: 50px;
            border: 3px solid #b2bec3;
            display: flex;
            transition: 0.4s ease;
        }

        .streamline .sl-item {
            position: relative;
            padding-bottom: 12px;
            border-left: 1px solid #ccc;
        }

        .streamline .sl-item:before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            background-color: #ccc;
            width: 12px;
            height: 12px;
            border-radius: 100%;
        }

        .streamline .sl-primary:before,
        .streamline .sl-primary:last-child:after {
            background-color: #8C27FF;
        }

        .streamline .sl-primary {
            border-left-color: #8c27ff65;
        }

        .streamline .sl-item .sl-content {
            margin-left: 24px;
        }

        .streamline .sl-item .text-muted {
            color: inherit;
            opacity: .6;
            font-size: 12px;
        }

        .streamline .sl-item p {
            font-size: 14px;
            color: #5e5873;
        }

        #scrollbar::-webkit-scrollbar {
            display: none;
        }

        .loading-icon-ajax {
            display: none
        }

        @media only screen and (max-width:992px) {
            .card-footer {
                display: none;
            }
        }

    </style>
@endpush

@push('modal')
    {{-- PROFILE PICTURE --}}
    <div class="modal fade" id="profile-picture" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="col-lg-12 d-flex justify-content-center">
                            @if ($driver->user->userInfo->profile_picture != null)
                                <img style="min-height: 600px" class="img-fluid"
                                    src="{{ asset('storage/driver_profile/' . $driver->user->userInfo->profile_picture) }}">
                            @else
                                <img class="img-fluid" src="{{ asset('assets/images/Profile_Placeholder.png') }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- DRIVING LICENSE --}}
    <div class="modal fade" id="driving-license" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="col-lg-12 d-flex justify-content-center">
                            @if ($driver->driver_license_image != null)
                                <img style="min-height: 600px" class="img-fluid"
                                    src="{{ asset('storage/driver_profile/' . $driver->driver_license_image) }}">
                            @else
                                <img class="img-fluid"
                                    src="{{ asset('assets/images/driving_license_placeholder.png') }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- NBI CLEARANCE --}}
    <div class="modal fade" id="nbi-clearance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="col-lg-12 d-flex justify-content-center">
                            @if ($driver->nbi_clearance != null)
                                <img style="min-height: 600px" class="img-fluid"
                                    src="{{ asset('storage/driver_profile/' . $driver->nbi_clearance) }}">
                            @else
                                <img class="img-fluid"
                                    src="{{ asset('assets/images/nbi_clearance_placeholder.png') }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($driver->driverVehicles as $key => $vehicle)
        {{-- Vehicle Front --}}
        <div class="modal fade" id="vehicle-front{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 d-flex justify-content-center">
                                @if ($vehicle->vehicle_front != null)
                                    <img style="min-height: 600px" class="img-fluid"
                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_front) }}">
                                @else
                                    <img class="img-fluid" src="{{ asset('assets/images/vehicle_front.png') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Vehicle Side --}}
        <div class="modal fade" id="vehicle-side{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 d-flex justify-content-center">
                                @if ($vehicle->vehicle_side)
                                    <img style="min-height: 600px" class="img-fluid"
                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_side) }}">
                                @else
                                    <img class="img-fluid" src="{{ asset('assets/images/vehicle_side.png') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Vehicle Back --}}
        <div class="modal fade" id="vehicle-back{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 d-flex justify-content-center">
                                @if ($vehicle->vehicle_back != null)
                                    <img style="min-height: 600px" class="img-fluid"
                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_back) }}">
                                @else
                                    <img class="img-fluid" src="{{ asset('assets/images/vehicle_back.png') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Deed of Sale --}}
        <div class="modal fade" id="deed-of-sale{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 d-flex justify-content-center">
                                @if ($vehicle->deed_of_sale != null)
                                    <img style="min-height: 600px" class="img-fluid"
                                        src="{{ asset('storage/driver_profile/' . $vehicle->deed_of_sale) }}">
                                @else
                                    <img class="img-fluid" src="{{ asset('assets/images/deed_of_sale.png') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Vehicle Registration --}}
        <div class="modal fade" id="vehicle-registration{{ $key }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 d-flex justify-content-center">

                                @if ($vehicle->vehicle_registration != null)
                                    <img style="min-height: 600px" class="img-fluid"
                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_registration) }}">
                                @else
                                    <img class="img-fluid"
                                        src="{{ asset('assets/images/vehicle_registration.png') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endpush

@section('content')
    <div id="content">
        <!-- Top Nav Bar -->
        @include('include.management_navbar')
        <!-- Main Content -->
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header">
                    <div class="col-lg-12 d-flex align-items-center">
                        <span class="header-title border-end pe-3">USERS</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a class="d-flex align-items-center" href="{{ route('management.index') }}">
                                    <span id="click-link" class="material-icons d-flex align-items-center ps-2">home</span>
                                </a>
                            </small>
                            <span class="material-icons d-flex align-items-center">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                Users
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a id="click-link" class="d-flex align-items-center "
                                    href="{{ route('management.userDrivers') }}">
                                    Drivers
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <small>
                            <span class="">Driver Info</span>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card p-3" id="main-profile">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <!-- left COlumn profile -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12 d-flex">
                                        <div class="crop-profile me-4">
                                            @if ($driver->user->userInfo->profile_picture != null)
                                                <img src="{{ asset('storage/driver_profile/' . $driver->user->userInfo->profile_picture) }}"
                                                    type="button" data-bs-toggle="modal" data-bs-target="#profile-picture">
                                            @else
                                                <img src="{{ asset('assets/images/Profile_Placeholder.png') }}"
                                                    type="button" data-bs-toggle="modal" data-bs-target="#profile-picture">
                                            @endif
                                        </div>
                                        <div class=" ml-1">
                                            <h4 class="mb-0">
                                                <strong class="driver-name" style="text-transform: none">
                                                    {{ $driver->user->userInfo->first_name }}
                                                    {{ $driver->user->userInfo->last_name }}
                                                </strong>
                                            </h4>
                                            <span class="driver-gmail" style="text-transform: none">
                                                @if ($driver->user->email != null)
                                                    {{ $driver->user->email }}
                                                @else
                                                    empty
                                                @endif
                                            </span>
                                            <div>
                                                <span class="badge rounded-pill px-3" style="font-size: medium;"
                                                    id="driver_status">
                                                    <div id="status-refresh">
                                                        {{ $driver->verificationStatus->status }}
                                                    </div>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mt-4">
                                        <div class="col-lg-8 col-md-6 d-flex flex-row">
                                            <div class="d-flex justify-content-start me-5">
                                                <div class="Icon">
                                                    <div
                                                        class="icon-background-1 d-flex icon-container h-100 w-100 align-items-center px-3 rounded">
                                                        <span class="icon-value-1 material-icons">
                                                            people
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <strong class="driver-left-title">Follower</strong>
                                                    <p class="driver-left-value mt-0">
                                                        @if ($driver->number_of_fans != null)
                                                            {{ $driver->number_of_fans }}
                                                        @else
                                                            0
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start">
                                                <div class="Icon">
                                                    <div
                                                        class="icon-background-2 d-flex icon-container h-100 w-100 align-items-center px-3 rounded">
                                                        <span class="icon-value-2 material-icons">
                                                            trending_up
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <strong class="driver-left-title">Rating</strong>
                                                    <p class="driver-left-value mt-0">
                                                        @if ($driver->driver_rating != null)
                                                            {{ $driver->driver_rating }}
                                                        @else
                                                            0
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- right Col profile-->
                            <div class="col-lg-6">
                                <table class="mt-2 mt-xl-0 w-100">
                                    {{-- user id --}}
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">verified_user</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">User
                                                ID</span>
                                        </th>
                                        <td align="right">
                                            <span class="driver-right-title">
                                                {{ $driver->user_id }}
                                            </span>
                                        </td>
                                    </tr>
                                    {{-- mobile --}}
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">phone_iphone</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">Mobile
                                                Number</span>
                                        </th>
                                        <td align="right">
                                            <span class="driver-right-title">
                                                {{ $driver->user->mobile_number }}
                                            </span>
                                        </td>
                                    </tr>
                                    {{-- city --}}
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">apartment</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">City</span>
                                        </th>
                                        <td style="text-transform: none" align="right">
                                            <span class="driver-right-title">
                                                @if ($driver->city != null)
                                                    {{ $driver->city }}
                                                @else
                                                    -
                                                @endif

                                            </span>
                                        </td>
                                    </tr>
                                    {{-- vehicle type --}}
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">directions_car</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">Vehicle
                                                Type</span>
                                        </th>
                                        <td style="text-transform: none" align="right">
                                            <span class="driver-right-title">

                                                @if ($driver->driverVehicles->isNotEmpty())
                                                    {{ $driver->driverVehicles->first()->vehicle->type }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">vpn_key</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">Sponsor Code</span>
                                        </th>
                                        <td style="text-transform: none" align="right">
                                            <span class="driver-right-title">
                                                @if ($driver->operator_id != null)
                                                    {{ $driver->operator->sponsor_code }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">psychology</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">Sponsor by</span>
                                        </th>
                                        <td style="text-transform: none" align="right">
                                            <span class="driver-right-title">
                                                @if ($driver->operator_id != null)
                                                    {{ $driver->operator->user->email }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="footer-refresh">
                    @if ($driver->verification_status_id != 7)
                        <div class="card-footer mb-5">
                            <div class="container-bar col-lg-12" id="footer-container">
                                <Strong class="">Status Bar</Strong>
                                <div class="progress-container col-lg-12 mt-5 d-flex justify-content-between">
                                    <div class="progress" id="progress"></div>
                                    <div class="progress-gray"></div>
                                    <div class="circle active d-flex justify-content-center align-items-center">
                                        <span class="loading-icon-ajax spinner-border text-primary spinner-border-sm"
                                            role="status" aria-hidden="true"></span>
                                        <span class="status-icon material-icons">contact_mail</span>
                                        <strong class="status-text">Profile</strong>
                                        <div class="status-button" id="status-buttons-profile">
                                            <button class="status-buttons btn btn-danger rounded-circle" id="decline">
                                                <span class="material-icons d-flex justify-content-center">
                                                    close
                                                </span>
                                            </button>
                                            <button class="status-buttons btn btn-primary rounded-circle" id="accept">
                                                <span class="material-icons d-flex justify-content-center">
                                                    done
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="circle d-flex justify-content-center align-items-center">
                                        <span class="loading-icon-ajax spinner-border text-primary spinner-border-sm"
                                            role="status" aria-hidden="true"></span>
                                        <span class="status-icon activated material-icons">article</span>
                                        <strong class="status-text">Documents</strong>
                                        <div class="status-button" id="status-buttons-document">
                                            <button class="status-buttons btn btn-danger rounded-circle" id="decline">
                                                <span class="material-icons d-flex justify-content-center">
                                                    close
                                                </span>
                                            </button>
                                            <button class="status-buttons btn btn-primary rounded-circle" id="accept">
                                                <span class="material-icons d-flex justify-content-center">
                                                    done
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="circle d-flex justify-content-center align-items-center">
                                        <span class="loading-icon-ajax spinner-border text-primary spinner-border-sm"
                                            role="status" aria-hidden="true"></span>
                                        <span class="status-icon material-icons">waving_hand</span>
                                        <strong class="status-text">KYC</strong>
                                        <div class="status-button" id="status-buttons-kyc">
                                            <button class="status-buttons btn btn-danger rounded-circle" id="decline">
                                                <span class="material-icons d-flex justify-content-center">
                                                    close
                                                </span>
                                            </button>
                                            <button class="status-buttons btn btn-primary rounded-circle" id="accept">
                                                <span class="material-icons d-flex justify-content-center">
                                                    done
                                                </span>
                                            </button>
                                        </div>
                                        <div class="status-alert" id="status-alert-training">
                                            <small class="text-muted" style="text-transform: none">
                                                Pending Confirmation from Management
                                            </small>
                                        </div>
                                    </div>
                                    <div class="circle d-flex justify-content-center align-items-center">
                                        <span class="loading-icon-ajax spinner-border text-primary spinner-border-sm"
                                            role="status" aria-hidden="true"></span>
                                        <span class="status-icon material-icons">model_training</span>
                                        <span class="visually-hidden">Loading...</span>
                                        <strong class="status-text">Training</strong>
                                        <div class="status-button" id="status-buttons-training">
                                            <button class="status-buttons btn btn-danger rounded-circle" id="decline">
                                                <span class="material-icons d-flex justify-content-center">
                                                    close
                                                </span>
                                            </button>
                                            <button class="status-buttons btn btn-primary rounded-circle" id="accept">
                                                <span class="material-icons d-flex justify-content-center">
                                                    done
                                                </span>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="circle d-flex justify-content-center align-items-center">
                                        <span class="loading-icon-ajax spinner-border text-primary spinner-border-sm"
                                            role="status" aria-hidden="true"></span>
                                        <span class="status-icon material-icons">pending_actions</span>
                                        <strong class="status-text">Pending</strong>
                                        <div class="status-button" id="status-buttons-pending">
                                            <button class="status-buttons btn btn-danger rounded-circle" id="decline">
                                                <span class="material-icons d-flex justify-content-center">
                                                    close
                                                </span>
                                            </button>
                                            <button class="status-buttons btn btn-primary rounded-circle" id="accept">
                                                <span class="material-icons d-flex justify-content-center">
                                                    done
                                                </span>
                                            </button>
                                        </div>
                                        {{-- <div class="status-alert" id="status-alert-pending">
                                        <small class="text-muted" style="text-transform: none">
                                            Pending Confirmation from Operator/Management
                                        </small>
                                    </div> --}}
                                    </div>
                                    <div class="circle d-flex justify-content-center align-items-center">
                                        <span class="loading-icon-ajax spinner-border text-primary spinner-border-sm"
                                            role="status" aria-hidden="true"></span>
                                        <span class="status-icon material-icons">verified</span>
                                        <strong class="status-text">Verified</strong>
                                        <div class="status-button" id="status-buttons-verified">
                                            <button class="status-buttons btn btn-danger rounded-circle" id="decline">
                                                <span class="material-icons d-flex justify-content-center">
                                                    close
                                                </span>
                                            </button>
                                            <button class="status-buttons btn btn-primary rounded-circle verified-accept"
                                                id="accept">
                                                <span class="material-icons d-flex justify-content-center">
                                                    done
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="row">
                <div class="col-lg-8 d-flex justify-content-stretch pe-0">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                <strong>Drivers Information</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <span class="vehicle-information-title">Data of Birth</span>
                                        <span class="vehicle-information-body">
                                            <strong>
                                                @if ($driver->user->userInfo->date_of_birth != null)
                                                    {{ date('F d, Y', strtotime($driver->user->userInfo->date_of_birth)) }}
                                                @else
                                                    empty
                                                @endif
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <span class="vehicle-information-title">Driving License Number</span>
                                        <span class="vehicle-information-body" style="text-transform: none">
                                            <strong>
                                                @if ($driver->driving_license_number != null)
                                                    {{ $driver->driving_license_number }}
                                                @else
                                                    empty
                                                @endif
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <span class="vehicle-information-title">Driving License Expiry</span>
                                        <span class="vehicle-information-body">
                                            <strong>
                                                @if ($driver->driving_license_expiry != null)
                                                    {{ date('F d, Y', strtotime($driver->driving_license_expiry)) }}
                                                @else
                                                    empty
                                                @endif
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- Driver License --}}
                                <div class="col-lg-6 p-2 ">
                                    <div class="driver-image-container p-2 mt-3 border border-2 rounded">
                                        @if ($driver->driver_license_image != null)
                                            <img class="img-fluid"
                                                src="{{ asset('storage/driver_profile/' . $driver->driver_license_image) }}"
                                                type="button" data-bs-toggle="modal" data-bs-target="#driving-license">
                                        @else
                                            <img src="{{ asset('assets/images/driving_license_placeholder.png') }}"
                                                type="button" data-bs-toggle="modal" data-bs-target="#driving-license"
                                                class="rounded">
                                        @endif
                                    </div>
                                    <label for="" class="d-flex justify-content-center"><small>Driving
                                            License</small></label>
                                </div>
                                {{-- NBI Clearance --}}
                                <div class="col-lg-6 p-2">
                                    <div class="driver-image-container p-2 mt-3 border border-2 rounded">
                                        @if ($driver->nbi_clearance != null)
                                            <img class="img-fluid"
                                                src="{{ asset('storage/driver_profile/' . $driver->nbi_clearance) }}"
                                                type="button" data-bs-toggle="modal" data-bs-target="#nbi-clearance">
                                        @else
                                            <img src="{{ asset('assets/images/nbi_clearance_placeholder.png') }}"
                                                type="button" data-bs-toggle="modal" data-bs-target="#nbi-clearance"
                                                class="rounded">
                                        @endif
                                    </div>
                                    <label for="" class="d-flex justify-content-center"><small>nbi
                                            clearance</small></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-stretch">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title d-flex justify-content-between">
                                <strong>History Log</strong>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="container overflow-scroll px-2" style="max-height: 350px" id="scrollbar">
                                <div class="streamline" id="history-log-refresh">
                                    @if ($driver->driverHistoryLogs->isNotEmpty())
                                        @foreach ($driver->driverHistoryLogs->sortDesc()->take(10) as $log)
                                            <div class="sl-item sl-primary">
                                                <div class="sl-content">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <small
                                                            class="text-muted">{{ date('F d, Y', strtotime($log->created_at)) }}
                                                        </small>
                                                        <small
                                                            class="text-muted">{{ date('H:i', strtotime($log->created_at)) }}
                                                        </small>
                                                    </div>
                                                    <p class="mt-0" style="text-transform: none">
                                                        {{ $log->remarks }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        No History Logs Available
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        @foreach ($driver->driverVehicles as $key => $vehicle)
                            <div class="card-header">
                                <div class="card-header-title">
                                    @if ($loop->index < 1)
                                        <strong>vehicle Information</strong>
                                    @else
                                        <strong>Vehicle Information {{ $key }}</strong>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="row">
                                                <span class="vehicle-information-title">Vehicle Brand</span>
                                                <span class="vehicle-information-body" style="text-transform: none">
                                                    <strong>
                                                        @if ($vehicle->vehicle_brand != null)
                                                            {{ $vehicle->vehicle_brand }}
                                                        @else
                                                            empty
                                                        @endif
                                                    </strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="row">
                                                <span class="vehicle-information-title">Vehicle Model</span>
                                                <span class="vehicle-information-body" style="text-transform: none">
                                                    <strong>
                                                        @if ($vehicle->vehicle_model != null)
                                                            {{ $vehicle->vehicle_model }}
                                                        @else
                                                            empty
                                                        @endif
                                                    </strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="row">
                                                <span class="vehicle-information-title">Vehicle Manufacturer Year</span>
                                                <span class="vehicle-information-body">
                                                    <strong>
                                                        @if ($vehicle->vehicle_manufacture_year != null)
                                                            {{ date('F d, Y', strtotime($vehicle->vehicle_manufacture_year)) }}
                                                        @else
                                                            empty
                                                        @endif
                                                    </strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="row">
                                                <span class="vehicle-information-title">License Plate Number</span>
                                                <span class="vehicle-information-body" style="text-transform: none">
                                                    <strong>
                                                        @if ($vehicle->license_plate_number != null)
                                                            {{ $vehicle->license_plate_number }}
                                                        @else
                                                            empty
                                                        @endif
                                                    </strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- Vehicle Front --}}
                                        <div class="col-lg-4 p-2 ">
                                            <div class="driver-image-container p-2 mt-3 border border-2 rounded">
                                                @if ($vehicle->vehicle_front != null)
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_front) }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-front{{ $key }}">
                                                @else
                                                    <img src="{{ asset('assets/images/vehicle_front.png') }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-front{{ $key }}"
                                                        class="rounded">
                                                @endif
                                            </div>
                                            <label for="" class="d-flex justify-content-center"><small>Vehicle
                                                    Front</small></label>
                                        </div>
                                        {{-- Vehicle Side --}}
                                        <div class="col-lg-4 p-2">
                                            <div class="driver-image-container p-2 mt-3 border border-2 rounded">
                                                @if ($vehicle->vehicle_side != null)
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_side) }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-side{{ $key }}">
                                                @else
                                                    <img src="{{ asset('assets/images/vehicle_side.png') }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-side{{ $key }}"
                                                        class="rounded">
                                                @endif
                                            </div>
                                            <label for="" class="d-flex justify-content-center"><small>Vehicle
                                                    Side</small></label>
                                        </div>
                                        {{-- Vehicle Back --}}
                                        <div class="col-lg-4 p-2">
                                            <div class="driver-image-container p-2 mt-3 border border-2 rounded">
                                                @if ($vehicle->vehicle_back != null)
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_back) }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-back{{ $key }}">
                                                @else
                                                    <img src="{{ asset('assets/images/vehicle_back.png') }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-back{{ $key }}"
                                                        class="rounded">
                                                @endif
                                            </div>
                                            <label for="" class="d-flex justify-content-center"><small>Vehicle
                                                    Back</small></label>
                                        </div>
                                        {{-- Deed of Sale --}}
                                        <div class="col-lg-4 p-2">
                                            <div class="driver-image-container p-2 mt-3 border border-2 rounded">
                                                @if ($vehicle->deed_of_sale != null)
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/driver_profile/' . $vehicle->deed_of_sale) }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deed-of-sale{{ $key }}">
                                                @else
                                                    <img src="{{ asset('assets/images/deed_of_sale.png') }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deed-of-sale{{ $key }}"
                                                        class="rounded">
                                                @endif
                                            </div>
                                            <label for="" class="d-flex justify-content-center"><small>Deed of
                                                    Sale</small></label>
                                        </div>
                                        {{-- Vehicle Registration --}}
                                        <div class="col-lg-4 p-2">
                                            <div class="driver-image-container p-2 mt-3 border border-2 rounded">
                                                @if ($vehicle->vehicle_registration != null)
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/driver_profile/' . $vehicle->vehicle_registration) }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-registration{{ $key }}">
                                                @else
                                                    <img src="{{ asset('assets/images/vehicle_registration.png') }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#vehicle-registration{{ $key }}"
                                                        class="rounded">
                                                @endif
                                            </div>
                                            <label for="" class="d-flex justify-content-center"><small>Vehicle
                                                    Registration</small></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @include('include.operator_footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let progress = document.getElementById("progress");
        let decline = document.querySelectorAll("#decline");
        let accept = document.querySelectorAll("#accept");
        let footer_container = document.getElementById("footer-container");
        let driver_status = document.getElementById("driver_status");
        let circles = document.querySelectorAll(".circle");
        let loader = document.querySelectorAll('.loading-icon-ajax');
        let status_icon = document.querySelectorAll('.status-icon');
        // json
        var currentActive = @json($driver->verification_status_id, JSON_PRETTY_PRINT);

        update();

        function updateDriverVerificationAjaxx(status_id) {
            loader.forEach((loader, idx) => {
                if (idx == currentActive - 1) {
                    loader.style.display = 'block';
                }
            });
            status_icon.forEach((status_icon, idx) => {
                if (idx == currentActive - 1) {
                    status_icon.style.display = 'none';
                }
            });
            var url =
                "{{ route('management.userDriverInfoUpdateVerificationStatus', ['id' => $driver->user_id, 'status_id' => ':id']) }}";
            url = url.replace(':id', status_id);
            $.ajax({
                url: url,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                complete: function() {
                    status_icon.forEach((status_icon, idx) => {
                        if (idx == currentActive - 2) {
                            status_icon.style.display = 'block';
                        }
                    });
                    loader.forEach((loader, idx) => {
                        if (idx < currentActive) {
                            loader.style.display = 'none';
                        }
                    });
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: response.status,
                        title: response.title,
                        text: response.text,
                        timer: 3000,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    currentActive = response.driver.verification_status_id;
                    $("#status-refresh").load(window.location.href + " #status-refresh");
                    $("#history-log-refresh").load(window.location.href + " #history-log-refresh");
                    if (response.driver.verification_status_id != 7) {
                        if (response.driver.verification_status_id == 2) {
                            $('#status-buttons-profile').fadeOut();
                            $('#status-buttons-document').fadeIn();
                        } else if (response.driver.verification_status_id == 3) {
                            $('#status-buttons-document').fadeOut();
                            $('#status-buttons-kyc').fadeIn();
                        } else if (response.driver.verification_status_id == 4) {
                            $('#status-buttons-kyc').fadeOut();
                            $('#status-buttons-training').fadeIn();
                        } else if (response.driver.verification_status_id == 5) {
                            $('#status-buttons-training').fadeOut();
                            $('#status-buttons-pending').fadeIn();
                        } else if (response.driver.verification_status_id == 6) {
                            $('#status-buttons-pending').fadeOut();
                            $('#status-buttons-verified').fadeIn();
                        }
                    } else {
                        $("#footer-refresh").fadeOut('fast');
                    }

                    if (response.driver.verification_status_id == 1) {
                        driver_status.style.backgroundColor = '#6C757D'
                    } else if (response.driver.verification_status_id == 2) {
                        driver_status.style.backgroundColor = '#FFC107';
                    } else if (response.driver.verification_status_id == 3) {
                        driver_status.style.backgroundColor = '#F58840';
                    } else if (response.driver.verification_status_id == 4) {
                        driver_status.style.backgroundColor = '#FF5DA2';
                    } else if (response.driver.verification_status_id == 5) {
                        driver_status.style.backgroundColor = '#113CFC';
                    } else if (response.driver.verification_status_id == 6) {
                        driver_status.style.backgroundColor = '#198754';
                    } else if (response.driver.verification_status_id == 7) {
                        driver_status.style.backgroundColor = '#DC3545';
                    }


                    circles.forEach((circle, idx) => {
                        if (idx < response.driver.verification_status_id) {
                            circle.classList.add("active");
                        } else {
                            circle.classList.remove("active");
                        }
                        const actives = document.querySelectorAll(".active");
                        if (response.driver.verification_status_id == 1) {
                            progress.style.width = "0%";
                        } else if (response.driver.verification_status_id == 2) {
                            progress.style.width = "20%";
                        } else if (response.driver.verification_status_id == 3) {
                            progress.style.width = "40%";
                        } else if (response.driver.verification_status_id == 4) {
                            progress.style.width = "60%";
                        } else if (response.driver.verification_status_id == 5) {
                            progress.style.width = "80%";
                        } else if (response.driver.verification_status_id == 6) {
                            progress.style.width = "100%";
                        }
                    });
                },
                error: function(error) {
                    alert('oops something went wrong');
                }
            });
        }

        if (currentActive != 7) {
            for (let i = 0; i < accept.length; i++) {
                accept[i].addEventListener("click", () => {
                    if (currentActive == 1) {
                        updateDriverVerificationAjaxx(2);
                    } else if (currentActive == 2) {
                        updateDriverVerificationAjaxx(3);
                    } else if (currentActive == 3) {
                        updateDriverVerificationAjaxx(4);
                    } else if (currentActive == 4) {
                        updateDriverVerificationAjaxx(5);
                    } else if (currentActive == 5) {
                        updateDriverVerificationAjaxx(6);
                    }
                });
                decline[i].addEventListener("click", () => {
                    updateDriverVerificationAjaxx(7);
                    driver_status.style.backgroundColor = '#DC3545';
                });
            }
        }

        function update() {
            if (currentActive != 7) {
                if (currentActive === 1) {
                    $('#status-buttons-profile').show();
                } else if (currentActive === 2) {
                    $('#status-buttons-document').show();
                } else if (currentActive === 3) {
                    $('#status-buttons-kyc').show();
                } else if (currentActive === 4) {
                    $('#status-buttons-training').show();
                    document.getElementById('status-buttons-training').style.visibility = 'visible';
                } else if (currentActive === 5) {
                    $('#status-buttons-pending').show();
                } else if (currentActive === 6) {
                    $('#status-buttons-verified').show();
                }
            }

            if (currentActive === 1) {
                driver_status.style.backgroundColor = '#6C757D'
            } else if (currentActive === 2) {
                driver_status.style.backgroundColor = '#FFC107';
            } else if (currentActive === 3) {
                driver_status.style.backgroundColor = '#F58840';
            } else if (currentActive === 4) {
                driver_status.style.backgroundColor = '#FF5DA2';
            } else if (currentActive === 5) {
                driver_status.style.backgroundColor = '#113CFC';
            } else if (currentActive === 6) {
                driver_status.style.backgroundColor = '#198754';
            } else if (currentActive === 7) {
                driver_status.style.backgroundColor = '#DC3545';
            }

            circles.forEach((circle, idx) => {
                if (idx < currentActive) {
                    circle.classList.add("active");
                } else {
                    circle.classList.remove("active");
                }
                const actives = document.querySelectorAll(".active");
                if (currentActive == 1) {
                    progress.style.width = "0%";
                } else if (currentActive == 2) {
                    progress.style.width = "20%";
                } else if (currentActive == 3) {
                    progress.style.width = "40%";
                } else if (currentActive == 4) {
                    progress.style.width = "60%";
                } else if (currentActive == 5) {
                    progress.style.width = "80%";
                } else if (currentActive == 6) {
                    progress.style.width = "100%";
                }
            });
        }
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
