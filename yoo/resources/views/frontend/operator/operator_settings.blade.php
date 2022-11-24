@extends('layouts.layout_operator')

@section('title', 'Settings Page')

@push('css')
    <style>
        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff !important;
            background-color: #8C27FF !important;
        }

        .nav-pills .nav-link {
            color: #8C27FF !important
        }

        .text-danger {
            font-size: 13px;
            text-transform: none;
        }

        .crop-profile {
            width: 100px;
            height: 100px;
            border-radius: 15px;
            overflow: hidden;
        }

        .crop-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #amount-div {
            display: none;
        }

        #otp-verification-form input {
            margin-right: 12px;
            height: 70px;
            font-size: 20px;
            text-align: center;
            font-weight: 600;
        }

        #otp-verification-form input:focus {
            color: #495057;
            background-color: #fff;
            border-color: #8C27FF;
            outline: 100;
            box-shadow: none;
        }

        .cursor {
            cursor: pointer;
        }
    </style>
@endpush

@push('modal')
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
                                @foreach ($wm_available as $methods)
                                    @if ($methods)
                                        <option value="{{ $methods->walletMethod->id }}">
                                            {{ $methods->walletMethod->id }}</option>
                                    @endif
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
                            <input type="text" class="form-control" name="ref_no" id="ref_no" placeholder=" "
                                required>
                            <label for="ref_no">
                                Ref No.
                            </label>
                        </div>
                        <div>
                            <label for="pop" class="form-label mb-0">Proof of payments</label>
                            <input name="pop" id="req_pop" class="form-control form-control mb-3" type="file"
                                required>
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
    <div class="modal fade" id="update-wallet-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-keyboard="false" data-bs-backdrop="static" data-bs-target="#staticBackdrop">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update-wallet-modal-title">Updating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="update-wallet-form" method="POST" action="">
                        @csrf
                        <input type="hidden" id="wallet-info-id" name="wallet_info_id">
                        <div class="form-floating mb-3">
                            <input type="text" id="update-acc-name" name="acc_name" class="form-control"
                                placeholder=" ">
                            <label for="notes">Account Name or Address</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" id="update-acc-no" name="acc_no" class="form-control"
                                placeholder=" ">
                            <label for="notes">Account Number or Mobile Number</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="update-wallet-btn" form="update-wallet-form"
                        class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disconnect-wallet-modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disconnect-wallet-modal-title">Confirm Disconnect</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="pb-3" id="disconnect-wallet-modal-text">are you sure you want to disconnect?</span>
                    <form id="disconnect-wallet-form" action="" method="POST">
                        @csrf
                        <input type="hidden" id="disconnect-wallet-info-id" name="wallet_info_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="disconnect-wallet-form" id="disconnect-wallet-btn"
                        class="btn btn-primary">Confirm</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="connect-wallet-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-target="#staticBackdrop">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connect-wallet-modal-title">Connecting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="connect-wallet-form" method="POST" action="">
                        @csrf
                        <input type="hidden" id="wallet-method-id" name="wallet_method_id">
                        <div class="form-floating mb-3">
                            <input type="text" id="connect-acc-name" name="acc_name" class="form-control"
                                placeholder=" ">
                            <label for="notes">Account Name or Address</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" id="connect-acc-no" name="acc_no" class="form-control"
                                placeholder=" ">
                            <label for="notes">Account Number or Mobile Number</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="connect-wallet-btn" form="connect-wallet-form"
                        class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="otp-verification-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-target="#staticBackdrop">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="d-flex justify-content-center align-items-center container">
                    <div class="py-5 px-3">
                        <div class="text-center mb-4">
                            <h5 class="m-0"><strong>OTP Verification</strong></h5>
                            <span>Enter verification code we sent to</span>
                            <br>
                            <small>
                                <strong id="otp-mobile-number">09275652944</strong>
                            </small>
                        </div>
                        <span>Type your 4 digit security code</span>
                        <form id="otp-verification-form" action="POST">
                            @csrf
                            <input type="hidden" name="otp_id" id="otp_id">
                            <input type="hidden" id="otp_code" name="otp_code">
                            <input type="hidden" id="new_pass" name="password">
                            <div class="d-flex flex-row" id="otp_code_field">
                                <input type="text" maxlength="1" id="first" class="form-control otp-input"
                                    autofocus>
                                <input type="text" maxlength="1" id="second" class="form-control otp-input">
                                <input type="text" maxlength="1" id="third" class="form-control otp-input">
                                <input type="text" maxlength="1" id="fourth" class="form-control otp-input">
                            </div>
                        </form>
                        <div class="text-center mt-5">
                            <span class="d-block mobile-text">Don't Recieve the code? <strong
                                    class="text-primary cursor">Resend Code</strong>
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
                        <span class="header-title border-end pe-3">SETTINGS</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a class="d-flex align-items-center" href="{{ route('operator.index') }}">
                                    <span id="click-link"
                                        class="material-icons d-flex align-items-center ps-2">home</span>
                                </a>
                            </small>
                            <span class="material-icons d-flex align-items-center">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Settings</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

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

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills col-lg-3 " id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active d-flex mb-2" id="general-tab" data-bs-toggle="pill"
                                data-bs-target="#general" type="button" role="tab" aria-controls="general"
                                aria-selected="true">
                                <span class="material-icons pe-2">person</span>
                                General
                            </button>
                            @if ($operator->operator_verification_status_id == 4)
                                <button class="nav-link d-flex mb-2" id="wallet-method-tab" data-bs-toggle="pill"
                                    data-bs-target="#wallet-method" type="button" role="tab"
                                    aria-controls="wallet-method" aria-selected="true">
                                    <span class="material-icons pe-2">account_balance_wallet</span>
                                    Wallet Method
                                </button>
                            @endif
                            <button class="nav-link d-flex mb-2" id="change-pass-tab" data-bs-toggle="pill"
                                data-bs-target="#change-pass" type="button" role="tab" aria-controls="change-pass"
                                aria-selected="true">
                                <span class="material-icons pe-2">vpn_key</span>
                                Change Password
                            </button>
                        </div>

                        <div class="tab-content col-lg-9" id="v-pills-tabContent">
                            <div class="tab-pane fade show px-4 active" id="general" role="tabpanel"
                                aria-labelledby="v-pills-home-tab">
                                {{-- form --}}
                                <form id="update-profile-form" action="" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mb-3">
                                    @csrf
                                    <div class="col-lg-12 d-flex">
                                        <div class="row d-flex">
                                            <div class="profile-picture">
                                                <div class="profile-container">
                                                    <div class="crop-profile px-0">
                                                        @if ($operator->user->userInfo->profile_picture != null)
                                                            <img id="profile-pircure-img" class="img-fluid"
                                                                src="{{ asset('storage/profile_picture/' . $operator->user->userInfo->profile_picture) }}"
                                                                type="button">
                                                        @else
                                                            <img id="profile-pircure-img" src="{{ asset('assets/images/Profile_Placeholder.png') }}"
                                                                type="button" data-bs-toggle="modal"
                                                                data-bs-target="#view-management-profile">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex pt-4 px-4 mb-1">
                                                <input name="profile_picture" id="profile_picture" type="file">
                                            </div>
                                            <span class="px-4">Allowed JPG ,JPEG or PNG. Max size of 2MB</span>
                                        </div>
                                    </div>

                                    <span class="mt-4"><strong>Contacts</strong></span>
                                    {{-- mobile --}}
                                    <div class="col-md-12">
                                        <div class="form-floating mt-2">
                                            <input type="mobile"
                                                class="form-control @error('mobile_number') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="mobile_number" name="mobile_number" placeholder="Mobile No"
                                                value="{{ $operator->user->mobile_number }}" readonly>
                                            <label for="floatingInput">Mobile Number</label>
                                        </div>
                                    </div>
                                    {{-- email --}}
                                    <div class="col-md-12">
                                        <div class="form-floating mt-2">
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="email" name="email" placeholder="Email"
                                                value="{{ $operator->user->email }}">
                                            <label for="floatingInput">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mt-2">
                                            <input type="text"
                                                class="form-control @error('fb_link') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="fb_link" name="fb_link" placeholder=" "
                                                value="{{ $operator->user->userInfo->fb_link }}">
                                            <label for="floatingInput">Facebook Link</label>
                                        </div>
                                    </div>

                                    <span class="mt-4"><strong>Profile</strong></span>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="first_name" name="first_name" placeholder=" "
                                                value="{{ $operator->user->userInfo->first_name }}">
                                            <label for="floatingInput">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="last_name" name="last_name" placeholder=" "
                                                value="{{ $operator->user->userInfo->last_name }}">
                                            <label for="floatingInput">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mt-2">
                                            <input type="text"
                                                class="form-control @error('middle_name') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="middle_name" name="middle_name" placeholder=" "
                                                value="{{ $operator->user->userInfo->middle_name }}">
                                            <label for="floatingInput">Middle Name</label>
                                        </div>
                                    </div>
                                    {{-- date of birth --}}
                                    <div class="col-md-6">
                                        <div class="form-floating mt-2">
                                            <input type="date"
                                                class="form-control @error('date_of_birth') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="date_of_birth" name="date_of_birth" placeholder="Date of birth"
                                                value="{{ $operator->user->userInfo->date_of_birth }}">
                                            <label for="floatingInput">Date of birth</label>
                                        </div>
                                    </div>

                                    <span><strong>Address</strong></span>
                                    {{-- address --}}
                                    <div class="col-md-12">
                                        <div class="form-floating mt-2">
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="address" name="address" placeholder="Address"
                                                value="{{ $operator->user->userInfo->address }}">
                                            <label for="floatingInput">Address</label>
                                        </div>
                                    </div>
                                    {{-- country --}}
                                    <div class="col-md-6">
                                        <div class="form-floating mt-2">
                                            <select name="country" id="country" class="form-select"
                                                aria-label="Default select example">
                                                <option value="Phillipines">Philippines</option>
                                            </select>
                                            <label for="country">
                                                Country
                                            </label>
                                        </div>
                                    </div>
                                    {{-- province --}}
                                    <input type="hidden" id="province" name="province"
                                        value="{{ $operator->user->userInfo->province }}">
                                    <div class="col-md-6">
                                        <div class="form-floating mt-2">
                                            <select name="province_code" id="province_code" class="form-select"
                                                aria-label="Default select example"
                                                @if ($user->userInfo->province_code == null) disabled @endif>
                                                @if ($user->userInfo->province_code != null)
                                                    <option value="0" selected>select province</option>
                                                    <option value="{{ $user->userInfo->province_code }}" selected>
                                                        {{ $operator->user->userInfo->province }}
                                                    </option>
                                                @else
                                                    <option value="0" selected>select province</option>
                                                @endif
                                            </select>
                                            <label for="province_code">
                                                Province
                                            </label>
                                        </div>
                                    </div>
                                    {{-- city --}}
                                    <input type="hidden" id="city_municipality" name="city_municipality"
                                        value="{{ $operator->user->userInfo->city_municipality }}">
                                    <div class="col-md-5">
                                        <div class="form-floating mt-2">
                                            <select name="citymun_code" id="citymun_code" class="form-select"
                                                aria-label="Default select example"
                                                @if ($user->userInfo->citymun_code == null) disabled @endif>
                                                @if ($user->userInfo->citymun_code != null)
                                                    <option value="{{ $user->userInfo->citymun_code }}" selected>
                                                        {{ $user->userInfo->city_municipality }}
                                                    </option>
                                                @else
                                                    <option value="0" selected>select city municipality</option>
                                                @endif
                                            </select>
                                            <label for="citymun_code">
                                                City Municipality
                                            </label>
                                        </div>
                                    </div>
                                    {{-- barangay --}}
                                    <input type="hidden" id="barangay" name="barangay"
                                        value="{{ $operator->user->userInfo->barangay }}">
                                    <div class="col-md-4">
                                        <div class="form-floating mt-2">
                                            <select name="brgy_code" id="brgy_code" class="form-select"
                                                aria-label="Default select example"
                                                @if ($user->userInfo->brgy_code == null) disabled @endif>
                                                @if ($user->userInfo->brgy_code != null)
                                                    <option value="{{ $user->userInfo->brgy_code }}" selected>
                                                        {{ $user->userInfo->barangay }}
                                                    </option>
                                                @else
                                                    <option value="0" selected>select barangay</option>
                                                @endif
                                            </select>
                                            <label for="brgy_code">
                                                Barangay
                                            </label>
                                        </div>
                                    </div>
                                    {{-- postal code --}}
                                    <div class="col-md-3">
                                        <div class="form-floating mt-2">
                                            <input type="text"
                                                class="form-control @error('postal_code') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                                id="postal_code" name="postal_code" placeholder="Postal Code"
                                                value="{{ $operator->user->userInfo->postal_code }}">
                                            <label for="floatingInput">Postal Code</label>
                                        </div>
                                    </div>
                                    @if ($user->userInfo->brgy_code == null && $user->userInfo->citymun_code == null && $user->userInfo->province_code == null)
                                        <button id="update-profile-btn" type="submit" form="update-profile-form"
                                            class="btn btn-primary mt-5 mb-1" disabled>Save Changes</button>
                                    @else
                                        <button id="update-profile-btn" type="submit" form="update-profile-form"
                                            class="btn btn-primary mt-5 mb-1">Save Changes</button>
                                    @endif

                                </form>
                            </div>
                            @if ($operator->operator_verification_status_id == 4)
                                <div class="tab-pane fade show px-4" id="wallet-method" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <div class="row">
                                        @foreach ($wm_available as $key => $wm)
                                            @if ($wm)
                                                <div class="col-lg-4 p-5" id="wallet-type-{{ $wm->walletMethod->id }}">
                                                    <div class="d-flex justify-content-center mt-5 mb-3">
                                                        <img class="img-fluid img-thumbnail border rounded-circle"
                                                            src="{{ asset('/storage/wallet-method/' . $wm->walletMethod->image) }}"
                                                            style="height: 102px; width: 102px" alt="gcash_logo.png">
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <span>
                                                            <strong id="wallet-method-no-{{ $wm->id }}">
                                                                {{ $wm->acc_no }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <span class="text-capitalized"
                                                            id="wallet-method-name-{{ $wm->id }}">
                                                            {{ $wm->acc_name }}
                                                        </span>
                                                    </div>

                                                    <div class="d-flex justify-content-center mt-2">
                                                        <button class="btn btn-outline-danger mx-1 wallet-disconnect-btn"
                                                            value="{{ $wm->id }}">
                                                            Disconnect
                                                        </button>
                                                        <button class="btn btn-primary mx-1 wallet-update-btn"
                                                            value="{{ $wm->id }}">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                @php
                                                    $wallet_method = \App\Models\WalletMethod::find($key + 1);
                                                @endphp
                                                <div class="col-lg-4 p-5" id="wallet-type-{{ $wallet_method->id }}">
                                                    <div class="d-flex justify-content-center mt-5 mb-3">

                                                        <img class="img-fluid img-thumbnail border rounded-circle"
                                                            src="{{ asset('storage/wallet-method/' . $wallet_method->image) }}"
                                                            style="height: 102px; width: 102px" alt="gcash_logo.png">
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-2"
                                                        id="{{ $wallet_method->method }}">
                                                        <button class="btn btn-outline-primary wallet-connect-btn"
                                                            value="{{ $wallet_method->id }}">Connect</button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="tab-pane fade show px-4" id="change-pass" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <form id="change-pass-form" action="" method="POST">
                                        @csrf
                                        <input type="hidden" name="mobile_number" value="{{ $user->mobile_number }}">
                                        <div class="mb-2">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="old-password" name="old_password"
                                                    placeholder="Password" type="password">
                                                <label for="floatingInput">Old Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="new-password" name="new_password"
                                                    placeholder="Password" type="password">
                                                <label for="floatingInput">New Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="new-password-confirmation"
                                                    name="new_password_confirmation" placeholder="Password Confirmation"
                                                    type="password">
                                                <label for="floatingInput">New Password Confirmation</label>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" id="change-pass-reset-btn"
                                                class="btn btn-outline-secondary me-2">Reset</button>
                                            <button type="submit" id="change-pass-btn" form="change-pass-form"
                                                class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
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
        let packages = @json($packages, JSON_PRETTY_PRINT);
        let method;
        let otp_set = [];


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
            jQuery.validator.addMethod("notEqual", function(value, element, param) {
                return this.optional(element) || value != param;
            }, "This field is required.");

            function walletUpdateButton() {
                $('.wallet-update-btn').off('click').on('click', function() {
                    let url = "{{ route('operator.settingsWalletFetch', ':id') }}";
                    url = url.replace(':id', $(this).attr('value'));
                    $.ajax({
                        url: url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#update-wallet-modal-title').text('Updating ' + response
                                .wallet_info.wallet_method.method.toUpperCase() + ' Method');
                            $('#wallet-info-id').val(response.wallet_info.id);
                            $('#update-acc-name').val(response.wallet_info.acc_name);
                            $('#update-acc-no').val(response.wallet_info.acc_no);
                            $('#update-wallet-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            function walletDisconnectButton() {
                $('.wallet-disconnect-btn').off('click').on('click', function() {
                    let url = "{{ route('operator.settingsWalletFetch', ':id') }}";
                    url = url.replace(':id', $(this).attr('value'));
                    $.ajax({
                        url: url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#disconnect-wallet-modal-title').text('Disconnecting ' + response
                                .wallet_info.wallet_method.method.toUpperCase() + ' Method');
                            $('#disconnect-wallet-modal-text').text(
                                'are you sure you want to disconnect your ' + response
                                .wallet_info.wallet_method.method.toUpperCase() +
                                ' wallet method?');
                            $('#disconnect-wallet-info-id').val(response.wallet_info.id);
                            $('#disconnect-wallet-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            function walletConnectButton() {
                $('.wallet-connect-btn').off('click').on('click', function() {
                    $('#connect-wallet-modal').modal('toggle');
                    sample = $(this).parent().attr('id');
                    $('#connect-wallet-modal-title').text('Connecting ' + $(this).parent().attr('id')
                        .toUpperCase() + ' Method');
                    $('#wallet-method-id').val($(this).attr('value'));
                });
            }

            function getProvince() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('address.province') }}",
                    contentType: "application/json",
                    dataType: "json",
                    success: function(data) {
                        user_province_code = "{{ $user->userInfo->province_code }}";
                        if (user_province_code == '' || user_province_code != null) {
                            if ($('#province_code').val() == 0) {
                                $('#citymun_code').attr('disabled', true);
                                $('#brgy_code').attr('disabled', true);
                                $('#province_code').attr('disabled', false);
                            } else {
                                $('#province_code').attr('disabled', false);
                                getCities();
                            }
                        }

                        data.forEach(element => {
                            $(document.createElement('option'))
                                .attr('value', element.province_code).text(element.province)
                                .appendTo($('#province_code'));
                        });
                    },
                    error: function(error) {
                    }
                });
            }

            function getCities() {
                province_code = $("#province_code").val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('address.city') }}",
                    contentType: "application/json",
                    dataType: "json",
                    data: {
                        data: province_code,
                    },
                    success: function(data) {
                        data.forEach(element => {
                            $(document.createElement('option'))
                                .attr('value', element.citymun_code).text(element.citymun)
                                .appendTo($('#citymun_code'));
                        });
                        $('#citymun_code').attr('disabled', false);
                        if ($('#citymun_code').val() == 0) {
                            $('#brgy_code').attr('disabled', true);
                        } else {
                            getBarangay();
                        }
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            }

            function getBarangay() {
                citymun_code = $("#citymun_code").val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('address.barangay') }}",
                    contentType: "application/json",
                    dataType: "json",
                    data: {
                        data: citymun_code,
                    },
                    success: function(data) {
                        $('#brgy_code').attr('disabled', false);
                        data.forEach(element => {
                            $(document.createElement('option'))
                                .attr('value', element.brgy_code).text(element.brgy)
                                .appendTo($('#brgy_code'));
                        });

                        $('#update-profile-btn').attr('disabled', false).text('Save Changes');
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            }

            function checkEmptyAddress() {
                province_code = $('#province_code').val();
                citymun_code = $('#citymun_code').val();
                brgy_code = $('#brgy_code').val();

                if (province_code == 0 || citymun_code == 0 || brgy_code == 0 || province_code == '' || citymun_code == '' || brgy_code == '') {
                    $('#update-profile-btn').attr('disabled', true);
                } else {
                    $('#update-profile-btn').attr('disabled', false);
                }
            }

            $('#province_code').on('change', function() {
                if ($(this).val() == 0) {
                    $('#citymun_code').attr('disabled', true);
                } else {
                    $(this).removeClass('is-invalid');
                    getCities();
                }
                document.getElementById("province").value = $("#province_code option:selected").text();

                $('#citymun_code').children().remove();
                citymun_append = $(document.createElement('option'))
                    .attr('value', 0).text('select city municipality')
                    .attr('selected', 'selected')
                    .appendTo($('#citymun_code'));

                $('#brgy_code').children().remove();
                brgy_append = $(document.createElement('option'))
                    .attr('value', 0).text('select barangay')
                    .attr('selected', 'selected')
                    .appendTo($('#brgy_code'));

                checkEmptyAddress();
            });

            $('#citymun_code').on('change', function() {
                if ($(this).val() == 0) {
                    $('#brgy_code').attr('disabled', true);
                } else {
                    $(this).removeClass('is-invalid');
                    getBarangay();
                }

                $("#city_municipality").val($("#citymun_code option:selected").text());

                $('#brgy_code').children().remove();
                $(document.createElement('option'))
                    .attr('value', 0).text('select barangay')
                    .attr('selected', 'selected')
                    .appendTo($('#brgy_code'));
                checkEmptyAddress();
            });

            $('#brgy_code').on('change', function() {
                document.getElementById("barangay").value = $("#brgy_code option:selected").text()
                checkEmptyAddress();
            });

            walletUpdateButton();
            walletDisconnectButton();
            walletConnectButton();
            getProvince()

            $('#update-wallet-form').validate({
                rules: {
                    acc_name: {
                        required: true,
                    },
                    acc_no: {
                        required: true,
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
                    $('#update-wallet-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.settingsWalletUpdate') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#update-wallet-btn').attr('disabled', false).text('Confirm');
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
                            $('#update-wallet-modal').modal('toggle');
                            $('#update-wallet-form').trigger('reset');
                            $('#wallet-method-name-' + response.wallet_info.id).text(
                                response.wallet_info.acc_name);
                            $('#wallet-method-no-' + response.wallet_info.id).text(response
                                .wallet_info.acc_no);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#connect-wallet-form').validate({
                rules: {
                    acc_name: {
                        required: true,
                    },
                    acc_no: {
                        required: true,
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
                    $('#connect-wallet-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.settingsWalletConnect') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#connect-wallet-btn').attr('disabled', false).text(
                                'Confirm');
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
                            $('#connect-wallet-modal').modal('toggle');
                            $('#connect-wallet-form').trigger('reset');
                            image_src = "{{ asset('/storage/wallet-method/') }}" + '/' +
                                response.wallet_info.wallet_method.image
                            wallet_card = `
                                    <div class="d-flex justify-content-center mt-5 mb-3">
                                        <img class="img-fluid img-thumbnail border rounded-circle"
                                            src="${ image_src }"
                                            style="height: 102px; width: 102px" alt="gcash_logo.png">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <span>
                                            <strong  id="wallet-method-no-${ response.wallet_info.id }">
                                                ${ response.wallet_info.acc_no }
                                            </strong>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <span class="text-capitalized" id="wallet-method-name-${response.wallet_info.id }">
                                            ${ response.wallet_info.acc_name }
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-center mt-2">
                                        <button class="btn btn-outline-danger mx-1 wallet-disconnect-btn" value="${ response.wallet_info.id }">
                                            Disconnect
                                        </button>
                                        <button class="btn btn-primary mx-1 wallet-update-btn" value="${ response.wallet_info.id }">
                                            Update
                                        </button>
                                    </div>
                            `
                            $('#wallet-type-' + response.wallet_info.wallet_method_id).html(
                                wallet_card);
                            walletUpdateButton();
                            walletDisconnectButton();
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#disconnect-wallet-form').validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#disconnect-wallet-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.settingsWalletDisconnect') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#disconnect-wallet-btn').attr('disabled', false).text(
                                'Confirm');
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

                            $('#disconnect-wallet-modal').modal('toggle');
                            $('#disconnect-wallet-form').trigger('reset');

                            image_src = "{{ asset('/storage/wallet-method/') }}" + '/' +
                                response.wallet_info.wallet_method.image
                            wallet_card = `
                            <div class="d-flex justify-content-center mt-5 mb-3">
                                <img class="img-fluid img-thumbnail border rounded-circle"
                                    src="${ image_src }"
                                    style="height: 102px; width: 102px" alt="gcash_logo.png">
                            </div>
                            <div class="d-flex justify-content-center mt-2" id="${ response.wallet_info.wallet_method.method }">
                                <button class="btn btn-outline-primary wallet-connect-btn" value="${ response.wallet_info.wallet_method.id }">Connect</button>
                            </div>
                            `
                            $('#wallet-type-' + response.wallet_info.wallet_method_id).html(
                                wallet_card);
                            walletConnectButton();
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#update-profile-form').validate({
                rules: {
                    'email': {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('verify.email') }}",
                            type: "GET",
                            data: {
                                current_email: "{{ $user->email }}",
                                email: function() {
                                    return $('#email').val();
                                },
                            },
                        }
                    },
                    'first_name': {
                        required: true
                    },
                    'last_name': {
                        required: true
                    },
                    'middle_name': {
                        required: true
                    },
                    'date_of_birth': {
                        required: true,
                        date: true
                    },
                    'address': {
                        required: true,
                    },
                    'country': {
                        required: true,
                    },
                    'province': {
                        required: true,
                    },
                    'province_code': {
                        required: true,
                        notEqual: 0
                    },
                    'citymun_code': {
                        required: true,
                        notEqual: 0
                    },
                    'brgy_code': {
                        required: true,
                        notEqual: 0
                    },
                    'city_municipality': {
                        required: true,
                    },
                    'barangay': {
                        required: true,
                    },
                    'postal_code': {
                        required: true,
                    },
                },
                messages: {
                    'email': {
                        required: 'please input email',
                        email: 'You have entered an invalid e-mail address. Please try again.',
                        remote: "Email already registered"
                    },
                    'date_of_birth': {
                        required: 'please fill out this field',
                        date: 'please input valid date'
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
                submitHandler: function(form, event) {
                    $('#update-profile-btn').attr('disabled', true).text('processing');
                    event.preventDefault();
                    $('#connect-wallet-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.settingsUpdateProfile') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#update-profile-btn').attr('disabled', false).text(
                                'Save Changes');
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

                            profile_picture_container = "{{ asset('storage/profile_picture/' . ':profile_picture') }}"
                            profile_picture_container = profile_picture_container.replace(':profile_picture', response.user.user_info.profile_picture );
                            $('#profile-pircure-img').attr('src', profile_picture_container);
                            $('#nav-profile-picture-img').attr('src', profile_picture_container);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

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
                        complete: function() {
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
                            $('#status-info-badge').children('.status-badge').removeClass(
                                'bg-info').addClass('bg-warning').children('span').text(
                                'pending');
                            $('#payments').modal('toggle');
                            $('#upload-alert').fadeOut('fast', function() {
                                row = $(document.createElement('div')).addClass(
                                        'row mt-3').attr('id', 'pending-alert')
                                    .insertAfter($('.content-header').parent());
                                col = $(document.createElement('div')).addClass(
                                    'col-lg-12').appendTo(row);
                                alert = $(document.createElement('div')).addClass(
                                    'alert alert-danger m-0').attr('role',
                                    'alert').text(
                                    'Your payment is now pending verification from managment'
                                ).appendTo(col);
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
            });

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

            });

            $('#change-pass-form').validate({
                rules: {
                    'old_password': {
                        required: true,
                        remote: {
                            url: "{{ route('verify.checkOldPass') }}",
                            type: "GET",
                            data: {
                                user_id: "{{ $user->id }}",
                                old_password: function() {
                                    return $('#old-password').val();
                                },
                            },
                        }
                    },
                    'new_password': {
                        required: true
                    },
                    'new_password_confirmation': {
                        required: true,
                        equalTo: "#new-password"
                    }
                },
                messages: {
                    'old_password': {
                        remote: "This old password is incorrect."
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
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#change-pass-btn').attr('disabled', true).text('Processing');
                    $.ajax({
                        url: "{{ route('operator.settingsChangePassSendOtp') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#change-pass-btn').attr('disabled', false).text(
                                'Save Changes');
                        },
                        success: function(response) {
                            $('#otp-verification-modal').modal('show');
                            $('#otp-mobile-number').text(response.mobile_number.replace(
                                /\d(?=\d{4})/g, "*"));
                            $('#otp_id').val(response.otp_register.id);
                            $('#new_pass').val(response.new_password);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#otp-verification-form').validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('operator.settingsChangePassConfirmOtp') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#otp-verification-form').trigger('reset');
                            $('#otp-verification-form').find('.otp-input').each(function(
                                index) {
                                $(this).attr('readonly', false);
                            });
                            $('#otp-verification-form').find('.otp-input').first().focus();

                            if (response.otp_verified == 1) {
                                $('#otp-verification-modal').modal('toggle');
                                $('#change-pass-form').trigger('reset');
                            } else {

                            }
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#otp-verification-modal').on('shown.bs.modal', function() {
                $('#otp-verification-form').find('.otp-input').first().focus();
            })

            $('#otp-verification-form').find('.otp-input').each(function(index) {
                otp_set.push($(this).attr('id'));
                $(this).focus(function() {
                    $(this).val(null);
                    $(this).attr('readonly', false);
                });
                $(this).on('keyup', function() {
                    if ($(this).val().length > 1) {
                        $(this).val(null);
                    } else if ($(this).val().length == 1) {
                        $(this).attr('readonly', true);
                        $(this).next().focus();
                    }
                    if ($('#first').val() != '' && $('#fourth').val() != '' && $('#third').val() !=
                        '' && $('#fourth').val() != '') {
                        $(this).blur();
                        $('#otp_code').val($('#first').val() + $('#second').val() + $('#third')
                        .val() + $('#fourth').val());
                        $('#otp-verification-form').submit();
                    }
                });
            })

            $('#change-pass-reset-btn').click(function() {
                $('#change-pass-form').trigger('reset');
                $('#change-pass-form').find('input.form-control').each(function() {
                    if ($(this).hasClass('is-invalid')) {
                        $(this).removeClass('is-invalid');
                    }
                });
            });

            $('#profile_picture').on('change', function () {
                const file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(event){
                    $('#profile-pircure-img').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            })
        });
    </script>
    @if (session()->has('status'))
        <script>
            Swal.fire({
                icon: '{{ session()->get('status') }}',
                title: '{{ session()->get('title') }}',
                text: '{{ session()->get('text') }}',
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false
            })
        </script>
    @endif
@endpush
