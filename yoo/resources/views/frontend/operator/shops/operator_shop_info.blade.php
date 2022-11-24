@extends('layouts.layout_operator')

@section('title', 'Shop Info Page')

@push('css')
    <style>
        .crop-profile {
            width: auto;
            height: 150px;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        .crop-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #shop-image {
            opacity: 1;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .middle-shop-image {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .edit-shop-image-preview {
            width: 100%;
            height: 400px;
        }

        .crop-profile:hover #shop-image {
            opacity: 0.3;
        }

        .crop-profile:hover .middle-shop-image {
            opacity: 1;
        }

        #item-image {
            opacity: 1;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .middle-item-image {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .crop-profile:hover #item-image {
            opacity: 0.3;
        }

        .crop-profile:hover .middle-item-image {
            opacity: 1;
        }

        .edit-item-image-preview {
            width: 100%;
            height: 400px;
        }

        .icon-background-1 {
            background-color: #EEEDFD;
        }

        .icon-background-2 {
            background-color: #E5F8ED;
        }

        .icon-value-1 {
            color: #7367F0;
        }

        .icon-value-2 {
            color: #28C76F;
        }

        .accordion-button:not(.collapsed) {
            color: black;
            background-color: rgba(255, 255, 255, 13%);
        }

        .accordion-button:(.collapsed) {
            color: rgb(255, 0, 0);
            background-color: rgba(255, 255, 255, 13%);
        }

        .accordion-button:focus {
            z-index: 3;
            border-color: white;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 0%);
            box-shadow: inset 0 -1px 0 rgb(0 0 0 / 13%);
        }

        .accordion-item {
            background-color: rgba(255, 255, 255, 0);
            border: 1px solid rgba(255, 255, 255, 0);
        }

        .accordion-button {
            background-color: rgba(255, 255, 255, 0);
            box-shadow: inset 0 -1px 0 rgb(0 0 0 / 13%);
        }

        .accordion-button:after {
            background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23859488'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important;
        }

        .shop-type-header {
            color: #555e58;
            font-size: 24px
        }

        .info-details {
            font-weight: 500;
        }

        #headerToggle {
            height: 35px;
            width: 75px;
        }

        .form-switch .form-check-input {
            height: 20px;
            width: 40px;
        }

        .form-switch .form-check-input:focus {
            border-color: rgba(0, 0, 0, 0.25);
            outline: 0;
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }

        .form-switch .form-check-input:checked {
            background-color: #8C27FF;
            border: none;
        }

        .streamline .sl-item {
            position: relative;
            padding-bottom: 12px;
            border-left: 1px solid #ccc;
        }

        .streamline .sl-item:before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            background-color: #ccc;
            width: 12px;
            height: 12px;
            border-radius: 100%;
        }

        .streamline .sl-primary:before,
        .streamline .sl-primary:last-child:after {
            background-color: #8C27FF;
        }

        .streamline .sl-primary {
            border-left-color: #8c27ff65;
        }

        .streamline .sl-item .sl-content {
            margin-left: 24px;
        }

        .streamline .sl-item .text-muted {
            color: inherit;
            opacity: .6;
            font-size: 12px;
        }

        .streamline .sl-item p {
            font-size: 14px;
            color: #5e5873;
        }

        #scrollbar::-webkit-scrollbar {
            display: none;
        }

        .view-note:link {
            color: #8C27FF;
        }

        .view-note:hover {
            color: #28C76F;
        }

        #item-markup-model {
            display: none;
        }

        #item-combo-markup-model {
            display: none;
        }

        #item-variant-markup-model {
            display: none;
        }

        #custom-days {
            display: none;
        }

             .edit-item-combo-btn {
            font-size: 20px;
            transition: 0.2s;
        }

        .edit-item-combo-btn:focus,
        .edit-item-combo-btn:active,
        .edit-item-combo-btn.active,
        .edit-item-combo-btn.focus,
        {
            outline: none !important;
            box-shadow: none !important;
        }

        .edit-item-combo-btn:hover {
            font-size: 24px;
        }

        .delete-item-combo-btn {
            font-size: 20px;
            transition: 0.2s;
        }

        .delete-item-combo-btn:focus,
        .delete-item-combo-btn:active,
        .delete-item-combo-btn.active,
        .delete-item-combo-btn.focus,
        {
            outline: none !important;
            box-shadow: none !important;
        }

        .delete-item-combo-btn:hover {
            font-size: 24px;
        }

        /* edit variant button */
        .edit-item-variant-btn {
            font-size: 20px;
            transition: 0.2s;
        }

        .edit-item-variant-btn:focus,
        .edit-item-variant-btn:active,
        .edit-item-variant-btn.active,
        .edit-item-variant-btn.focus
        {
            outline: none !important;
            box-shadow: none !important;
        }

        .edit-item-variant-btn:hover {
            font-size: 24px;
        }

        /* delete variant button */
        .delete-item-variant-btn {
            font-size: 20px;
            transition: 0.2s;
        }

        .delete-item-variant-btn:focus,
        .delete-item-variant-btn:active,
        .delete-item-variant-btn.active,
        .delete-item-variant-btn.focus
        {
            outline: none !important;
            box-shadow: none !important;

        }

        .delete-item-variant-btn:hover {
            font-size: 24px;
        }

        .dropdown-toggle:focus,
        .dropdown-toggle:active,
        .dropdown-toggle.active,
        .dropdown-toggle.focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .dropdown-toggle.show i {
            transition: 0.2s ease-in;
            -webkit-transform: rotate(180deg);
        }

        .d-down {
            cursor: pointer;
        }
    </style>
@endpush

@push('modal')
    <div class="modal fade" id="add-category-modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-category-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="category" id="category" placeholder=" ">
                            <label for="category">Category</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="add-category-submit-btn" type="submit" form="add-category-form"
                        class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-item-modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-item-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder=" ">
                            <label for="category">Name</label>
                        </div>
                        <div class="markup-section">
                            <div class="form-floating mb-3">
                                <input type="number" class="cost form-control" name="cost" id="item_cost"
                                    placeholder=" ">
                                <label for="category">Cost</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="markup form-control" name="markup" id="item_markup"
                                    placeholder=" ">
                                <label for="category">Mark up</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="item_markup_type"
                                            id="inlineRadio2" value="php" checked>
                                        <label class="form-check-label" for="inlineRadio2">php (₱)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="item_markup_type"
                                            id="inlineRadio1" value="percent">
                                        <label class="form-check-label" for="inlineRadio1">percent (%)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="markup-model form-floating mb-3" id="item-markup-model">
                                <input type="text" class="form-control" placeholder=" " readonly>
                                <label for="category">Markup Value</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3" id="item-category-refresh">
                            <select class="form-select" id="item_category_id" name="item_category_id"
                                aria-label="Floating label select example">
                                <option selected value="0">Open this select menu</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            <label for="shop_type_id">Item Category</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="item_tag_id" name="item_tag_id"
                                aria-label="Floating label select example">
                                <option selected value="0">Open this select menu</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                @endforeach
                            </select>
                            <label for="shop_type_id">Item Tag</label>
                        </div>
                        <div class="input-group mb-3" id="error">
                            <label class="input-group-text">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="add-item-form" class="btn btn-primary"
                        id="add-item-submit-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-note-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="note-title">Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="note-body">Notes here</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toggle-shop-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="toggle-shop-modal-label">Publish Shop</h5>
                </div>
                <div class="modal-body">
                    <form id="toggle-shop-form" action="" method="POST">
                        @csrf
                        <input type="hidden" id="toggle_shop_info_id" name="shop_info_id" value="{{ $shop->id }}">
                        <input type="hidden" id="toggle_status" name="status" value="">
                        <span id="toggle-message"></span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="toggle-shop-form" class="btn btn-primary"
                        id="toggle-shop-form-btn">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toggle-item-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="toggle-item-modal-label"></h5>
                </div>
                <div class="modal-body">
                    <form id="toggle-item-form" action="" method="POST">
                        @csrf
                        <input type="hidden" id="toggle_item_info_id" name="item_id" value="">
                        <input type="hidden" id="toggle_status-item" name="status" value="">
                        <span id="toggle-message-item"></span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="toggle-item-form" class="btn btn-primary"
                        id="toggle-item-form-btn">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="item-view-modal" value="" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="content-header" class="d-flex justify-content-between">
                        {{-- TOGGLE SA MODAL --}}
                        <div id="header-btn" class="d-flex align-items-center">
                            <button id="add-item-combo-btn" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#add-item-combo-modal" data-bs-dismiss="modal">
                                <div class="d-flex align-items-center">
                                    Add Item Combo
                                </div>
                            </button>
                            <button id="add-item-combo-category-btn" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#add-item-category-combo-modal" data-bs-dismiss="modal">
                                <div class="d-flex align-items-center">
                                    Add Item Combo Category
                                </div>
                            </button>
                            <button id="add-item-combo-category-btn" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#add-item-variant-modal" data-bs-dismiss="modal">
                                <div class="d-flex align-items-center">
                                    Add Variant
                                </div>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-0 pt-0">
                        <div class="col-xl-7 col-md-12 d-flex justify-content-stretch">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="crop-profile me-4">
                                                    <img id="item-image" src="{{ asset('assets/images/Profile_Placeholder.png') }}">
                                                    <div class="middle-item-image">
                                                        <button value="" id="upload-item-image-btn" class="btn btn-primary" style="font-size: 13px">
                                                            upload photo
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-0">
                                                    <strong id="item-name-view">Sample</strong>
                                                </h4>
                                                <span class="badge rounded-pill text-capitalize px-3"
                                                    style="font-size: medium;">
                                                    <div id="item_status_name">Sample</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-7 mt-4">
                                                <div class="col-lg-8 col-md-6 d-flex flex-row">
                                                    <div class="d-flex justify-content-start me-5">
                                                        <div class="Icon">
                                                            <div
                                                                class="icon-background-1 d-flex icon-container h-100 w-100 align-items-center px-3 rounded">
                                                                <span class="icon-value-1 material-icons">
                                                                    people
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column ms-2">
                                                            <strong class="driver-left-title">Sales</strong>
                                                            <p class="driver-left-value mt-0">
                                                                0
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start">
                                                        <div class="Icon">
                                                            <div
                                                                class="icon-background-2 d-flex icon-container h-100 w-100 align-items-center px-3 rounded">
                                                                <span class="icon-value-2 material-icons">
                                                                    trending_up
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column ms-2">
                                                            <strong class="driver-left-title">Rating</strong>
                                                            <p class="driver-left-value mt-0">
                                                                0
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <span class="fw-bold">
                                                    ID:
                                                </span>
                                            </div>
                                            <div class="col-8 d-flex justify-content-end pe-5">
                                                <span class="text-muted" id="item-id-view">Sample id
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <span class="fw-bold">
                                                    Cost:
                                                </span>
                                            </div>
                                            <div class="col-8 d-flex justify-content-end pe-5">
                                                <span class="text-muted" id="item-cost-view">Sample
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <span class="fw-bold">
                                                    Markup:
                                                </span>
                                            </div>
                                            <div class="col-8 d-flex justify-content-end pe-5">
                                                <span class="text-muted text-capitalize" id="item-markup-view">Sample type
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <span class="fw-bold">
                                                    Total:
                                                </span>
                                            </div>
                                            <div class="col-8 d-flex justify-content-end pe-5">
                                                <span class="text-muted text-capitalize" id="item-total-view">Sample type
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <span class="fw-bold">
                                                    Category:
                                                </span>
                                            </div>
                                            <div class="col-8 d-flex justify-content-end pe-5">
                                                <span class="fw-boldtext-muted" id="item-category-view"> Item Code
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-md-12">
                            <div class="card-body pt-0">
                                <div class="accordion" id="item-combo-category">
                                    {{-- <div class="accordion-item">
                                        <h2 class="accordion-header" id="header-sample">
                                            <button class="accordion-button p-2" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#body-sample" aria-expanded="true"
                                                aria-controls="body-sample">
                                                <div id="acc-btn-sample" class="shop-type-header fs-6 text"
                                                    style="text-transform: capitalize">
                                                    Category
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="body-sample" class="accordion-collapse collapse show"
                                            aria-labelledby="header-sample">
                                            <div class="accordion-body">
                                                <div class="row" id="content-sample">
                                                    Sample
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-item-category-combo-modal" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Add New Category Combo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-combo-category-form" action="" method="POST">
                        @csrf
                        <input type="hidden" id="combo-category-id" name="item_id" value="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="combo_category" id="combo-category"
                                placeholder=" ">
                            <label for="category">Category</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="item-combo-category-isrequired" name="is_required"
                                aria-label="Floating label select example">
                                <option selected value="3">Open this select menu</option>
                                <option value="0">Optional</option>
                                <option value="1">Required</option>
                            </select>
                            <label for="shop_type_id">Combo Category Type</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="add-combo-category-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-item-variant-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Add New Item Variantss</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-item-variant-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="item_variant_id" name="item_id" value="">
                        {{-- <input type="hidden" id="item_id_belong" name="item_id_belong" value=""> --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="variant" id="item-variant-name"
                                placeholder=" ">
                            <label for="category">Variant Name</label>
                        </div>

                        <div class="markup-section">
                            <div class=" form-floating mb-3">
                                <input type="number" class="cost form-control" name="cost" id="item-variant-cost"
                                    placeholder=" ">
                                <label for="category">Cost</label>
                            </div>
                            <div class="form-floating">
                                <input type="number" class="markup form-control" name="markup"
                                    id="item-variant-markup" placeholder=" ">
                                <label for="category">Mark up</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="variant_markup_type"
                                            id="inlineRadio2" value="php" checked>
                                        <label class="form-check-label" for="inlineRadio2">php (₱)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="variant_markup_type"
                                            id="inlineRadio1" value="percent">
                                        <label class="form-check-label" for="inlineRadio1">percent (%)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="markup-model form-floating mb-3" id="item-variant-markup-model">
                                <input type="text" class="form-control" placeholder=" " readonly>
                                <label for="category">Markup Value</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="add-item-variant-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-item-combo-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Add New Item Combo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-item-combo-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="item_combo_item_id" name="item_id" value="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="combo" id="item-combo-name"
                                placeholder=" ">
                            <label for="category">Combo Name</label>
                        </div>

                        <div class="markup-section">
                            <div class="form-floating mb-3">
                                <input type="number" class="cost form-control" name="cost" id="item-combo-cost"
                                    placeholder=" ">
                                <label for="category">Cost</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="markup form-control" name="markup" id="item-combo-markup"
                                    placeholder=" ">
                                <label for="category">Mark up</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="combo_markup_type"
                                            id="inlineRadio2" value="php" checked>
                                        <label class="form-check-label" for="inlineRadio2">php (₱)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="combo_markup_type"
                                            id="inlineRadio1" value="percent">
                                        <label class="form-check-label" for="inlineRadio1">percent (%)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="markup-model form-floating mb-3" id="item-combo-markup-model">
                                <input type="text" class="form-control" placeholder=" " readonly>
                                <label for="category">Markup Value</label>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="item-combo-category-id" name="item_combo_category_id"
                                aria-label="Floating label select example">
                                <option selected value="0">Open this select menu</option>
                            </select>
                            <label for="shop_type_id">Item Combo Category</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="add-item-combo-form" id="add-item-combo-form-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-shophour-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Shop Hour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-shop-hour-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shop_info_id" value="{{ $shop->id }}">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="shop_days" name="shop_days"
                                aria-label="Floating label select example">
                                <option selected value="0">Open this select menu</option>
                                <option value="1">Everyday</option>
                                <option value="2">Weekdays</option>
                                <option value="3">Custom</option>
                            </select>
                            <label for="shop_type_id">Opening Days</label>
                        </div>
                        <div id="default-days">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="time" class="form-control" name="opening" id="opening"
                                            placeholder=" ">
                                        <label for="name">Opening hours</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="time" class="form-control" name="closing" id="closing"
                                            placeholder=" ">
                                        <label for="name">Closing hours</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="custom-days">
                            @foreach ($shop_day as $day)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" name="{{ $day->day }}_opening"
                                                id="{{ $day->day }}_opening" placeholder=" ">
                                            <label for="name">{{ substr($day->day, 0, 3) }} Opening hours</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" name="{{ $day->day }}_closing"
                                                id="{{ $day->day }}_closing" placeholder=" ">
                                            <label for="name">{{ substr($day->day, 0, 3) }} Closing hours</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="add-shophour-submit-btn" type="submit" form="add-shop-hour-form" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-item-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-item-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="item_id" id="edit-item-id" value="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="edit-item-name" placeholder=" ">
                            <label for="category">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="cost form-control" name="cost" id="edit-item-cost"
                                placeholder=" ">
                            <label for="category">Cost</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="markup form-control" name="markup" id="edit-item-markup"
                                placeholder=" ">
                            <label for="category">Mark up</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="edit-item-form" class="btn btn-primary" id="edit-item-form-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-item-modal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="delete-item-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="item_id" id="delete-item-id" value="">
                        <span id="delete-item-text">are you sure you want to delete this item?</span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="delete-item-form" class="btn btn-primary" id="delete-item-form-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-item-combo-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Add Item Combo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-item-combo-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit-item-combo-id" name="item_combo_id" value="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="combo" id="edit-item-combo-name"
                                placeholder=" " value="">
                            <label for="category">Combo Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="cost" id="edit-item-combo-cost"
                                placeholder=" " value="">
                            <label for="category">Cost</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="markup" id="edit-item-combo-markup"
                                placeholder=" " value="">
                            <label for="category">Mark up</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-item-combo-btn" form="edit-item-combo-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-item-combo-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Delete Item Combo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="delete-item-combo-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="delete-item-combo-id" name="item_combo_id" value="">
                        <span id="delete-item-combo-text">are you sure you want to delete this item combo</span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-item-combo-btn" form="delete-item-combo-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-item-variant-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Edit Item Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-item-variant-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="item_variant_id" id="edit-item-variant-id">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="variant" id="edit-item-variant-variant"
                                placeholder=" " value="">
                            <label for="edit-item-variant-name">Variant Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="cost" id="edit-item-variant-cost"
                                placeholder=" " value="">
                            <label for="edit-item-variant-cost">Cost</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="markup" id="edit-item-variant-markup"
                                placeholder=" " value="">
                            <label for="edit-item-variant-markup">Mark up</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-item-variant-btn" form="edit-item-variant-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-item-variant-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Delete Item Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="delete-item-variant-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="delete-item-variant-id" name="item_variant_id" value="">
                        <span id="delete-item-variant-text">are you sure you want to delete this item variant</span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="delete-item-variant-btn" form="delete-item-variant-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-shop-image-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Edit Shop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-shop-image-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shop_info_id" value="{{ $shop->id }}">
                        <img class="edit-shop-image-preview img-fluid" src="{{ asset('storage/shop_image/' . $shop->image) }}">
                        <div class="input-group mt-3" id="error">
                            <input type="file" class="form-control" id="edit_shop_image" name="image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-shop-image-form-btn" form="edit-shop-image-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-item-image-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Edit Item Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-item-image-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit-item-image-id" name="item_id" value="">
                        <img class="edit-item-image-preview img-fluid" src="">
                        <div class="input-group mt-3" id="error">
                            <input type="file" class="form-control" id="edit_item_image" name="image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-item-image-form-btn" form="edit-item-image-form">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div id="content">
        @include('include.operator_navbar')
        <div class="main-content">
            <div class="row mt-3">
                <div class="content-header d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="header-title border-end pe-3">TOP UP</span>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <a class="d-flex align-items-center" href="{{ route('operator.index') }}">
                                    <span id="click-link" class="material-icons ps-2">home</span>
                                </a>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Shop</span>
                            </small>
                            <span class="material-icons">navigate_next</span>
                        </div>
                        @switch($type)
                            @case('publish')
                                <div class="d-flex align-items-center home-logo">
                                    <small>
                                        <a href="{{ route('operator.shop', ['publish', 'view' => 'grid']) }}">
                                            <span id="click-link">Published</span>
                                        </a>
                                    </small>
                                    <span class="material-icons">navigate_next</span>
                                </div>
                            @break

                            @case('pending')
                                <div class="d-flex align-items-center home-logo">
                                    <small>
                                        <a href="{{ route('operator.shop', ['pending', 'view' => 'grid']) }}">
                                            <span id="click-link">Pending</span>
                                        </a>
                                    </small>
                                    <span class="material-icons">navigate_next</span>
                                </div>
                            @break

                            @case('my')
                                <div class="d-flex align-items-center home-logo">
                                    <small>
                                        <a href="{{ route('operator.shop', ['my', 'view' => 'grid']) }}">
                                            <span id="click-link">My Shops</span>
                                        </a>
                                    </small>
                                    <span class="material-icons">navigate_next</span>
                                </div>
                            @break

                            @default
                        @endswitch


                        <div class="d-flex align-items-center home-logo">
                            <small>
                                <span>Shop info</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if ($shop->shop_status_id <= 2 || $shop->shop_status_id == 5)
                            <button id="submit-btn" class="btn btn-primary me-2"
                                @if ($shop->shopHour->isEmpty() || $shop->itemCategories->isEmpty() || $shop->items->isEmpty() || $shop->shop_status_id == 2) disabled @endif>
                                @if ($shop->shop_status_id == 2)
                                    Pending
                                @elseif ($shop->shop_status_id == 1 || $shop->shop_status_id == 5)
                                    Submit
                                @endif
                            </button>
                        @elseif ($shop->shop_status_id == 3 || $shop->shop_status_id == 4)
                            <div class="form-check form-switch mx-3">
                                <input type="checkbox" class="form-check-input toggler" id="headerToggle" checked>
                            </div>
                            {{-- toggle switch here --}}
                        @endif

                        @if ($shop->user_id == auth()->user()->id)
                            <button id="add-item-btn" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#add-item-modal" @if ($shop->itemCategories->isEmpty()) disabled @endif>
                                <div class="d-flex align-items-center">
                                    Add new item
                                </div>
                            </button>

                            <button id="add-category-btn" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#add-category-modal" @if ($shop->shopHour->isEmpty()) disabled @endif>
                                <div class="d-flex align-items-center">
                                    Add new category
                                </div>
                            </button>
                        @else
                            <button id="add-category-btn" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#add-item-modal" @if ($shop->itemCategories->isEmpty()) disabled @endif>
                                <div class="d-flex align-items-center">
                                    Add note
                                </div>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card p-3" id="main-profile">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <!-- left COlumn profile -->
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="crop-profile me-4">
                                            @if ($shop->image != null)
                                                <img id="shop-image" src="{{ asset('storage/shop_image/' . $shop->image) }}">
                                                <div class="middle-shop-image">
                                                    <button id="upload-shop-image-btn" class="btn btn-primary btn-sm" style="font-size: 13px;">upload photo</button>
                                                </div>
                                            @else
                                                <img id="shop-image" src="{{ asset('assets/images/Profile_Placeholder.png') }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-0">
                                            <strong class="driver-name">
                                                {{ $shop->name }}
                                            </strong>
                                        </h4>
                                        <span class="badge rounded-pill text-capitalize px-3" style="font-size: medium;"
                                            id="shop_status">
                                            <div id="shop-status-refresh">{{ $shop->shopStatus->status }}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mt-4">
                                        <div class="col-lg-8 col-md-6 d-flex flex-row">
                                            <div class="d-flex justify-content-start me-5">
                                                <div class="Icon">
                                                    <div
                                                        class="icon-background-1 d-flex icon-container h-100 w-100 align-items-center px-3 rounded">
                                                        <span class="icon-value-1 material-icons">
                                                            people
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <strong class="driver-left-title">Sales</strong>
                                                    <p class="driver-left-value mt-0">
                                                        0
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start">
                                                <div class="Icon">
                                                    <div
                                                        class="icon-background-2 d-flex icon-container h-100 w-100 align-items-center px-3 rounded">
                                                        <span class="icon-value-2 material-icons">
                                                            trending_up
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <strong class="driver-left-title">Rating</strong>
                                                    <p class="driver-left-value mt-0">
                                                        0
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <span class="fw-bold">
                                            shop id:
                                        </span>
                                    </div>
                                    <div class="col-8 d-flex justify-content-end pe-5">
                                        <span class="text-muted">
                                            {{ $shop->id }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <span class="fw-bold">
                                            Type:
                                        </span>
                                    </div>
                                    <div class="col-8 d-flex justify-content-end pe-5">
                                        <span class="text-muted text-capitalize">
                                            {{ $shop->shopType->type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <span class="fw-bold">
                                            Code:
                                        </span>
                                    </div>
                                    <div class="col-8 d-flex justify-content-end pe-5">
                                        <span class="fw-boldtext-muted">
                                            {{ $shop->shop_code }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <span class="fw-bold">
                                            Managed by:
                                        </span>
                                    </div>
                                    <div class="col-8 d-flex justify-content-end pe-5">
                                        <span class="text-muted">
                                            {{ $shop->user->email }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <span class="fw-bold text-capitalize">
                                            Pin Address:
                                        </span>
                                    </div>
                                    <div class="col-8 d-flex justify-content-end pe-5">
                                        <span class="text-muted text-end">
                                            {{ $shop->address }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" id="shop-hour-div">
                                @if ($shop->shopHour->isNotEmpty())
                                    @foreach ($shop->shopHour as $shop_hour)
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <span class="fw-bold text-capitalize">
                                                    {{ $shop_hour->weekday }}:
                                                </span>
                                            </div>
                                            <div class="col-8 d-flex justify-content-end pe-5">
                                                <span class="text-muted text-capitalize ">
                                                    {{ date('h:i A', strtotime($shop_hour->opening)) }}
                                                    -
                                                    {{ date('h:i A', strtotime($shop_hour->closing)) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div id="alert-shop-hour" class="alert alert-danger m-0" role="alert">
                                        This shop doesn't have shop hours. Please add <button class="btn btn-primary"
                                            data-bs-target="#add-shophour-modal" data-bs-toggle="modal"
                                            data-bs-dismiss="modal">Add
                                            Shop Hour</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if ($shop->shopNotes->isNotEmpty() && $shop->shopStatus->id == 5)
                    <div class="col-xl-6 col-lg-8 col-md-12 d-flex justify-content-stretch">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-title d-flex justify-content-between">
                                    <strong>Notes</strong>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="container overflow-scroll px-2" style="max-height: 250px" id="scrollbar">
                                    <div class="streamline">
                                        @foreach ($shop->shopNotes->sortDesc()->take(10) as $note)
                                            <div class="sl-item sl-primary">
                                                <div class="sl-content">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <small class="text-muted">
                                                            {{ date('F d, Y', strtotime($note->created_at)) }}
                                                        </small>
                                                        <small class="text-muted">
                                                            {{ date('H:i', strtotime($note->created_at)) }}
                                                        </small>
                                                    </div>

                                                    <div class="d-flex justify-content-between mb-1">
                                                        <p class="mt-0">
                                                            {{ $note->title }}
                                                        </p>
                                                        <button value="{{ $note->id }}"
                                                            class="note-btn btn btn-primary btn-sm stretched-link">view
                                                            more</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <div class="col-xl-6 col-lg-8 col-md-12 d-flex justify-content-stretch">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title d-flex justify-content-between">
                                <strong>History Logs</strong>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="container overflow-scroll px-2" style="max-height: 350px" id="scrollbar">
                                <div class="streamline">
                                    <div class="sl-item sl-primary">
                                        <div class="sl-content">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">Sample
                                                </small>
                                                <small class="text-muted">Sample
                                                </small>
                                            </div>
                                            <p class="mt-0" style="text-transform: none">
                                                Sample</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-primary">
                                        <div class="sl-content">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">Sample
                                                </small>
                                                <small class="text-muted">Sample
                                                </small>
                                            </div>
                                            <p class="mt-0" style="text-transform: none">
                                                Sample</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-primary">
                                        <div class="sl-content">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">Sample
                                                </small>
                                                <small class="text-muted">Sample
                                                </small>
                                            </div>
                                            <p class="mt-0" style="text-transform: none">
                                                Sample</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            @if ($categories->isEmpty())
                <div class="row mt-3" id="alert-header">
                    <div class="col-lg-12">
                        <div class="alert alert-danger m-0" role="alert">
                            <span>
                                Shop category is empty. Please add a new category.
                            </span>
                        </div>
                    </div>
                </div>
            @elseif ($categories->isNotEmpty() && $items->isEmpty())
                <div class="row mt-3" id="alert-header">
                    <div class="col-lg-12">
                        <div class="alert alert-danger m-0" role="alert">
                            <span>
                                Shop Items is empty. Please add a new Items.
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mt-3">
                <div class="accordion" id="item-category-accordion">
                    @foreach ($categories as $category)
                        <div class="accordion-item">
                            <div class="accordion-header" id="header-{{ $category->id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#body-{{ $category->id }}" aria-expanded="true"
                                    aria-controls="body-{{ $category->id }}">
                                    <div id="acc-btn-{{ $category->id }}" class="shop-type-header"
                                        style="text-transform: capitalize">{{ $category->category }}
                                    </div>
                                </button>
                            </div>
                            <div class="accordion-collapse collapse show" aria-labelledby="header-{{ $category->id }}"
                                id="body-{{ $category->id }}">
                                <div class="accordion-body">
                                    <div class="row" id="content-{{ $category->id }}">
                                        @if ($category->items->isNotEmpty())
                                            @foreach ($category->items->sortByDesc('id') as $item)
                                                <div class="col-lg-2 col-md-3 col-sm-5 col-xs-6" id="item-id-{{ $item->id }}" >
                                                    <div class="card">
                                                        <div class="position-relative">
                                                            <img id="item-image-{{ $item->id }}" src="{{ asset('storage/item_image/' . $item->image) }}"
                                                                class="img-fluid rounded-top"
                                                                style="height: 200px; width: 100%;">
                                                            <div class="position-absolute top-0 start-0 p-2">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-sm dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#FFFFFF;">
                                                                        <i class="sub-icon material-icons">arrow_drop_down</i>
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                        <li><a class="edit-item-btn dropdown-item d-down" value="{{ $item->id }}">Edit</a></li>
                                                                        <li><a class="delete-item-btn dropdown-item d-down" value="{{ $item->id }}">Delete</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            @if ($item->status == 1)
                                                                <div
                                                                    class="form-check form-switch position-absolute top-0 end-0 p-2">
                                                                    <input class="form-check-input toggler"
                                                                        type="checkbox" id="flexSwitchCheckChecked"
                                                                        checked="checked" value="{{ $item->id }}">
                                                                </div>
                                                                <div
                                                                    class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                                    <span id="status-badge"
                                                                        class="badge rounded-pill text-capitalize p-2"
                                                                        style="background-color: rgb(25, 135, 84); font-size: 13px;">Active</span>
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="form-check form-switch position-absolute top-0 end-0 p-2">
                                                                    <input class="form-check-input toggler"
                                                                        type="checkbox" id="flexSwitchCheckChecked"
                                                                        value="{{ $item->id }}">
                                                                </div>
                                                                <div
                                                                    class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                                    <span id="status-badge"
                                                                        class="badge bg-danger rounded-pill text-capitalize p-2"
                                                                        style="background-color: #dc3545; font-size: 13px;">Inactive</span>
                                                                </div>
                                                            @endif

                                                        </div>
                                                        <div class="card-body">
                                                            <div class="card-title">
                                                                <div>
                                                                    <h5 id="item-name" class="align-items-center mb-0"
                                                                        style="font-weight: 500;">
                                                                        {{ $item->name }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div class="card-text">
                                                                <div class="d-flex align-items-center">
                                                                    <small id="item-total" class="text-truncate">
                                                                        ₱{{ number_format( $item->cost + $item->markup , 2) }}
                                                                    </small>
                                                                </div>
                                                                {{-- <div class="d-flex align-items-center">
                                                                    <small>
                                                                        Number of Sales:
                                                                    </small>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="çard-footer p-3">
                                                            <button class="view-more-btn btn btn-primary"
                                                                id="item-card-btn-{{ $item->id }}"
                                                                value="{{ $item->id }}">
                                                                View More
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="empty-item-{{ $category->id }}">Shop List Empty...</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let shop = @json($shop, JSON_PRETTY_PRINT);
        let shop_status_id = shop.shop_status_id;
        let markup_section = [];
        let item_combo_category;

        $(document).ready(function() {
            switch (shop_status_id) {
                case 1:
                    $('#shop_status').css("background-color", "#6C757D");
                    break;
                case 2:
                    $('#shop_status').css("background-color", "#FFC107");
                    break;
                case 3:
                    $('#shop_status').css("background-color", "#198754");
                    break;
                case 4:
                    $('#shop_status').css("background-color", "#DC3545");
                    break;
                case 5:
                    $('#shop_status').css("background-color", "#DC3545");
                    break;

                default:
                    break;
            }

            function formatToCurrency(amount) {
                value = parseFloat(amount);
                return "₱" + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
            }

            $('.markup-section').each(function() {
                let model = $(this).find('.markup-model').attr('id');
                let markup_type = $(this).find('.form-check-input').attr('name');
                let cost = $(this).find('input.cost').attr('id');
                let markup = $(this).find('input.markup').attr('id');
                obj = {
                        markup_type: markup_type,
                        model: model,
                        cost: cost,
                        markup: markup
                    },
                    markup_section.push(obj);
            });

            markup_section.forEach(element => {
                markUpModel(element.markup_type, element.model, element.cost, element.markup)
            });

            function markUpModel(markup_type, model, cost, markup) {
                $("input[name=" + markup_type + "]:radio").click(function() {
                    if ($("input[name=" + markup_type + "]:checked").val() == "percent") {
                        $("#" + model).fadeIn('fast');
                        if ($("#" + markup).val().length != 0 && $("#" + cost).val().length != 0) {
                            $("#" + model).children('input').val(formatToCurrency($("#" + cost).val() * $(
                                "#" + markup).val() / 100));
                        } else {
                            $("#" + model).children('input').val(formatToCurrency(0));
                        }
                    } else if ($("input[name=" + markup_type + "]:checked").val() == "php") {
                        $("#" + model).fadeOut('fast', function() {
                            $("#" + model).children('input').val(formatToCurrency(0));
                        });
                    }
                });

                $("#" + markup).on('change', function() {
                    if ($("input[name=" + markup_type + "]:checked").val() == "percent") {
                        if ($("#" + markup).val().length != 0 && $("#" + cost).val().length != 0 && $("#" +
                                markup).val() != 0) {
                            $("#" + model).children('input').val(formatToCurrency($("#" + cost).val() * $(
                                "#" + markup).val() / 100));
                        } else {
                            $("#" + model).children('input').val(formatToCurrency(0));
                        }
                    }
                });

                $("#" + cost).on('change', function() {
                    if ($("input[name=" + markup_type + "]:checked").val() == "percent") {
                        if ($("#" + markup).val().length != 0 && $("#" + cost).val().length != 0 && $("#" +
                                markup).val() != 0) {
                            $("#" + model).children('input').val(formatToCurrency($("#" + cost).val() * $(
                                "#" + markup).val() / 100));
                        } else {
                            $("#" + model).children('input').val(formatToCurrency(0));
                        }
                    }
                });
            }

            function shopComboCategory(content, category) {
                if (category.is_required == 0) {
                    is_required = 'Optional';
                } else {
                    is_required = 'Required';
                }

                combo_category = `<div class="accordion-item">
                        <h6 class="accordion-header" id="header-combo-${ category.id }">
                            <button class="accordion-button pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#body-combo-${ category.id }" aria-expanded="true" aria-controls="body-combo-${ category.id }">
                                <div id="acc-btn-combo-${ category.id }" class="shop-type-header" style="text-transform: capitalize;">
                                    ${ category.category }  (${ is_required })
                                </div>
                            </button>
                        </h6>
                    <div class="accordion-collapse collapse show" aria-labelledby="header-combo-${ category.id }" id="body-combo-${ category.id }">
                        <div class="accordion-body">
                            <div class="row" id="content-combo-${ category.id }">
                            </div>
                        </div>
                    </div>`
                content.prepend(combo_category);

                if (category.item_combo.length != 0) {
                    $.each(category.item_combo, function(key, item) {
                        let item_combo_cost = parseInt(item.cost) + parseInt(item.markup);
                        item_combo = `
                            <div class="d-flex justify-content-between align-items-center">
                                <li>${ formatToCurrency(item_combo_cost) } - ${ item.combo }</li>
                                <div>
                                    <button class="btn edit-item-combo-btn material-icons py-0 px-1 text-primary" value="${ item.id }">
                                        edit
                                    </button>
                                    <button class="btn delete-item-combo-btn material-icons py-0 px-1 text-primary" value="${ item.id }">
                                        delete
                                    </button>
                                </div>
                            </div>
                        `
                        $('#content-combo-' + item.item_combo_category_id).prepend(item_combo);
                    });
                } else {
                    combo_category_empty = `<div class="empty-item-combo-${ category.id }">Item combo list empty...</div>`
                    $('#content-combo-' + category.id).prepend(combo_category_empty);
                }

                editItemComboBtn();
                deleteItemComboBtn();
            }

            function shopVariant(content, variant) {
                let variant_sum = parseInt(variant.cost) + parseInt(variant.markup);

                variant_div = `
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="header-variant">
                            <button class="accordion-button pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#body-variant" aria-expanded="true" aria-controls="body-variant">
                                <div id="acc-btn-variant" class="shop-type-header" style="text-transform: capitalize;">
                                    variants
                                </div>
                            </button>
                        </h6>
                        <div class="accordion-collapse collapse show" aria-labelledby="header-combo-variant" id="body-variant">
                            <div class="accordion-body">
                                <div class="row" id="content-variant-category">
                                </div>
                            </div>
                        </div>
                    </div>
                `
                content.prepend(variant_div);

                variant.forEach(variant => {
                    item_variant_sum = parseInt(variant.cost) + parseInt(variant.markup);
                    item_variant = `
                        <div class="d-flex justify-content-between align-items-center">
                            <li>${ formatToCurrency(item_variant_sum) } - ${ variant.variant }</li>
                            <div>
                                <button class="btn edit-item-variant-btn material-icons py-0 px-1 text-primary" value="${ variant.id }">edit</button>
                                <button class="btn delete-item-variant-btn material-icons py-0 px-1 text-primary" value="${ variant.id }">delete</button>
                            </div>
                        </div>
                    `
                    $('#content-variant-category').prepend(item_variant);
                });

                editItemVariantBtn();
                deleteItemVariantBtn();
            }

            function itemInfo(item_id) {
                item_info_url = "{{ route('operator.shopInfoItemInfoFetch', ':id') }}";
                item_info_url = item_info_url.replace(':id', item_id);

                $.ajax({
                    url: item_info_url,
                    method: "GET",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        uploaded_img = "{{ asset('storage/item_image/:img') }}";
                        uploaded_img = uploaded_img.replace(':img', response.item.image);

                        $('#item_variant_id').val(response.item.id);
                        $('#item-id-view').text(response.item.id);
                        $('#item-name-view').text(response.item.name);
                        $('#item-cost-view').text(formatToCurrency(response.item.cost));
                        $("#item-markup-view").text(formatToCurrency(response.item.markup));
                        $("#item-total-view").text(formatToCurrency(response.item.cost +
                            response.item.markup));
                        $('#item-category-view').text(response.item.item_category.category);
                        $('#combo-category-id').val(response.item.id);
                        $('#item_combo_item_id').val(response.item.id);
                        $('#item-image').attr('src', uploaded_img);
                        $('#upload-item-image-btn').attr('value', response.item.id);

                        if (response.item.status == 1) {
                            $('#item_status_name').text('active').parent().css(
                                'background-color',
                                '#198754');
                        } else {
                            $('#item_status_name').text('inactive').parent().css(
                                'background-color',
                                '#DC3545');
                        }

                        item_combo_category = response.item.item_combo_categories;

                        if (response.item.item_combo_categories.length == 0) {
                            accordion_item = $(document.createElement('div'))
                                .addClass('alert alert-danger')
                                .text('This item dont have Categories')
                                .prependTo($('#item-combo-category'));
                            $('#add-item-combo-btn').attr('disabled', true);
                        } else {
                            $.each(response.item.item_combo_categories, function(key,
                                combo_category) {
                                shopComboCategory($('#item-combo-category'),
                                    combo_category);
                                $('#add-item-combo-btn').attr('disabled', false);
                            });
                        }

                        if (response.item.item_variants.length != 0) {
                            shopVariant($('#item-combo-category'), response.item
                                .item_variants)
                        }

                        $('#item-view-modal').modal('toggle');
                    },
                    error: function(response) {
                        alert('oops something went wrong');
                    }
                });
            }

            function viewMoreBtn() {
                $('.view-more-btn').off('click').click(function() {
                    item_id = $(this).attr('value');
                    itemInfo(item_id);
                })
            }

            function itemSwitch() {
                $('input.toggler').off('click').on('click', function() {
                    thisToggle = $(this);
                    status = $(this).prop('checked') == true ? 1 : 0;
                    let i_url = "{{ route('operator.shopInfoItemToggleFetchItem', ':id') }}";
                    i_url = i_url.replace(':id', thisToggle.val());
                    thisToggle.prop('disabled', true);
                    $.ajax({
                        url: i_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#toggle-item-modal').modal('toggle');
                            $('#toggle_item_info_id').val(response.item.id);
                            $('#toggle_status-item').val(status);
                            if (status == 1) {
                                $('#toggle-item-modal-label').text('Publish Shop');
                                $('#toggle-item-modal').on('hidden.bs.modal', function() {
                                    thisToggle.prop("checked", false);
                                    thisToggle.prop('disabled', false);
                                });
                                $('#toggle-message-item').text(response.item.name +
                                    ' will be published. Proceed?');
                            } else if (status == 0) {
                                $('#toggle-item-modal-label').text('Deactivate Shop');
                                $('#toggle-item-modal').on('hidden.bs.modal', function() {
                                    thisToggle.prop("checked", true);
                                    thisToggle.prop('disabled', false);
                                });
                                $('#toggle-message-item').text(response.item.name +
                                    ' will be inactive. Proceed?');
                            }
                        },
                        error: function(response) {
                            alert('Oops something went wrong');
                        }
                    });
                });
            }

            function editItemButton() {
                $('.edit-item-btn').on('click', function() {
                    item_fetch_url = "{{ route('operator.shopInfoEditItemFetch', ':shop_info_id') }}";
                    item_fetch_url = item_fetch_url.replace(':shop_info_id', $(this).attr('value'));
                    $.ajax({
                        url: item_fetch_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#edit-item-name').val(response.item.name);
                            $('#edit-item-cost').val(response.item.cost);
                            $('#edit-item-markup').val(response.item.markup);
                            $('#edit-item-id').val(response.item.id);
                            $('#edit-item-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });

            }

            function deleteItemButton() {
                $('.delete-item-btn').off('click').on('click', function() {
                    item_fetch_url = "{{ route('operator.shopInfoEditItemFetch', ':shop_info_id') }}";
                    item_fetch_url = item_fetch_url.replace(':shop_info_id', $(this).attr('value'));
                    $.ajax({
                        url: item_fetch_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#delete-item-id').val(response.item.id);
                            item = `<strong class="text-capitalize">${response.item.name}</strong>`
                            $('#delete-item-text').html('are you sure you want to delete ' + item + '?');
                            $('#delete-item-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            function editItemComboBtn() {
                $('.edit-item-combo-btn').off('click').on('click', function() {
                    $(this).attr('disabled', true);
                    var item_combo_fetch_url = "{{ route('operator.shopInfoEditItemComboFetch', ':item_combo_id') }}";
                    item_combo_fetch_url = item_combo_fetch_url.replace(':item_combo_id', $(this).attr('value'));
                    $.ajax({
                        url: item_combo_fetch_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#edit-item-combo-name').val(response.item_combo.combo);
                            $('#edit-item-combo-cost').val(response.item_combo.cost);
                            $('#edit-item-combo-markup').val(response.item_combo.markup);
                            $('#edit-item-combo-id').val(response.item_combo.id);
                            $('#edit-item-combo-modal').modal('toggle');
                            $('#item-view-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            function deleteItemComboBtn() {
                $('.delete-item-combo-btn').off('click').on('click', function () {
                    $(this).attr('disabled', true);
                    var item_combo_fetch_url = "{{ route('operator.shopInfoEditItemComboFetch', ':item_combo_id') }}";
                    item_combo_fetch_url = item_combo_fetch_url.replace(':item_combo_id', $(this).attr('value'));
                    $.ajax({
                        url: item_combo_fetch_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#delete-item-combo-id').val(response.item_combo.id);
                            item_combo = `<strong class="text-capitalize">${response.item_combo.combo}</strong>`
                            $('#delete-item-combo-text').html('are you sure you want to delete ' + item_combo + '?');
                            $('#delete-item-combo-modal').modal('toggle');
                            $('#item-view-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            function editItemVariantBtn() {
                $('.edit-item-variant-btn').off('click').on('click', function() {
                    $(this).attr('disabled', true);
                    item_variant_fetch_url = "{{ route('operator.shopInfoEditItemVariantFetch', ':item_combo_id') }}";
                    item_variant_fetch_url = item_variant_fetch_url.replace(':item_combo_id', $(this).attr('value'));
                    $.ajax({
                        url: item_variant_fetch_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#edit-item-variant-variant').val(response.item_variant.variant);
                            $('#edit-item-variant-cost').val(response.item_variant.cost);
                            $('#edit-item-variant-markup').val(response.item_variant.markup);
                            $('#edit-item-variant-id').val(response.item_variant.id);
                            $('#edit-item-variant-modal').modal('toggle');
                            $('#item-view-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            function deleteItemVariantBtn() {
                $('.delete-item-variant-btn').off('click').on('click', function () {
                    $(this).attr('disabled', true);
                    item_variant_fetch_url = "{{ route('operator.shopInfoEditItemVariantFetch', ':item_combo_id') }}";
                    item_variant_fetch_url = item_variant_fetch_url.replace(':item_combo_id', $(this).attr('value'));
                    $.ajax({
                        url: item_variant_fetch_url,
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(response) {
                            $('#delete-item-variant-id').val(response.item_variant.id);
                            item_variant = `<strong class="text-capitalize">${response.item_variant.variant}</strong>`
                            $('#delete-item-variant-text').html('are you sure you want to delete ' + item_variant + '?');
                            $('#delete-item-variant-modal').modal('toggle');
                            $('#item-view-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                });
            }

            itemSwitch();
            viewMoreBtn();
            editItemButton();
            deleteItemButton();

            $.validator.addMethod("notEqual", function(value, element, param) {
                return this.optional(element) || value != param;
            }, "This field is required.");

            $('#item-view-modal').on('hidden.bs.modal', function() {
                $('#item-combo-category').children().detach();
            });

            $('#add-item-combo-modal').on('hidden.bs.modal', function() {
                $('#item-combo-category-id').children().not(':first').detach();
            });

            $('#add-item-combo-modal').on('show.bs.modal', function() {
                $.each(item_combo_category, function(key, combo_category) {
                    $(document.createElement('option'))
                        .attr('value', combo_category.id)
                        .text(combo_category.category)
                        .appendTo('#item-combo-category-id');
                });
            });

            $('#submit-btn').off('click').on('click', function() {
                submit_btn = $(this);
                submit_btn.attr('disabled', true).text('Processing');
                $.ajax({
                    url: "{{ route('operator.submitShopApproval', $shop->id) }}",
                    method: "GET",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    complete: function() {
                        submit_btn.text('Pending approval');
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: response.icon,
                            title: response.title,
                            text: response.text,
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        $('#shop-status-refresh').text('Pending approval').parent().css(
                            'background-color', '#FFC107')
                    },
                    error: function(response) {
                        alert('Oops something went wrong');
                    }
                });
            });

            $('.note-btn').on('click', function() {
                note_id = $(this).val();
                var note_url = "{{ route('operator.shopInfoNoteFetch', ':id') }}";
                note_url = note_url.replace(':id', note_id);
                $.ajax({
                    url: note_url,
                    method: "GET",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        $('#note-title').text(response.title);
                        $('#note-body').text(response.note);
                        $('#view-note-modal').modal('toggle');
                    },
                    error: function(response) {
                        alert(
                            'Oops something went wrong'
                        );
                    }
                });
                $('#view-note-modal').modal('toggle');
            });

            $('#headerToggle').off('click').on('click', function() {
                status = $(this).prop('checked') == true ? 3 : 4;
                $('#toggle-shop-modal').modal('toggle');
                $('#toggle_status').val(status);
                if (status == 3) {
                    $('#toggle-shop-modal-label').text('Publish Shop')
                    $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                        $('#headerToggle').prop("checked", false);
                    });
                    $('#toggle-message').text(shop.name + ' will be published. Proceed?');
                } else if (status == 4) {
                    $('#toggle-shop-modal-label').text('Deactivate Shop');
                    $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                        $('#headerToggle').prop("checked", true);
                    });
                    $('#toggle-message').text(shop.name + ' will be inactive. Proceed?');
                }
            });

            $('#upload-shop-image-btn').on('click', function(){
                $('#edit-shop-image-modal').modal('toggle');
            });

            $('#upload-item-image-btn').on('click', function(){
                item_fetch_url = "{{ route('operator.shopInfoEditItemFetch', ':shop_info_id') }}";
                item_fetch_url = item_fetch_url.replace(':shop_info_id', $(this).attr('value'));
                $.ajax({
                    url: item_fetch_url,
                    method: "GET",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        item_image = "{{ asset('storage/item_image/:img') }}";
                        item_image = item_image.replace(':img', response.item.image);
                        $('#edit-item-image-modal').modal('toggle');
                        $('.edit-item-image-preview').attr('src', item_image);
                        $('#edit-item-image-id').val(response.item.id);
                        $('#item-view-modal').modal('toggle');
                    },
                    error: function(response) {
                        alert('oops something went wrong');
                    }
                });
            });

            $("#shop_days").on('change', function() {
                if (this.value == 3) {
                    $("#default-days").fadeOut('fast', function () {
                        $("#custom-days").fadeIn('fast');
                    });
                } else {
                    $("#custom-days").fadeOut('fast', function () {
                        $("#default-days").fadeIn('fast');
                    });
                }
            });

            $('#edit_shop_image').on('change', function () {
                const file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(event){
                    $('.edit-shop-image-preview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            });

            $('#edit_item_image').on('change', function () {
                const file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(event){
                    $('.edit-item-image-preview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            });

            $('#add-item-form').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    cost: {
                        required: true,
                        number: true
                    },
                    markup: {
                        required: true,
                        number: true
                    },
                    item_category_id: {
                        notEqual: 0
                    },
                    image: {
                        required: true
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#add-item-submit-btn').attr('disabled', true).text('Processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoAddItem') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#add-item-submit-btn').attr('disabled', false)
                                .text('Submit');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $("#add-item-modal").modal('toggle');
                            $('#add-item-form').trigger('reset');

                            if ( $('.empty-item-' + response.item.item_category_id).length ) {
                                $('.empty-item-' + response.item.item_category_id).fadeOut(function () {
                                    $(this).detach();
                                })
                            }

                            new_item_image = "{{ asset('storage/item_image/' . ':image') }}"
                            new_item_image = new_item_image.replace(':image', response.item.image);
                            item_cost = parseFloat(response.item.cost) + parseFloat(response.item.cost)
                            new_shop = `
                                <div class="col-lg-2 col-md-3 col-sm-5 col-xs-6" id="item-id-${ response.item.id }" >
                                    <div class="card">
                                        <div class="position-relative">
                                            <img id="item-image-${ response.item.id }" src="${ new_item_image }"
                                                class="img-fluid rounded-top"
                                                style="height: 200px; width: 100%;">
                                            <div class="position-absolute top-0 start-0 p-2">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#FFFFFF;">
                                                        <i class="sub-icon material-icons">arrow_drop_down</i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li><a class="edit-item-btn dropdown-item d-down" value="${ response.item.id }">Edit</a></li>
                                                        <li><a class="delete-item-btn dropdown-item d-down" value="${ response.item.id }">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @if (1 == 1)
                                                <div
                                                    class="form-check form-switch position-absolute top-0 end-0 p-2">
                                                    <input class="form-check-input toggler"
                                                        type="checkbox" id="flexSwitchCheckChecked"
                                                        checked="checked" value="${ response.item.id }">
                                                </div>
                                                <div
                                                    class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                    <span id="status-badge"
                                                        class="badge rounded-pill text-capitalize p-2"
                                                        style="background-color: rgb(25, 135, 84); font-size: 13px;">Active</span>
                                                </div>
                                            @else
                                                <div
                                                    class="form-check form-switch position-absolute top-0 end-0 p-2">
                                                    <input class="form-check-input toggler"
                                                        type="checkbox" id="flexSwitchCheckChecked"
                                                        value="${ response.item.id }">
                                                </div>
                                                <div
                                                    class="d-flex align-items-center position-absolute bottom-0 end-0 p-2">
                                                    <span id="status-badge"
                                                        class="badge bg-danger rounded-pill text-capitalize p-2"
                                                        style="background-color: #dc3545; font-size: 13px;">Inactive</span>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="card-body">
                                            <div class="card-title">
                                                <div>
                                                    <h5 id="item-name" class="align-items-center mb-0"
                                                        style="font-weight: 500;">
                                                        ${ response.item.name }
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="card-text">
                                                <div class="d-flex align-items-center">
                                                    <small id="item-total" class="text-truncate">
                                                        ${ formatToCurrency(item_cost) }
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="çard-footer p-3">
                                            <button class="view-more-btn btn btn-primary"
                                                id="item-card-btn-${ response.item.id }"
                                                value="${ response.item.id }">
                                                View More
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `
                            $('#content-' + response.item.item_category_id).prepend(new_shop);
                            viewMoreBtn();
                            itemSwitch();
                            editItemButton();
                            deleteItemButton();
                            if (response.item.shop_info.shop_status_id == 1) {
                                $("#publish-btn").attr("disabled", false);
                            }
                            $('#alert-header').fadeOut();
                            $('#submit-btn').attr('disabled', false);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#add-category-form').validate({
                rules: {
                    category: {
                        required: true,
                        remote: {
                            url: "{{ route('verify.shopCategory') }}",
                            type: "GET",
                            data: {
                                shop_id: shop.id,
                                shop_code: function() {
                                    return $('#category').val();
                                },
                            },
                        }
                    },
                },
                messages: {
                    category: {
                        remote: "This shop category name has been used."
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#add-category-submit-btn').attr('disabled', true).text('please wait...');
                    $.ajax({
                        url: "{{ route('operator.shopInfoAddCategory') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#add-category-submit-btn').attr('disabled', false)
                                .text('Submit');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: ' Added Successfully',
                                text: 'You have successfully added a new category on this shop',
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $("#add-category-modal").modal('toggle');
                            $('#add-category-form').trigger('reset');
                            $("#add-item-btn").attr("disabled", false);
                            accordion_item = $(document.createElement('div'))
                                .addClass('accordion-item')
                                .prependTo($('#item-category-accordion'))
                            accordion_header = $(document.createElement('h2'))
                                .addClass('accordion-header')
                                .attr('id', 'header-' + response.item_category.id)
                                .appendTo(accordion_item);
                            button = $(document.createElement('button'))
                                .addClass('accordion-button')
                                .attr({
                                    'type': 'button',
                                    'data-bs-toggle': 'collapse',
                                    'data-bs-target': '#body-' + response.item_category
                                        .id,
                                    'aria-expanded': 'true',
                                    'aria-controls': 'body-' + response.item_category
                                        .id,
                                }).appendTo(accordion_header);
                            header_title = $(document.createElement('div'))
                                .attr('id', 'acc-btn-' + response.item_category.id)
                                .addClass('shop-type-header')
                                .css('text-transform', 'capitalize')
                                .text(response.item_category.category)
                                .appendTo(button)
                            body_container = $(document.createElement('div'))
                                .addClass('accordion-collapse collapse show')
                                .attr({
                                    'aria-labelledby': 'header-' + response
                                        .item_category.id,
                                    'id': 'body-' + response.item_category.id
                                }).appendTo(accordion_item);
                            accordion_body = $(document.createElement('div'))
                                .addClass('accordion-body')
                                .appendTo(body_container);
                            accordion_content = $(document.createElement('div'))
                                .addClass('row')
                                .attr('id', 'content-' + response.item_category.id)
                                .appendTo(accordion_body);
                            item_list = $(document.createElement('div'))
                                .addClass('empty-item-' + response.item_category.id)
                                .text('Item List Empty...')
                                .appendTo(accordion_content);

                            item_dropdown_options = $(document.createElement('option'))
                                .attr('value', response.item_category.id)
                                .text(response.item_category.category)
                                .insertAfter($('#item_category_id').children().first());
                            if (response.item_category.items.length == 0) {
                                $('#alert-header').find('span').text(
                                    'Shop Items is empty. Please add a new Items.');
                            }
                        },
                        error: function(response) {
                            alert('Oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#add-shop-hour-form').validate({
                rules: {
                    shop_days: {
                        notEqual: 0,
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#add-shophour-submit-btn').attr('disabled', true).text('please wait...');
                    $.ajax({
                        url: "{{ route('operator.shopInfoAddShopHour') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#add-shophour-submit-btn').attr('disabled', false)
                                .text('Submit');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#add-shophour-modal').modal('toggle');
                            $('#add-shop-hour-form').trigger('reset');
                            $('#alert-shop-hour').detach();
                            $('#add-category-btn').attr('disabled', false);

                            response.shop_info.shop_hour.forEach(element => {
                                row = $(document.createElement('div'))
                                    .addClass('row mb-2')
                                    .prependTo($('#shop-hour-div'));
                                col_week = $(document.createElement('div'))
                                    .addClass('col-4')
                                    .appendTo(row);
                                weekday = $(document.createElement('div'))
                                    .addClass('fw-bold text-capitalize')
                                    .text(element.weekday)
                                    .appendTo(col_week);
                                col_hour = $(document.createElement('div'))
                                    .addClass('col-8 d-flex justify-content-end pe-5')
                                    .appendTo(row);
                                hour = $(document.createElement('div'))
                                    .addClass('text-muted text-capitalize')
                                    .text(element.opening + ' AM' + ' - ' + element.closing + ' PM')
                                    .appendTo(col_hour);
                            });



                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#add-item-variant-form').validate({
                rules: {
                    variant: {
                        required: true,
                    },
                    cost: {
                        required: true
                    },
                    markup: {
                        required: true
                    },
                    item_combo_category_id: {
                        required: true,
                        notEqual: 0
                    },
                    item_id: {
                        required: true,
                        notEqual: 0
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();;
                    $.ajax({
                        url: "{{ route('operator.shopInfoAddItemVariant') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            console.log(response);
                            $('#add-item-variant-modal').modal('toggle');
                            $('#add-item-variant-form').trigger('reset');
                            itemInfo(response.item.id);
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        error: function(response) {
                            alert(
                                'Oops something went wrong'
                            );
                        }
                    });
                    return false;
                },
            });

            $('#add-combo-category-form').validate({
                rules: {
                    combo_category: {
                        required: true,
                    },
                    is_required: {
                        required: true,
                        notEqual: 3
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();;
                    $.ajax({
                        url: "{{ route('operator.shopInfoAddItemComboCategory') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            $('#add-item-category-combo-modal').modal('toggle');
                            $('#add-combo-category-form').trigger('reset');
                            $('#add-item-combo-btn').attr('disabled', false);
                            itemInfo(response.item.id);
                            item_combo_category = response.item.item_combo_categories;
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        error: function(response) {
                            alert(
                                'Oops something went wrong'
                            );
                        }
                    });
                    return false;
                },
            });

            $('#add-item-combo-form').validate({
                rules: {
                    combo: {
                        required: true,
                    },
                    cost: {
                        required: true
                    },
                    markup: {
                        required: true
                    },
                    item_combo_category_id: {
                        required: true,
                        notEqual: 0
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#add-item-combo-form-btn').attr('disabled', true).text('Processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoAddItemCombo') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            console.log(response);
                            $('#add-item-combo-form-btn').attr('disabled', false).text('Submit');
                            $('#add-item-combo-modal').modal('toggle');
                            $('#add-item-combo-form').trigger('reset');
                            itemInfo(response.item_combo.item_id);
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        error: function(response) {
                            alert(
                                'Oops something went wrong'
                            );
                        }
                    });
                    return false;
                },
            });

            $('#toggle-item-form').validate({
                submitHandler: function(form, event) {
                    var status_badge = thisToggle.parent().next().children()
                    $("#toggle-item-form-btn").attr('disabled', true).text('Processing');
                    event.preventDefault();;
                    $.ajax({
                        url: "{{ route('operator.shopInfoItemToggleStatusUpdate') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#toggle-item-modal').modal('toggle');
                            $('#toggle-item-form').trigger('reset');
                            $("#toggle-item-form-btn").attr('disabled', false).text('Proceed');
                            if (response.item.status == 1) {
                                status_badge.fadeOut('fast', function() {
                                    status_badge.css('background-color', '#198745')
                                        .text('Active');
                                    status_badge.fadeIn('fast');
                                });
                                $('#toggle-item-modal').on('hidden.bs.modal', function() {
                                    thisToggle.prop("checked", true);
                                });
                            } else if (response.item.status == 0) {
                                status_badge.fadeOut('fast', function() {
                                    status_badge.css('background-color', '#DC3545')
                                        .text('Inactive');
                                    status_badge.fadeIn('fast');
                                });
                                $('#toggle-item-modal').on('hidden.bs.modal', function() {
                                    thisToggle.prop("checked", false);
                                });
                            }
                        },
                        error: function(response) {
                            alert(
                                'Oops something went wrong'
                            );
                        }
                    });
                    return false;
                },
            });

            $('#toggle-shop-form').validate({
                submitHandler: function(form, event) {
                    $('#toggle-shop-form-btn').attr('disabled', true).text('Processing');
                    event.preventDefault();;
                    $.ajax({
                        url: "{{ route('operator.shopInfoToggleStatusUpdate') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        success: function(response) {
                            $('#toggle-shop-form-btn').attr('disabled', false).text('Proceed');
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#toggle-shop-modal').modal('toggle');
                            $('#toggle-shop-form').trigger('reset');

                            if (response.shop.shop_status_id == 3) {
                                $('#shop_status').fadeOut(function() {
                                    $('#shop_status').css('background-color',
                                        '#198745').text('Published');
                                    $('#shop_status').fadeIn('fast');
                                });
                                $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                                    $('#headerToggle').prop("checked", true);
                                });
                            } else if (response.shop.shop_status_id == 4) {
                                $('#shop_status').fadeOut(function() {
                                    $('#shop_status').css('background-color',
                                        '#DC3545').text('Inactive');
                                    $('#shop_status').fadeIn('fast');
                                });
                                $('#toggle-shop-modal').on('hidden.bs.modal', function() {
                                    $('#headerToggle').prop("checked", false);
                                });
                            }
                        },
                        error: function(response) {
                            alert(
                                'Oops something went wrong'
                            );
                        }
                    });
                    return false;
                },
            });

            $('#edit-item-form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    shop_type_id: {
                        notEqual: 0
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-item-form-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoEditItem') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-item-form-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#edit-item-modal').modal('toggle');
                            $('#edit-item-form').trigger('reset');
                            item_cost = parseFloat(response.item.cost) + parseFloat(response.item.markup);
                            item = $('#item-id-' + response.item.id);
                            item.find('#item-name').text(response.item.name);
                            item.find('#item-total').text(formatToCurrency(item_cost));
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#delete-item-form').validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#delete-item-form-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoDeleteItem') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#delete-item-form-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });

                            $('#delete-item-modal').modal('toggle');
                            $("#item-id-" + response.item.id).fadeOut(function () {
                                $(this).detach();
                            });

                            if ($('#content-' + response.item.item_category_id).children().length == 1) {
                                alert_items_empty = `
                                    <div class="row mt-3" id="alert-header">
                                        <div class="col-lg-12">
                                            <div class="alert alert-danger m-0" role="alert">
                                                <span>
                                                    Shop Items is empty. Please add a new Items.
                                                </span>
                                            </div>
                                        </div>
                                    </div>`
                                $('#main-profile').after(alert_items_empty)
                                shop_list_empty = `<div class="empty-item-${ response.item.item_category_id }">Shop List Empty...</div>`
                                $('#content-' + response.item.item_category_id).html(shop_list_empty);
                            }
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#edit-item-combo-form').validate({
                rules: {
                    combo: {
                        required: true
                    },
                    cost: {
                        required: true
                    },
                    markup: {
                        required: true
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
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-item-combo-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoEditItemCombo') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-item-combo-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#edit-item-combo-modal').modal('toggle');
                            $('#edit-item-combo-form').trigger('reset');
                            itemInfo(response.item_combo.item_id);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#delete-item-combo-form').validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-item-combo-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoDeleteItemCombo') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-item-combo-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#delete-item-combo-modal').modal('toggle');
                            $('#delete-item-combo-form').trigger('reset');
                            itemInfo(response.item_combo.item_id);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#edit-item-variant-form').validate({
                rules: {
                    variant: {
                        required: true
                    },
                    cost: {
                        required: true
                    },
                    markup: {
                        required: true
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
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-item-variant-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoEditItemVariant') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-item-variant-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#edit-item-variant-modal').modal('toggle');
                            $('#edit-item-variant-form').trigger('reset');
                            itemInfo(response.item_variant.item_id);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#delete-item-variant-form').validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-item-variant-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoDeleteItemVariant') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-item-variant-btn').attr('disabled', false).text('Proceed');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#delete-item-variant-modal').modal('toggle');
                            $('#delete-item-variant-form').trigger('reset');
                            itemInfo(response.item_variant.item_id);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#edit-shop-image-form').validate({
                rules: {
                    image: {
                        required: true,
                        extension: "jpg|jpeg|png"
                    },
                },
                messages: {
                    required: "Please upload file.",
                    extension: "Please upload file in these format only (jpg, jpeg, png)."
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-shop-image-form-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoEditShopImage') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-shop-image-form-btn').attr('disabled', false).text('Submit');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            uploaded_shop_image = "{{ asset('storage/shop_image/:img') }}"
                            uploaded_shop_image = uploaded_shop_image.replace(':img', response.shop_info.image);
                            $('#shop-image').attr('src', uploaded_shop_image);
                            $('#edit-shop-image-modal').modal('toggle');
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });

            $('#edit-item-image-form').validate({
                rules: {
                    image: {
                        required: true,
                        extension: "jpg|jpeg|png"
                    },
                },
                messages: {
                    required: "Please upload file.",
                    extension: "Please upload file in these format only (jpg, jpeg, png)."
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-floating').append(error);
                    element.closest('#error').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#edit-item-image-form-btn').attr('disabled', true).text('processing');
                    $.ajax({
                        url: "{{ route('operator.shopInfoEditItemImage') }}",
                        method: "POST",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        data: new FormData(form),
                        complete: function() {
                            $('#edit-item-image-form-btn').attr('disabled', false).text('Submit');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.text,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $('#edit-item-image-modal').modal('toggle');
                            $('#edit-item-image-form').trigger('reset');
                            itemInfo(response.item.id);
                            item_image = "{{ asset('storage/item_image/:img') }}"
                            item_image = item_image.replace(':img', response.item.image);
                            $('#item-image-' + response.item.id).attr('src', item_image);
                        },
                        error: function(response) {
                            alert('oops something went wrong');
                        }
                    });
                    return false;
                },
            });
        });
    </script>

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
