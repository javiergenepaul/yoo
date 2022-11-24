@extends('layouts.layout_operator')

@section('title', 'Top Up Page')

@push('css')
    <style>
        .pagination .page-item .page-link {
            color: #8C27FF;
        }

        .pagination .page-item.active .page-link {
            color: white;
            background-color: #8C27FF;
            border-color: #8C27FF;
        }

        div.dataTables_wrapper div.dataTables_paginate ul.pagination .page-item.active .page-link:focus {
            color: white;
            background-color: #8C27FF;
        }

        .pagination .page-item.active .page-link:hover {
            background-color: #8C27FF;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }

    </style>
@endpush

@section('content')
    <div id="content">
        @include('include.operator_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="header-title border-end pe-3">{Name} REQUEST</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a class="d-flex align-items-center" href="{{ route('management.index') }}">
                                    <span id="click-link" class="material-icons ps-2">home</span>
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a id="click-link" class="d-flex align-items-center "
                                    href="{{ route('management.topUp') }}">
                                    TOP UP
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>{name} Request</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-12 col-md-12">
                    <div class="card" style="min-height: 100vh">
                        <div class="card-content table-responsive">
                            <table class="table table-hover" id="top-up-table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>REF ID</th>
                                        <th>NAME</th>
                                        <th>MOBILE</th>
                                        <th>STATUS</th>
                                        <th>AMOUNT</th>
                                        <th>ACTIONS </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Name</td>
                                        <td>09275652944</td>
                                        <td>Requested</td>
                                        <td>100</td>
                                        <td><button class="btn btn-primary">View Details</button></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Name</td>
                                        <td>09275652944</td>
                                        <td>Loaded</td>
                                        <td>100</td>
                                        <td><button class="btn btn-primary">View Details</button></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Name</td>
                                        <td>09275652944</td>
                                        <td>Cancelled</td>
                                        <td>100</td>
                                        <td><button class="btn btn-primary">View Details</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#top-up-table').DataTable({
                bLengthChange: true,
                "lengthMenu": [[5, 10, 25, ,-1], [5, 10, "All"]],
                "iDisplayLength": 5,
            });
        });
    </script>

@endpush
