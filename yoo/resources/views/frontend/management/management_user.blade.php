@extends('layouts.layout_management')

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

        #icons {
            /* color: blue */
            vertical-align: middle
        }

    </style>
@endpush

@push('modal')
    {{-- modals --}}
    {{-- add user --}}
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
                                <input type="number" name="mobile_number" id="operator_mobile_number" class="form-control"
                                    placeholder=" ">
                                <label for="mobile_number">
                                    Mobile Number
                                </label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="operator_email" class="form-control" placeholder=" ">
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

    {{-- update user --}}
    <div class="modal fade" id="update_user" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="loadRiderAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                {{-- <div class="modal-header">
                    <h5 class="modal-title" id="loadRiderModalLabel">
                        <strong>Update User</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}
                <div class="modal-body">
                    <form id="load-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <span class="mt-4"><strong>Profile</strong></span>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('first_name') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="first_name" name="first_name" placeholder=" "
                                        value="">
                                    <label for="floatingInput">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('last_name') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="last_name" name="last_name" placeholder=" "
                                        value="">
                                    <label for="floatingInput">Last Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mt-2">
                                    <input type="text"
                                        class="form-control @error('middle_name') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="middle_name" name="middle_name" placeholder=" "
                                        value="">
                                    <label for="floatingInput">Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mt-2">
                                    <input type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="date_of_birth" name="date_of_birth" placeholder="Date of birth"
                                        value="">
                                    <label for="floatingInput">Date of birth</label>
                                </div>
                            </div>

                            <span><strong>Address</strong></span>
                            {{-- address --}}
                            <div class="col-md-12">
                                <div class="form-floating mt-2">
                                    <input type="text"
                                        class="form-control @error('address') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="address" name="address" placeholder="Address"
                                        value="">
                                    <label for="floatingInput">Address</label>
                                </div>
                            </div>
                            {{-- country --}}
                            <div class="col-md-6">
                                <div class="form-floating mt-2">
                                    <input type="text"
                                        class="form-control @error('country') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="country" name="country" placeholder="Country"
                                        value="">
                                    <label for="floatingInput">Country</label>
                                </div>
                            </div>
                            {{-- province --}}
                            <div class="col-md-6">
                                <div class="form-floating mt-2">
                                    <input type="text"
                                        class="form-control @error('province') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="province" name="province" placeholder="Province"
                                        value="">
                                    <label for="floatingInput">Province</label>
                                </div>
                            </div>
                            {{-- city --}}
                            <div class="col-md-5">
                                <div class="form-floating mt-2">
                                    <input type="text"
                                        class="form-control @error('city_municipality') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="city_municipality" name="city_municipality" placeholder="City Municipality"
                                        value="">
                                    <label for="floatingInput">City Municipality</label>
                                </div>
                            </div>
                            {{-- barangay --}}
                            <div class="col-md-4">
                                <div class="form-floating mt-2">
                                    <input type="text"
                                        class="form-control @error('barangay') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="barangay" name="barangay" placeholder="Barangay"
                                        value="">
                                    <label for="floatingInput">Barangay</label>
                                </div>
                            </div>
                            {{-- postal code --}}
                            <div class="col-md-3">
                                <div class="form-floating mt-2">
                                    <input type="text"
                                        class="form-control @error('postal_code') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                        id="postal_code" name="postal_code" placeholder="Postal Code"
                                        value="">
                                    <label for="floatingInput">Postal Code</label>
                                </div>
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
                                            <div class="form-floating mb-3">
                                                <input type="text" name="s_acct_name" class="form-control"
                                                    id="s_acct_name" placeholder=" ">
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
                                                <input type="text" name="ref" class="form-control" id="ref"
                                                    placeholder=" ">
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
                                                <input class="form-control form-control" id="formFileLg" type="file"
                                                    name="pop">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
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
                                <span>USER</span>
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
                    {{-- tabs --}}
                    <ul class="nav nav-tabs nav-justified red" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="driver-tab" data-bs-toggle="tab" href="#driver" role="tab"
                                aria-controls="driver" aria-selected="true">Drivers</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="customer-tab" data-bs-toggle="tab" href="#customer" role="tab"
                                aria-controls="customer" aria-selected="false">Customers</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="operator-tab" data-bs-toggle="tab" href="#operator" role="tab"
                                aria-controls="operator" aria-selected="false">Operators</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="management-tab" data-bs-toggle="tab" href="#management"
                                role="tab" aria-controls="management" aria-selected="false">Management</a>
                        </li>
                    </ul>
                    {{-- content --}}
                    <div class="tab-content" id="myTabContent">
                        {{-- driver tab --}}
                        <div class="tab-pane fade show active" id="driver" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="p-2" style="min-height: 600px">
                                        <div class="card-content">
                                            <table class="table table-hover" id="management-driver" style="width:100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>UID</th>
                                                        <th>MOBILE</th>
                                                        <th>EMAIL</th>
                                                        <th>NAME</th>
                                                        <th>CITY</th>
                                                        {{-- <th>VEHICLE</th> --}}
                                                        <th>STATUS</th>
                                                        <th>RATING</th>
                                                        <th>ORDERS</th>
                                                        <th>UPDATED DATE</th>
                                                        <th>CREATED DATE</th>
                                                        <th>ACTIONS</th>
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
                        {{-- customer tab --}}
                        <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="p-2" style="min-height: 600px">
                                        <div class="card-content">
                                            <table class="table table-hover table-responsive-xl" id="management-customer"
                                                style="width: 100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>UID</th>
                                                        <th>MOBILE</th>
                                                        <th>EMAIL</th>
                                                        <th>NAME</th>
                                                        <th>CITY</th>
                                                        <th>RATING</th>
                                                        <th>UPDATED DATE</th>
                                                        <th>CREATED DATE</th>
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
                        {{-- operator tab --}}
                        <div class="tab-pane fade" id="operator" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="p-2" style="min-height: 600px">
                                        <div class="card-content table-responsive">
                                            <table class="table table-hover" id="management-operator" style="width: 100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>UID</th>
                                                        <th>MOBILE</th>
                                                        <th>EMAIL</th>
                                                        <th>NAME</th>
                                                        <th>STATUS</th>
                                                        <th>TYPE</th>
                                                        <th>OPERATOR EMAIL</th>
                                                        <th>CODE</th>
                                                        <th>UPDATED DATE</th>
                                                        <th>CREATED DATE</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- management tab --}}
                        <div class="tab-pane fade" id="management" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12">
                                    <div class="p-2" style="min-height: 600px">
                                        <div class="card-content table-responsive">
                                            <table class="table table-hover" id="management-management"
                                                style="width: 100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>UID</th>
                                                        <th>MOBILE</th>
                                                        <th>EMAIL</th>
                                                        <th>NAME</th>
                                                        <th>UPDATED DATE</th>
                                                        <th>CREATED DATE</th>
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
    </div>
@endsection


@push('scripts')
    <script>
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

        $(document).ready(function() {
            function loadManagementDriver() {
                $('#management-driver').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('management.getUserDrivers') }}",
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
                });

            }

            function loadManagementCustomer() {
                $('#management-customer').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('management.getUserCustomers') }}",
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
                            data: "rating"
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
                    scrollX: true,
                });
            }

            function loadManagementOperator() {
                $('#management-operator').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('management.getUserOperator') }}",
                        dataType: "json",
                        dataSrc: function(data) {
                            return data.data;
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
                            data: "op_status"
                        },
                        {
                            data: "type"
                        },
                        {
                            data: "sponsor_id"
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
                        {
                            data: "action"
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    scrollX: true,
                });
            }

            function loadManagementManagement() {
                $('#management-management').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "GET",
                        url: "{{ route('management.getUserManagement') }}",
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
                            data: "updated_at"
                        },
                        {
                            data: "created_at"
                        },
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    scrollX: true,
                });
            }

            loadManagementDriver();

            $('#driver-tab').on('shown.bs.tab', function() {
                $('#management-customer').DataTable().destroy();
                $('#management-operator').DataTable().destroy();
                $('#management-management').DataTable().destroy();
                loadManagementDriver();
            });

            $('#customer-tab').on('shown.bs.tab', function() {
                $('#management-driver').DataTable().destroy();
                $('#management-operator').DataTable().destroy();
                $('#management-management').DataTable().destroy();
                loadManagementCustomer();
            });

            $('#operator-tab').on('shown.bs.tab', function() {
                $('#management-driver').DataTable().destroy();
                $('#management-customer').DataTable().destroy();
                $('#management-management').DataTable().destroy();
                loadManagementOperator();
            });

            $('#management-tab').on('shown.bs.tab', function() {
                $('#management-driver').DataTable().destroy();
                $('#management-customer').DataTable().destroy();
                $('#management-operator').DataTable().destroy();
                loadManagementManagement();
            });


            $('#management-driver tbody').on('click', '#update_user_btn', function() {
                let driver_id = $('#management-driver').DataTable().row($(this).parents('tr')).data()['id'];
                $('#update_user').modal({}).on('shown.bs.modal', function() {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('management.getUserInfoDetails') }}",
                        contentType: "application/json",
                        dataType: "json",
                        data: {
                            data: driver_id,
                        },
                        success: function(response) {
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });

            // validation
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
