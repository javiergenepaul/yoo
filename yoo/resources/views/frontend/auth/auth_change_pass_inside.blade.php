@extends('layouts.layout_operator')

@section('title', 'Confirm Otp')

@push('css')
@endpush

@section('content')
    <div id="content">
        @include('include.operator_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header">
                    <div class="col-lg-12 d-flex align-items-center">
                        <span class="header-title border-end pe-3">VERIFY OTP</span>
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
                        <small>
                            <span class="">Verify Otp</span>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <strong>Confirm Mobile OTP</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('changePass.verifyOtpCodeInside') }}" method="POST">
                        @csrf
                        <input type="hidden" name="otp" id="otp" value="">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="mb-2">
                            <div class="form-floating mt-2">
                                <input
                                    class="form-control @error('mobile_number') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                    id="mobile_number" name="mobile_number" placeholder="Mobile Number" type="number"
                                    value="{{ $mobile_number }}" readonly>
                                <label for="floatingInput">Mobile Number</label>
                            </div>
                            {{-- <label for="mobile_number" class="col-form-label">Mobile Number:</label>
                            <input name="mobile_number" type="text" class="form-control" id="mobile_number"
                                placeholder="Enter Code" value="{{ $mobile_number }}" readonly> --}}
                            <div class="form-floating mt-2">
                                <input class="form-control @error('otp_code') is-invalid @enderror @if ($message = Session::get('error')) is-invalid  @endif"
                                    id="otp_code" name="otp_code" placeholder="OTP code" type="text">
                                <label for="floatingInput">OTP Code</label>
                            </div>
                            {{-- <label for="otp_code" class="col-form-label">OTP Code</label>
                            <input name="otp_code" type="text" class="form-control @error('otp_code') is-invalid @enderror"
                                id="otp_code" placeholder="Enter Code"> --}}
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
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary" id="send-otp-code">
                                Send Code
                            </button>
                            <button type="submit" class="btn btn-outline-secondary" id="send" disabled>Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('include.operator_footer')
        </div>
    </div>

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
            Swal.fire({
                icon: '{{ session()->get('status') }}',
                title: '{{ session()->get('title') }}',
                text: '{{ session()->get('text') }}',
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false
            })
        </script>
    @endif
@endpush
