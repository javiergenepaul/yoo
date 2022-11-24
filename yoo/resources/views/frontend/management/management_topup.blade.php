@extends('layouts.layout_management')

@section('title', 'Top Up Page')

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

    </style>
@endpush

@push('modal')
    {{-- modals --}}
    {{-- LOAD DRIVER --}}
    <div class="modal fade" id="load-operator-account" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="loadRiderAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loadRiderModalLabel">
                        <strong>Load</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="load-form" action="{{ route('management.topUpLoad') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="loaded_id" value="" id="loaded_id">
                        <div class="form-floating mb-3">
                            <input type="number" name="amount" class="form-control" id="amount" required>
                            <label for="amount">Top Up
                                Amount (₱)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select onChange="w_method(this.value)" class="form-select" name="wallet_method"
                                aria-label="Default select example" id="wallet_method">
                                @foreach ($wallet_methods as $method)
                                    <option value="{{ $method->walletMethod->id }}">
                                        {{ $method->walletMethod->method }}</option>
                                @endforeach
                                <option value="5">others</option>
                            </select>
                            <label for="wallet_method">
                                Top Up Method
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="r_acct_name" class="form-control" id="r_acct_name" placeholder=" "
                                required>
                            <label for="r_acct_name">
                                Reciever Account Name
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="r_acct_number" class="form-control" id="r_acct_number"
                                placeholder=" " required>
                            <label for="r_acct_number">
                                Reciever Account No.
                            </label>
                        </div>

                        {{-- Optional Starts --}}
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
                                        <div class="form-floating mb-3">
                                            <input type="text" name="s_acct_name" class="form-control" id="s_acct_name"
                                                placeholder=" ">
                                            <label for="s_acct_name">
                                                Sender Account Name
                                            </label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="s_acct_no" class="form-control" id="s_acct_no"
                                                placeholder=" ">
                                            <label for="s_acct_no">
                                                Sender Account No.
                                            </label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="ref" class="form-control" id="ref" placeholder=" ">
                                            <label for="ref">
                                                Reference No.
                                            </label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="notes" class="form-control" id="notes"
                                                placeholder=" ">
                                            <label for="notes">Notes</label>
                                        </div>
                                        <div>
                                            <label for="formFileLg" class="form-label mb-0">
                                                Proof of payments
                                            </label>
                                            <input class="form-control form-control" id="formFileLg" type="file" name="pop">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Optional Ends --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- view Request driver --}}
    <div class="modal fade" id="view-rider-requests" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="topUpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topUpModalLabel"><strong>View Operator Request</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="view-rider-requests-table" style="width: 100%">
                            <thead class="text-primary">
                                <tr>
                                    <th>REF ID</th>
                                    <th>EMAIL</th>
                                    <th>MOBILE</th>
                                    <th>STATUS</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- view details --}}
    <div class="modal fade" id="view-request" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topUpModalLabel">
                        <strong>Top Up Request</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('management.loadRequest') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" id="request_id" name="id" value="">
                        <input type="hidden" id="request_method" name="wallet_method" value="">
                        <input type="hidden" id="request_submitted_to" name="submitted_to" value="">
                        <input type="hidden" id="request_user_id" name="user_id" value="">
                        <input type="hidden" id="request_amount" name="amount" value="">

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
                        <div class="modal-footer pb-0">
                            <button id="decline-btn" name="action" type="submit" value="decline"
                                class="btn btn-outline-primary">Decline</button>
                            <button id="approve-btn" name="action" type="submit" value="approve"
                                class="btn btn-primary">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modals --}}
    <div class="modal fade" id="add_user" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topUpModalLabel">
                        <strong>ADD USERS</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{ route('management.addUsers') }}" method="POST">
                        @csrf

                        <section id="operator-req-info">
                            <div class="form-floating mb-3">
                                <select name="user_type" id="request_user_type" onChange="userType(this.value)"
                                    class="form-select" aria-label="Default select example">
                                    <option value="1">operator</option>
                                    <option value="2">sub-operator</option>
                                    <option value="3">Driver</option>
                                    <option value="4">Customer</option>
                                </select>
                                <label for="wallet_method">
                                    User Type
                                </label>
                            </div>

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
                                    placeholder=" ">
                                <label for="operator_first_name">
                                    First Name
                                </label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="last_name" id="operator_last_name"
                                    placeholder=" ">
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
                            <div class="form-floating mb-3" id="sponsor_op">
                                <input type="text" name="sponsor_code" id="operator_sponsor_code" class="form-control"
                                    placeholder=" ">
                                <label for="operator_sponsor_code">
                                    Sponsor Code
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
@endpush

@section('content')
    <div id="content">
        @include('include.management_navbar')
        <div class="main-content">
            {{-- header --}}
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="header-title border-end pe-3">TOP UP</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a class="d-flex align-items-center" href="{{ route('management.index') }}">
                                    <span id="click-link" class="material-icons ps-2">home</span>
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>TOP UP</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add_user">
                            <div class="d-flex align-items-center">
                                <span class="material-icons">person_add</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-justified red" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="accounts-tab" data-bs-toggle="tab" href="#accounts" role="tab"
                                aria-controls="accounts" aria-selected="true">Accounts</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="requests-tab" data-bs-toggle="tab" href="#requests" role="tab"
                                aria-controls="requests" aria-selected="false">Requests</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        {{-- view Accounts --}}
                        <div class="tab-pane fade show active" id="accounts" role="tabpanel"
                            aria-labelledby="accounts-tab">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="p-2" style="min-height: 600px">
                                        <div class="card-content table-responsive pt-0">
                                            <table class="table table-hover" id="accounts-table" style="width: 100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>UID</th>
                                                        <th>EMAIL</th>
                                                        <th>MOBILE</th>
                                                        <th>BALANCE</th>
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
                        {{-- view requests --}}
                        <div class="tab-pane fade" id="requests" role="tabpanel" aria-labelledby="requests-tab">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="p-2" style="min-height: 600px">
                                        <div class="card-content table-responsive pt-0">
                                            <table class="table table-hover" id="requests-table" style="width: 100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>REF ID</th>
                                                        <th>EMAIL</th>
                                                        <th>MOBILE</th>
                                                        <th>AMOUNT</th>
                                                        <th>DATE</th>
                                                        <th>ACTIONS </th>
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
            @include('include.operator_footer')
        </div>

    @endsection


    @push('scripts')
        <script>
            let wallet;
            let methods = @json($wallet_methods, JSON_PRETTY_PRINT);

            let detach;
            detach = $('#sponsor_op').detach();

            function userType(user_type) {
                if (user_type == 1 || user_type == 4) {
                    $('#operator-req-info').append(detach)
                    detach = $('#sponsor_op').detach();
                } else if (user_type == 2 || user_type == 3) {
                    $('#operator-req-info').append(detach)
                }
            }

            function id_method(id) {
                methods.forEach(element => {
                    if (element.wallet_method_id == id) {
                        wallet = element;
                    }
                });
            }

            function w_method(topUpMethod) {
                id_method(topUpMethod);
                if (topUpMethod != 5) {
                    document.getElementById('r_acct_name').value = wallet.acc_name;
                    document.getElementById('r_acct_number').value = wallet.acc_no;
                } else {
                    document.getElementById('r_acct_name').value = null;
                    document.getElementById('r_acct_number').value = null;
                }
            }

            function viewContent(divSelector, value) {
                if (value != null) {
                    document.querySelector(divSelector).innerHTML = value;
                } else {
                    document.querySelector(divSelector).innerHTML = '-';
                }
            }

            $(document).ready(function() {
                let req_table = $('#requests-table').DataTable({
                    "order": [
                        [0, "desc"]
                    ]
                });

                // get data tables
                function loadAccountsTable() {
                    $('#accounts-table').DataTable({
                        responsive: true,
                        dom: 'lBfrtip',
                        processing: true,
                        serverSide: true,
                        ajax: {
                            type: "GET",
                            url: "{{ route('management.getAccountsTable') }}",
                            dataType: "json",
                            dataSrc: function(data) {
                                return data.data;
                            },
                        },
                        columns: [{
                                data: "id"
                            },
                            {
                                data: "email"
                            },
                            {
                                data: "mobile_number"
                            },
                            {
                                data: "total"
                            },
                            {
                                data: "action"
                            },
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        scrollX: true,
                    });
                }

                function loadRequestsTable() {
                    $('#requests-table').DataTable({
                        responsive: true,
                        dom: 'lBfrtip',
                        processing: true,
                        serverSide: true,
                        ajax: {
                            type: "GET",
                            url: "{{ route('management.getRequestsTable') }}",
                            dataType: "json",
                            dataSrc: function(data) {
                                return data.data;
                            },
                        },
                        columns: [{
                                data: "id"
                            },
                            {
                                data: "email"
                            },
                            {
                                data: "mobile_number"
                            },
                            {
                                data: "amount"
                            },
                            {
                                data: "created_at"
                            },
                            {
                                data: "actions"
                            },
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        columnDefs: [{
                            "orderable": false,
                            "targets": [1, 2, 3]
                        }, ],
                        scrollX: true,
                    });
                }

                function loadTransactionsTable(req_acct_data) {
                    $('#view-rider-requests-table').DataTable({
                        bLengthChange: false,
                        responsive: true,
                        dom: 'lBfrtip',
                        processing: true,
                        serverSide: true,
                        ajax: {
                            type: "GET",
                            url: "{{ route('management.getTransactionsTable') }}",
                            dataType: "json",
                            data: {
                                data: req_acct_data,
                            },
                            dataSrc: function(data) {
                                return data.data;
                            },
                        },
                        columns: [{
                                data: "id"
                            },
                            {
                                data: "email"
                            },
                            {
                                data: "mobile_mobile"
                            },
                            {
                                data: "statuses"
                            },
                            {
                                data: "amount"
                            },
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        columnDefs: [{
                            "orderable": false,
                            "targets": [1, 2]
                        }, ]
                    });
                }

                loadAccountsTable();
                // tab on click
                $('#accounts-tab').on('shown.bs.tab', function() {
                    $('#accounts-table').DataTable().destroy();
                    loadAccountsTable();
                });

                $('#requests-tab').on('shown.bs.tab', function() {
                    $('#requests-table').DataTable().destroy();
                    loadRequestsTable();
                });

                $('#accounts-table tbody').on('click', '#load-btn', function() {
                    let data = $('#accounts-table').DataTable().row($(this).parents('tr')).data();
                    w_method(1);
                    document.getElementById('wallet_method').value = 1;
                    $('#load-operator-account').modal({}).on('shown.bs.modal', function() {
                        document.getElementById('loaded_id').value = data['id'];
                    });
                });

                // click transactions button
                $('#accounts-table tbody').on('click', '#request-btn', function() {
                    let req_acct_data = $('#accounts-table').DataTable().row($(this).parents('tr')).data()[
                        'id'];
                    $('#view-rider-requests-table').DataTable().destroy();
                    loadTransactionsTable(req_acct_data);
                });

                // on click view requests
                $('#requests-table tbody').on('click', '#view-request-details-btn', function() {
                    let req_data = $('#requests-table').DataTable().row($(this).parents('tr')).data()['id'];
                    $.ajax({
                        type: "GET",
                        url: "{{ route('management.getViewDetails') }}",
                        contentType: "application/json",
                        dataType: "json",
                        data: {
                            data: req_data,
                        },
                        success: function(response) {
                            document.getElementById('request_id').value = response.topup
                                .id;
                            document.getElementById('request_submitted_to').value =
                                response.topup.submitted_to;
                            document.getElementById('request_user_id').value = response
                                .topup.user_id;
                            document.getElementById('request_method').value =
                                response.topup.wallet_method_id;
                            document.getElementById('request_amount').value =
                                response.topup.amount;
                            document.getElementById('request_pop').src =
                                '{{ asset('storage/pop') }}' + '/' + response.topup
                                .pop;
                            // content
                            viewContent('#date-content', response.topup.created_at);
                            viewContent('#mobile-content', response.user.mobile_number);
                            viewContent('#email-content', response.user.email);
                            viewContent('#amount-content', response.topup.amount);
                            viewContent('#method-content', response.method.method);
                            viewContent('#rec-acc-name-content', response.topup.receiver_acc_name);
                            viewContent('#rec-acc-no-content', response.topup.receiver_acc_no);
                            viewContent('#send-acc-name-content', response.topup.sender_acc_name);
                            viewContent('#send-acc-no-content', response.topup.sender_acc_no);
                            viewContent('#ref-no-content', response.topup.ref_no);
                        },
                        error: function(error) {
                        }
                    });
                });

                $('#load-form').validate({
                    rules: {
                        'amount': {
                            required: true,
                            number: true,
                            range: [100, 10000000]
                        },
                        'r_acct_name_required': {
                            required: true,
                        },
                        'r_acct_number_required': {
                            required: true,
                        }
                    },
                    messages: {
                        'amount': {
                            number: "input number only",
                            range: "Please Input Minimum of ₱100.00",
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
                    }
                });

                $('#add-form').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true,
                            remote: {
                                url: "{{ route('management.verifyEmail') }}",
                                type: "GET",
                                data: {
                                    email: function() {
                                        return $('#operator_email').val();
                                    },
                                },
                            }
                        },
                        mobile_number: {
                            required: true,
                            minlength: 11,
                            maxlength: 11,
                            remote: {
                                url: "{{ route('management.verifyMobileNumber') }}",
                                type: "GET",
                                data: {
                                    mobile_number: function() {
                                        return $('#operator_mobile_number').val();
                                    }
                                }
                            }
                        },
                        password: {
                            required: true,
                            minlength: 8
                        },
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        sponsor_code: {
                            remote: {
                                url: "{{ route('management.verifySponsorCode') }}",
                                type: "GET",
                                data: {
                                    sponsor_code: function() {
                                        return $('#operator_sponsor_code').val();
                                    }
                                }
                            }
                        }
                    },
                    messages: {
                        email: {
                            remote: "Email already registered"
                        },
                        mobile_number: {
                            remote: "Mobile number already registred",
                            minlength: "Please enter a valid mobile number",
                            maxlength: "Please enter a valid mobile number"
                        },
                        sponsor_code: {
                            remote: "Sponsor code does not exist"
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
                    submitHandler: function(form) {

                        form.submit();
                    },
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
