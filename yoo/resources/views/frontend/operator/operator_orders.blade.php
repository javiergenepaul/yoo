@extends('layouts.layout_operator')
@section('title', 'Order lists')

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
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-lg-12 col-md-12">
                            <div class="p-2" style="min-height: 600px">
                                <div class="card-content table-responsive">
                                    <div class="row" id="filter-header">
                                        <div class="col-lg-4" id="o_date_filter_div">
                                            <div class="form-floating mb-3">
                                                <select name="o_date_filter" id="o_date_filter" class="form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="0">- select date -</option>
                                                    <option value="1">today</option>
                                                    <option value="2">yesterday</option>
                                                    <option value="3">this week</option>
                                                    <option value="4">this month</option>
                                                    <option value="5">this year</option>
                                                    <option value="6">custom</option>
                                                </select>
                                                <label for="o_date_filter">
                                                    order date filter
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="o_date_start_div">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="o_date_start" id="o_date_start"
                                                    class="form-control" placeholder=" ">
                                                <label for="o_date_start">
                                                    order date start
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="o_date_end_div">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="o_date_end" id="o_date_end" class="form-control"
                                                    placeholder=" ">
                                                <label for="o_date_end">
                                                    order date end
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="c_date_filter_div">
                                            <div class="form-floating mb-3">
                                                <select name="c_date_filter" id="c_date_filter" class="form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="0">- select date -</option>
                                                    <option value="1">today</option>
                                                    <option value="2">yesterday</option>
                                                    <option value="3">this week</option>
                                                    <option value="4">this month</option>
                                                    <option value="5">this year</option>
                                                    <option value="6">custom</option>
                                                </select>
                                                <label for="c_date_filter">
                                                    completed date filter
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="c_date_start_div">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="c_date_start" id="c_date_start"
                                                    class="form-control" placeholder=" ">
                                                <label for="c_date_start">
                                                    completed date start
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="c_date_end_div">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="c_date_end" id="c_date_end" class="form-control"
                                                    placeholder=" ">
                                                <label for="c_date_end">
                                                    completed date end
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <select name="status_filter" id="status_filter" class="form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="0">- select status- </option>
                                                    <option value="1">Ongoing</option>
                                                    <option value="2">Completed</option>
                                                    <option value="3">Cancelled</option>
                                                </select>
                                                <label for="status_filter">
                                                    status
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <select name="area_filter" id="area_filter" class="form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="0">- select area - </option>
                                                    <option value="1">cebu</option>
                                                    <option value="2">manila</option>
                                                    <option value="3">davao</option>
                                                </select>
                                                <label for="area_filter">
                                                    area
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <table class="table table-hover" id="order-table">
                                            <thead class="text-primary">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>DRIVER</th>
                                                    <th>CUSTOMER</th>
                                                    <th>SUB-OPERATOR</th>
                                                    <th>STATUS</th>
                                                    <th>AREA</th>
                                                    <th>METHOD</th>
                                                    <th>AMOUNT</th>
                                                    <th>DATE ORDER</th>
                                                    <th>DATE COMPLETED</th>
                                                    <th>DATE CANCELLED</th>
                                                    <th>TOTAL SERVICE FEE</th>
                                                    @if ($operator->operator_type_id == 1)
                                                        <th>SUB COMMISSION</th>
                                                    @endif
                                                    <th>PROFIT</th>
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
@endsection

@push('scripts')
    <script>
        let ope_type = @json($operator->operator_type_id, JSON_PRETTY_PRINT);

        $(document).ready(function() {
            function orderTable(
                o_date_filter,
                o_date_started,
                o_date_ended,
                c_date_filter,
                c_date_started,
                c_date_ended,
                status_filter,
                area_filter
            ) {
                if (ope_type == 1) {
                    $('#order-table').DataTable({
                        searching: false,
                        responsive: true,
                        dom: 'lBfrtip',
                        processing: true,
                        serverSide: true,
                        ajax: {
                            type: "GET",
                            url: "{{ route('operator.getOrderList') }}",
                            dataType: "json",
                            data: {
                                ordered_date_filter: o_date_filter,
                                ordered_date_started: o_date_started,
                                ordered_date_ended: o_date_ended,
                                complete_date_filter: c_date_filter,
                                complete_date_start: c_date_started,
                                complete_date_ended: c_date_ended,
                                status_filter: status_filter,
                                area_filter: area_filter,
                            },
                            dataSrc: function(data) {
                                return data.data;
                            },
                        },
                        columns: [{
                                data: "order_id"
                            },
                            {
                                data: "driver"
                            },
                            {
                                data: "customer_id"
                            },
                            {
                                data: "sub_operator_id"
                            },
                            {
                                data: "order_status"
                            },
                            {
                                data: "area"
                            },
                            {
                                data: "payment_method"
                            },
                            {
                                data: "amount"
                            },
                            {
                                data: "date_ordered"
                            },
                            {
                                data: "date_completed"
                            },
                            {
                                data: "date_cancelled"
                            },
                            {
                                data: "service_fee"
                            },
                            {
                                data: "sub_commission"
                            },
                            {
                                data: "profit"
                            },
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        scrollX: true,
                        buttons: [{
                                extend: 'pdfHtml5',
                                title: function() {
                                    return "Driver List";
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL',
                                exportOptions: {
                                    columns: [
                                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,
                                    ]
                                },
                                text: 'PDF',
                                titleAttr: 'PDF',
                            },
                            {
                                extend: 'csvHtml5'
                            }
                        ],
                    });
                } else {
                    $('#order-table').DataTable({
                        searching: false,
                        responsive: true,
                        dom: 'lBfrtip',
                        processing: true,
                        serverSide: true,
                        ajax: {
                            type: "GET",
                            url: "{{ route('operator.getOrderList') }}",
                            dataType: "json",
                            data: {
                                ordered_date_filter: o_date_filter,
                                ordered_date_started: o_date_started,
                                ordered_date_ended: o_date_ended,
                                complete_date_filter: c_date_filter,
                                complete_date_start: c_date_started,
                                complete_date_ended: c_date_ended,
                                status_filter: status_filter,
                                area_filter: area_filter,
                            },
                            dataSrc: function(data) {
                                return data.data;
                            },
                        },
                        columns: [{
                                data: "order_id"
                            },
                            {
                                data: "driver"
                            },
                            {
                                data: "customer_id"
                            },
                            {
                                data: "sub_operator_id"
                            },
                            {
                                data: "order_status"
                            },
                            {
                                data: "area"
                            },
                            {
                                data: "payment_method"
                            },
                            {
                                data: "amount"
                            },
                            {
                                data: "date_ordered"
                            },
                            {
                                data: "date_completed"
                            },
                            {
                                data: "date_cancelled"
                            },
                            {
                                data: "service_fee"
                            },
                            {
                                data: "profit"
                            },
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        scrollX: true,
                        buttons: [{
                                extend: 'pdfHtml5',
                                title: function() {
                                    return "Driver List";
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL',
                                exportOptions: {
                                    columns: [
                                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,
                                    ]
                                },
                                text: 'PDF',
                                titleAttr: 'PDF',
                            },
                            {
                                extend: 'csvHtml5'
                            }
                        ],
                    });
                }

            }
            orderTable();

            let o_date_start = $('#o_date_start_div').detach();
            let o_date_end = $('#o_date_end_div').detach();
            let o_detach = true;

            let c_date_start = $('#c_date_start_div').detach();
            let c_date_end = $('#c_date_end_div').detach();
            let c_detach = true;

            $('#o_date_filter').on('change', function() {
                $('#order-table').DataTable().destroy();
                if (this.value != 6) {
                    orderTable(
                        $('#o_date_filter').val(),
                        $('#o_date_start').val(),
                        $('#o_date_end').val(),
                        $('#c_date_filter').val(),
                        $('#c_date_start').val(),
                        $('#c_date_end').val(),
                        $('#status_filter').val(),
                        $('#area_filter').val()
                    )
                    if (!o_detach) {
                        o_date_start = $('#o_date_start_div').detach();
                        o_date_end = $('#o_date_end_div').detach();
                        o_detach = true;
                    }
                } else {
                    orderTable();
                    $("#filter-header").append(o_date_start);
                    $("#filter-header").append(o_date_end);
                    $("#o_date_end_div").insertAfter("#o_date_filter_div");
                    $("#o_date_start_div").insertAfter("#o_date_filter_div");

                    $('#o_date_start').change(function() {
                        if (this.value && $('#o_date_end').val()) {
                            $('#order-table').DataTable().destroy();
                            orderTable(
                                $('#o_date_filter').val(),
                                $('#o_date_start').val(),
                                $('#o_date_end').val(),
                                $('#c_date_filter').val(),
                                $('#c_date_start').val(),
                                $('#c_date_end').val(),
                                $('#status_filter').val(),
                                $('#area_filter').val()
                            )
                        }
                    });

                    $('#o_date_end').on("change", function() {
                        if (this.value && $('#o_date_start').val()) {
                            $('#order-table').DataTable().destroy();
                            orderTable(
                                $('#o_date_filter').val(),
                                $('#o_date_start').val(),
                                $('#o_date_end').val(),
                                $('#c_date_filter').val(),
                                $('#c_date_start').val(),
                                $('#c_date_end').val(),
                                $('#status_filter').val(),
                                $('#area_filter').val()
                            )
                        }
                    });
                    o_detach = false;
                }
            });

            $('#c_date_filter').on('change', function() {
                $('#order-table').DataTable().destroy();

                if (this.value != 6) {
                    orderTable(
                        $('#o_date_filter').val(),
                        $('#o_date_start').val(),
                        $('#o_date_end').val(),
                        $('#c_date_filter').val(),
                        $('#c_date_start').val(),
                        $('#c_date_end').val(),
                        $('#status_filter').val(),
                        $('#area_filter').val()
                    )
                    if (!c_detach) {
                        date_start = $('#c_date_start_div').detach();
                        date_end = $('#c_date_end_div').detach();
                        c_detach = true;
                    }
                } else {
                    $('#order-table').DataTable().destroy();
                    $("#filter-header").append(c_date_start);
                    $("#filter-header").append(c_date_end);
                    $("#c_date_end_div").insertAfter("#c_date_filter_div");
                    $("#c_date_start_div").insertAfter("#c_date_filter_div");

                    orderTable(
                        $('#o_date_filter').val(),
                        $('#o_date_start').val(),
                        $('#o_date_end').val(),
                        $('#c_date_filter').val(),
                        $('#c_date_start').val(),
                        $('#c_date_end').val(),
                        $('#status_filter').val(),
                        $('#area_filter').val()
                    )

                    $('#c_date_start').change(function() {
                        if (this.value && $('#c_date_end').val()) {
                            $('#order-table').DataTable().destroy();
                            orderTable(
                                $('#o_date_filter').val(),
                                $('#o_date_start').val(),
                                $('#o_date_end').val(),
                                $('#c_date_filter').val(),
                                $('#c_date_start').val(),
                                $('#c_date_end').val(),
                                $('#status_filter').val(),
                                $('#area_filter').val()
                            )
                        }
                    });

                    $('#c_date_end').on("change", function() {
                        if (this.value && $('#c_date_start').val()) {
                            $('#order-table').DataTable().destroy();
                            orderTable(
                                $('#o_date_filter').val(),
                                $('#o_date_start').val(),
                                $('#o_date_end').val(),
                                $('#c_date_filter').val(),
                                $('#c_date_start').val(),
                                $('#c_date_end').val(),
                                $('#status_filter').val(),
                                $('#area_filter').val()
                            )
                        }
                    });

                    c_detach = false;
                }
            });

            $('#status_filter').on('change', function() {
                $('#order-table').DataTable().destroy();
                orderTable($('#o_date_filter').val(), this.value, $('#area_filter').val());
            });

            $('#area_filter').on('change', function() {
                $('#order-table').DataTable().destroy();
                orderTable($('#o_date_filter').val(), $('#status_filter').val(), this.value);
            });

        });
    </script>
@endpush
