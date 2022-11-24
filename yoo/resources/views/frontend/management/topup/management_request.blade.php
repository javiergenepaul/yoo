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
                    <form id="request-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="request_id" name="id" value="">
                        <input type="hidden" id="request_method" name="wallet_method" value="">
                        <input type="hidden" id="request_submitted_to" name="submitted_to" value="">
                        <input type="hidden" id="request_user_id" name="user_id" value="">
                        <input type="hidden" id="request_amount" name="amount" value="">
                        <input type="hidden" id="action" name="action" value="">

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
                    <button id="decline-btn" name="action" form="request-form" type="submit" value="decline"
                        class="btn btn-outline-primary">Decline</button>
                    <button id="approve-btn" name="action" form="request-form" type="submit" value="approve"
                        class="btn btn-primary">Approve</button>
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
                                <span>Request</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
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
                                                <th>CREATED DATE</th>
                                                <th>UPDATED DATE</th>
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

        function viewContent(divSelector, value) {
            if (value != null) {
                document.querySelector(divSelector).innerHTML = value;
            } else {
                document.querySelector(divSelector).innerHTML = '-';
            }
        }

        function date(dateInput) {
            dateValue = new Date(dateInput);
            date = ('00' + (dateValue.getMonth() + 1)).slice(-2) + '-' +
                dateValue.getDate() + '-' + dateValue.getFullYear()
            return date;
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
            $('#decline-btn').on('click', function() {
                $('#action').val(this.value);
            });

            $('#approve-btn').on('click', function() {
                $('#action').val(this.value);
            });

            $('#requests-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('management.topUpRequestsFetch') }}",
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
                        data: "amount"
                    },
                    {
                        data: "created_at"
                    },
                    {
                        data: "updated_at"
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
                buttons: [{
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [
                                0, 1, 2, 3, 4,
                            ]
                        },
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "TopupRequestTable_" + date;
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [
                                0, 1, 2, 3, 4,
                            ]
                        },
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "TopupRequestTable_" + date;
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "TopupRequestTable_" + date;
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [
                                0, 1, 2, 3, 4,
                            ]
                        },
                        text: 'PDF',
                        titleAttr: 'PDF',
                    },
                ],
            });

            $('#requests-table tbody').on('click', '#view-request-details-btn', function() {
                let req_data = $('#requests-table').DataTable().row($(this).parents('tr')).data()['id'];
                // console.log(req_data);
                $.ajax({
                    type: "GET",
                    url: "{{ route('management.topUpRequestViewDetails') }}",
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

                        viewContent('#date-content', date(response.topup.created_at));
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

            $('#request-form').validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('management.topUpRequestLoad') }}",
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
                                text: response.message,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $("#view-request").modal('toggle');
                            $('#requests-table').DataTable().ajax.reload();
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
