@extends('layouts.layout_operator')

@section('title', 'Users Page')

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


        #amount-div {
            display: none;
        }
    </style>
@endpush

@push('modal')
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
                        <span class="header-title border-end pe-3">USERS</span>
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
                                <span>Users</span>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Drivers</span>
                            </small>
                        </div>
                    </div>
                    @if ($operator->operator_type_id == 1 && $operator->operator_verification_status_id == 2)
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add_user">
                                <div class="d-flex align-items-center">
                                    <span class="material-icons">person_add</span>
                                </div>
                            </button>
                        </div>
                    @endif
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
                    <div class="row ">
                        <div class="col-lg-12 col-md-12">
                            <div class="p-2" style="min-height: 600px">
                                <div class="card-content table-responsive">
                                    <table class="table table-hover" id="operator-driver" style="width: 100%">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>USER ID</th>
                                                <th>MOBILE</th>
                                                <th>EMAIL</th>
                                                <th>NAME</th>
                                                <th>CITY</th>
                                                <th>STATUS</th>
                                                <th>RATING</th>
                                                <th>ORDERS</th>
                                                <th>CREATED DATE</th>
                                                <th>UPDATED DATE</th>
                                                <th>DOCUMENTS</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modals --}}
            {{-- @if ($operator->operator_type_id == 1)
                <div class="modal fade" id="add_user" data-bs-backdrop="static" tabindex="-1"
                    aria-labelledby="topUpModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="topUpModalLabel">
                                    <strong>Add Sub Operator</strong>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
                                            <input type="text" class="form-control" name="first_name"
                                                id="operator_first_name" placeholder=" " required>
                                            <label for="operator_first_name">
                                                First Name
                                            </label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="last_name"
                                                id="operator_last_name" placeholder=" " required>
                                            <label for="operator_last_name">
                                                last Name
                                            </label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" id="operator_password"
                                                class="form-control" placeholder=" ">
                                            <label for="operator_password">
                                                Password
                                            </label>
                                        </div>
                                    </section>

                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button p-2 " type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="false" aria-controls="collapseOne">
                                                    Optional
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
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
                                                                <input type="date" class="form-control"
                                                                    name="date_of_birth" id="operator_date_of_birth"
                                                                    placeholder=" ">
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
                                                                <input type="text" class="form-control"
                                                                    name="city_municipality" id="operator_city_municipality"
                                                                    placeholder=" ">
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
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endif --}}
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
            $('#operator-driver').DataTable({
                responsive: true,
                dom: 'lBfrtip',
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('operator.getUserDrivers') }}",
                    dataType: "json",
                    dataSrc: function(data) {
                        return data.data;
                    },
                },
                columns: [{
                        data: "uid"
                    },
                    {
                        data: "mobile_number"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "city"
                    },
                    {
                        data: "status_id"
                    },
                    {
                        data: "rating"
                    },
                    {
                        data: "orders"
                    },
                    {
                        data: "updated_at"
                    },
                    {
                        data: "created_at"
                    },
                    {
                        data: "document_id"
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
                                0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                            ]
                        },
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "DriversTable_" + date;
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [
                                0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                            ]
                        },
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "DriversTable_" + date;
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [
                                0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
                            ]
                        },
                        title: function() {
                            var today = new Date();
                            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' +
                                today
                                .getDate();
                            return "DriversTable_" + date;
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        text: 'PDF',
                        titleAttr: 'PDF',
                    },
                ],
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
