@extends('layouts.layout_operator')
@section('title', 'My Profile')

@push('css')
    <style>
        /* start */
        .crop-profile {
            width: 150px;
            height: 150px;
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

        #loadFile {
            display: none
        }

        .header-details {
            font-weight: 500;
            font-size: 20px;
        }

        .info-details {
            font-weight: 500;
        }

        .disp-name {
            font-size: 45px;
            padding: 0;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }

        div:not(.dataTables_scrollFoot)::-webkit-scrollbar {
            display: none;
        }

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

        #amount-div {
            display: none;
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
                            @if ($operator->user->userInfo->profile_picture != null)
                                <img class="img-fluid"
                                    src="{{ asset('storage/profile_picture/' . $operator->user->userInfo->profile_picture) }}">
                            @else
                                <img class="img-fluid" src="{{ asset('assets/images/Profile_Placeholder.png') }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Payment modal --}}
    <div class="modal fade" id="payments" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topUpModalLabel"><strong>Submit Payment</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="payment-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <select name="package_id" id="package-id" class="form-select"
                                aria-label="Default select example">
                                <option selected value="0">Open this select menu</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }} ({{ $package->days }}
                                        days)</option>
                                @endforeach
                            </select>
                            <label for="wallet_method">
                                Package Available
                            </label>
                        </div>
                        <div class="form-floating mb-3" id="amount-div">
                            <input type="number" name="amount" id="amount" class="form-control" id="floatingInput"
                                placeholder=" " required readonly>
                            <label for="amount">
                                Top Up Amount (₱)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="wallet_method_id" id="wallet_method_id" onChange="req_w_method(this.value)"
                                class="form-select" aria-label="Default select example">
                                @foreach ($m_wallet_methods as $methods)
                                    <option value="{{ $methods->walletMethod->id }}">
                                        {{ $methods->walletMethod->method }}</option>
                                @endforeach
                            </select>
                            <label for="wallet_method">
                                Top Up Method
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="receiver_acc_name" id="receiver_acc_name"
                                placeholder=" " required readonly>
                            <label for="receiver_acc_name">
                                Receiver Account Name
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="receiver_acc_no" id="receiver_acc_no"
                                placeholder=" " required readonly>
                            <label for="receiver_acc_no">
                                Receiver Account No.
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="sender_acc_name" id="sender_acc_name"
                                placeholder=" " required>
                            <label for="s_acc_name">
                                Sender Account Name
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="sender_acc_no" id="sender_acc_no"
                                placeholder=" " required>
                            <label for="s_acc_no">
                                Sender Account No.
                            </label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="ref_no" id="ref_no" placeholder=" " required>
                            <label for="ref_no">
                                Ref No.
                            </label>
                        </div>
                        <div>
                            <label for="pop" class="form-label mb-0">Proof of payments</label>
                            <input name="pop" id="req_pop" class="form-control form-control mb-3" type="file" required>
                        </div>

                        {{-- Optional Ends --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="payment-btn" type="submit" form="payment-form" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </div>
    </div>
    {{-- valid ID --}}
    <div class="modal fade" id="valid-id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="col-lg-12 d-flex justify-content-center">
                            @if ($operator->valid_id_image != null)
                                <img class="img-fluid"
                                    src="{{ asset('storage/operator/valid_id/' . $operator->valid_id_image) }}">
                            @else
                                <img class="img-fluid" src="{{ asset('assets/images/Operator_Valid_ID.png') }}">
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
        @include('include.operator_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header">
                    <div class="col-lg-12 d-flex align-items-center">
                        <span class="header-title border-end pe-3">PROFILE</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a class="d-flex align-items-center" href="{{ route('operator.index') }}">
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

            @if ($operator)
                @if ($operator->operator_verification_status_id == 1)
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="alert alert-danger m-0" role="alert">
                                Your profile is pending management review. Ensure all details are complete and correct. Go
                                to <strong>Settings</strong> to update.
                            </div>
                        </div>
                    </div>
                @endif
                @if ($operator->operator_verification_status_id == 2)
                    <div class="row mt-3" id="upload-alert">
                        <div class="col-lg-12">
                            <div class="alert alert-danger m-0" role="alert">
                                Please upload proof of payment
                                <button class="btn btn-primary p-1 px-2" data-bs-toggle="modal"
                                    data-bs-target="#payments"><small>upload here</small>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($operator->operator_verification_status_id == 3)
                    <div class="row mt-3" id="pending-alert">
                        <div class="col-lg-12">
                            <div class="alert alert-danger m-0" role="alert">
                                Your payment is now pending verification from management.
                            </div>
                        </div>
                    </div>
                @endif
                @if ($operator->operator_verification_status_id == 5)
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="alert alert-danger m-0" role="alert">
                                You have been rejected by the management
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row p-4">
                        <div class="d-flex flex-wrap">
                            <div class="profile-container d-flex align-items-center">
                                <div class="crop-profile px-0">
                                    @if ($operator->user->userInfo->profile_picture != null)
                                        <img class="img-fluid"
                                            src="{{ asset('storage/profile_picture/' . $operator->user->userInfo->profile_picture) }}"
                                            type="button" data-bs-toggle="modal" data-bs-target="#view-operator-profile">
                                    @else
                                        <img src="{{ asset('assets/images/Profile_Placeholder.png') }}" type="button"
                                            data-bs-toggle="modal" data-bs-target="#view-operator-profile">
                                    @endif
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="disp-name">
                                    <span>
                                        <strong>
                                            {{ $operator->user->userInfo->first_name }}
                                            {{ $operator->user->userInfo->last_name }}
                                        </strong>
                                    </span>
                                </div>
                                <div id="status-info-badge">
                                    @if ($operator->operator_verification_status_id == 1)
                                        <div class="status-badge badge rounded-pill bg-secondary"
                                            style="font-size: 15px; text-transform:capitalize; backroung-color: #6C757D">
                                            <span>
                                                {{ $operator->operatorVerificationStatus->status }}
                                            </span>
                                        </div>
                                    @elseif ($operator->operator_verification_status_id == 2)
                                        <div class="status-badge badge rounded-pill bg-info"
                                            style="font-size: 15px; text-transform:capitalize">
                                            <span>
                                                {{ $operator->operatorVerificationStatus->status }}
                                            </span>
                                        </div>
                                    @elseif ($operator->operator_verification_status_id == 3)
                                        <div class="status-badge badge rounded-pill bg-warning"
                                            style="font-size: 15px; text-transform:capitalize">
                                            <span>
                                                {{ $operator->operatorVerificationStatus->status }}
                                            </span>
                                        </div>
                                    @elseif ($operator->operator_verification_status_id == 4)
                                        <div class="status-badge badge rounded-pill bg-success"
                                            style="font-size: 15px; text-transform:capitalize">
                                            <span>
                                                {{ $operator->operatorVerificationStatus->status }}
                                            </span>
                                        </div>
                                    @elseif ($operator->operator_verification_status_id == 5)
                                        <div class="status-badge badge rounded-pill bg-danger"
                                            style="font-size: 15px; text-transform:capitalize">
                                            <span>
                                                {{ $operator->operatorVerificationStatus->status }}
                                            </span>
                                        </div>
                                    @else
                                    @endif

                                </div>
                                <div class="info-details" style="text-transform: capitalize">
                                    <span>
                                        <strong>{{ $operator->operatorType->type }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- personal Info --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-4 d-flex align-items-center">
                                    <span class="badge bg-primary material-icons p-2" style="font-size: 35px">person</span>
                                    <span class="header-details px-2">
                                        Personal Details
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Firstname:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->first_name != null)
                                                {{ $operator->user->userInfo->first_name }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Lastname:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->last_name != null)
                                                {{ $operator->user->userInfo->last_name }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Middlename:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->middle_name != null)
                                                {{ $operator->user->userInfo->middle_name }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Email:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->email != null)
                                                {{ $operator->user->email }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Mobile:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->mobile_number != null)
                                                {{ $operator->user->mobile_number }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Date of birth:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->date_of_birth != null)
                                                {{ date('F d, Y', strtotime($operator->user->userInfo->date_of_birth)) }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- operator Info --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-4 d-flex align-items-center">
                                    <span class="badge bg-primary material-icons p-2"
                                        style="font-size: 35px">admin_panel_settings</span>
                                    <span class="header-details px-2">
                                        Operator Details
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">UID:</div>
                                        <div class="info-details col-lg-8">
                                            {{ $operator->user->id }}

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Type:</div>
                                        <div class="info-details col-lg-8">
                                            {{ $operator->operatorType->type }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Code:</div>
                                        <div class="info-details col-lg-8">
                                            {{ $operator->sponsor_code }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Status:</div>
                                        <div class="info-details col-lg-8">
                                            {{ $operator->operatorVerificationStatus->status }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Referee ID:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->sponsor_id != null)
                                                {{ $operator->sponsor_id }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Expiry Date:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->expiry_date != null)
                                                {{ date('F d, Y', strtotime($operator->expiry_date)) }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- address Info --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-4 d-flex align-items-center">
                                    <span class="badge bg-primary material-icons p-2"
                                        style="font-size: 35px">location_on</span>
                                    <span class="header-details px-2">
                                        Address Details
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Address:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->address != null)
                                                {{ $operator->user->userInfo->address }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Country:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->country != null)
                                                {{ $operator->user->userInfo->country }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Province:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->province != null)
                                                {{ $operator->user->userInfo->province }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">City:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->city_municipality != null)
                                                {{ $operator->user->userInfo->city_municipality }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Barangay:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->barangay != null)
                                                {{ $operator->user->userInfo->barangay }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 text-muted">Postal Code:</div>
                                        <div class="info-details col-lg-8">
                                            @if ($operator->user->userInfo->postal_code != null)
                                                {{ $operator->user->userInfo->postal_code }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- wallet Details --}}
                @if ($operator->operator_verification_status_id == 4)
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mb-4 d-flex align-items-center">
                                        <span class="badge bg-primary material-icons p-2"
                                            style="font-size: 35px">wallet</span>
                                        <span class="header-details px-2">
                                            Wallet Details
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Gcash:</div>
                                            <div class="info-details col-lg-8">
                                                @if ($gcash != null)
                                                    {{ $gcash->acc_no }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Bdo:</div>
                                            <div class="info-details col-lg-8">
                                                @if ($bdo != null)
                                                    {{ $bdo->acc_no }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Bpi:</div>
                                            <div class="info-details col-lg-8">
                                                @if ($bpi != null)
                                                    {{ $bpi->acc_no }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Balance:</div>
                                            <div class="info-details col-lg-8">
                                                ₱ {{ number_format($balance, 2) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Commission:</div>
                                            <div class="info-details col-lg-8">
                                                ₱ {{ number_format($commission, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- referee Details --}}
                @if ($referee != null)
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mb-4 d-flex align-items-center">
                                        <span class="badge bg-primary material-icons p-2"
                                            style="font-size: 35px">volunteer_activism</span>
                                        <span class="header-details px-2">
                                            Referee Details
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Code:</div>
                                            <div class="info-details col-lg-8">
                                                @if ($referee != null)
                                                    {{ $referee->sponsor_code }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($operator->operatorSubscription)
                    {{-- vehicle limits --}}
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mb-4 d-flex align-items-center">
                                        <span class="badge bg-primary material-icons p-2"
                                            style="font-size: 35px">local_shipping</span>
                                        <span class="header-details px-2">
                                            Vehicle Limits
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Motorcycle:</div>
                                            <div class="info-details col-lg-8">
                                                {{ $motorcycle_limit }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Sedan:</div>
                                            <div class="info-details col-lg-8">
                                                {{ $sedan_limit }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- sub list --}}
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col d-flex align-items-center">
                                        <span class="badge bg-primary material-icons p-2"
                                            style="font-size: 35px">subscriptions</span>
                                        <span class="header-details px-2">
                                            Subscription Lists
                                        </span>
                                    </div>
                                </div>
                                {{-- table here --}}
                                <div class="row ">
                                    <table class="table table-hover" id="subscription-table" style="width: 100%">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>ID</th>
                                                <th>Package ID</th>
                                                <th>Price</th>
                                                <th>Motorcycle</th>
                                                <th>Sedan</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ope_sub_list as $sub)
                                                <tr>
                                                    @php
                                                        $motor = $sub->package->vehicleLimit->where('vehicle_id', 1)->first();
                                                        $sedan = $sub->package->vehicleLimit->where('vehicle_id', 2)->first();
                                                    @endphp
                                                    <td>{{ $sub->id }}</td>
                                                    <td>{{ $sub->package->id }}</td>
                                                    <td>{{ $sub->package->price }}</td>
                                                    <td>{{ $motor->limit }}</td>
                                                    <td>{{ $sedan->limit }}</td>
                                                    <td>{{ date('F d, Y', strtotime($sub->created_at)) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-4 d-flex align-items-center">
                                    <span class="badge bg-primary material-icons p-2" style="font-size: 35px">badge</span>
                                    <span class="header-details px-2">
                                        Valid ID
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="driver-image-container p-2 border border-2 rounded">
                                        @if ($operator->valid_id_image != null)
                                            <img class="img-fluid"
                                                src="{{ asset('storage/operator/valid_id/' . $operator->valid_id_image) }}"
                                                type="button" data-bs-toggle="modal" data-bs-target="#valid-id">
                                        @else
                                            <img src="{{ asset('assets/images/driving_license_placeholder.png') }}"
                                                type="button" data-bs-toggle="modal" data-bs-target="#valid-id"
                                                class="rounded">
                                        @endif
                                    </div>
                                    <label for="" class="d-flex justify-content-center"><small>Valid ID</small></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @include('include.operator_footer')
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let m_wallet_methods = @json($m_wallet_methods, JSON_PRETTY_PRINT);
        let packages = @json($packages, JSON_PRETTY_PRINT);
        let method;


        function req_id_method(id) {
            m_wallet_methods.forEach(element => {
                if (element.wallet_method_id == id) {
                    method = element;
                }
            });
        }

        function req_w_method(topUpMethod) {
            req_id_method(topUpMethod);
            if (topUpMethod != 5) {
                document.getElementById('receiver_acc_name').value = method.acc_name;
                document.getElementById('receiver_acc_no').value = method.acc_no;
            } else {
                document.getElementById('receiver_acc_name').value = null;
                document.getElementById('receiver_acc_no').value = null;
            }
        }
        $(document).ready(function() {
            $('#subscription-table').DataTable({
                bLengthChange: false,
                "lengthMenu": [
                    [5, 10, , -1],
                    [5, 10, "All"]
                ],
                "searching": false,
                "scrollX": true
            });

            jQuery.validator.addMethod("notEqual", function(value, element, param) {
                return this.optional(element) || value != param;
            }, "This field is required.");

            $('#payment-form').validate({
                rules: {
                    package_id: {
                        notEqual: 0
                    },
                    amount: {
                        required: true,
                        number: true,
                    },
                    s_acc_name: {
                        required: true
                    },
                    s_acc_no: {
                        required: true
                    },
                    ref_no: {
                        required: true
                    },
                    pop: {
                        required: true,
                    }
                },
                messages: {
                    amount: {
                        number: "input number only",
                        range: "Please Input Minimum of ₱100.00",
                    },
                    pop: {
                        required: "Please input new password",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#payment-btn').attr('disabled', true).text('loading');
                    $.ajax({
                        url: "{{ route('operator.operatorPayment') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function () {
                            $('#payment-btn').attr('disabled', false).text('Submit');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#status-info-badge').children('.status-badge').removeClass('bg-info').addClass('bg-warning').children('span').text('pending');
                            $('#payments').modal('toggle');
                            $('#upload-alert').fadeOut('fast', function() {
                                row = $(document.createElement('div')).addClass('row mt-3').attr('id', 'pending-alert').insertAfter($('.content-header').parent());
                                col = $(document.createElement('div')).addClass('col-lg-12').appendTo(row);
                                alert = $(document.createElement('div')).addClass('alert alert-danger m-0').attr('role', 'alert').text('Your payment is now pending verification from managment').appendTo(col);
                            });
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#payments').modal().on('show.bs.modal', function() {
                req_w_method(1);
                document.getElementById('wallet_method_id').value = 1;
            })

            $('#package-id').on('change', function() {
                let package_selected;
                packages.forEach((package, idx) => {
                    if (package.id == $(this).val()) {
                        package_selected = package;
                    }
                });

                if ($(this).val() != 0) {
                    $('#amount-div').fadeIn();
                    $('#amount').val(package_selected.price)
                } else {
                    $('#amount-div').fadeOut();
                }

            })
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
