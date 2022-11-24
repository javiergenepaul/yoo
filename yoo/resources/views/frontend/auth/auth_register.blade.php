@extends('layouts.layout_auth')

@section('title', 'Register')

@push('css')
    <style>
        body {
            background: #edf0f5;
        }

        #forgot-password {
            text-decoration: none;
        }

        #forgot-password:hover {
            text-decoration: underline;
        }

    </style>
@endpush

@section('content')
    <div class="container" style="height: 100vh">
        <div class="row mt-4 align-items-center" style="height: 100%;">
            <div class="col-md-5 mb-5 mb-md-0">
                <img src="{{ asset('assets/images/02_Logo.png') }}" alt="logo" width="300">
            </div>

            <div class="col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        @if ($request->has('customer_referral_code'))
                            <form id="customer-register-form" action="{{ route('register.createCustomerAccount') }}"
                                method="POST" enctype="multipart/form-data" class="row g-3 mb-3">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="customer_first_name" name="first_name"
                                            placeholder=" ">
                                        <label for="floatingInput">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="customer_last_name" name="last_name"
                                            placeholder=" ">
                                        <label for="floatingInput">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="customer_middle_name"
                                            name="middle_name" placeholder=" ">
                                        <label for="floatingInput">Middle Name</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="mobile" class="form-control" id="customer_mobile_number"
                                            name="mobile_number" placeholder="Mobile No">
                                        <label for="floatingInput">Mobile Number</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="email" class="form-control" id="customer_email" name="email"
                                            placeholder=" ">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="customer_date_of_birth"
                                            name="date_of_birth" placeholder="Date of birth">
                                        <label for="floatingInput">Date of birth</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mt-0">
                                        <input type="text" class="form-control" id="customer_referral_code"
                                            name="referral_code" placeholder="referral-code"
                                            value="{{ $request->customer_referral_code }}" readonly>
                                        <label for="floatingInput">Referral Code</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="password" class="form-control" id="customer_password" name="password"
                                            placeholder="password">
                                        <label for="floatingInput">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="password" class="form-control" id="customer_confirm_password"
                                            name="confirm_password" placeholder="confirm_password">
                                        <label for="floatingInput">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 mx-auto mt-4">
                                    <button class="btn btn-primary py-2 w-100" form="customer-register-form" type="submit">
                                        <span class="font-weight-bold">Create Account</span>
                                    </button>
                                </div>
                            </form>
                        @else
                            <form id="register-form" action="{{ route('register.createNewAccount') }}" method="POST"
                                enctype="multipart/form-data" class="row g-3 mb-3">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            placeholder=" ">
                                        <label for="floatingInput">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            placeholder=" ">
                                        <label for="floatingInput">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="middle_name" name="middle_name"
                                            placeholder=" ">
                                        <label for="floatingInput">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                            placeholder="Date of birth">
                                        <label for="floatingInput">Date of birth</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="mobile" class="form-control" id="mobile_number" name="mobile_number"
                                            placeholder="Mobile No">
                                        <label for="floatingInput">Mobile Number</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="email" class="form-control" id="email" name="email" placeholder=" ">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="text" class="form-control" id="fb_link" name="fb_link"
                                            placeholder=" ">
                                        <label for="text">Facebook link</label>
                                    </div>
                                </div>
                                <div class="col-md-12" id="address_op">
                                    <div class="form-floating mt-0">
                                        <input type="address" class="form-control" id="address" name="address"
                                            placeholder=" ">
                                        <label for="address">Address</label>
                                    </div>
                                </div>
                                {{-- country --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-0">
                                        <select name="country" id="country" class="form-select"
                                            aria-label="Default select example">
                                            <option value="Phillipines">Philippines</option>
                                        </select>
                                        <label for="country">
                                            Country
                                        </label>
                                    </div>
                                </div>

                                {{-- province --}}
                                <input type="hidden" id="province" name="province" value="">
                                <div class="col-md-6">
                                    <div class="form-floating mb-0">
                                        <select name="province_code" id="province_code" class="form-select"
                                            aria-label="Default select example">
                                            <option value="" selected>select province</option>
                                        </select>
                                        <label for="province_code">
                                            Province
                                        </label>
                                    </div>
                                </div>

                                {{-- city --}}
                                <input type="hidden" id="city_municipality" name="city_municipality" value="">
                                <div class="col-md-5">
                                    <div class="form-floating mb-0">
                                        <select name="citymun_code" id="citymun_code" class="form-select"
                                            aria-label="Default select example">
                                            <option value="" selected>select city municipality</option>
                                        </select>
                                        <label for="citymun_code">
                                            City Municipality
                                        </label>
                                    </div>
                                </div>

                                {{-- barangay --}}
                                <input type="hidden" id="barangay" name="barangay" value="">
                                <div class="col-md-4">
                                    <div class="form-floating mb-0">
                                        <select name="brgy_code" id="brgy_code" class="form-select"
                                            aria-label="Default select example">
                                            <option value="" selected>select barangay</option>
                                        </select>
                                        <label for="brgy_code">
                                            Barangay
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mt-0">
                                        <input type="text" class="form-control" id="postal_code" name="postal_code"
                                            placeholder="Postal Code">
                                        <label for="floatingInput">Postal Code</label>
                                    </div>
                                </div>
                                <div class="col-md-12" id="sponsor_op">
                                    <div class="form-floating mt-0" id="sponsor_op">
                                        @if ($request->has('referral_code'))
                                            <input type="address" class="form-control" id="sponsor_code"
                                                name="sponsor_code" placeholder=" " value="{{ $request->referral_code }}"
                                                readonly>
                                            <label for="address">Sponsor Code</label>
                                        @else
                                            <input type="address" class="form-control" id="sponsor_code"
                                                name="sponsor_code" placeholder=" ">
                                            <label for="address">Sponsor Code</label>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mt-0">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="password">
                                        <label for="floatingInput">Password</label>
                                    </div>
                                </div>
                                <div class="input-group mb-3" id="error">
                                    <label class="input-group-text">Valid ID</label>
                                    <input type="file" class="form-control" id="valid_id_image" name="valid_id_image">
                                </div>
                                <div class="form-group col-lg-12 mx-auto mt-4">
                                    <button class="btn btn-primary py-2 w-100" form="register-form" type="submit">
                                        <span class="font-weight-bold">Create Account</span>
                                    </button>
                                </div>
                                <div class="text-center w-100">
                                    <p class="text-muted font-weight-bold">already registered?
                                        <a href="{{ route('login') }}" class="text-primary"
                                            id="forgot-password">login</a>
                                    </p>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        $(document).ready(function() {
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

            $('#customer-register-form').validate({
                rules: {
                    'first_name': {
                        required: true,
                    },
                    'last_name': {
                        required: true,
                    },
                    'middle_name': {
                        required: true,
                    },
                    'date_of_birth': {
                        required: true,
                        date: true
                    },
                    'mobile_number': {
                        required: true,
                        digits: true,
                        minlength: 11,
                        maxlength: 11,
                        remote: {
                            url: "{{ route('verify.mobileNumber') }}",
                            type: "GET",
                            data: {
                                email: function() {
                                    return $('#customer_mobile_number').val();
                                },
                            },
                        }
                    },
                    'email': {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('verify.email') }}",
                            type: "GET",
                            data: {
                                email: function() {
                                    return $('#customer_email').val();
                                },
                            },
                        }
                    },
                    'referral_code': {
                        required: true,
                        // remote: {
                        //     url: "{{ route('verify.referralCode') }}",
                        //     type: "GET",
                        //     data: {
                        //         referral_code: function() {
                        //             return $('#customer_referral_code').val();
                        //         },
                        //     },
                        // }
                    },
                    'password': {
                        required: true,
                    },
                    'confirm_password': {
                        required: true,
                        equalTo: '#customer_password'
                    },
                },
                messages: {
                    'mobile_number': {
                        digits: "Please enter a valid mobile number",
                        minlength: "Please enter a valid mobile number",
                        maxlength: "Please enter a valid mobile number",
                        remote: "Mobile number already registered"
                    },
                    'email': {
                        email: "Please enter a valid email address",
                        remote: "Email already registered"
                    },
                    'referral_code': {
                        remote: "Referral Code does not exist"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#register-form').validate({
                rules: {
                    'first_name': {
                        required: true,
                    },
                    'last_name': {
                        required: true,
                    },
                    'middle_name': {
                        required: true,
                    },
                    'date_of_birth': {
                        required: true,
                        date: true
                    },
                    'mobile_number': {
                        required: true,
                        digits: true,
                        minlength: 11,
                        maxlength: 11,
                        remote: {
                            url: "{{ route('verify.mobileNumber') }}",
                            type: "GET",
                            data: {
                                email: function() {
                                    return $('#mobile_number').val();
                                },
                            },
                        }
                    },
                    'email': {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('verify.email') }}",
                            type: "GET",
                            data: {
                                email: function() {
                                    return $('#email').val();
                                },
                            },
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
                    'sponsor_code': {
                        remote: {
                            url: "{{ route('verify.sponsorCode') }}",
                            type: "GET",
                            data: {
                                sponsor_code: function() {
                                    return $('#sponsor_code').val();
                                },
                            },
                        }
                    },
                    'valid_id_image': {
                        required: true,
                    },
                    'password': {
                        required: true,
                    },
                },
                messages: {
                    'mobile_number': {
                        digits: "Please enter a valid mobile number",
                        minlength: "Please enter a valid mobile number",
                        maxlength: "Please enter a valid mobile number",
                        remote: "Mobile number already registered"
                    },
                    'email': {
                        email: "Please enter a valid email address",
                        remote: "Email already registered"
                    },
                    'sponsor_code': {
                        remote: "Sponsor code does not exist"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

    @if (session()->has('status'))
        <script>
            console.log('spawn');
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
