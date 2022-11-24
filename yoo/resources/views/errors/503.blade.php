@extends('frontend.auth.auth_login')

@push('css')
    <style>
        body {
            margin: 0%;
        }

        .square-box {
            min-height: 100vh;
        }

    </style>
@endpush

@section('content')
    <div class="container square-box d-flex justify-content-center align-items-center">
        <div class="flex-row">
            <h1 class="text-center">We'll be back soon!!</h1>
            <p class="lead text-center body-message">
                Sorry for the inconveniencet but were performing some maintenance at the moment.
            </p>
        </div>
    </div>
@endsection
