@extends('layouts.layout_management')

@section('title', 'Operator Information')

@push('css')
    <style>
        .status-icon {
            color: #8C27FF;
            /* transition: 0.4s ease; */
            display: block;
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



        #status-buttons-profile {
            display: none;
            left: 0%;
        }

        #status-buttons-payment {
            display: none;
        }

        #status-buttons-pending {
            display: none;
        }

        #status-buttons-verified {
            right: 0%;
            display: none;
        }

        .verified-accept {
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

        .header-details {
            font-weight: 500;
            font-size: 20px;
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
    <div class="modal fade" id="add-sub" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topUpModalLabel">
                        <strong>Add Subscriptions</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-sub-form" action="{{ route('management.addOperatorSubscription', $operator->id) }}"
                        method="POST">
                        @csrf
                        <section id="operator-req-info">
                            <div class="form-floating mb-3">
                                <select name="package_id" id="package_id" class="form-select"
                                    aria-label="Default select example">
                                    <option selected value="0">Open this select menu</option>
                                    @foreach ($package_list as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }}</option>
                                    @endforeach
                                </select>
                                <label for="wallet_method">
                                    Package Type
                                </label>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="add-sub-form" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

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
                            <input type="number" name="amount" id="amount" class="form-control" id="floatingInput"
                                placeholder=" " required>
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
                            <select name="package_id" id="package_id" class="form-select" aria-label="Default select example">
                                    <option selected value="0">Open this select menu</option>
                                    @foreach ($package_list as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }} ({{ $package->days }} days)</option>
                                    @endforeach
                            </select>
                            <label for="wallet_method">
                                Package ID
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="receiver_acc_name" id="receiver_acc_name"
                                placeholder=" " required>
                            <label for="receiver_acc_name">
                                Receiver Account Name
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="receiver_acc_no" id="receiver_acc_no"
                                placeholder=" " required>
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
                        <div class="input-group mb-3">
                            <label class="input-group-text">payment</label>
                            <input type="file" class="form-control" id="pop" name="pop">
                        </div>

                        {{-- Optional Ends --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="payment-form" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-payment" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topUpModalLabel">
                        <strong>Operator Payment Request</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="request-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Top Up Info --}}
                        <input type="hidden" id="request_id" name="id" value="">
                        <input type="hidden" id="request_user_id" name="user_id" value="">
                        <input type="hidden" id="action" name="action">
                        <input type="hidden" id="reqest-package-id" name="package_id" value="">
                        <div class="row p-5">
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Date Requested:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="date-content"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Mobile Number:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="mobile-content"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Email:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="email-content" style="text-transform: none"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Top up amount:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex">
                                            <span>₱ </span>
                                            <span id="amount-content"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Top up method:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="method-content">gcash</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Reciever account name:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="rec-acc-name-content">-</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Reciever account no:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="rec-acc-no-content">-</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Sender account name:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="send-acc-name-content">-</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Sender account no:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="send-acc-no-content">-</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <strong><span>Reference account no:</span></strong>
                                    </div>
                                    <div class="col-lg-6">
                                        <span id="ref-no-content">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <strong><span>Proof of Payment</span></strong>
                                </div>
                                <img src="" id="request_pop" class="img-fluid border rounded p-3" style="width: 100%"
                                    alt="no image">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="decline-btn" form="request-form" name="action" type="submit" value="decline"
                        class="btn btn-outline-primary">Decline</button>
                    <button id="approve-btn" form="request-form" name="action" type="submit" value="approve"
                        class="btn btn-primary">Approve</button>
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
        @include('include.management_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
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
                                    href="{{ route('management.userOperators') }}">
                                    Operator
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <small>
                            <span class="">Operator Info</span>
                        </small>
                    </div>
                    <div id="add-sub-refresh">
                        @if ($operator->operator_verification_status_id == 4)
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add-sub">
                                    <div class="d-flex align-items-center">
                                        Add Subscriptions
                                    </div>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div id="payment-detector">
                @if ($operator->operator_verification_status_id == 2)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card p-0 mb-0">
                                <div class="alert alert-danger m-0" role="alert">
                                    No Pending Payment Detected
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
                                            <img src="{{ asset('assets/images/Profile_Placeholder.png') }}" type="button"
                                                data-bs-toggle="modal" data-bs-target="#profile-picture">
                                        </div>
                                        <div class=" ml-1">
                                            <h4 class="mb-0">
                                                <strong class="driver-name">
                                                    {{ $operator->user->userInfo->first_name }}
                                                    {{ $operator->user->userInfo->last_name }}
                                                </strong>
                                            </h4>
                                            <span class="driver-gmail">
                                                {{ $operator->user->email }}
                                            </span>
                                            <div>
                                                <span class="badge rounded-pill px-3" style="font-size: medium;"
                                                    id="driver_status">
                                                    <div id="status-refresh">
                                                        {{ $operator->operatorVerificationStatus->status }}
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
                                                            two_wheeler
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <strong class="driver-left-title">Drivers</strong>
                                                    <p class="driver-left-value mt-0">
                                                        {{ $total_driver }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start">
                                                <div class="Icon">
                                                    <div
                                                        class="icon-background-2 d-flex icon-container h-100 w-100 align-items-center px-3 rounded">
                                                        <span class="icon-value-2 material-icons">
                                                            admin_panel_settings
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <strong class="driver-left-title">Sub-operator</strong>
                                                    <p class="driver-left-value mt-0">
                                                        {{ $total_sub_operator }}
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
                                                {{ $operator->user_id }}
                                            </span>
                                        </td>
                                    </tr>
                                    {{-- mobile --}}
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">phone_iphone</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">
                                                Mobile Number</span>
                                        </th>
                                        <td align="right">
                                            <span class="driver-right-title">
                                                {{ $operator->user->mobile_number }}
                                            </span>
                                        </td>
                                    </tr>
                                    {{-- city --}}
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">apartment</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">Type</span>
                                        </th>
                                        <td style="text-transform: none" align="right">
                                            <span class="driver-right-title text-capitalize">
                                                {{ $operator->operatorType->type }}
                                            </span>
                                        </td>
                                    </tr>
                                    {{-- vehicle type --}}
                                    <tr>
                                        <th class="pb-50 d-flex justify-item-center mb-2">
                                            <span class="driver-icon material-icons">directions_car</span>
                                            <span class="driver-right-title ps-1 font-weight-bold">
                                                Expiry Date
                                            </span>
                                        </th>
                                        <td style="text-transform: none" align="right">
                                            <span class="driver-right-title">
                                                <div id="expiry-date-profile-refresh">
                                                    @if ($operator->expiry_date != null)
                                                        {{ date('F d, Y', strtotime($operator->expiry_date)) }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
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
                                                {{ $operator->sponsor_code }}
                                            </span>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="footer-refresh">
                    @if ($operator->operator_verification_status_id != 5)
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
                                        <span class="status-icon activated material-icons">attach_money</span>
                                        <strong class="status-text">Payments</strong>
                                        <div class="status-button" id="status-buttons-payment">
                                            <button class="btn btn-primary p-1 px-2" data-bs-toggle="modal"
                                                data-bs-target="#payments"><small>upload here</small>
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
                                            <button class="status-buttons btn btn-primary rounded-circle"
                                                data-bs-toggle="modal" data-bs-target="#view-payment" id="accept">
                                                <span class="material-icons d-flex justify-content-center">
                                                    question_mark
                                                </span>
                                            </button>
                                        </div>
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
                                        <img class="img-fluid"
                                            src="{{ asset('assets/images/Operator_Valid_ID.png') }}">
                                    @endif
                                </div>
                                <label for="" class="d-flex justify-content-center"><small>Valid ID</small></label>
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
                                            <div id="op-details-status-refresh">
                                                {{ $operator->operatorVerificationStatus->status }}
                                            </div>
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
                                            <div id="expiry-date-details-refresh">
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
                                            <div class="col-lg-4 text-muted">Name:</div>
                                            <div class="info-details col-lg-8">
                                                @if ($referee != null)
                                                    {{ $referee->user->userInfo->first_name }}
                                                    {{ $referee->user->userInfo->last_name }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Email:</div>
                                            <div class="info-details col-lg-8">
                                                @if ($referee != null)
                                                    {{ $referee->user->email }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 text-muted">Mobile:</div>
                                            <div class="info-details col-lg-8">
                                                @if ($referee != null)
                                                    {{ $referee->user->mobile_number }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
                <div id="operator-sub-refresh">
                    @if ($operator->operatorSubscription)
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
                                        {{-- <div class="col-lg-6">
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
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div id="pending-payment-refresh">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col d-flex align-items-center">
                                            <span class="badge bg-primary material-icons p-2"
                                                style="font-size: 35px">paid</span>
                                            <span class="header-details px-2">
                                                Pending Operator Payments
                                            </span>
                                        </div>
                                    </div>
                                    {{-- table here --}}
                                    <div class="row ">
                                        <div class="bg-white" style="min-height: 180px; width:100%">
                                            <div class="mt-4 table-responsive">
                                                <table class="table table-hover" id="pending-payment-table"
                                                    style="width: 100%">
                                                    <thead class="text-primary">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Price</th>
                                                            <th>Status</th>
                                                            <th>DATE</th>
                                                            <th>ACTION</th>
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
                    {{-- pending payments --}}
                    @if ($pending_operator_payment->isNotEmpty() && $operator->operatorSubscription)
                    @endif
                </div>
                <div id="operator-subscription-refresh">
                    {{-- subscriptions --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col d-flex align-items-center">
                                            <span class="badge bg-primary material-icons p-2"
                                                style="font-size: 35px">subscriptions</span>
                                            <span class="header-details px-2">
                                                Subscribed Packages
                                            </span>
                                        </div>
                                    </div>
                                    {{-- table here --}}
                                    <div class="row ">
                                        <div class="bg-white" style="min-height: 180px; width:100%">
                                            <div class="mt-4 table-responsive">
                                                <table class="table table-hover" id="subscription-table"
                                                    style="width: 100%">
                                                    <thead class="text-primary">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Package Name</th>
                                                            <th>Price</th>
                                                            <th>created at</th>
                                                            <th>updated at</th>
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
        @include('include.operator_footer')
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

        let currentActive = @json($operator->operator_verification_status_id, JSON_PRETTY_PRINT);
        let pending_operator_payment = @json($pending_operator_payment->where('operator_payment_info_status_id', 1), JSON_PRETTY_PRINT);
        let user_id = @json($user->id, JSON_PRETTY_PRINT);
        let m_wallet_methods = @json($m_wallet_methods, JSON_PRETTY_PRINT);
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

        update();

        function update() {
            if (currentActive != 5) {
                if (currentActive === 1) {
                    $('#status-buttons-profile').show();
                } else if (currentActive === 2) {
                    $('#status-buttons-payment').show();
                } else if (currentActive === 3) {
                    $('#status-buttons-pending').show();
                } else if (currentActive === 4) {
                    $('#status-buttons-verified').show();
                }
            }

            if (currentActive === 1) {
                driver_status.style.backgroundColor = '#6C757D'
            } else if (currentActive === 2) {
                driver_status.style.backgroundColor = '#17A2B8';
            } else if (currentActive === 3) {
                driver_status.style.backgroundColor = '#FFC107';
            } else if (currentActive === 4) {
                driver_status.style.backgroundColor = '#198754';
            } else if (currentActive === 5) {
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
                    progress.style.width = "35%";
                } else if (currentActive == 3) {
                    progress.style.width = "65%";
                } else if (currentActive == 4) {
                    progress.style.width = "100%";
                }
            });
        }

        function viewContent(divSelector, value) {
            if (value != null) {
                document.querySelector(divSelector).innerHTML = value;
            } else {
                document.querySelector(divSelector).innerHTML = '-';
            }
        }

        function updateOperatorVerificationAjaxx(status_id) {
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
                "{{ route('management.userOperatorInfoUpdateVerificationStatus', ['id' => $operator->user_id,'status_id' => ':id']) }}";
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
                    Swal.fire({
                        icon: response.status,
                        title: response.title,
                        text: response.text,
                        timer: 3000,
                        showCancelButton: false,
                        showConfirmButton: false
                    });

                    currentActive = response.operator.operator_verification_status_id;
                    $("#status-refresh").load(window.location.href + " #status-refresh");
                    $("#op-details-status-refresh").load(window.location.href + " #op-details-status-refresh");

                    if (currentActive != 5) {
                        if (currentActive == 2) {
                            $('#status-buttons-profile').fadeOut();
                            $('#status-buttons-payment').fadeIn();
                            $('#payment-detector').fadeIn();
                            $("#payment-detector").load(window.location.href + " #payment-detector");
                        }
                    } else {
                        $("#footer-refresh").fadeOut('fast');
                    }

                    if (currentActive == 1) {
                        driver_status.style.backgroundColor = '#6C757D'
                    } else if (currentActive == 2) {
                        driver_status.style.backgroundColor = '#17A2B8';
                    } else if (currentActive == 3) {
                        driver_status.style.backgroundColor = '#FFC107';
                    } else if (currentActive == 4) {
                        driver_status.style.backgroundColor = '#198754';
                    } else if (currentActive == 5) {
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
                            progress.style.width = "35%";
                        } else if (currentActive == 3) {
                            progress.style.width = "65%";
                        } else if (currentActive == 4) {
                            progress.style.width = "100%";
                        }
                    });
                },
                error: function(error) {
                    alert('oops something went wrong');
                }
            });
        }

        if (currentActive != 5) {
            for (let i = 0; i < accept.length; i++) {
                accept[i].addEventListener("click", () => {
                    if (currentActive === 1) {
                        updateOperatorVerificationAjaxx(2);
                    } else if (currentActive === 3) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('management.getPaymentDetailsDirect') }}",
                            contentType: "application/json",
                            dataType: "json",
                            data: {
                                user_id: user_id,
                            },
                            success: function(response) {
                                let dateValue = new Date(response.payment_info.created_at);
                                date = ('00' + (dateValue.getMonth() + 1)).slice(-2) + '-' +
                                    dateValue.getDate() + '-' + dateValue.getFullYear()

                                $('#request_id').val(response.payment_info.id);
                                $('#request_user_id').val(response.payment_info.user_id);
                                $('#request_pop').attr('src', '{{ asset('storage/pop') }}' +
                                    '/' + response.payment_info
                                    .pop)
                                $('#reqest-package-id').val(response.payment_info.package_id);

                                viewContent('#date-content', date);
                                viewContent('#mobile-content', response.user.mobile_number);
                                viewContent('#email-content', response.user.email);
                                viewContent('#amount-content', response.payment_info.amount);
                                viewContent('#method-content', response.method.method);
                                viewContent('#rec-acc-name-content', response.payment_info
                                    .receiver_acc_name);
                                viewContent('#rec-acc-no-content', response.payment_info
                                    .receiver_acc_no);
                                viewContent('#send-acc-name-content', response.payment_info
                                    .sender_acc_name);
                                viewContent('#send-acc-no-content', response.payment_info
                                    .sender_acc_no);
                                viewContent('#ref-no-content', response.payment_info.ref_no);

                            },
                            error: function(error) {
                                alert('something went wrong')
                            }
                        });

                    }
                });
                decline[i].addEventListener("click", () => {
                    updateOperatorVerificationAjaxx(5);
                    driver_status.style.backgroundColor = '#DC3545';
                });
            }
        }



        $(document).ready(function() {
            $('#wallet_method_id').on('change', function() {
                if (this.value == 1) {
                    $("#receiver_acc_name").attr("readonly", false);
                    $("#receiver_acc_no").attr("readonly", false);
                } else {
                    $("#receiver_acc_name").attr("readonly", true);
                    $("#receiver_acc_no").attr("readonly", true);
                }
            });

            $('#decline-btn').on('click', function() {
                $('#action').val(this.value);
            });

            $('#approve-btn').on('click', function() {
                $('#action').val(this.value);
            });

            $('#operator-request').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

            $('#pending-payment-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('management.userOperatorInfoPendingPaymentsFetch', $operator->user_id) }}",
                    dataType: "json",
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "amount"
                    },
                    {
                        data: "status_name"
                    },
                    {
                        data: "created_at"
                    },
                    {
                        data: "updated_at"
                    },
                ],
                order: [
                    [0, 'desc']
                ],
                scrollX: true,
            });

            $('#subscription-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('management.userOperatorInfoSubscriptionPackegesFetch', $operator->user_id) }}",
                    dataType: "json",
                    dataSrc: function(data) {
                        return data.data;
                    },
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "package_name"
                    },
                    {
                        data: "price"
                    },
                    {
                        data: "created_at"
                    },
                    {
                        data: "updated_at"
                    },
                ],
                order: [
                    [0, 'desc']
                ],
                scrollX: true,
            });

            $('#pending-operators-payment-table tbody').on('click', '#view-payment-btn', function() {
                let id = $('#pending-operators-table').DataTable().row($(this).parents('tr')).data()[0];
                $.ajax({
                    type: "GET",
                    url: "{{ route('management.userOperatorInfoPaymetDetailsFetch') }}",
                    contentType: "application/json",
                    dataType: "json",
                    data: {
                        id: id,
                        user_id: user_id,
                    },
                    success: function(response) {
                        document.getElementById('request_id').value = response.payment_info
                            .id;
                        document.getElementById('request_user_id').value = response
                            .payment_info.user_id;
                        document.getElementById('request_pop').src =
                            '{{ asset('storage/pop') }}' + '/' + response.payment_info
                            .pop;
                        viewContent('#date-content', response.payment_info.created_at);
                        viewContent('#mobile-content', response.user.mobile_number);
                        viewContent('#email-content', response.user.email);
                        viewContent('#amount-content', response.payment_info.amount);
                        viewContent('#method-content', response.method.method);
                        viewContent('#rec-acc-name-content', response.payment_info
                            .receiver_acc_name);
                        viewContent('#rec-acc-no-content', response.payment_info
                            .receiver_acc_no);
                        viewContent('#send-acc-name-content', response.payment_info
                            .sender_acc_name);
                        viewContent('#send-acc-no-content', response.payment_info
                            .sender_acc_no);
                        viewContent('#ref-no-content', response.payment_info.ref_no);
                    },
                    error: function(error) {
                        alert('something went wrong')
                    }
                });
            });

            jQuery.validator.addMethod("notEqual", function(value, element, param) {
                return this.optional(element) || value != param;
            }, "This field is required.");

            $('#add-sub-form').validate({
                rules: {
                    package_id: {
                        notEqual: '0'
                    },
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
                submitHandler: function(form) {
                    form.submit();
                },
            });

            $('#payment-form').validate({
                rules: {
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

                    },
                    package_id: {
                        notEqual: 0,
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
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
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('management.userOperatorInfoAddPayment', $operator->user_id) }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
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
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            currentActive = response.operator
                                .operator_verification_status_id;
                            $('#pending-payment-table').DataTable().ajax.reload();
                            if (currentActive == 3) {
                                $('#payment-detector').fadeOut();
                                $('#status-buttons-payment').fadeOut();
                                $('#status-buttons-pending').fadeIn();
                                $("#payments").modal('toggle');
                                driver_status.style.backgroundColor = '#FFC107';
                                $("#status-refresh").load(window.location.href +
                                    " #status-refresh");
                                $("#op-details-status-refresh").load(window.location.href +
                                    " #op-details-status-refresh");
                                circles.forEach((circle, idx) => {
                                    if (idx < currentActive) {
                                        circle.classList.add("active");
                                    } else {
                                        circle.classList.remove("active");
                                    }
                                    const actives = document.querySelectorAll(
                                        ".active");
                                    if (currentActive == 3) {
                                        progress.style.width = "65%";
                                    }
                                });
                            } else {
                                alert('oops something went wrong');
                            }
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#request-form').validate({
                submitHandler: function(form, event) {
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
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('management.userOperatorInfoUpdatePaymentStatus') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
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
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            currentActive = response.operator
                                .operator_verification_status_id;

                            $("#view-payment").modal('toggle');
                            $("#status-refresh").load(window.location.href +
                                " #status-refresh");
                            $("#op-details-status-refresh").load(window.location.href +
                                " #op-details-status-refresh");


                            if (currentActive == 4) {
                                $('#status-buttons-pending').fadeOut();
                                $('#status-buttons-verified').fadeIn();
                                driver_status.style.backgroundColor = '#198754';
                                $("#expiry-date-details-refresh").load(window.location
                                    .href +
                                    " #expiry-date-details-refresh");
                                $("#expiry-date-profile-refresh").load(window.location
                                    .href +
                                    " #expiry-date-profile-refresh");
                                $("#add-sub-refresh").load(window.location
                                    .href +
                                    " #add-sub-refresh");

                                $('#pending-payment-table').DataTable().ajax.reload();
                                $('#subscription-table').DataTable().ajax.reload();
                                circles.forEach((circle, idx) => {
                                    if (idx < currentActive) {
                                        circle.classList.add("active");
                                    } else {
                                        circle.classList.remove("active");
                                    }
                                    const actives = document.querySelectorAll(
                                        ".active");
                                    if (currentActive == 4) {
                                        progress.style.width = "100%";
                                    }
                                });
                            } else {
                                alert('oops something went wrong !!')
                            }
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#payments').modal({}).on('show.bs.modal', function() {
                document.getElementById('amount').value = 10000;
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
