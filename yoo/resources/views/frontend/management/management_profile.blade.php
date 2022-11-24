@extends('layouts.layout_management')
@section('title', 'My Profile')


@push('css')
    <style>
        /* start */
        .crop-profile {
            width: 100px;
            height: 100px;
            border-radius: 50%;
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
            color: #000000;

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

        /* .upload-button {
                            position: absolute;
                            top: 0px;
                            right: 0px;
                        }


                        .profile-container {
                            position: relative;
                        }

                        .btn-circle {
                            width: 30px;
                            height: 30px;
                            padding: 6px 0px;
                            border-radius: 15px;
                            text-align: center;
                            font-size: 12px;
                            line-height: 1.42857;
                        }


                        .modal-header>.modal-title,
                        .modal-body>.body-desc,
                        .modal-body>.photo-input,
                        .modal-footer>.footer-title {
                            text-align: center
                        } */

        #loadFile {
            display: none
        }

    </style>

@endpush

@push('modal')
    {{-- view Profile --}}
    <div class="modal fade" id="view-operator-profile" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="col-lg-12 d-flex justify-content-center">
                            @if ($profile->user->userInfo->profile_picture != null)
                                <img class="img-fluid"
                                    src="{{ asset('storage/profile_picture/' . $profile->user->userInfo->profile_picture) }}">
                            @else
                                <img class="img-fluid" src="{{ asset('assets/images/Profile_Placeholder.png') }}">
                            @endif
                        </div>
                    </div>
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
                <div class="content-header">
                    <div class="col-lg-12 d-flex align-items-center">
                        <span class="header-title border-end pe-3">PROFILE</span>
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
                                <span>Profile</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="profile-picture d-flex justify-content-center">
                            <div class="profile-container">
                                <div class="crop-profile px-0">
                                    @if ($profile->user->userInfo->profile_picture != null)
                                        <img class="img-fluid"
                                            src="{{ asset('storage/profile_picture/' . $profile->user->userInfo->profile_picture) }}"
                                            type="button" data-bs-toggle="modal" data-bs-target="#view-operator-profile">
                                    @else

                                        <img src="{{ asset('assets/images/Profile_Placeholder.png') }}" type="button"
                                            data-bs-toggle="modal" data-bs-target="#view-operator-profile">
                                    @endif
                                    {{-- <a href="{{ route('operator.settings') }}">
                                        <button class="btn upload-button btn-primary btn-circle">
                                            <span style="color:white" id="material-icons" class="material-icons">edit</span>
                                        </button>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <strong class="d-flex justify-content-center">
                            {{ $profile->user->userInfo->first_name }} {{ $profile->user->userInfo->last_name }}
                        </strong>
                        <span class="d-flex justify-content-center driver-gmail" style="text-transform: none">
                            {{ $profile->user->email }}
                        </span>
                        @if ($user_type != null)
                            <div class="d-flex justify-content-center">
                                <span class="badge rounded-pill bg-primary px-3" style="font-size: medium;">
                                    {{ $user_type }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card p-3 mt-0">
                <div class="card-body">
                    <div class="row mb-3">
                        <Strong>Personal Information</Strong>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 pe-5">
                            <table class="mt-xl-0 w-100">
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">person</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">First Name</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->userInfo->first_name != null)
                                                {{ $profile->user->userInfo->first_name }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">person</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Middle Name</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->userInfo->middle_name != null)
                                                {{ $profile->user->userInfo->middle_name }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">person</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Last Name</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->userInfo->last_name != null)
                                                {{ $profile->user->userInfo->last_name }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">call</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Mobile Number</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title">
                                            @if ($profile->user->mobile_number != null)
                                                {{ $profile->user->mobile_number }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">email</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Email</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->email != null)
                                                {{ $profile->user->email }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">celebration</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Date Of Birth</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title">
                                            @if ($profile->user->userInfo->date_of_birth != null)
                                                {{ date('F d, Y', strtotime($profile->user->userInfo->date_of_birth)) }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 pe-5">
                            <table class="mt-2 mt-xl-0 w-100">
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">flag</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Country</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->userInfo->country != null)
                                                {{ $profile->user->userInfo->country }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">gite</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Province</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->userInfo->province != null)
                                                {{ $profile->user->userInfo->province }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">business</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">City/Municipality</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->userInfo->city_municipality != null)
                                                {{ $profile->user->userInfo->city_municipality }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">villa</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Barangay</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title">
                                            <span class="driver-right-title" style="text-transform: none">
                                                @if ($profile->user->userInfo->barangay != null)
                                                    {{ $profile->user->userInfo->barangay }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center mb-2">
                                        <span class="driver-icon material-icons">cottage</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Address</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title">
                                            <span class="driver-right-title" style="text-transform: none">
                                                @if ($profile->user->userInfo->address != null)
                                                    {{ $profile->user->userInfo->address }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pb-50 d-flex align-items-center   mb-2">
                                        <span class="driver-icon material-icons">markunread_mailbox</span>
                                        <span class="driver-right-title ps-1 font-weight-bold">Postal Code</span>
                                    </th>
                                    <td align="right">
                                        <span class="driver-right-title" style="text-transform: none">
                                            @if ($profile->user->userInfo->postal_code != null)
                                                {{ $profile->user->userInfo->postal_code }}
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
        </div>
    </div>
@endsection
