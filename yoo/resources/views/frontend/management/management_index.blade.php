@extends('layouts.layout_management')

@section('title', 'Home Page')

@push('css')
    <style>
        .icon-dashboard {
            color: #8C27FF;
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
            left: 50px
        }

        .text-line {
            font-size: 14px
        }

        .accordion-button:not(.collapsed) {
            color: black;
            background-color: rgba(255, 255, 255, 0);
        }

        .accordion-button:focus {
            z-index: 3;
            border-color: white;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 0%);
        }

    </style>
@endpush

@push('modal')
    {{-- View users Requests --}}
    <div class="modal fade" id="view-payment" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
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
                    <form id="request-form" action="{{ route('management.userOperatorInfoUpdatePaymentStatus') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- Top Up Info --}}
                        <input type="hidden" id="request_id" name="id" value="">
                        {{-- <input type="hidden" id="request_method" name="wallet_method" value=""> --}}
                        <input type="hidden" id="request_user_id" name="user_id" value="">
                        {{-- <input type="hidden" id="request_amount" name="amount" value=""> --}}

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
        @include('include.management_navbar')
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
                    {{-- <div class="d-flex align-items-center">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add_user">
                            <div class="d-flex align-items-center">
                                <span class="material-icons">person_add</span>
                            </div>
                        </button>
                    </div> --}}
                </div>
            </div>
            {{-- dashboards --}}
            <div class="row mt-3">
                {{-- orders today --}}
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
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
                            <a href="{{ route('management.orders', ['order_today' => 1] ) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                {{-- total orders --}}
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
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
                            <a href="{{ route('management.orders') }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                {{-- verified drivers --}}
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
                                <span class="material-icons">
                                    verified
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Verified Drivers</strong></p>
                            <h3 class="card-title">
                                @if ($verified_drivers != null)
                                    {{ $verified_drivers->count() }}
                                @else
                                    0
                                @endif
                                <a href="{{ route('management.userDrivers', ['status' => 2] ) }}" class="stretched-link"></a>
                            </h3>
                        </div>
                    </div>
                </div>
                {{-- total driver --}}
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
                                <span class="material-icons">
                                    local_shipping
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Total Drivers</strong></p>
                            <h3 class="card-title">
                                @if ($driver != null)
                                    {{ $driver->count() }}
                                @else
                                    0
                                @endif
                            </h3>
                            <a href="{{ route('management.userDrivers') }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>

                {{-- pending Drivers --}}
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
                                <span class="material-icons">
                                    local_shipping
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Pending Drivers</strong></p>
                            <h3 class="card-title">
                                @if ($unverified_drivers != null)
                                    {{ $unverified_drivers->count() }}
                                @else
                                    0
                                @endif
                            </h3>
                            <a href="{{ route('management.userDrivers', ['status' => 1] ) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                {{-- pending Operator --}}
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
                                <span class="material-icons">
                                    local_shipping
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Pending Operator</strong></p>
                            <h3 class="card-title">
                                @if ($pending_operator != null)
                                    {{ $pending_operator->count() }}
                                @else
                                    0
                                @endif
                            </h3>
                            <a href="{{ route('management.userOperators', ['status' => 1] ) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                {{-- Total Operator --}}
                <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
                                <span class="material-icons">
                                    local_shipping
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Total Operator</strong></p>
                            <h3 class="card-title">
                                @if ($operator != null)
                                    {{ $operator->count() }}
                                @else
                                    0
                                @endif
                            </h3>
                            <a href="{{ route('management.userOperators') }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                {{-- profits --}}
                {{-- <div class="col-md-3">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-dashboard">
                                <span class="material-icons">
                                    paid
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Total Profits</strong></p>
                            <h3 class="card-title">
                                @if ($driver != null)
                                    {{ $driver->count() }}
                                @else
                                    0
                                @endif
                            </h3>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- pending opertors --}}
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <div id="container_Rider">
                        <div class="sampleHeader">Pending Operators Payments</div>
                        <a href="{{ route('operator.users') }}" id="viewAll"> view all</a>
                    </div>
                    <div class="card bg-white" style="min-height: 300px; width:100%">
                        <div class="card-content">
                            <table class="table table-hover" id="pending-operators-table" style="width: 100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>UID</th>
                                        <th>EMAIl</th>
                                        <th>MOBILE</th>
                                        <th>NAME</th>
                                        <th>TYPE</th>
                                        <th>DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pending_operator_payment as $pending_payment)
                                        <tr>
                                            <td>{{ $pending_payment->id }}</td>
                                            <td>{{ $pending_payment->user->id }}</td>
                                            <td>{{ $pending_payment->user->email }}</td>
                                            <td>{{ $pending_payment->user->mobile_number }}</td>
                                            <td>{{ $pending_payment->user->userInfo->first_name }}</td>
                                            <td>{{ $pending_payment->user->operator->operatorType->type }}</td>
                                            <td>{{ $pending_payment->created_at->diffForHumans() }}</td>
                                            <td>
                                                <button id="view-payment-btn" class="btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#view-payment">
                                                    view payment
                                                </button>
                                                <a
                                                    href="{{ route('management.userOperatorInfo', $pending_payment->user_id) }}">
                                                    <button class="btn btn-primary">
                                                        more info
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- unverified drivers --}}
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <div id="container_Rider">
                        <div class="sampleHeader">Unverified Drivers</div>
                        <a href="#" id="viewAll"> view all</a>
                    </div>
                    <div class="card bg-white" style="min-height: 300px; width:100%">
                        <div class="card-content">
                            <table class="table table-hover" id="unverified-drivers" style="width: 100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Documents</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($unverified_drivers != null)
                                        @foreach ($unverified_drivers as $driver)
                                            <tr>
                                                <td>
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
                                                <td>
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
                                                <td>
                                                    {{ $driver->verificationStatus->status }}
                                                </td>
                                                <td>
                                                    {{ $driver->created_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('management.userDriverInfo', $driver->user_id) }}">
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
            <div class="row mt-3">
                {{-- Topup --}}
                <div class="col-lg-12 col-md-12 ">
                    <div id="container_Rider">
                        <div class="sampleHeader">Top Up Requests</div>
                        <a href="" id="viewAll"> view all</a>
                    </div>
                    <div class="card bg-white" style="min-height: 300px; width:100%">
                        <div class="card-content table-responsive">
                            <table class="table table-hover" id="top-up" style="width: 100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th>REF ID</th>
                                        <th>MOBILE</th>
                                        <th>EMAIL</th>
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
            @include('include.operator_footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let detach;
        detach = $('#sponsor_op').detach();
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })

        function copy(text, target) {
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

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }

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

            $('#pending-operators-table').DataTable({
                bLengthChange: false,
                "lengthMenu": [
                    [5, 10, , -1],
                    [5, 10, "All"]
                ],
                "searching": false,
                "scrollX": true,
                "responsive": true,
                "order": [0, 'desc']
            });

            $('#pending-operators-table tbody').on('click', '#approve-btn', function() {
                let data = $('#pending-operators-table').DataTable().row($(this).parents('tr')).data()[0];
                document.getElementById('user_id').value = data;
            });

            $('#pending-operators-table tbody').on('click', '#view-payment-btn', function() {
                let id = $('#pending-operators-table').DataTable().row($(this).parents('tr')).data()[0];
                let payment_data = $('#pending-operators-table').DataTable().row($(this).parents('tr'))
                    .data()[1];

                $.ajax({
                    type: "GET",
                    url: "{{ route('management.userOperatorInfoPaymetDetailsFetch') }}",
                    contentType: "application/json",
                    dataType: "json",
                    data: {
                        id: id,
                        user_id: payment_data,
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
                        alert('something went wrong');
                    }
                });
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
