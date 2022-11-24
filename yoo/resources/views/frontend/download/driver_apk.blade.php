@extends('layouts.layout_download')

@push('css')
    <style>
        .container {
            margin: auto;
            text-align: center;
            font-size: 2.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div>
            <a href="{{ asset('apk/yoo-driver.apk') }}" download>
                DOWNLOAD DRIVER APK HERE!
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    
@endpush