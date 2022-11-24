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

    </style>
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
                                <span>USER</span>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card p-3 mb-0">
                            <div class="alert alert-danger m-0" role="alert">
                                Your profile is pending management review. Ensure all details are complete and correct. Go
                                to <strong>Settings</strong> to update.
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($operator->operator_verification_status_id == 2)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card p-3 mb-0">
                            <div class="alert alert-danger m-0" role="alert">
                                Please upload proof of payment <button class="btn btn-primary p-1 px-2"><small>upload
                                        here</small></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($operator->operator_verification_status_id == 3)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card p-3 mb-0">
                            <div class="alert alert-danger m-0" role="alert">
                                Your payment is now pending verification from management.
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    {{-- tabs --}}
                    @if ($operator->operator_type_id == 1)
                        <ul class="nav nav-tabs nav-justified red" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="driver-tab" data-bs-toggle="tab" href="#driver" role="tab"
                                    aria-controls="driver" aria-selected="true">Drivers</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="operator-tab" data-bs-toggle="tab" href="#operator" role="tab"
                                    aria-controls="operator" aria-selected="false">Operators</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            {{-- driver tab --}}
                            <div class="tab-pane fade show active" id="driver" role="tabpanel" aria-labelledby="home-tab">
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
                            {{-- operator tab --}}
                            <div class="tab-pane fade" id="operator" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row ">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="p-2" style="min-height: 600px">
                                            <div class="card-content table-responsive">
                                                <table class="table table-hover" id="operator-operator" style="width: 100%">
                                                    <thead class="text-primary">
                                                        <tr>
                                                            <th>UID</th>
                                                            <th>NAME</th>
                                                            <th>MOBILE</th>
                                                            <th>EMAIL</th>
                                                            <th>TYPE</th>
                                                            <th>SPONSOR CODE</th>
                                                            <th>CREATED DATE</th>
                                                            <th>UPDATED DATE</th>
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
                    @else
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
                    @endif

                </div>
            </div>

            {{-- modals --}}
            @if ($operator->operator_type_id == 1)
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
            @endif

            @include('include.operator_footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function loadOperatorDriver() {
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
                });
            }

            function loadOperatorOperator() {
                $('#operator-operator').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('operator.getUserOperator') }}",
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
                            data: "type"
                        },
                        {
                            data: "sponsor_code"
                        },
                        {
                            data: "updated_at"
                        },
                        {
                            data: "created_at"
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

            loadOperatorDriver();
            $('#driver-tab').on('shown.bs.tab', function() {
                $('#operator-operator').DataTable().destroy();
                loadOperatorDriver();
            });

            $('#operator-tab').on('shown.bs.tab', function() {
                $('#operator-driver').DataTable().destroy();
                loadOperatorOperator();
            });

            $('#add-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('operator.verifyEmail') }}",
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
                            url: "{{ route('operator.verifyMobileNumber') }}",
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
@endpush
