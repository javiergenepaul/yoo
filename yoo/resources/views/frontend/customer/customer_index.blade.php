@extends('layouts.layout_customer')

@push('css')
    <style>
        body {
            /* background-color: #E2C9FF; */
            background:
                linear-gradient(125deg, #C08BFD, #FFFFFF);
            height: 100vh;
        }

        .main-content {
            padding: 50px 150px 0px;
        }

        .content1 {
            color: #400089;
        }

        .content2 {
            color: #8011FF;
        }

        .customer_pictures {
            position: relative;
            /* top: 200px; */
            top: 180px
        }

        .motorcycle-customer {
            position: relative;
            right: 150px;
        }

        .building-customer {
            position: relative;
            left: 250px;
        }

        .primary--btn {
            background: #8C27FF;
            color: #fff !important;
            border-radius: 25px;
            border: unset;
            padding: 15px 30px;
        }

        .google {
            position: absolute;
            right: 0px;
            top: 200px;
        }

    </style>
@endpush
@section('content')
    <section class="main-content">
        <div class="container-fluid position-relative">
            <div class="row align-items-center gx-5">
                <div class="col-8">
                    <h1 class="fs-1 fw-bold fst-italic content1">Fast and easy delivery</h1>
                </div>
                <div class="col-4 text-center">
                    <a href="{{ route('landingPage') }}"><img src="{{ asset('assets/images/logo_customer.png') }}"
                            class="" alt="..."></a>
                </div>
            </div>
            <div class="row gx-5 my-3">
                <div class="col-8">
                    <h3 class="fs-1 content2">We value customers just as how
                        we handle your bookings!</h4>
                </div>
            </div>


            <div class="translate-middle google">
                <a href="https://play.google.com/store/apps/details?id=com.mach95.yoo">
                    <img class="google" src="{{ asset('assets/images/googleplay_black.png') }}">
                </a>
            </div>


            <div class="row align-items-end customer_pictures">
                <div class="col-6 ">
                    <img src="{{ asset('assets/images/motorcycle_customer.png') }}" class="motorcycle-customer img-fluid"
                        alt="...">
                </div>
                <div class="col-3 ">
                    <img src="{{ asset('assets/images/customer_building.png') }}" class="building-customer img-fluid"
                        alt="...">
                </div>
                <div class="col-3 ">
                    <img src="{{ asset('assets/images/customer_building2.png') }}" class="building-customer img-fluid"
                        alt="...">
                </div>
            </div>
        </div>


    </section>
@endsection
@push('scripts')
    @if (session()->has('status'))
        <script>
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
