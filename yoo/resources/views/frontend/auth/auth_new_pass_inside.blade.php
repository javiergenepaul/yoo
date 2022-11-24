@extends('layouts.layout_operator')

@section('title', 'New Password')

@push('css')
@endpush

@section('content')
    <div id="content">
        @include('include.operator_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header">
                    <div class="col-lg-12 d-flex align-items-center">
                        <span class="header-title border-end pe-3">CHANGE PASSWORD</span>
                        <div class="d-flex align-items-center home-logo">
                            @if ($user_type->operator)
                                <small>
                                    <a class="d-flex align-items-center" href="{{ route('operator.index') }}">
                                        <span id="click-link"
                                            class="material-icons d-flex align-items-center ps-2">home</span>
                                    </a>
                                </small>
                            @else
                                <small>
                                    <a class="d-flex align-items-center" href="{{ route('management.index') }}">
                                        <span id="click-link"
                                            class="material-icons d-flex align-items-center ps-2">home</span>
                                    </a>
                                </small>
                            @endif
                            <span class="material-icons d-flex align-items-center">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            @if ($user_type->operator)
                                <small>
                                    <a id="click-link" class="d-flex align-items-center "
                                        href="{{ route('operator.settings') }}">
                                        SETTINGS
                                    </a>
                                </small>
                            @else
                                <small>
                                    <a id="click-link" class="d-flex align-items-center "
                                        href="{{ route('management.settings') }}">
                                        SETTINGS
                                    </a>
                                </small>
                            @endif
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a id="click-link" class="d-flex align-items-center "
                                    href="{{ route('changePass.changePassInside') }}">
                                    VERIFY OTP
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <small>
                            <span class="">Change Pass</span>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <strong>Change Password</strong>
                </div>
                <div class="card-body">
                    <form id="new-pass-inside-form" class="g-3"
                        action="{{ route('changePass.verifyNewPassInside') }}" method="POST">
                        @csrf
                        <input type="hidden" name="mobile_number" value="{{ $mobile_number }}">
                        <div class="mb-3">
                            {{-- <label for="password" class="col-form-label">New Password:</label>
                            <input name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"> --}}
                            <div class="form-floating mt-2">
                                <input class="form-control @error('password') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                    id="password" name="password" placeholder="Password" type="password">
                                <label for="floatingInput">Password</label>
                            </div>
                            {{-- @error('password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror --}}
                        </div>
                        <div class="mb-3">
                            {{-- <label for="password_confirmation" class="col-form-label">Confirm New Password:</label>
                            <input name="password_confirmation" type="password"
                                class="form-control @error('password') is-invalid @enderror" id="password_confirmation"> --}}
                            <div class="form-floating mt-2">
                                <input class="form-control @error('password') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Password Confirmation" type="password">
                                <label for="floatingInput">Password Confirmation</label>
                            </div>
                            {{-- @error('password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror --}}
                        </div>
                        <button type="button" class="btn btn-secondary">
                            <a style="color: white" href="{{ route('changePass.cancelUpdate') }}">Cancel</a>
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            @include('include.operator_footer')
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#new-pass-inside-form').validate({
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
                        required: "please input password",
                    },
                    'password_confirmation' : {
                        required : "Please input new password",
                        equalTo: "password does not match please try again"

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
