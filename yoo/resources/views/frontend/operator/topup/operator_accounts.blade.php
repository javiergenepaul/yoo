@extends('layouts.layout_operator')

@section('title', 'Account List Page')

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

        .dt-buttons {
            margin-top: 24px;
        }

        .dataTables_filter {
            margin-top: 24px;
        }

    </style>
@endpush

@push('modal')
    {{-- view my requests --}}
    <div class="modal fade" id="view-my-requests" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="myRequestsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myRequestsModelLabel">
                        <strong style="color: #555E58">My Requests</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover" id="my-requests-table" style="width: 100%">
                        <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>STATUS</th>
                                <th>AMOUNT</th>
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
    {{-- send request Modal --}}
    <div class="modal fade" id="send-request-modal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="topUpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topUpModalLabel"><strong>Top Up Request</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="send-request-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="number" name="amount" id="send_request_amount" class="form-control"
                                id="floatingInput" placeholder=" " required>
                            <label for="amount">
                                Top Up Amount (₱)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="wallet_method" id="send_request_wallet_method" class="form-select"
                                aria-label="Default select example">
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
                            <input type="text" name="r_acct_name" id="send_request_r_acct_name" class="form-control"
                                placeholder=" " readonly>
                            <label for="send_request_r_acct_name">
                                Receiver Account Name
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="r_acct_number" id="send_request_r_acct_number"
                                placeholder=" " readonly>
                            <label for="send_request_r_acct_number">
                                Receiver Account No.
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="s_acct_name" id="send_request_s_acct_name"
                                placeholder=" ">
                            <label for="send_request_s_acct_name">Sender Account Name (optional)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="s_acct_no" class="form-control" id="send_request_s_acct_no"
                                placeholder=" ">
                            <label for="send_request_s_acct_no">Sender Account No. (optional)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="req_ref" id="send_request_ref" placeholder=" ">
                            <label for="send_request_ref">Reference No. (optional)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="req_notes" id="send_request_notes"
                                placeholder=" ">
                            <label for="send_request_notes">Notes (optional)</label>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text">payment</label>
                            <input type="file" class="form-control" id="pop" name="pop">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="send-request-form" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Load Rider --}}
    <div class="modal fade" id="load-modal" data-bs-backdrop="static" tabindex="-1"
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
                    <form id="load-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="loaded_id" value="" id="loaded_id">
                        <div class="form-floating mb-3">
                            <input type="number" name="amount" class="form-control" id="load_amount" placeholder=" "
                                required>
                            <label for="amount">
                                Top Up Amount (₱)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="wallet_method" id="load_wallet_method" class="form-select"
                                aria-label="Default select example">
                                @foreach ($op_wallet_methods as $method)
                                    <option value="{{ $method->walletMethod->id }}">
                                        {{ $method->walletMethod->method }}</option>
                                @endforeach
                                <option value="5">others</option>
                            </select>
                            <label for="load_wallet_method">
                                Top Up Method
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="r_acct_name" id="load_r_acct_name" class="form-control"
                                placeholder=" " required>
                            <label for="load_r_acct_name">
                                Receiver Accounts Name
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="r_acct_number" id="load_r_acct_number" class="form-control"
                                placeholder=" " required>
                            <label for="load_r_acct_number">
                                Receiver Accounts No.
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="s_acct_name" class="form-control" id="load_s_acct_name"
                                placeholder=" ">
                            <label for="s_acct_name">
                                Sender Account Name (optional)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="s_acct_no" class="form-control" id="load_s_acct_no" placeholder=" ">
                            <label for="s_acct_no">
                                Sender Account No. (optional)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="ref" class="form-control" id="load_ref" placeholder=" ">
                            <label for="ref">
                                Reference No. (optional)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="notes" class="form-control" id="load_notes" placeholder=" ">
                            <label for="notes">Notes (optional)</label>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text">payment (optional)</label>
                            <input type="file" class="form-control" id="load_pop" name="pop">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal-btn" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="load-btn" form="load-form" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- View users Requests --}}
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
                    <form id="request-form" action="" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- Top Up Info --}}
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
@endpush

@section('content')
    <div id="content">
        @include('include.operator_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="header-title border-end pe-3">TOP UP</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a class="d-flex align-items-center" href="{{ route('operator.index') }}">
                                    <span id="click-link" class="material-icons ps-2">home</span>
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Top Up</span>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Accounts</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button id="view-my-request-btn" class="btn btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#view-my-requests">My
                            Requests</button>
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#send-request-modal">Top Up</button>
                        <span class="header-title border-start px-2">BAL:</span>
                        <span class="header-title me-2">
                            <div id="balance-refresh">
                                ₱ {{ number_format($operator_wallet_balance, 2) }}
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
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
                                                <th>NAME</th>
                                                @if ($operator->operator_type_id == 1)
                                                    <th>TYPE</th>
                                                @endif
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
            </div>
            @include('include.operator_footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let wallet_balance = @json($operator_wallet_balance, JSON_PRETTY_PRINT);
        let operator_type = @json($operator->operator_type_id, JSON_PRETTY_PRINT);
        let send_request_wallet_method_selected;
        let management_wallet_method = @json($m_wallet_methods, JSON_PRETTY_PRINT);
        let load_request_wallet_method_selected;
        let operator_wallet_method = @json($op_wallet_methods, JSON_PRETTY_PRINT);

        $(document).ready(function() {
            function operatorAccountsTable() {
                $('#accounts-table').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('operator.topUpAccountsFetch') }}",
                        dataType: "json",
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
                            data: "name"
                        },
                        {
                            data: "type"
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
                    buttons: [{
                            extend: 'csvHtml5',
                            exportOptions: {
                                columns: [
                                    0, 1, 2, 3, 4, 5,
                                ]
                            },
                            title: function() {
                                var today = new Date();
                                var date = today.getFullYear() + '-' + (today.getMonth() + 1) +
                                    '-' + today
                                    .getDate();
                                return "TopupAccountsTable_" + date;
                            },
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: [
                                    0, 1, 2, 3, 4, 5,
                                ]
                            },
                            title: function() {
                                var today = new Date();
                                var date = today.getFullYear() + '-' + (today.getMonth() + 1) +
                                    '-' + today
                                    .getDate();
                                return "TopupAccountsTable_" + date;
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            title: function() {
                                var today = new Date();
                                var date = today.getFullYear() + '-' + (today.getMonth() + 1) +
                                    '-' + today
                                    .getDate();
                                return "TopupAccountsTable_" + date;
                            },
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            exportOptions: {
                                columns: [
                                    0, 1, 2, 3, 4, 5,
                                ]
                            },
                            text: 'PDF',
                            titleAttr: 'PDF',
                        },
                    ],
                });
            }

            function subOperatorAccountsTable() {
                $('#accounts-table').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('operator.topUpAccountsFetch') }}",
                        dataType: "json",
                        // dataSrc: function(data) {
                        //     console.log(data);
                        //     return data.data;
                        // },
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
                            data: "name"
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
                    buttons: [{
                        extend: 'pdfHtml5',
                        title: function() {
                            return "Topup Account List";
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [
                                1, 2, 3, 4,
                            ]
                        },
                        text: 'PDF',
                        titleAttr: 'PDF',
                    }, ],
                });
            }

            function myRequestTable() {
                $('#my-requests-table').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('operator.topUpMyRequestsFetch') }}",
                        dataType: "json",
                        // dataSrc: function(data) {
                        //     console.log(data);
                        //     return data.data;
                        // },
                    },
                    columns: [{
                            data: "id"
                        },
                        {
                            data: "statuses"
                        },
                        {
                            data: "amount"
                        },
                        {
                            data: "created_at"
                        },
                        {
                            data: "action"
                        },
                    ],
                    order: [
                        [0, 'desc']
                    ],
                });
            }

            function userTransactionTable(account_id) {
                $('#view-user-requests-table').DataTable({
                    "bFilter": true,
                    bLengthChange: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('operator.topUpAccountsRequests') }}",
                        dataType: "json",
                        data: {
                            data: account_id,
                        },
                        dataSrc: function(data) {
                            return data.data;
                        },
                    },
                    columns: [{
                            data: "id"
                        },
                        // {
                        //     data: "email"
                        // },
                        {
                            data: "mobile_mobile"
                        },
                        {
                            data: "statuses"
                        },
                        {
                            data: "amount"
                        },
                        {
                            data: "created_at"
                        },
                    ],
                    order: [
                        [0, 'desc']
                    ],
                });
            }

            function management_method_id(id) {
                management_wallet_method.forEach(element => {
                    if (element.wallet_method_id == id) {
                        send_request_wallet_method_selected = element;
                    }
                });
            }

            function operator_method_id(id) {
                operator_wallet_method.forEach(element => {
                    if (element.wallet_method_id == id) {
                        load_request_wallet_method_selected = element;
                    }
                });
            }

            if (operator_type == 1) {
                operatorAccountsTable();
            } else {
                subOperatorAccountsTable();
            }

            $('#view-my-requests').modal({}).on('show.bs.modal', function() {
                myRequestTable();
            });

            $('#view-my-requests').modal({}).on('hidden.bs.modal', function() {
                $('#my-requests-table').DataTable().destroy();
            });

            $('#my-requests-table tbody').on('click', '#cancel_my_request', function() {
                let request_id = $('#my-requests-table').DataTable().row($(this).parents('tr')).data()[
                    'id'];
                var url = "{{ route('operator.topUpMyRequestCancel', ':id') }}";
                url = url.replace(':id', request_id);
                $.ajax({
                    url: url,
                    method: "get",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Loaded Successfully',
                            text: 'You have successfully loaded an operator',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        $('#my-requests-table').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        alert('oops something went wrong');
                    }
                });
            });

            $('#send_request_wallet_method').on('change', function() {
                management_method_id(this.value);
                $('#send_request_r_acct_number').val(send_request_wallet_method_selected.acc_no)
                $('#send_request_r_acct_name').val(send_request_wallet_method_selected.acc_name)
            });

            $('#send-request-modal').modal({}).on('show.bs.modal', function() {
                management_method_id($('#send_request_wallet_method').val());
                $('#send_request_r_acct_number').val(send_request_wallet_method_selected.acc_no)
                $('#send_request_r_acct_name').val(send_request_wallet_method_selected.acc_name)
            });

            $('#send-request-form').validate({
                rules: {
                    'amount': {
                        required: true,
                        number: true,
                        range: [100, 10000000]
                    },
                    'wallet_method': {
                        required: true,
                    },
                    'r_acct_name': {
                        required: true,
                    },
                    'r_acct_number': {
                        required: true,
                    },
                    'pop': {
                        required: true,
                    }
                },
                messages: {
                    'amount': {
                        number: "input number only",
                        range: "Please input minimum of ₱100.00",
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
                    $.ajax({
                        url: "{{ route('operator.topUpSendRequest') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Loaded Successfully',
                                text: 'You have successfully loaded an operator',
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#send-request-modal').modal('toggle');
                            $('#send-request-form').trigger('reset');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#load_wallet_method').on('change', function() {
                operator_method_id(this.value);
                if (this.value != 5) {
                    $('#load_r_acct_number').val(load_request_wallet_method_selected.acc_no)
                    $('#load_r_acct_name').val(load_request_wallet_method_selected.acc_name)
                } else {
                    $('#load_r_acct_number').val(null)
                    $('#load_r_acct_name').val(null)
                }
            });

            $('#load-modal').modal({}).on('show.bs.modal', function() {
                value = $('#load_wallet_method').val()
                operator_method_id(value);
                if (value != 5) {
                    $('#load_r_acct_number').val(load_request_wallet_method_selected.acc_no)
                    $('#load_r_acct_name').val(load_request_wallet_method_selected.acc_name)
                } else {
                    $('#load_r_acct_number').val(null)
                    $('#load_r_acct_name').val(null)
                }
            });

            $('#load-form').validate({
                rules: {
                    'amount': {
                        required: true,
                        number: true,
                        range: [100, wallet_balance]
                    },
                    'r_acct_name': {
                        required: true,
                    },
                    'r_acct_number': {
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
                    $.ajax({
                        url: "{{ route('operator.topUpAccountsLoad') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $("#load-modal").modal('toggle');
                            $('#load-form').trigger('reset');
                            $('#accounts-table').DataTable().ajax.reload();
                            $("#balance-refresh").load(window.location.href +
                                " #balance-refresh");
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#accounts-table tbody').on('click', '#load-btn', function() {
                let account_id = $('#accounts-table').DataTable().row($(this).parents('tr')).data()['id'];
                $('#loaded_id').val(account_id);
            });

            $('#accounts-table tbody').on('click', '#transaction-btn', function() {
                let account_id = $('#accounts-table').DataTable().row($(this).parents('tr')).data()['id'];
                userTransactionTable(account_id);
            });

            $('#view-user-request-modal').on('hidden.bs.modal', function() {
                $('#view-user-requests-table').DataTable().destroy();
            });
        });
    </script>
@endpush
