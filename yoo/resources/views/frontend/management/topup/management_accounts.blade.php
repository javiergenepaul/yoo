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

        .dt-buttons {
            margin-top: 24px;
        }

        .dataTables_filter {
            margin-top: 24px;
        }

    </style>
@endpush


@push('modal')
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
                                    <th>DATE</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <form id="load-form" action="" method="POST" enctype="multipart/form-data">
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
                        <div class="form-floating mb-3">
                            <input type="text" name="s_acct_name" class="form-control" id="s_acct_name" placeholder=" ">
                            <label for="s_acct_name">
                                Sender Account Name (optional)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="s_acct_no" class="form-control" id="s_acct_no" placeholder=" ">
                            <label for="s_acct_no">
                                Sender Account No. (optional)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="ref" class="form-control" id="ref" placeholder=" ">
                            <label for="ref">
                                Reference No. (optional)
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="notes" class="form-control" id="notes" placeholder=" ">
                            <label for="notes">Notes (optional)</label>
                        </div>
                        <div class="input-group mb-3" id="error">
                            <label class="input-group-text">payment (optional)</label>
                            <input type="file" class="form-control" id="pop" name="pops">
                        </div>

                        {{-- Optional Starts --}}
                        {{-- <div class="accordion" id="accordionExample">
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

                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- Optional Ends --}}

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="load-form" class="btn btn-primary">Submit</button>
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
                                <span>Top up</span>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Account</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add_user">
                            <div class="d-flex align-items-center">
                                <span class="material-icons">person_add</span>
                            </div>
                        </button> --}}
                    </div>
                </div>
            </div>
            <div class="card mt-3">
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
        </div>
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

        function viewContent(divSelector, value) {
            if (value != null) {
                document.querySelector(divSelector).innerHTML = value;
            } else {
                document.querySelector(divSelector).innerHTML = '-';
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
        $(document).ready(function() {
            function loadTransactionsTable(req_acct_data) {
                $('#view-rider-requests-table').DataTable({
                    bLengthChange: false,
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('management.topUpAccountTransactionFetch') }}",
                        dataType: "json",
                        data: {
                            data: req_acct_data,
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
                        {
                            data: 'created_at'
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    columnDefs: [{
                        "orderable": false,
                        "targets": [1, 2]
                    }, ],
                    buttons: [],
                    searching: false
                });
            }

            $('#accounts-table').DataTable({
                responsive: true,
                dom: 'lBfrtip',
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('management.topUpAccountsFetch') }}",
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
                                0, 1, 2, 3,
                            ]
                        },
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "TopupAccountsTable_" + date;
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [
                                0, 1, 2, 3,
                            ]
                        },
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "TopupAccountsTable_" + date;
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "TopupAccountsTable_" + date;
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [
                                0, 1, 2, 3,
                            ]
                        },
                        text: 'PDF',
                        titleAttr: 'PDF',
                    },
                ],
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
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('management.topUpAccountLoad') }}",
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
                            $("#load-operator-account").modal('toggle');
                            $('#load-form').trigger('reset');
                            // $("#shop-content").load(location.href +
                            //     " #shop-content"); //reload div
                            // $('#shop-list-table').DataTable().destroy();
                            // shopListTable();
                            $('#accounts-table').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });


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
