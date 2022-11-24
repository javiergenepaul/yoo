@extends('layouts.layout_auth')

@section('title', 'Register')
@push('css')
    <style>

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
                        <form id="register-form" action="{{ route('customer.createAccount') }}" method="POST"
                            enctype="multipart/form-data" class="row g-3 mb-3">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder=" ">
                                    <label for="floatingInput">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder=" ">
                                    <label for="floatingInput">Last Name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                                        placeholder=" ">
                                    <label for="floatingInput">Middle Name</label>
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
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        placeholder="Date of birth">
                                    <label for="floatingInput">Date of birth</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mt-0">
                                    <input type="text" class="form-control" id="referral_code" name="referral_code"
                                        placeholder="referral-code">
                                    <label for="floatingInput">Referral Code</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating mt-0">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="password">
                                    <label for="floatingInput">Password</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating mt-0">
                                    <input type="password" class="form-control" id="password" name="confirm_password"
                                        placeholder="confirm_password">
                                    <label for="floatingInput">Confirm Password</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 mx-auto mt-4">
                                <button class="btn btn-primary py-2 w-100" type="submit">
                                    <span class="font-weight-bold">Create Account</span>
                                </button>
                            </div>
                            <div class="text-center w-100">
                                <p class="text-muted font-weight-bold">already have account?
                                    <a href="{{ route('customer.login') }}" class="text-primary" id="forgot-password">login</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
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
                    'referral_code': {
                        // required: true,
                        remote: {
                            url: "{{ route('verify.referralCode') }}",
                            type: "GET",
                            data: {
                                referral_code: function() {
                                    return $('#referral_code').val();
                                },
                            },
                        }
                    },
                    'password': {
                        required: true,
                    },
                    'confirm_password': {
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
        });
    </script>
@endpush
