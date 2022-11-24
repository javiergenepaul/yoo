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

        .bg--primary {
            opacity: 0.6;
            border-radius: 8px 0px 0px 8px;
        }

        .register-content {
            padding-left: 10%;
            padding-right: 25%;
        }

    </style>
@endpush

@section('content')

    <div class="position-absolute top-0 end-0 bg--primary vector" style="height: 100vh; width: 30%;">
        <div class="position-absolute top-0 end-0">
            <img src="{{ asset('assets/images/loginvector2.png') }}" alt="loginvector2" width="250" height="270"
                class="img-fluid">
        </div>
    </div>
    <div class="container-fluid position-relative main content p-0 m-0" style="height: 100vh">
        <div class="row m-0 p-0 align-items-center" style="height: 100%;">
            <div class="col-xl-9 col-lg-8 col-md-12 mb-5 mb-md-0">
                @if ($request->has('customer_referral_code'))
                    <div class="register-content">
                        <form id="customer-register-form" action="{{ route('register.createCustomerAccount') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="register-page">
                                <h5 class="fw-normal mb-2" style="opacity: .8;">Personal Info</h5>
                                <div class="row g-3  mb-2">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="customer_first_name"
                                                name="first_name" placeholder=" ">
                                            <label for="floatingInput">
                                                <p>First Name</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="customer_last_name"
                                                name="last_name" placeholder=" ">
                                            <label for="floatingInput">
                                                <p>Last Name</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="customer_middle_name"
                                                name="middle_name" placeholder=" ">
                                            <label for="floatingInput">
                                                <p>Middle Name</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="customer_date_of_birth"
                                                name="date_of_birth" placeholder="Date of birth">
                                            <label for="floatingInput">
                                                <p>Date of birth</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mt-0">
                                            <input type="mobile" class="form-control" id="customer_mobile_number"
                                                name="mobile_number" placeholder="Mobile No">
                                            <label for="floatingInput">
                                                <p>Mobile Number</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="register-page">
                                {{-- <h3 class="fw-normal">Let's get started</h3>
                                <p class="mb-5" style="opacity: .6;">*Please provide all the fields below</p> --}}
                                <h5 class="fw-normal mb-2" style="opacity: .8;">Account Info</h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mt-0">
                                            <input type="text" class="form-control" id="customer_referral_code"
                                                name="referral_code" placeholder="referral-code"
                                                value="{{ $request->customer_referral_code }}" readonly>
                                            <label for="floatingInput">
                                                <p>Referral Code</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating m-0">
                                            <input type="password" class="form-control" id="customer_password"
                                                name="password" placeholder="password">
                                            <label for="floatingInput">
                                                <p>Password</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mt-0">
                                            <input type="password" class="form-control" id="customer_confirm_password"
                                                name="confirm_password" placeholder="confirm_password">
                                            <label for="floatingInput">
                                                <p>Confirm Password</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="register-content py-0 my-0">
                        <form id="register-form" action="{{ route('register.createNewAccount') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="register-page py-0 my-0">
                                {{-- <h3 class="fw-normal">Let's Register your Account</h3>
                                <p class="mb-3" style="opacity: .6;">*Please provide all the fields below</p> --}}
                                <h5 class="fw-normal mb-2" style="opacity: .8;">Personal Info</h5>
                                <div class="row g-3  mb-2">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                placeholder=" ">
                                            <label for="floatingInput">
                                                <p>First Name</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                placeholder=" ">
                                            <label for="floatingInput">
                                                <p>Last Name</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="middle_name" name="middle_name"
                                                placeholder=" ">
                                            <label for="floatingInput">
                                                <p>Middle Name</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="date_of_birth"
                                                name="date_of_birth" placeholder="Date of birth">
                                            <label for="floatingInput">
                                                <p>Date of birth</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mt-0">
                                            <input type="mobile" class="form-control" id="mobile_number"
                                                name="mobile_number" placeholder="Mobile No">
                                            <label for="floatingInput">
                                                <p>Mobile Number</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mt-0">
                                            <input type="text" class="form-control" id="fb_link" name="fb_link"
                                                placeholder=" ">
                                            <label for="text">
                                                <p>Facebook link</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group mt-3" id="error">
                                        <label class="input-group-text">
                                            <p class="m-0 p-0">Valid ID</p>
                                        </label>
                                        <input type="file" class="form-control" id="valid_id_image" name="valid_id_image">
                                    </div>
                                </div>
                                {{-- <div class="row justify-content-between mt-5">
                                    <div class="col-3">
                                        <button class="btn btn-primary py-2 w-100 next1" form="register-form" type="submit">
                                            <span>
                                                <p class="fw-normal p-0 m-0">Continue</p>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-5">
                                        <div class="text-right w-100">
                                            <p class="text-muted font-weight-bold">Already have an account?
                                                <a href="{{ route('login') }}" class="text-primary"
                                                    id="forgot-password">Login</a>
                                            </p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="register-page">
                                {{-- <h3 class="fw-normal">You're almost done</h3>
                                <p class="mb-5" style="opacity: .6;">*Please provide all the fields below</p> --}}
                                <h5 class="fw-normal mb-2" style="opacity: .8;">Address Info</h5>
                                <div class="row g-3 mb-2">
                                    <div class="col-md-12" id="address_op">
                                        <div class="form-floating mt-0">
                                            <input type="address" class="form-control" id="address" name="address"
                                                placeholder=" ">
                                            <label for="address">
                                                <p>Address</p>
                                            </label>
                                        </div>
                                    </div>
                                    {{-- country --}}
                                    <div class="col-md-6">
                                        <div class="form-floating mb-0">
                                            <select name="country" id="country" class="form-select"
                                                aria-label="Default select example">
                                                <option value="Phillipines">
                                                    <p>Philippines</p>
                                                </option>
                                            </select>
                                            <label for="country">
                                                <p>Country</p>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- province --}}
                                    <input type="hidden" id="province" name="province" value="">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-0">
                                            <select name="province_code" id="province_code" class="form-select"
                                                aria-label="Default select example">
                                                <option value="" selected>
                                                    <p>Select Province</p>
                                                </option>
                                            </select>
                                            <label for="province_code">
                                                <p>Province</p>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- city --}}
                                    <input type="hidden" id="city_municipality" name="city_municipality" value="">
                                    <div class="col-md-5">
                                        <div class="form-floating mb-0">
                                            <select name="citymun_code" id="citymun_code" class="form-select"
                                                aria-label="Default select example">
                                                <option value="" selected>
                                                    <p>Select City Municipality</p>
                                                </option>
                                            </select>
                                            <label for="citymun_code">
                                                <p>City Municipality</p>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- barangay --}}
                                    <input type="hidden" id="barangay" name="barangay" value="">
                                    <div class="col-md-4">
                                        <div class="form-floating mb-0">
                                            <select name="brgy_code" id="brgy_code" class="form-select"
                                                aria-label="Default select example">
                                                <option value="" selected>
                                                    <p>Select Barangay</p>
                                                </option>
                                            </select>
                                            <label for="brgy_code">
                                                <p>Barangay</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mt-0">
                                            <input type="text" class="form-control" id="postal_code" name="postal_code"
                                                placeholder="Postal Code">
                                            <label for="floatingInput">
                                                <p>Postal Code</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row justify-content-start mt-5">
                                    <div class="col-2">
                                        <button class="btn btn-primary py-2 w-100 back2" type="button">
                                            <span class="fw-bold">
                                                <p class="fw-normal m-0 p-0">Back</p>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-primary py-2 w-100 next2" form="register-form" type="submit">
                                            <span class="fw-bold">
                                                <p class="fw-normal m-0 p-0">Continue</p>
                                            </span>
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="register-page">
                                {{-- <h3 class="fw-normal">Let's get started</h3>
                                <p class="mb-5" style="opacity: .6;">*Please provide all the fields below</p> --}}
                                <h5 class="fw-normal mb-2" style="opacity: .8;">Account Info</h5>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-12" id="sponsor_op">
                                        <div class="form-floating mt-0" id="sponsor_op">
                                            @if ($request->has('referral_code'))
                                                <input type="address" class="form-control" id="sponsor_code"
                                                    name="sponsor_code" placeholder=" "
                                                    value="{{ $request->referral_code }}" readonly>
                                                <label for="address">
                                                    <p>Sponsor Code</p>
                                                </label>
                                            @else
                                                <input type="address" class="form-control" id="sponsor_code"
                                                    name="sponsor_code" placeholder=" ">
                                                <label for="address">
                                                    <p>Sponsor Code</p>
                                                </label>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-floating mt-0">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder=" ">
                                            <label for="email">
                                                <p>Email</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating m-0">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="password">
                                            <label for="floatingInput">
                                                <p>Password</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-start mt-3">
                                <div class="col-3">
                                    <button class="btn btn-primary py-2 w-100 next2" form="register-form" type="submit">
                                        <span class="fw-bold">
                                            <p class="fw-normal m-0 p-0">Create Account</p>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-0" style="height:100%, width:100%;">
                <img src="{{ asset('assets/images/registerbackground.png') }}" alt="registerbackground" width="400"
                    height="400" class="img-fluid">
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
                            $('<option></option>').val('').html('Select Province')
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
