@extends('layouts.layout_auth')

@section('title', 'Login')


@push('css')
    <style>
        body {
            background: #FFFFFF;
        }

        .main-content {
            padding: 5%;
        }

        .bg--primary {
            opacity: 0.6;
            border-radius: 0px 8px 8px 0px;
        }

    </style>
@endpush

@section('content')

    <div class="position-absolute top-0 start-0 bg--primary vector" style="height: 100%; width: 20%;">
        <div class="position-absolute bottom-0 start-0">
            <img src="{{ asset('assets/images/loginvector.png') }}" alt="loginvector" width="250" height="270"
                class="img-fluid">
        </div>
    </div>
    <div class="container-fluid main-content position-relative" style="height: 100vh">
        <div class="row mt-4 align-items-center" style="height: 100%;">
            <div class="col-lg-5 col-md-6 col-sm-12 align-self-center">
                <img src="{{ asset('assets/images/loginbackground.png') }}" alt="logo" width="600" height="500"
                    class="img-fluid">
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12">
                <div class="container">
                    <h2>Welcome</h2>
                    <p class="fst-italic mb-5">Yoo Operator/Management</p>
                    <form id="login-form" action="" method="POST">
                        @csrf
                        <div class="form-floating mt-5">
                            <input class="form-control" id="account" name="account" placeholder="Email/Mobile No."
                                type="text" value="">
                            <label for="floatingInput">
                                <p>Email/Mobile No.</p>
                            </label>
                        </div>
                        {{-- @error('account')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @if ($message = Session::get('error'))
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @endif --}}
                        <div class="form-floating mt-4 mb-5">
                            <input class="form-control" id="password" name="password" placeholder="Password"
                                type="password" value="">
                            <label for="floatingInput">
                                <p>Password</p>
                            </label>
                        </div>
                        <div class="form-group col-lg-12 mx-auto mt-5">
                            <button class="btn btn-primary py-2 w-100" type="submit">
                                <p class="fw-normal m-0 p-0">Log in</p>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between login-anchor">
                            <div class="text-left">
                                <p class="text-muted fw-normal mt-2">Don't have an account?
                                    <a href="{{ route('registerv2') }}" class="prim--color" id="forgot-password">Create
                                        Account</a>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-muted fw-normal mt-2">
                                    <a href="{{ route('changePass.forgotPassword') }}" class="prim--color"
                                        style="text-decoration: underline;" id="forgot-password"
                                        style="text-decoration: none;">Forgot Password?</a>
                                </p>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#login-form').validate({
                rules: {
                    'account': {
                        required: true,
                    },
                    'password': {
                        required: true,
                    }
                },
                messages: {
                    'account': {
                        required: "Please input email/password",
                    },
                    'password': {
                        required: 'Please enter a password'
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
