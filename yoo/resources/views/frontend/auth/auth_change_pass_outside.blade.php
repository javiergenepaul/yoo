@extends('layouts.layout_auth')

@section('title', 'Verify Otp')

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
                <form action="{{ route('login.authenticate') }}" method="POST" class="d-flex">
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
                            <span><strong>Confirm Mobile OTP</strong></span>
                        </div>
                        <div class="card-body p-3">
                            <form action="{{ route('changePass.verifyOtpCodeOutside') }}" method="POST">
                                @csrf
                                <span>Please confirm the OTP sent to your mobile number.</span>
                                {{-- mobile --}}
                                <input type="hidden" name="otp" id="otp" value="">
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-floating mt-2">
                                    <input
                                        class="form-control @error('mobile_number') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                        id="mobile_number" name="mobile_number" placeholder="Mobile No"
                                        type="text" value="{{ $mobile_number }}" readonly>
                                    <label for="floatingInput">Mobile Number</label>
                                </div>
                                <div class="form-floating mt-2">
                                    <input
                                        class="form-control @error('otp_code') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                        id="otp_code" name="otp_code" placeholder="OTP Here"
                                        type="text">
                                    <label for="floatingInput">Mobile OTP</label>
                                </div>
                                {{-- <div class="input-group mt-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text border-end-0 rounded-0 pe-0 rounded-start"
                                            id="basic-addon1">
                                            <span class="material-icons">call</span>
                                        </span>
                                    </div>
                                    <input id="mobile_number" type="text" name="mobile_number"
                                        class="form-control border-start-0 rounded-end" value="{{ $mobile_number }}"
                                        readonly>
                                </div> --}}
                                {{-- otp --}}
                                {{-- <div class="input-group mt-2">
                                    <div class="input-group-prepend ">
                                        <span
                                            class="input-group-text border-end-0 rounded-0 pe-0 rounded-start bg-white @error('mobile_number') border-danger @enderror @if ($message = Session::get('error')) border-danger  @endif"
                                            id="basic-addon1">
                                            <span class="material-icons">key</span>
                                        </span>
                                    </div>
                                    <input id="otp_code" type="text" name="otp_code"
                                        class="form-control border-start-0 rounded-end
                                        @error('otp_code') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                        placeholder="OTP Here">
                                </div> --}}
                                @error('otp_code')
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
                                    <button type="button" class="btn btn-primary" id="send-otp-code">Send Code</button>
                                    <button type="submit" class="btn btn-outline-secondary" id="send"
                                        disabled>Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('include.operator_footer')
@endsection


@push('scripts')

    {{-- Send OTP SMS --}}
    <script>
        $(document).ready(function() {
            $("#send-otp-code").click(function() {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('changePass.sendOtpCode') }}',
                    // contentType: 'application/json',
                    dataType: 'json',
                    data: {
                        mobileNumber: $('#mobile_number').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response);
                        $('#otp').val(response.otp_register.otp);
                        $('#id').val(response.otp_register.id);


                    },
                    error: function(response) {
                        // console.log(response);
                    }
                });
            });


            
        });
    </script>

    {{-- TIMER CD --}}
    <script>
        var mins;
        var secs;
        var interval;
        $(document).ready(function() {
            $("#send-otp-code").click(function() {
                mins = 3;
                secs = 0;
                var btn = $(this);
                // console.log(btn);
                btn.attr("disabled", true);
                interval = setInterval(function() {
                    if (mins >= 0 && secs >= 0) {
                        btn.text("Resend Code in " + pad(mins, 2) + ":" + pad(secs, 2));
                        if (secs > 0) {
                            secs--;
                        } else {
                            secs = 59;
                            mins--;
                        }
                        if (mins < 0) {
                            clearInterval(interval);
                            btn.removeAttr("disabled").text("Send Code");
                            return true;
                        }
                    }
                    // console.log("Mins: " + mins + ", Secs: " + secs);
                }, 1000);
                // console.log('sample');
            });

        });

        function pad(num, size) {
            var s = num + "";
            while (s.length < size) s = "0" + s;
            return s;
        }
    </script>


    {{-- Disable Button --}}
    <script>
        document.getElementById("otp_code").addEventListener("keyup", function() {
            var otpInput = document.getElementById('otp_code').value;
            if (otpInput === $('#otp').val() && otpInput != "") {
                document.getElementById('send').removeAttribute("disabled");
                document.getElementById('send-otp-code').classList.remove("btn-primary")
                document.getElementById('send-otp-code').classList.add("btn-outline-secondary")
                document.getElementById('send').classList.remove("btn-outline-secondary")
                document.getElementById('send').classList.add("btn-primary")
            } else {
                document.getElementById('send').setAttribute("disabled", null);
                document.getElementById('send-otp-code').classList.remove("btn-outline-secondary")
                document.getElementById('send-otp-code').classList.add("btn-primary")
                document.getElementById('send').classList.remove("btn-primary")
                document.getElementById('send').classList.add("btn-outline-secondary")
            }
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
