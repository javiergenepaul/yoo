@extends('layouts.layout_operator')

@section('title', 'Home Page')

@push('css')
    <style>
        .icon.icon-warning {
            color: #ff9800;
        }

        .icon.icon-rose {
            color: #e91e63;
        }

        .icon.icon-success {
            color: #4caf50;
        }

        .icon.icon-info {
            color: #00bcd4;
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

        #click-link {
            color: #555E58;
        }

        td {
            text-transform: none;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }

        div:not(.dataTables_scrollFoot)::-webkit-scrollbar {
            display: none;
        }
    </style>
    <style>
        .copy-button {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative
        }

        .tip {
            background-color: #263646;
            padding: 0 14px;
            line-height: 27px;
            position: absolute;
            border-radius: 4px;
            z-index: 100;
            color: #fff;
            font-size: 12px;
            animation-name: tip;
            animation-duration: .6s;
            animation-fill-mode: both
        }

        .tip:before {
            content: "";
            background-color: #263646;
            height: 10px;
            width: 10px;
            display: block;
            position: absolute;
            transform: rotate(45deg);
            top: -4px;
            left: 17px
        }

        #copied_tip {
            animation-name: come_and_leave;
            animation-duration: 1s;
            animation-fill-mode: both;
            bottom: -35px;
            left: 0px
        }

        .text-line {
            font-size: 14px
        }


        #amount-div {
            display: none;
        }
    </style>
@endpush

@push('modal')
    {{-- modals --}}
    {{-- @if ($operator->operator_type_id == 1 && $operator->operator_verification_status_id == 4)
        <div class="modal fade" id="add_user" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpModalLabel">
                            <strong>Add Sub Operator</strong>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-form" action="{{ route('operator.addUsers') }}" method="POST">
                            @csrf
                            <section id="operator-req-info">
                                <div class="form-floating mb-3">
                                    <input type="number" name="mobile_number" id="operator_mobile_number"
                                        class="form-control" placeholder=" ">
                                    <label for="mobile_number">
                                        Mobile Number
                                    </label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" name="email" id="operator_email" class="form-control"
                                        placeholder=" ">
                                    <label for="email">
                                        Email Address
                                    </label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="first_name" id="operator_first_name"
                                        placeholder=" " required>
                                    <label for="operator_first_name">
                                        First Name
                                    </label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="last_name" id="operator_last_name"
                                        placeholder=" " required>
                                    <label for="operator_last_name">
                                        last Name
                                    </label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" name="password" id="operator_password" class="form-control"
                                        placeholder=" ">
                                    <label for="operator_password">
                                        Password
                                    </label>
                                </div>
                            </section>

                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button p-2 " type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Optional
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-1">

                                            <section id="operator-opt-info">
                                                <div class="request-receiver-info-optional-div">

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="middle_name"
                                                            id="operator_middle_name" placeholder=" ">
                                                        <label for="operator_middle_name">
                                                            Middle Name
                                                        </label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="date" class="form-control" name="date_of_birth"
                                                            id="operator_date_of_birth" placeholder=" ">
                                                        <label for="operator_date_of_birth">
                                                            Date of Birth
                                                        </label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="country"
                                                            id="operator_country" placeholder=" ">
                                                        <label for="operator_country">
                                                            Country
                                                        </label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="province"
                                                            id="operator_province" placeholder=" ">
                                                        <label for="operator_province">
                                                            Province
                                                        </label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="city_municipality"
                                                            id="operator_city_municipality" placeholder=" ">
                                                        <label for="operator_city_municipality">
                                                            City Municipality
                                                        </label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="postal_code"
                                                            id="operator_postal_code" placeholder=" ">
                                                        <label for="operator_postal_code">
                                                            Postal Code
                                                        </label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="barangay"
                                                            id="operator_barangay" placeholder=" ">
                                                        <label for="operator_baranagay">
                                                            Baranagay
                                                        </label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="address"
                                                            id="operator_address" placeholder=" ">
                                                        <label for="operator_baranagay">
                                                            Address
                                                        </label>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif --}}
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
@endpush

@section('content')
    <div id="content">
        <!-- Top Nav Bar -->
        @include('include.operator_navbar')
        <!-- Main Content -->
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="header-title border-end pe-3">HOME</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span id="click-link" class="material-icons ps-2">home</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alerts">
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
            </div>

            @if ($operator->operator_verification_status_id == 4)
                {{-- code --}}
                <div class="row">
                    <div class="col-lg-12 my-3">
                        <div class="sampleHeader mb-2">Driver Sponsor Code</div>
                        @if ($operator->sponsor_code != null)
                            <div class="border rounded d-flex justify-content-between align-content-center bg-white">
                                <span class="pt-1 ps-3" id="referral-code" style="text-transform: none">
                                    {{ $operator->sponsor_code }}
                                </span>
                                <div class="d-flex">
                                    <button id="copy-sponsor-code-btn" class="btn btn-primary copy-button"
                                        onclick="copy_sponsor_code('{{ $operator->sponsor_code }}','#copy-sponsor-code-btn')">
                                        <span class="material-icons">content_copy</span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="border rounded d-flex justify-content-between align-content-center">
                                <span class="pt-1 ps-3" id="referral-code">
                                    Subscribe to get Sponsor Code
                                </span>
                                <button disabled class="btn btn-primary" onclick="copy_referral_link('#referral-code')">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 my-3">
                        <div class="sampleHeader mb-2">Operator Referral Link</div>
                        @if ($operator->sponsor_code != null)
                            <div class="border rounded d-flex justify-content-between align-content-center bg-white">
                                <span class="pt-1 ps-3" id="referral-code">
                                    {{ route('register') }}?referral_code={{ $operator->sponsor_code }}
                                </span>
                                <button id="copy-referral-link-btn" class="btn btn-primary copy-button"
                                    onclick="copy_referral_link('{{ route('register') }}?referral_code={{ $operator->sponsor_code }}','#copy-referral-link-btn')">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                        @else
                            <div class="border rounded d-flex justify-content-between align-content-center">
                                <span class="pt-1 ps-3" id="referral-code">
                                    Subscribe to get Sponsor Code
                                </span>
                                <button disabled class="btn btn-primary" onclick="copy_referral_link('#referral-code')">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-6 my-3">
                        <div class="sampleHeader mb-2">Customer Referral Link</div>
                        @if ($operator->sponsor_code != null)
                            <div class="border rounded d-flex justify-content-between align-content-center bg-white">
                                <span class="pt-1 ps-3" id="referral-code">
                                    {{ route('register') }}?customer_referral_code={{ $operator->user->id }}
                                </span>
                                <button id="copy-referral-link-btn" class="btn btn-primary copy-button"
                                    onclick="copy_referral_link('{{ route('register') }}?customer_referral_code={{ $operator->user->id }}','#copy-referral-link-btn')">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                        @else
                            <div class="border rounded d-flex justify-content-between align-content-center">
                                <span class="pt-1 ps-3" id="referral-code">
                                    Subscribe to get Sponsor Code
                                </span>
                                <button disabled class="btn btn-primary" onclick="copy_referral_link('#referral-code')">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            {{-- second Row --}}
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12" id="colPadding">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-warning">
                                        <span class="material-icons">receipt</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Orders Today</strong></p>
                                    <h3 class="card-title">
                                        @if ($orders_today != null)
                                            {{ $orders_today->count() }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-rose">
                                        <span class="material-icons">shopping_cart</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Total Orders</strong></p>
                                    <h3 class="card-title">
                                        @if ($orders_count != null)
                                            {{ $orders_count->count() }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12" id="colPadding">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-success">
                                        <span class="material-icons">
                                            verified
                                        </span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Verified Drivers</strong></p>
                                    <h3 class="card-title">
                                        @if ($verified_drivers_list != null)
                                            {{ $verified_drivers_list->count() }}
                                        @else
                                            0
                                        @endif

                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-info">
                                        <span class="material-icons">
                                            local_shipping
                                        </span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Total Drivers</strong></p>
                                    <h3 class="card-title">
                                        @if ($driver_list != null)
                                            {{ $driver_list->count() }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- unverified Drivers --}}
            <div class="row ">
                <div class="col-lg-12 col-md-12">
                    <div id="container_Rider">
                        <div class="sampleHeader">Unverified Drivers</div>
                        <a href="{{ route('operator.users') }}" id="viewAll"> view all</a>
                    </div>
                    <div class="card bg-white" style="min-height: 180px; width:100%">
                        <div class="card-content">
                            <table class="table table-hover" id="unverified-drivers" style="width: 100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Documents</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($unverified_drivers_list != null)
                                        @foreach ($unverified_drivers_list as $driver)
                                            <tr>
                                                <td style="text-transform: none">
                                                    @if ($driver->driverVehicles->isNotEmpty())
                                                        @if ($driver->driverVehicles->first()->vehicle->type != null)
                                                            {{ $driver->driverVehicles->first()->vehicle->type }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td style="text-transform: none">
                                                    @if ($driver->user->userInfo->first_name != null && $driver->user->userInfo->last_name != null)
                                                        {{ $driver->user->userInfo->first_name }}
                                                        {{ $driver->user->userInfo->last_name }}
                                                    @elseif ($driver->user->userInfo->first_name || (null && $driver->user->userInfo->last_name != null))
                                                        {{ $driver->user->userInfo->first_name }}
                                                        {{ $driver->user->userInfo->last_name }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td style="text-transform: none">
                                                    {{ $driver->verificationStatus->status }}</td>
                                                <td style="text-transform: none">
                                                    <a href="{{ route('operator.driver-info', $driver->user->id) }}">
                                                        <button class="btn btn-primary">view details</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if ($operator->operator_verification_status_id == 4)
                {{-- topup --}}
                <div class="row">
                    <div class="col-lg-12 col-md-12 ">
                        <div id="container_Rider">
                            <div class="sampleHeader">Top Up Requests</div>
                            <a href="" id="viewAll"> view all</a>
                        </div>
                        <div class="card bg-white" style="min-height: 180px; width:100%">
                            <div class="card-content table-responsive">
                                <table class="table table-hover" id="top-up" style="width: 100%">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>REF ID</th>
                                            <th>NAME</th>
                                            <th>MOBILE</th>
                                            <th>AMOUNT</th>
                                            <th>DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($request_list as $request)
                                            <tr>
                                                <td>{{ $request->id }}</td>
                                                <td>{{ $request->user->mobile_number }}</td>
                                                <td>{{ $request->user->email }}</td>
                                                <td>{{ $request->amount }}</td>
                                                <td>{{ $request->updated_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @include('include.operator_footer')
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        let m_wallet_methods = @json($m_wallet_methods, JSON_PRETTY_PRINT);
        let packages = @json($packages, JSON_PRETTY_PRINT);
        let method;

        function copy_sponsor_code(text, target) {
            setTimeout(function() {
                $('#copied_tip').remove();
            }, 800);
            $(target).append("<div class='tip' id='copied_tip'>Copied!</div>");
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            var result = document.execCommand('copy');
            document.body.removeChild(input)
            return result;
        }

        function copy_referral_link(text, target) {
            setTimeout(function() {
                $('#copied_tip').remove();
            }, 800);
            $(target).append("<div class='tip' id='copied_tip'>Copied!</div>");
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            var result = document.execCommand('copy');
            document.body.removeChild(input)
            return result;
        }


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
            $('#unverified-drivers').DataTable({
                bLengthChange: false,
                "lengthMenu": [
                    [5, 10, , -1],
                    [5, 10, "All"]
                ],
                "searching": false,
                "scrollX": true
            });

            $('#top-up').DataTable({
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
