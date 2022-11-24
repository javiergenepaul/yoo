@extends('layouts.layout_auth')

@section('title', 'Login')


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
                <h4>Welcome Yoo Operator/Management</h4>
            </div>
            <div class="col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <form id="login-form" action="{{ route('login.authenticate') }}" method="POST">
                            @csrf
                            <div class="form-floating mt-2">
                                <input
                                    class="form-control @error('account') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                    id="account" name="account" placeholder="Email/Mobile No." type="text"
                                    value="{{ old('account') }}">
                                <label for="floatingInput">Email/Mobile No.</label>
                            </div>
                            @error('account')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($message = Session::get('error'))
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @endif
                            <div class="form-floating mt-2">
                                <input
                                    class="form-control @error('password') is-invalid @enderror @if ($message = Session::get('error')) is-invalid @endif"
                                    id="password" name="password" placeholder="Password" type="password"
                                    value="{{ old('password') }}">
                                <label for="floatingInput">Password</label>
                            </div>
                            <div class="form-group col-lg-12 mx-auto mt-4">
                                <button class="btn btn-primary py-2 w-100" type="submit">
                                    <span class="font-weight-bold">Log in</span>
                                </button>
                            </div>
                            <div class="text-center w-100">
                                <p class="text-muted font-weight-bold mt-2">
                                    <a href="{{ route('changePass.forgotPassword') }}" class="text-primary"
                                        id="forgot-password">Forgot Password?</a>
                                </p>
                            </div>
                            <div class="text-center w-100">
                                <p class="text-muted font-weight-bold">don't have account?
                                    <a href="{{ route('register') }}" class="text-primary" id="forgot-password">create
                                        account</a>
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
                        required: "please input Email/Password",
                    },
                    'password': {
                        required: 'please enter an password'
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
