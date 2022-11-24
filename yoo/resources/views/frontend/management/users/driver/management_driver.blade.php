@extends('layouts.layout_management')

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
    <div class="modal fade" id="add_user" data-bs-backdrop="static" tabindex="-1" aria-labelledby="topUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <select name="user_type" id="user_type" class="form-select"
                                        aria-label="Default select example">
                                        <option value="1">Operator</option>
                                        <option value="2">Sub-operator</option>
                                        <option value="3">Driver</option>
                                        <option value="4">Customer</option>
                                        <option value="5">Shop Admin</option>
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
                                    <input type="text" class="form-control" name="middle_name" id="operator_middle_name"
                                        placeholder=" ">
                                    <label for="operator_middle_name">
                                        Middle Name
                                    </label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="last_name" id="operator_last_name"
                                        placeholder=" ">
                                    <label for="operator_last_name">
                                        Last Name
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
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="date_of_birth"
                                        id="operator_date_of_birth" placeholder=" ">
                                    <label for="operator_date_of_birth">
                                        Date of Birth
                                    </label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="address" id="operator_address"
                                        placeholder=" ">
                                    <label for="operator_baranagay">
                                        Address
                                    </label>
                                </div>
                                {{-- country --}}
                                <div class="form-floating mb-3">
                                    <select name="country" id="country" class="form-select"
                                        aria-label="Default select example">
                                        <option value="Phillipines">Philippines</option>
                                    </select>
                                    <label for="country">
                                        Country
                                    </label>
                                </div>

                                {{-- province --}}
                                <input type="hidden" id="province" name="province" value="">
                                <div class="form-floating mb-3">
                                    <select name="province_code" id="province_code" class="form-select"
                                        aria-label="Default select example">
                                        <option value="" selected>select province</option>
                                    </select>
                                    <label for="province_code">
                                        Province
                                    </label>
                                </div>

                                {{-- city --}}
                                <input type="hidden" id="city_municipality" name="city_municipality" value="">
                                <div class="form-floating mb-3">
                                    <select name="citymun_code" id="citymun_code" class="form-select"
                                        aria-label="Default select example">
                                        <option value="" selected>select city municipality</option>
                                    </select>
                                    <label for="citymun_code">
                                        City Municipality
                                    </label>
                                </div>

                                {{-- barangay --}}
                                <input type="hidden" id="barangay" name="barangay" value="">
                                <div class="form-floating mb-3">
                                    <select name="brgy_code" id="brgy_code" class="form-select"
                                        aria-label="Default select example">
                                        <option value="" selected>select barangay</option>
                                    </select>
                                    <label for="brgy_code">
                                        Barangay
                                    </label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="postal_code" id="operator_postal_code"
                                        placeholder=" ">
                                    <label for="operator_postal_code">
                                        Postal Code
                                    </label>
                                </div>
                                <div id="valid-id">
                                    <div class="input-group mb-3" id="error">
                                        <label class="input-group-text">Valid ID</label>
                                        <input type="file" class="form-control" id="valid_id_image" name="valid_id_image">
                                    </div>
                                </div>

                            </div>
                        </div>

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
                                        <section id="operator-opt-info">
                                            <div class="request-receiver-info-optional-div">

                                            </div>
                                        </section>

                                    </div>
                                </div>
                            </div>
                        </div> --}}

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
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="header-title border-end pe-3">USERS</span>
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
                                <span>User</span>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Drivers</span>
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
            {{-- filter --}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <form id="filter-form" action="">
                            <div class="row" id="filter-header">
                                <div class="col-lg-4">
                                    <div class="form-floating">
                                        <select name="status_filter" id="status_filter" class="form-select"
                                            aria-label="Default select example">
                                            <option selected value="0">- select status- </option>
                                            <option value="1">Pending</option>
                                            <option value="2">Verified</option>
                                            <option value="3">Rejected</option>
                                        </select>
                                        <label for="status_filter">
                                            status
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- data tables --}}
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-lg-12 col-md-12">
                            <div class="p-2" style="min-height: 600px">
                                <div class="card-content table-responsive">
                                    <table class="table table-hover" id="management-driver" style="width: 100%">
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
                                                <th>UPDATED DATE</th>
                                                <th>CREATED DATE</th>
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
        </div>
        @include('include.operator_footer')

    </div>
@endsection

@push('scripts')
    <script>
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        $(document).ready(function() {
            function driversTable(status_filter) {
                $('#management-driver').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('management.userDriversFetch') }}",
                        dataType: "json",
                        data: {
                            status_filter: status_filter,
                        },
                    },
                    columns: [{
                            data: "id"
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
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    scrollX: true,
                    buttons: [{
                            extend: 'csvHtml5',
                            exportOptions: {
                                columns: [
                                    0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                                ]
                            },
                            title: function() {
                                var today = new Date();
                                var date = today.getFullYear() + '-' + (today.getMonth() + 1) +
                                    '-' + today
                                    .getDate();
                                return "DriversTable_" + date;
                            },
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: [
                                    0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                                ]
                            },
                            title: function() {
                                var today = new Date();
                                var date = today.getFullYear() + '-' + (today.getMonth() + 1) +
                                    '-' + today
                                    .getDate();
                                return "DriversTable_" + date;
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            title: function() {
                                var today = new Date();
                                var date = today.getFullYear() + '-' + (today.getMonth() + 1) +
                                    '-' + today
                                    .getDate();
                                return "DriversTable_" + date;
                            },
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            exportOptions: {
                                columns: [
                                    0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                                ]
                            },
                            text: 'PDF',
                            titleAttr: 'PDF',
                        },
                    ],
                });
            }

            driversTable(null);

            $('#status_filter').on('change', function() {
                $('#management-driver').DataTable().destroy();
                driversTable($('#status_filter').val());
            });

            // url check
            if (urlParams.has('status')) {
                $('#status_filter').val(urlParams.get('status')).change();
                $('#management-driver').DataTable().destroy();
                driversTable($('#status_filter').val());
                var uri = window.location.toString();
                if (uri.indexOf("?") > 0) {
                    var clean_uri = uri.substring(0, uri.indexOf("?"));
                    window.history.replaceState({}, document.title, clean_uri);
                }
            }

            $('#add-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('verify.email') }}",
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
                            url: "{{ route('verify.mobileNumber') }}",
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
                    'middle_name': {
                        required: true,
                    },
                    'date_of_birth': {
                        required: true,
                        date: true
                    },
                    sponsor_code: {
                        remote: {
                            url: "{{ route('verify.sponsorCode') }}",
                            type: "GET",
                            data: {
                                sponsor_code: function() {
                                    return $('#operator_sponsor_code').val();
                                }
                            }
                        }
                    },
                    'address': {
                        required: true
                    },
                    'country': {
                        required: true,
                    },
                    'province_code': {
                        required: true,
                    },
                    'citymun_code': {
                        required: true
                    },
                    'brgy_code': {
                        required: true
                    },
                    'postal_code': {
                        required: true
                    },
                    'valid_id_image': {
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
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('management.addUsers') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: ' Added Successfully',
                                text: 'You have successfully added a user',
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });

                            $("#add_user").modal('toggle');
                            $('#add-form').trigger('reset');
                            $('#management-driver').DataTable().ajax
                                .reload();
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                            // console.log(response);
                        }
                    });
                    return false;
                },
            });


            function getProvince() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('address.province') }}",
                    contentType: "application/json",
                    dataType: "json",
                    success: function(data) {
                        var option_htm;
                        $.each(data, function(i, val) {
                            option_htm += '<option value="' + val.province_code + '">' + val
                                .province + '</option>';
                        });

                        $('#province_code').html(option_htm);
                        $('#province_code').prepend(
                            $('<option></option>').val('').html('select province')
                        );
                        $('#province_code').val('');

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            getProvince(); //start page

            function getCities() {
                let val = {
                    'province_code': $("#province_code").val(),
                };
                $.ajax({
                    type: "GET",
                    url: "{{ route('address.city') }}",
                    contentType: "application/json",
                    dataType: "json",
                    data: {
                        data: val.province_code,
                    },
                    success: function(data) {
                        var option_htm;
                        $.each(data, function(i, val) {
                            option_htm += '<option value="' + val.citymun_code + '">' + val
                                .citymun + '</option>';
                        });
                        $('#citymun_code').html(option_htm);
                        $('#citymun_code').prepend(
                            $('<option></option>').val('').html('select city municipality')
                        );
                        $('#citymun_code').val('');
                    },
                    error: function(error) {
                        alert(error);
                        console.log(error);
                    }
                });
            }

            function getBarangay() {
                let val = {
                    'brgy_code': $("#citymun_code").val()
                };
                $.ajax({
                    type: "GET",
                    url: "{{ route('address.barangay') }}",
                    contentType: "application/json",
                    dataType: "json",
                    data: {
                        data: val.brgy_code,
                    },
                    success: function(data) {
                        var option_htm;
                        $.each(data, function(i, val) {
                            option_htm += '<option value="' + val.brgy_code + '">' + val
                                .brgy + '</option>';
                        });
                        $('#brgy_code').html(option_htm);
                        $('#brgy_code').prepend(
                            $('<option></option>').val('').html('select barangay')
                        );
                        $('#brgy_code').val('');
                    },
                    error: function(error) {
                        alert(error);
                        console.log(error);
                    }
                });

            }

            $('#province_code').on('change', function() {
                document.getElementById("province").value = $("#province_code option:selected").text();
                getCities();
            });

            $('#citymun_code').on('change', function() {
                document.getElementById("city_municipality").value = $("#citymun_code option:selected")
                    .text();
                getBarangay()
            });

            $('#brgy_code').on('change', function() {
                document.getElementById("barangay").value = $("#brgy_code option:selected").text()
            });

            $('#user_type').on('change', function() {
                if (this.value == 1) {
                    $('#valid-id').fadeIn();
                } else {
                    $('#valid-id').fadeOut();
                }
                if (this.value == 4 || this.value == 5) {
                    $('#sponsor_op').fadeOut();
                } else {
                    $('#sponsor_op').fadeIn();
                }
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
