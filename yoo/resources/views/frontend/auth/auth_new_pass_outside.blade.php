@extends('layouts.layout_auth')

@section('title', 'Change Pass Otp')

@push('css')
    <style>
        #content {
            background-color: #edf0f5;
            position: relative;
        }

        nav.navbar {
            position: absolute;
            width: 100%;
            z-index: 9;
            top: 0;
        }

    </style>
@endpush

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid mx-3">
            <a href="{{ route('operator.index') }}" class="navbar-brand">
                <img src="{{ asset('assets/images/02_Logo.png') }}" alt="logo" width="80">
            </a>
            <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarSupportedContent">
                <form action="{{ route('login.authenticate') }}" method="POST" class="d-flex"
                    zzzzzzzz>
                    @csrf
                    <input id="account" name="account" class="form-control me-2 @error('account') is-invalid @enderror"
                        type="text" placeholder="Email or Mobile Number">
                    <input id="password_login" name="password" class="form-control me-2" type="password" placeholder="Password">
                    <button class="btn btn-primary" type="submit">Login</button>
                </form>
            </div>
        </div>
    </nav>
    <section class="vh-100" id="content">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-header">
                            <span><strong>Change Password</strong></span>
                        </div>
                        <div class="card-body p-3">
                            <form id="newpass-form" action="{{ route('changePass.verifyNewPassOutside') }}" method="POST">
                                @csrf
                                <span>Please enter your new password</span>
                                {{-- mobile --}}
                                <input type="hidden" name="mobile_number" id="otp" value="{{ $mobile_number }}">
                                {{-- otp --}}

                                <div class="form-floating mt-2">
                                    <input
                                        class="form-control @error('password') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                        id="password" name="password" placeholder="New Password" type="password">
                                    <label for="floatingInput">Password</label>
                                </div>
                                {{-- <div class="input-group mt-2">
                                    <div class="input-group-prepend ">
                                        <span
                                            class="input-group-text border-end-0 rounded-0 pe-0 rounded-start bg-white @error('password') border-danger @enderror @if ($message = Session::get('error')) border-danger  @endif"
                                            id="basic-addon1">
                                            <span class="material-icons">key</span>
                                        </span>
                                    </div>
                                    <input id="password" type="password" name="password"
                                        class="form-control border-start-0 rounded-end
                                        @error('password') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                        placeholder="New Password">
                                </div> --}}
                                {{-- @error('password')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror --}}

                                <div class="form-floating mt-2">
                                    <input
                                        class="form-control @error('password') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                        id="password_confirmation" name="password_confirmation" placeholder="New Password"
                                        type="password">
                                    <label for="floatingInput">ConfirmPassword</label>
                                </div>

                                {{-- <div class="input-group mt-2">
                                    <div class="input-group-prepend ">
                                        <span
                                            class="input-group-text border-end-0 rounded-0 pe-0 rounded-start bg-white @error('password') border-danger @enderror @if ($message = Session::get('error')) border-danger  @endif"
                                            id="basic-addon1">
                                            <span class="material-icons">key</span>
                                        </span>
                                    </div>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        class="form-control border-start-0 rounded-end
                                        @error('password') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                        placeholder="Confirm New Password">
                                </div> --}}
                                {{-- @error('password')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
                                <div class="col-auto mt-2">
                                    <button type="button" class="btn btn-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('include.operator_footer')
    </section>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#newpass-form').validate({
                rules: {
                    'password': {
                        required: true,
                        minlength: 8
                    },
                    'password_confirmation' : {
                        required : true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    'password': {
                        required: "please Input password",
                    },
                    'password_confirmation' : {
                        required : "Please input new password",
                        equalTo: "password does not match"

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
                }
            });
        });
    </script>

@endpush
