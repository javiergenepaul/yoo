@extends('layouts.layout_api_docs')


@section('content')
    <div class="content">
        {{-- Customer OTP Starts --}}
        <section class="first-content-group" id="customer">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer OTP</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required | numeric| min: 09000000000 | max:
                                    09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input numeric mobile number for Customer
                                    OTP
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/customer/otp</div>
                        </div>
                        <pre class="sample" id="customer_request_OTP"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_OTP"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer OTP Ends --}}
        {{-- Customer OTP Verify Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer OTP Verification</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">otp</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to the registered OTP number for verification
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required | numeric| min: 09000000000 | max:
                                    09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input registered numeric number for OTP
                                    verification
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">id</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input registered ID for verification
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/customer/otp</div>
                        </div>
                        <pre class="sample" id="customer_request_otpVerify"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_otpVerify"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer OTP Verify Ends --}}
        {{-- Customer Register Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Registration</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required | numeric |
                                    unique:users,mobile_number | min: 09000000000 | max: 09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input numeric mobile number of verified
                                    mobile OTP
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">email</div>
                                <div class="parameter-content-header-type">string | unique | optional</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input a unique string email of customer</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string password of customer</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password_confirmation</div>
                                <div class="parameter-content-header-type">required | string | password</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string password for confirmation
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/customer/register</div>
                        </div>
                        <pre class="sample" id="customer_request_registration"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_registration "></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Register Ends --}}
        {{-- Customer Login Start --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Login</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">account</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input either of email or mobile
                                    number registered of Customer</p>
                            </div>
                        </div>

                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string password of Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/customer/login</div>
                        </div>
                        <pre class="sample" id="customer_request_login"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_login"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Login Ends --}}
        {{-- Customer Profile Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Get Profile</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login customer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">/api/customer/profile</div>
                        </div>

                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_profile"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Profile Ends --}}
        {{-- Customer Profile Update Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Profile Update</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login customer</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">first_name</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string first name for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">last_name</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string last name for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">date_of_birth</div>
                                <div class="parameter-content-header-type">required | date_format: YYYY-MM-DD</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input date of birth for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">profile_picture</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input profile picture for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">middle_name</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input middle name for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">country</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input country for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">province</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input province for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">city_municipality</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input city municipality for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">postal_code</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input postal code for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">barangay</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input barangay for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">address</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input address for customer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/customer/register</div>
                        </div>
                        <pre class="sample" id="customer_request_profileUpdate"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_profileUpdate"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Profile Update Ends --}}
        {{-- Customer Create Order --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Create Order</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login User</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">p_address</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input string of address</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">p_lat</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input latitude of the user</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">p_long</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input longitude of the user</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">p_time</div>
                                <div class="parameter-content-header-type">required | date_format:H:i:s</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input time</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">p_date</div>
                                <div class="parameter-content-header-type">required | date</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input date</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">total_mileage</div>
                                <div class="parameter-content-header-type">required | date</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input mileage</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">total_amount</div>
                                <div class="parameter-content-header-type">required | date</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input total amount</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input the ID of vehicle</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">area_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input the ID of area</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs</div>
                                <div class="parameter-content-header-type">required | array </div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input dropoffs</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.latitude</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs latitude</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.longitude</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs lognitude</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.address</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs address</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.name</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs name</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.contact</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs contact</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.instruction</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs contact</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.mileage</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs mileage</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoffs.*.landmark</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input droppoffs landmark</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/customer/order/create</div>
                        </div>
                        <pre class="sample" id="customer_request_createOrder"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_createOrder"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Create Order Ends --}}
        {{-- Customer Update Order Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Cancel Order</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login User</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/customer/order/update/{id}</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_updateOrder"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Update Order Ends --}}
        {{-- Customer Get Ongoing Order Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Get Ongoing Order</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login User</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/customer/orders/ongoing</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_getOrderOngoing"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Get Ongoing Order Ends --}}
        {{-- Customer Get Completed Order Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Get Completed Order</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login User</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/customer/orders/completed</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_getOrderCompleted"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Get Completed Order Ends --}}

        {{-- Customer Get Cancelled Orders Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Customer Get Cancelled Order</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login User</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/customer/orders/cancelled</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_getOrderCancelled"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Get Cancelled Order Ends --}}

        {{-- Customer Logout Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Costumer Logout</div>
                    <div class="parameter-title">Parameters</div>

                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">authorization token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input authorization token of login
                                    user</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/customer/logout</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_logout"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Customer Logout Ends --}}
        {{-- Driver Mobile OTP Starts --}}
        <section class="first-content-group" id="driver">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Drivers Mobile OTP</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>

                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required| numeric | min:09000000000 |
                                    max:09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string Mobile number OTP for
                                    drivers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/driver/otp</div>
                        </div>
                        <pre class="sample" id="driver_request_OTP"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_OTP"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Mobile OTP Ends --}}
        {{-- Driver Mobile OTP Verify Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver OTP Verification</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">otp</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to the registered OTP number for
                                    verification
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required | numeric| min: 09000000000 | max:
                                    09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input registered numeric number for OTP
                                    verification
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">id</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input registered ID for verification
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/driver/otp-verify</div>
                        </div>
                        <pre class="sample" id="driver_request_otpVerify"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_otpVerify"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Mobile OTP Verify Ends --}}
        {{-- Driver Register Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Drivers Register</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required | numeric |
                                    unique:users,mobile_number | min: 09000000000 | max: 09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input numeric mobile number of verified
                                    mobile OTP
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">email</div>
                                <div class="parameter-content-header-type">string | unique | optional</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input a unique string email of driver</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string password of driver</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password_confirmation</div>
                                <div class="parameter-content-header-type">required | string | password</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string password for confirmation
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">sponsor_code</div>
                                <div class="parameter-content-header-type">required</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input Sponsor code from Operator
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/driver/register</div>
                        </div>
                        <pre class="sample" id="driver_request_Register"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_Register"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Register Ends --}}
        {{-- Driver Login Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Drivers Login</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">account</div>
                                <div class="parameter-content-header-type">requried | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to Input either mobile number or email
                                    address of registered driver</p>
                            </div>
                        </div>

                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input password for drivers to login
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/driver/login</div>
                        </div>
                        <pre class="sample" id="driver_request_Login"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_Login"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Login Ends --}}
        {{-- Driver Profile Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Get Profile</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-right">

                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">/api/driver/profile</div>
                        </div>

                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_profile"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Profile Ends --}}
        {{-- Driver Profile Update Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Profile Update</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login customer</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">first_name</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string first name for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">last_name</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string last name for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">date_of_birth</div>
                                <div class="parameter-content-header-type">required | date_format: YYYY-MM-DD</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input date of birth for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">profile_picture</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input profile picture for customer
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">middle_name</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string of middle name for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">country</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input country for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">province</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input province for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">city_municipality</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input city municipality for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">postal_code</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input postal code for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">barangay</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input barangay for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">address</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input address for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">city</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input city for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">driving_license_number</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input driving license number for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">driving_license_expiry</div>
                                <div class="parameter-content-header-type">required | date_format: YYYY-MM-DD</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input driving license expiry date
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">driver_license_image</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input driver license image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">nbi_clearance</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input nbi clearance image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vax_certificate</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vaccine certificate image
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/driver/profile/update</div>
                        </div>
                        <pre class="sample" id="driver_request_profileUpdate"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_profileUpdate"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Profile Update Ends --}}
        {{-- Driver Get Vehicles Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Get Vehicles</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login customer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/driver/vehicles</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_vehicles"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Get Vehicles Ends --}}
        {{-- Drivers Vehicle Add Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Vehicle Add</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login customer</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle type ID
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_brand</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle brand for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_model</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle model for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_manufacture_year</div>
                                <div class="parameter-content-header-type">date_format:Y</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle manufacture year for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">license_plate_number</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input license plate number for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">deed_of_sale</div>
                                <div class="parameter-content-header-type">mimes:jpeg,jpg,png | max:1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input deed of sale for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_registration</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle registration image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_front</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle front image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_side</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle side image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_back</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle back image
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/driver/vehicle/create</div>
                        </div>
                        <pre class="sample" id="driver_request_vehicleCreate"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_vehicleCreate"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Drivers Vehicle Add Ends --}}
        {{-- Drivers Vehicle Update Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Vehicle Update</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login customer</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input id of driver vehicle
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle id for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_brand</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle brand for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_model</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle model for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_manufacture_year</div>
                                <div class="parameter-content-header-type">date_format:Y</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle manufacture year for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">license_plate_number</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input license plate number for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">deed_of_sale</div>
                                <div class="parameter-content-header-type">mimes:jpeg,jpg,png | max:1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input deed of sale for driver
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_registration</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle registration image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_front</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle front image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_side</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle side image
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">vehicle_back</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle back image
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">/api/driver/vehicle/update</div>
                        </div>
                        <pre class="sample" id="driver_request_vehicleUpdate"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_vehicleUpdate"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Drivers Vehicle Update Ends --}}

        {{-- Driver Get Orders Avaialable Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Drivers Get Orders Available</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/driver/orders/available</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_getOrderAvailable"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Get Orders Available Ends --}}
        {{-- Driver Get Orders Ongoing Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Ongoing Orders</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">/api/driver/orders/ongoing</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_ongoingOrder"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Get Orders Ongoing Ends --}}
        {{-- Driver Get Orders Completed Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Completed Orders</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">/api/driver/orders/completed</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_completedOrder"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Get Orders Completed Ends --}}
        {{-- Driver Get Orders Cancelled Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Cancelled Orders</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">/api/driver/orders/cancelled</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_cancelledOrder"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Get Orders Cancelled Ends --}}

        {{-- Driver Assign Orders Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Assign Orders</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Order ID</div>
                                <div class="parameter-content-header-type">order ID URL</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input order id in URL</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/driver/order/assign/{id}</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_assignedOrder"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Assign Orders Ends --}}

        {{-- Driver Update Orders Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Update Orders</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Order ID</div>
                                <div class="parameter-content-header-type">order ID URL</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input order id in URL</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">order_status_id</div>
                                <div class="parameter-content-header-type">order_status_id | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input Order Status ID</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">driver_id</div>
                                <div class="parameter-content-header-type">driver_id | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input driver ID of current Login Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/driver/order/update/{id}</div>

                        </div>
                        <pre class="sample" id="driver_request_updateOrder"></pre>

                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_updateOrder"></pre>

                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Update Orders Ends --}}
        {{-- Driver Create Pickup item Image Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Driver Create Pickup item Image</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Order ID</div>
                                <div class="parameter-content-header-type">order ID URL</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input order id in URL</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login Driver</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">driver_id</div>
                                <div class="parameter-content-header-type">driver_id | numeric | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input driver ID of current Login Driver</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">image</div>
                                <div class="parameter-content-header-type">required | mimes:jpeg,jpg,png | max:1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input pick up Image</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">dropoff_location_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input dropoff location</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/driver/order/create/pickup-item-image/{id}</div>

                        </div>
                        <pre class="sample" id="driver_request_pickupImage"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_pickupImage"></pre>

                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Create Pickup item Image Ends --}}
        {{-- Driver Logout Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Drivers Logout</div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">bearer token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input bearer token of login
                                    driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/driver/logout</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="driver_response_Logout"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Driver Logout Ends --}}
        {{-- Management Register Starts --}}
        <section class="first-content-group" id="management">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Management Register</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">first_name</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string email for login
                                    management</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">last_name</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input Last name of management</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required | numeric |
                                    unique:users,mobile_number | min:09000000000 | max:09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to mobile number</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">email</div>
                                <div class="parameter-content-header-type">required | string | email</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string email for login
                                    management</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string password for login
                                    management</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">date_of_birth</div>
                                <div class="parameter-content-header-type">date_format : YYYY-MM-DD</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input Date</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">management_role_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input id number of management Role
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/management/login</div>
                        </div>
                        <pre class="sample" id="management_request_Register"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="management_response_Register"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Management Register Ends --}}
        {{-- Management Login Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Management Login</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">email</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string email for login
                                    management</p>
                            </div>
                        </div>

                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">password</div>
                                <div class="parameter-content-header-type">required | string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input string password for login
                                    management</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/management/login</div>
                        </div>
                        <pre class="sample" id="management_request_Login"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="management_response_Login"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Management Login Ends --}}
        {{-- Management Driver List Start --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Management Drivers List</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Management</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">maangement will get all list of drivers list</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-content">
                        <div class="parameter-content-header">
                            <div class="parameter-content-header-title">token</div>
                            <div class="parameter-content-header-type">token</div>
                        </div>
                        <div class="parameter-description">
                            <p class="parameter-descrption-child">Input bearer token of login management</p>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/management/drivers/list</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="management_driversList"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Management Driver List Ends --}}
        {{-- Management Drivers Show by ID Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Management Drivers Show by ID</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Management</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input ID number of driver</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-content">
                        <div class="parameter-content-header">
                            <div class="parameter-content-header-title">token</div>
                            <div class="parameter-content-header-type">token</div>
                        </div>
                        <div class="parameter-description">
                            <p class="parameter-descrption-child">Input bearer token of login management</p>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/management/driver/show/{id}</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="management_driverShowId"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Management Driver Show by ID Ends --}}
        {{-- Management Driver Verification Update Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Management Driver Verification Update</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">verification_status_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input numeric for update driver in
                                    management</p>
                            </div>
                        </div>

                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input bearer token of login management</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/management/driver/verification/update/{id}</div>
                        </div>
                        <pre class="sample" id="management_request_driverVerificationUpdate"></pre>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="management_response_driverVerificationUpdate"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Management Driver Verification Updates Ends --}}
        {{-- Management Logout Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Management Logout</div>
                    <div class="parameter-title">Parameters</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">token</div>
                                <div class="parameter-content-header-type">authorization token</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input authorization token of login
                                    driver</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">POST - </div>
                            <div class="title-link">api/management/logout</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="management_response_Logout"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Management Logout Ends --}}
        {{-- Dropdown Vehicle Types Starts --}}
        <section class="first-content-group" id="dropdown">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Dropdown Vehicle Types</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Vehicle Types</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Motorcycle</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Vehicle type motorcycle</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">200kg Sedan</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Vehicle type 200g Sedan</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">300kg MPV</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Vehicle type 300g MPV</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">600kg MPV</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Vehicle type 600g MPV</p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">FB/L300</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Vehicle type FB/L300</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/dropdown/vehicle-types</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="dropdown_vehicleType"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Dropdown Vehicle Types Ends --}}
        {{-- Dropdown Vehicle Area Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Dropdown Vehicle Areas</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Areas</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Cebu</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Vehicles in Cebe areas</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/dropdown/vehicle-areas</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="dropdown_vehicleAreas"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Dropdown Vehicle Area Ends --}}
        {{-- Dropdown Management Role ID Starts --}}
        <section class="first-content-group">
            <div class="first-content-padding">
                <div class="content-left">
                    <div class="content-header">Management Role ID</div>
                    <div class="content-title">Headers</div>
                    <div class="table-box">
                        <div class="table-header">
                            <div class="table-header-cell">
                                <p>KEY</p>
                            </div>
                            <div class="table-header-cell">
                                <p>VALUE</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Accept</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">
                                <p>Content-Type</p>
                            </div>
                            <div class="table-cell">
                                <p>application/json</p>
                            </div>
                        </div>
                    </div>
                    <div class="parameter-title">Management Role</div>
                    <div class="parameters">
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">Admin</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Admin role assigned index 01</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-border">
                        <div class="title">
                            <div class="title-type">GET - </div>
                            <div class="title-link">api/dropdown/management-role</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="dropdown_ManagementRole"></pre>
                    </div>
                </div>
            </div>
        </section>
        {{-- Dropdown Management Role ID Ends --}}
    </div>
@endsection
