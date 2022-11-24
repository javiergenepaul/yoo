@extends('layouts.layout_auth')

@section('title', 'Forgot Password')

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
                <form id="" action="{{ route('login.authenticate') }}" method="POST" class="d-flex">
                    @csrf
                    <input id="account" name="account" class="form-control me-2 @error('account') is-invalid @enderror"
                        type="text" placeholder="Email or Mobile Number">
                    <input id="password" name="password" class="form-control me-2 @error('password') is-invalid @enderror"
                        type="password" placeholder="Password">
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
                            <span><strong>Find Your Account</strong></span>
                        </div>
                        <div class="card-body p-3">
                            <form id="find-mob-form" action="{{ route('changePass.checkMobileNumber') }}" method="POST">
                                @csrf
                                <span>Please enter your email or mobile number to search for your account.</span>
                                <div class="form-floating mt-2">
                                    <input type="mobile"
                                        class="form-control @error('mobile_number') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"" id="
                                        mobile_number" name="mobile_number" placeholder="Mobile No"
                                        value="{{ old('mobile_number') }}">
                                    <label for="floatingInput">Mobile Number</label>
                                </div>
                                @error('mobile_number')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if ($message = Session::get('error'))
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @endif
                                <div class="col-auto mt-2">
                                    <a href="{{ route('operator.index') }}" style="text-decoration: none">
                                        <button type="button" class="btn btn-secondary">Cancel</button>
                                    </a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            $('#find-mob-form').validate({
                rules: {
                    mobile_number: {
                        required: true,
                        digit: true,
                        min: 11
                    }
                },
                messages: {
                    mobile_number: {
                        required: "please input mobile number",
                        digit: "please input numbers only",
                        min: "please input minimum of 11 digits"
                    }
                }
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
