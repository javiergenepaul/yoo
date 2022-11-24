<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="stylesheet" href="resources/css/style.css"> --}}
    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://kit.fontawesome.com/caefad7d7f.js" crossorigin="anonymous"></script>


    <!-- Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;600;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            overflow-x: hidden;
        }


        /* Start SideBar CSS */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 78px;
            background: #11101d;
            padding: 6px 14px;
            transition: all 0.5s ease;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar.active {
            width: 240px;
        }

        .sidebar .logo-content .logo {
            color: #fff;
            display: flex;
            height: 50px;
            width: 100%;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s ease;
        }

        .sidebar.active .logo-content .logo {
            padding-left: 20px;
            opacity: 1;
            pointer-events: none;
        }

        .logo-content .logo .logo-name {
            font-size: 20px;
            font-weight: 400;
        }

        .sidebar #btn {
            position: absolute;
            color: #fff;
            left: 50%;
            top: 6px;
            font-size: 20px;
            height: 50px;
            width: 50px;
            text-align: center;
            line-height: 50px;
            transform: translate(-50%)
        }

        .sidebar.active #btn {
            left: 90%;
        }

        .sidebar ul {
            margin-top: 20px;
        }

        .sidebar ul li {
            position: relative;
            height: 50px;
            width: 100%;
            margin: 0 5px;
            line-height: 50px;
            list-style: none;
        }

        .sidebar ul li .tooltip {
            position: absolute;
            left: 78px;
            top: 50%;
            transform: translateY(-50%, -50%);
            border-radius: 6px;
            height: 35px;
            width: 122px;
            line-height: 35px;
            text-align: center;
            background: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            transition: 0s;
            opacity: 0;
            pointer-events: none;
            display: block;
        }

        .sidebar.active ul li .tooltip {
            display: block;
        }

        .sidebar ul li:hover .tooltip {
            opacity: 1;
            transition: all 0.5s ease;
            top: 50%;
        }

        .sidebar.active ul li:hover .tooltip {
            opacity: 0;
        }

        .sidebar ul li input {
            position: absolute;
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
            border-radius: 12px;
            outline: none;
            border: none;
            background: #11101d;
            padding-left: 50px;
            font-size: 18px;
            color: #fff;
            transition: all 0.4s ease;
        }

        .sidebar.active ul li input {
            background: #1d1b31;
        }

        .sidebar ul li .fa-search {
            position: absolute;
            z-index: 99;
            color: #fff;
            font-size: 22px;
            transition: all 0.5 ease;
        }

        .sidebar ul li .fa-search:hover {
            background: #fff;
            color: #1d1b31;
        }

        .sidebar ul li a {
            color: #fff;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.4 ease;
            border-radius: 12px;
            white-space: nowrap;
        }

        .sidebar ul li a:hover {
            color: #11011d;
            background: #fff;
        }

        .sidebar ul li i {
            height: 50px;
            min-width: 50px;
            border-radius: 12px;
            line-height: 50px;
            text-align: center;
        }

        .sidebar .links_name {
            opacity: 0;
            pointer-events: none;
            transition: all 0.5s ease;
        }

        .sidebar.active .links_name {
            opacity: 1;
            pointer-events: auto;
        }

        .content {
            position: absolute;
            width: calc(100% - 78px);
            left: 78px;
            box-sizing: border-box;
            background: #1A1F36;
            min-width: 30ch;
            transition: all 0.5s ease;
        }

        .sidebar.active~.content {
            left: 240px;
            width: calc(100% - 240px);
        }


        .first-content-group {
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);

        }

        .first-content-padding {
            display: flex;
            flex-wrap: wrap;
            padding: 5vw;
            flex-direction: row;
            width: 100%;
            gap: 20px;
            transition: all 0.5s ease;
        }

        .first-content-padding {
            gap: 20px;
        }

        .content .first-content-group .first-content-padding .content-left {
            color: #c1c9d2;
            min-width: 30ch;
            flex: 1 1 50%;
        }

        .content .first-content-group .first-content-padding .content-left>* {
            min-width: 30ch;
        }

        .content .first-content-group .first-content-padding .content-left .content-header {
            color: #c1c9d2;
            font-size: 24px;
            font-weight: 600;
        }

        .content-title {
            font-weight: 600;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;

        }

        .table-box {
            /* margin-top: 20px    ; */
            background: #4F566B;
            border-radius: 10px;
        }

        .table-box>* {
            font-size: 14px;
        }

        .table-header {
            display: table;
            width: 100%;
            padding: 4px 15px;
        }

        .table-header-cell {
            display: table-cell;
            width: 30%;
            padding: 4px 0;
            vertical-align: middle;
            font-weight: 600;
        }

        .table-row {
            display: table;
            width: 100%;
            padding: 4px 15px;
            background: #3C4257;
        }

        .table-cell {
            display: table-cell;
            width: 30%;
            padding: 4px 0;
            vertical-align: middle;
        }


        .parameter-title {
            font-weight: 600;
            font-size: 16px;
            margin-top: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .parameter-content-header {
            display: flex;
        }

        .parameter-content {
            padding-top: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            overflow: scroll;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .parameter-content::-webkit-scrollbar {
            display: none;
        }

        .parameter-content-header {
            align-items: baseline;
        }

        .parameter-content-header-title {
            font-size: 13px;
            font-weight: 600;
            padding-right: 4px;
        }

        .parameter-content-header-type {
            font-size: 12px;
            color: #858eaf;
        }

        .parameter-descrption-child {
            margin-top: 4px;
            font-size: 14px;
        }

        .content-right {
            min-width: 30ch;
            flex: 1 1 35%;
        }

        .content-border {
            background: #4F566B;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .title {
            padding: 15px;
            color: #c1c9d2;
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .title .title-type {
            font-size: 16px;
            font-weight: 600;
            padding-right: 4px;
            /* flex: 1 1 20%; */
        }

        .title .title-link {
            font-size: 16px;
            font-weight: 300;
            overflow: scroll;
            scrollbar-width: none;
            -ms-overflow-style: none;
            /* flex: 1 1 80%; */
        }

        .title-link::-webkit-scrollbar {
            display: none;
        }

        .sample {
            padding: 15px;
            color: #c1c9d2;
            background: #3C4257;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            overflow: scroll;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sample::-webkit-scrollbar {
            display: none;
        }

    </style>
</head>


<body>
    {{-- Start SideBar --}}
    <div class="sidebar">
        <div class="logo-content">
            <div class="logo">
                <div class="logo-name">
                    YOOAPI
                </div>
            </div>
            <i class="fas fa-bars" id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
                <span class="tooltip">Search</span>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-user"></i>
                    <span class="links_name">User</span>
                </a>
                <span class="tooltip">User</span>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-user"></i>
                    <span class="links_name">Driver</span>
                </a>
                <span class="tooltip">Management</span>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-user"></i>
                    <span class="links_name">Management</span>
                </a>
                <span class="tooltip">Dropdown</span>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-user"></i>
                    <span class="links_name">Driver</span>
                </a>
                <span class="tooltip">Driver</span>
            </li>
        </ul>
    </div>
    {{-- Ends SideBar --}}


    <div class="content">
        {{-- Customer OTP Starts --}}
        <section class="first-content-group">
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
                                <div class="parameter-content-header-type">required | numeric| min: 09000000000 | max: 09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input numeric mobile number for Customer OTP
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
                                <div class="parameter-content-header-type">required | numeric| min: 09000000000 | max: 09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input registered numeric number for OTP verification
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
                                <p class="parameter-descrption-child">Required to input numeric mobile number of verified mobile OTP
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
                                <p class="parameter-descrption-child">Required to input string password for confirmation</p>
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
                            <div class="title-link">api/user/order/create</div>
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
        {{-- Customer Get Ongoing Order --}}
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
                            <div class="title-link">api/user/orders/ongoing</div>
                        </div>
                    </div>
                    <div class="content-border">
                        <div class="title">Response Sample</div>
                        <pre class="sample" id="customer_response_getOrderOngoing"></pre>
                    </div>
                </div>
            </div>
        </section>
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
                            <div class="title-link">api/user/logout</div>
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
        {{-- Driver Mobile OTP Start --}}
        <section class="first-content-group">
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
                                <p class="parameter-descrption-child">Required to the registered OTP number for verification
                                </p>
                            </div>
                        </div>
                        <div class="parameter-content">
                            <div class="parameter-content-header">
                                <div class="parameter-content-header-title">mobile_number</div>
                                <div class="parameter-content-header-type">required | numeric| min: 09000000000 | max: 09999999999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input registered numeric number for OTP verification
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
                            <div class="title-link">/api/customer/otp-verify</div>
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
                                <p class="parameter-descrption-child">Required to input numeric mobile number of verified mobile OTP
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
                                <p class="parameter-descrption-child">Required to input string password for confirmation</p>
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
                        {{-- start --}}
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
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input vehicle manufacture year for driver
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
                                <div class="parameter-content-header-title">license_plate_number</div>
                                <div class="parameter-content-header-type">string</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input license plate number for driver
                                </p>
                            </div>
                        </div>
                        {{-- End --}}
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
                                <div class="parameter-content-header-title">vehicle_id</div>
                                <div class="parameter-content-header-type">required | numeric</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Required to input vehicle type from vehicle type api
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
                                <div class="parameter-content-header-title">deed_of_sale</div>
                                <div class="parameter-content-header-type">mimes: jpeg,jpg,png | max: 1999</div>
                            </div>
                            <div class="parameter-description">
                                <p class="parameter-descrption-child">Input deed of sale image
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
                            <div class="title-type">GET - </div>
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
        <section class="first-content-group">
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
        <section class="first-content-group">
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
        {{-- Dropdown Vehicle Area Ends--}}
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
    <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");
        let searchBtn = document.querySelector(".fa-search");

        // Customer OTP Starts
        let customer_request_OTP = {
            "mobile_number" : "09000000000"
        }
        let customer_response_OTP = {
            "message": "OTP created.",
            "data": {
                "otp": 1317,
                "mobile_number": "09000000000",
                "updated_at": "2021-10-06T14:15:50.000000Z",
                "created_at": "2021-10-06T14:15:50.000000Z",
                "id": 1
            }
        }
        // Customer OTP Ends
        // Customer OTP Verify Starts
        let customer_request_otpVerify = {
            "otp" : "1317",
            "mobile_number" : "09000000000",
            "id" : "1"
        }
        let customer_response_otpVerify = {
            "message": "OTP verified.",
            "data": {
                "id": 1,
                "mobile_number": "09000000000",
                "otp": "1317",
                "created_at": "2021-10-06T14:15:50.000000Z",
                "updated_at": "2021-10-06T14:15:50.000000Z"
            }
        }
        // Customer OTP Verify Ends
        // Customer register Start
        let customer_request_registration = {
            "mobile_number": "09000000000",
            "email" : "email@email.com",
            "password": "123456789",
            "password_confirmation": "123456789"
        }
        let customer_response_registration = {
            "message": "User created.",
            "user": {
                "mobile_number": "09000000000",
                "email": "email@email.com",
                "updated_at": "2021-10-06T14:21:26.000000Z",
                "created_at": "2021-10-06T14:21:26.000000Z",
                "id": 1,
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": null,
                    "last_name": null,
                    "date_of_birth": null,
                    "profile_picture": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T14:21:26.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                },
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T14:21:26.000000Z",
                    "verified": 0
                }
            },
            "token": "1|zUPBvm9yIkNytIrVCKwuy1Cfk1cK3BvPc8haSpRU"
        }
        // Customer Register Ends
        // Customer Login Start
        let customer_request_login = {
            "account": "09000000000",
            "password": "123456789",
        }
        let customer_response_login = {
            "message": "Successfully login.",
            "user": {
                "id": 1,
                "email": "email@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-06T14:21:26.000000Z",
                "updated_at": "2021-10-06T14:21:26.000000Z",
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T14:21:26.000000Z",
                    "verified": 0
                },
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": null,
                    "last_name": null,
                    "date_of_birth": null,
                    "profile_picture": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T14:21:26.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                }
            },
            "token": "2|pBjmyFdaPCLaCuRAHcG6RFNaH7ZtIvnktriV2Uy4"
        }
        // Customer Login Ends
        // Customer Profile Starts
        let customer_response_profile = {
            "message": "Customer profile.",
            "user": {
                "id": 1,
                "email": "email@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-06T14:21:26.000000Z",
                "updated_at": "2021-10-06T14:21:26.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": null,
                    "last_name": null,
                    "date_of_birth": null,
                    "profile_picture": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T14:21:26.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                },
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T14:21:26.000000Z",
                    "verified": 0
                }
            }
        }
        // Customer Profile Ends
        // Customer Profile Update Starts
        let customer_request_profileUpdate = {
            "first_name" : "customerFirstName" ,
            "last_name" : "customerLastName" ,
            "date_of_birth" : "2021-12-30" ,
            "profile_picture" : "(image_type)" 
        }

        let customer_response_profileUpdate = {
            "message": "Profile updated.",
            "user": {
                "id": 1,
                "email": "email@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-06T14:21:26.000000Z",
                "updated_at": "2021-10-06T14:21:26.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "customerFirstName",
                    "last_name": "customerLastName",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T15:36:05.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                },
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T15:36:05.000000Z",
                    "verified": 1
                }
            }
        }
        // Customer Profile Update Ends
        // Customer Create Order Start
        let customer_request_createOrder = {
            "p_address": "sampleAddress",
            "p_lat": "9.5",
            "p_long": "9.5",
            "p_time": "00:00:00",
            "p_date": "2021/09/17",
            "total_mileage": "1",
            "total_amount": "1",
            "vehicle_id" : "1",
            "area_id" : "1",
            "dropoffs": [
                {
                    "latitude": "9.5",
                    "longitude": "9.5",
                    "address": "sampleadd",
                    "name": "samplename",
                    "contact": "samplecontact",
                    "instruction" : "sampleInstruction",
                    "mileage": "1",
                    "landmark": "samplelandmark"
                }
            ]
        }
        let customer_response_createOrder = {
            "message": "Order created.",
            "order": {
                "customer_id": 1,
                "order_status_id": 1,
                "total_mileage": 1,
                "total_amount": 1,
                "payment_method_id": 2,
                "area_id": 1,
                "vehicle_id": 1,
                "updated_at": "2021-09-30T14:38:21.000000Z",
                "created_at": "2021-09-30T14:38:21.000000Z",
                "id": 2,
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-09-30T08:09:02.000000Z",
                    "updated_at": "2021-09-30T08:09:02.000000Z",
                    "user": {
                        "id": 1,
                        "email": "email@email.com",
                        "mobile_number": "09275652944",
                        "email_verified_at": null,
                        "created_at": "2021-09-30T08:09:02.000000Z",
                        "updated_at": "2021-09-30T08:09:02.000000Z",
                        "user_info": {
                            "id": 1,
                            "user_id": 1,
                            "first_name": "firstNames",
                            "last_name": "lastNames",
                            "date_of_birth": "1990-07-20",
                            "profile_picture": null,
                            "created_at": "2021-09-30T08:09:02.000000Z",
                            "updated_at": "2021-09-30T08:09:02.000000Z"
                        }
                    }
                },
                "order_status": {
                    "id": 1,
                    "status": "Ordered",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "payment_method": {
                    "id": 2,
                    "method": "Cash",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "pickup_info": {
                    "id": 2,
                    "order_id": 2,
                    "address": "sampleAddress",
                    "longitude": "9.500000000000000",
                    "latitude": "9.500000000000000",
                    "time": "00:00:00",
                    "date": "2021-09-17",
                    "created_at": "2021-09-30T14:38:21.000000Z",
                    "updated_at": "2021-09-30T14:38:21.000000Z"
                },
                "dropoff_locations": [
                    {
                        "id": 2,
                        "order_id": 2,
                        "longitude": "9.500000000000000",
                        "latitude": "9.500000000000000",
                        "name": "samplename",
                        "contact": "samplecontact",
                        "address": "sampleadd",
                        "instruction": "sampleInstruction",
                        "item_type_id": 7,
                        "created_at": "2021-09-30T14:38:21.000000Z",
                        "updated_at": "2021-09-30T14:38:21.000000Z",
                        "mileage": 1,
                        "landmark": "samplelandmark",
                        "item_type": {
                            "id": 7,
                            "type": "Others",
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z"
                        }
                    }
                ],
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 1,
                        "vehicle_id": 1,
                        "length_ft": 1.6,
                        "width_ft": 1.25,
                        "height_ft": 1.6,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 1,
                            "vehicle_id": 1,
                            "area_id": 1,
                            "base_fair": 15,
                            "charge_per_km": 8,
                            "per_add_stop": 30,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                }
            }
        }
        // Customer Create Order Ends
        // Customer Get Orders Starts
        let customer_response_getOrderOngoing = {
            "message": "Ongoing orders.",
            "total_orders": 1,
            "orders": [{
                "id": 1,
                "driver_id": null,
                "completed_datetime": null,
                "order_status_id": 1,
                "total_mileage": 1,
                "instruction": null,
                "payment_method_id": 2,
                "total_amount": 1,
                "total_paid": 0,
                "total_due": 0,
                "holiday": 0,
                "high_demand": 0,
                "created_at": "2021-09-30T09:06:09.000000Z",
                "updated_at": "2021-09-30T09:06:09.000000Z",
                "area_id": 1,
                "customer_id": 1,
                "vehicle_id": 1,
                "order_status": {
                    "id": 1,
                    "status": "Ordered",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 1,
                        "vehicle_id": 1,
                        "length_ft": 1.6,
                        "width_ft": 1.25,
                        "height_ft": 1.6,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    }
                },
                "area": {
                    "id": 1,
                    "description": "cebu",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "pickup_info": {
                    "id": 1,
                    "order_id": 1,
                    "address": "sampleAddress",
                    "longitude": "9.500000000000000",
                    "latitude": "9.500000000000000",
                    "time": "00:00:00",
                    "date": "2021-09-17",
                    "created_at": "2021-09-30T09:06:09.000000Z",
                    "updated_at": "2021-09-30T09:06:09.000000Z"
                },
                "dropoff_locations": [{
                    "id": 1,
                    "order_id": 1,
                    "longitude": "9.500000000000000",
                    "latitude": "9.500000000000000",
                    "name": "samplename",
                    "contact": "samplecontact",
                    "address": "sampleadd",
                    "instruction": "sampleInstruction",
                    "item_type_id": 7,
                    "created_at": "2021-09-30T09:06:09.000000Z",
                    "updated_at": "2021-09-30T09:06:09.000000Z",
                    "mileage": 1,
                    "landmark": "samplelandmark",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    }
                }]
            }]
        }
        // Customer Get Orders Ends
        // Customer Logout Starts
        let customer_response_logout = {
            "message": "Logged out.",
        }
        // Customer Logout Ends
        // Driver Mobile OTP Starts
        let driver_request_OTP = {
            "mobile_number": "09000000001",
        }
        let driver_response_OTP = {
            "message": "OTP created.",
            "data": {
                "otp": 6526,
                "mobile_number": "09000000001",
                "updated_at": "2021-10-06T14:57:21.000000Z",
                "created_at": "2021-10-06T14:57:21.000000Z",
                "id": 2
            }
        }
        // Driver Mobile OTP Ends
        // Driver Mobile OTP Verify Starts
        let driver_request_otpVerify = {
            "otp" : "6526",
            "mobile_number" : "09000000001",
            "id" : "2"
        }
        let driver_response_otpVerify = {
            "message": "OTP verified.",
            "data": {
                "id": 2,
                "mobile_number": "09000000001",
                "otp": "6526",
                "created_at": "2021-10-06T15:11:25.000000Z",
                "updated_at": "2021-10-06T15:11:25.000000Z"
            }
        }
        // Driver Mobile OTP Verify Ends
        // Driver Register Starts
        let driver_request_Register = {
            "mobile_number": "+632222222223",
            "email": "email@gmail.com",
            "password": "123456789",
            "password_confirmation" : "123456789"
        }
        let driver_response_Register = {
            "message": "User created.",
            "user": {
                "mobile_number": "09000000001",
                "email": "driver@gmail.com",
                "updated_at": "2021-10-06T15:20:15.000000Z",
                "created_at": "2021-10-06T15:20:15.000000Z",
                "id": 2,
                "user_info": {
                    "id": 2,
                    "user_id": 2,
                    "first_name": null,
                    "last_name": null,
                    "date_of_birth": null,
                    "profile_picture": null,
                    "created_at": "2021-10-06T15:20:15.000000Z",
                    "updated_at": "2021-10-06T15:20:15.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                },
                "driver": {
                    "id": 2,
                    "user_id": 2,
                    "city": null,
                    "driving_license_number": null,
                    "driving_license_expiry": null,
                    "driver_license_image": null,
                    "vehicle_brand": null,
                    "vehicle_model": null,
                    "vehicle_manufacture_year": null,
                    "license_plate_number": null,
                    "nbi_clearance": null,
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "driver_rating": null,
                    "status": 0,
                    "number_of_fans": null,
                    "vax_certificate": null,
                    "created_at": "2021-10-06T15:20:15.000000Z",
                    "updated_at": "2021-10-06T15:20:15.000000Z",
                    "verification_status_id": 1,
                    "vehicle_id": null,
                    "verification_status": {
                        "id": 1,
                        "status": "Profile",
                        "created_at": "2021-10-06T14:03:59.000000Z",
                        "updated_at": "2021-10-06T14:03:59.000000Z"
                    }
                }
            },
            "token": "3|t7YEZSqbft3wB8NkvCbNueA4mXnDVGOYOgByWMVq"
        }
        // Driver Register Ends
        // Driver Login Starts
        let driver_request_Login = {
            "account": "09000000000",
            "password": "123456789"
        }
        let driver_response_Login = {
            "message": "Successfully login.",
            "user": {
                "id": 2,
                "email": "email@gmail.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-09-30T11:19:29.000000Z",
                "updated_at": "2021-09-30T11:19:29.000000Z",
                "driver": {
                    "id": 1,
                    "user_id": 2,
                    "city": "cityName",
                    "driving_license_number": null,
                    "driving_license_expiry": null,
                    "driver_license_image": null,
                    "vehicle_brand": null,
                    "vehicle_model": null,
                    "vehicle_manufacture_year": null,
                    "license_plate_number": null,
                    "nbi_clearance": null,
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "driver_rating": null,
                    "status": 0,
                    "number_of_fans": null,
                    "vax_certificate": null,
                    "created_at": "2021-09-30T11:19:29.000000Z",
                    "updated_at": "2021-09-30T11:19:29.000000Z",
                    "verification_status_id": 8,
                    "vehicle_id": 1,
                    "verification_status": {
                        "id": 8,
                        "status": "Approval",
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle": {
                        "id": 1,
                        "type": "Motorcycle",
                        "max_weight_kg": 20,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z",
                        "vehicle_dimension": {
                            "id": 1,
                            "vehicle_id": 1,
                            "length_ft": 1.6,
                            "width_ft": 1.25,
                            "height_ft": 1.6,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z"
                        },
                        "vehicle_rates": [{
                            "id": 1,
                            "vehicle_id": 1,
                            "area_id": 1,
                            "base_fair": 15,
                            "charge_per_km": 8,
                            "per_add_stop": 30,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }]
                    }
                },
                "user_info": {
                    "id": 2,
                    "user_id": 2,
                    "first_name": "firstName",
                    "last_name": "lastName",
                    "date_of_birth": "1990-01-01",
                    "profile_picture": null,
                    "created_at": "2021-09-30T11:19:29.000000Z",
                    "updated_at": "2021-09-30T11:19:29.000000Z"
                }
            },
            "token": "7|fgOvmZ509NLC8pZkgPfzi8QmjUA2po6q6gIVpYaI"
        }
        // Driver Login Ends
        // Driver Profile Starts
        let driver_response_profile = {
            "message": "Driver profile.",
            "user": {
                "id": 1,
                "email": "email@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-06T14:21:26.000000Z",
                "updated_at": "2021-10-06T14:21:26.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "customerFirstName",
                    "last_name": "customerLastName",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": null,
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T15:36:05.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                },
                "driver": {
                    "id": 1,
                    "user_id": 1,
                    "city": null,
                    "driving_license_number": null,
                    "driving_license_expiry": null,
                    "driver_license_image": null,
                    "vehicle_brand": null,
                    "vehicle_model": null,
                    "vehicle_manufacture_year": null,
                    "license_plate_number": null,
                    "nbi_clearance": null,
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "driver_rating": null,
                    "status": 0,
                    "number_of_fans": null,
                    "vax_certificate": null,
                    "created_at": "2021-10-06T15:02:37.000000Z",
                    "updated_at": "2021-10-06T15:02:37.000000Z",
                    "verification_status_id": 1,
                    "vehicle_id": null,
                    "verification_status": {
                        "id": 1,
                        "status": "Profile",
                        "created_at": "2021-10-06T14:03:59.000000Z",
                        "updated_at": "2021-10-06T14:03:59.000000Z"
                    }
                }
            }
        }
        // Driver Profile Ends
        let driver_request_profileUpdate = {
            "first_name" : "driverFirstName",
            "last_name" : "driverLastName",
            "date_of_birth" : "2021-12-30",
            "profile_picture" : "(ImageType)",
            "middle_name" : "driverMiddleName",
            "driving_license_expiry" : "2021-12-30",
            "vehicle_id" : "1",
            "driver_license_image" : "(ImageType)",
            "nbi_clearance" : "(ImageType)",
            "deed_of_sale" : "(ImageType)",
            "vehicle_registration" : "(ImageType)",
            "vehicle_front" : "(ImageType)",
            "vehicle_side" : "(ImageType)",
            "vehicle_back" : "(ImageType)",
            "vax_certificate" : "(ImageType)"
        }
        let driver_response_profileUpdate = {
            "message": "Profile updated.",
            "user": {
                "id": 1,
                "email": "email@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-06T14:21:26.000000Z",
                "updated_at": "2021-10-06T14:21:26.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "driverFirstName",
                    "last_name": "driverLastName",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": "FB_IMG_1621079531007_1633536606.jpg",
                    "created_at": "2021-10-06T14:21:26.000000Z",
                    "updated_at": "2021-10-06T16:10:06.000000Z",
                    "middle_name": "driverMiddleName",
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                },
                "driver": {
                    "id": 1,
                    "user_id": 1,
                    "city": null,
                    "driving_license_number": null,
                    "driving_license_expiry": "2021-12-30",
                    "driver_license_image": null,
                    "vehicle_brand": null,
                    "vehicle_model": null,
                    "vehicle_manufacture_year": null,
                    "license_plate_number": null,
                    "nbi_clearance": null,
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "driver_rating": null,
                    "status": 0,
                    "number_of_fans": null,
                    "vax_certificate": null,
                    "created_at": "2021-10-06T15:02:37.000000Z",
                    "updated_at": "2021-10-06T16:10:06.000000Z",
                    "verification_status_id": 1,
                    "vehicle_id": 1,
                    "verification_status": {
                        "id": 1,
                        "status": "Profile",
                        "created_at": "2021-10-06T14:03:59.000000Z",
                        "updated_at": "2021-10-06T14:03:59.000000Z"
                    }
                }
            }
        }
        // Driver Profile Update Starts
        // Driver Profile Update Ends
        // Driver Get Order Available Starts
        let driver_response_getOrderAvailable = {
            "message": "Available orders.",
            "total_orders": 1,
            "orders": [{
                "id": 1,
                "driver_id": null,
                "completed_datetime": null,
                "order_status_id": 1,
                "total_mileage": 1,
                "instruction": null,
                "payment_method_id": 2,
                "total_amount": 1,
                "total_paid": 0,
                "total_due": 0,
                "holiday": 0,
                "high_demand": 0,
                "created_at": "2021-09-30T09:06:09.000000Z",
                "updated_at": "2021-09-30T09:06:09.000000Z",
                "area_id": 1,
                "customer_id": 1,
                "vehicle_id": 1,
                "order_status": {
                    "id": 1,
                    "status": "Ordered",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 1,
                        "vehicle_id": 1,
                        "length_ft": 1.6,
                        "width_ft": 1.25,
                        "height_ft": 1.6,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    }
                },
                "area": {
                    "id": 1,
                    "description": "cebu",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "pickup_info": {
                    "id": 1,
                    "order_id": 1,
                    "address": "sampleAddress",
                    "longitude": "9.500000000000000",
                    "latitude": "9.500000000000000",
                    "time": "00:00:00",
                    "date": "2021-09-17",
                    "created_at": "2021-09-30T09:06:09.000000Z",
                    "updated_at": "2021-09-30T09:06:09.000000Z"
                },
                "dropoff_locations": [{
                    "id": 1,
                    "order_id": 1,
                    "longitude": "9.500000000000000",
                    "latitude": "9.500000000000000",
                    "name": "samplename",
                    "contact": "samplecontact",
                    "address": "sampleadd",
                    "instruction": "sampleInstruction",
                    "item_type_id": 7,
                    "created_at": "2021-09-30T09:06:09.000000Z",
                    "updated_at": "2021-09-30T09:06:09.000000Z",
                    "mileage": 1,
                    "landmark": "samplelandmark",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    }
                }]
            }]
        }
        // Driver Get Available Orders Ends
        // Driver Get Ongoing Order Starts
        let driver_response_ongoingOrder = {
            "message": "Ongoing orders.",
            "total_orders": 1,
            "orders": [
                {
                    "id": 1,
                    "driver_id": 1,
                    "completed_datetime": null,
                    "order_status_id": 2,
                    "total_mileage": 1,
                    "instruction": null,
                    "payment_method_id": 2,
                    "total_amount": 1,
                    "total_paid": 0,
                    "total_due": 0,
                    "holiday": 0,
                    "high_demand": 0,
                    "created_at": "2021-10-07T12:55:51.000000Z",
                    "updated_at": "2021-10-07T12:57:27.000000Z",
                    "area_id": 1,
                    "customer_id": 1,
                    "vehicle_id": 1,
                    "order_status": {
                        "id": 2,
                        "status": "Assigned",
                        "created_at": "2021-10-06T14:03:59.000000Z",
                        "updated_at": "2021-10-06T14:03:59.000000Z"
                    },
                    "area": {
                        "id": 1,
                        "description": "cebu",
                        "created_at": "2021-10-06T14:03:59.000000Z",
                        "updated_at": "2021-10-06T14:03:59.000000Z"
                    },
                    "pickup_info": {
                        "id": 1,
                        "order_id": 1,
                        "address": "Addres",
                        "longitude": "9.500000000000000",
                        "latitude": "9.500000000000000",
                        "time": "00:00:00",
                        "date": "2021-09-17",
                        "created_at": "2021-10-07T12:55:51.000000Z",
                        "updated_at": "2021-10-07T12:55:51.000000Z"
                    },
                    "dropoff_locations": [
                        {
                            "id": 1,
                            "order_id": 1,
                            "longitude": "9.500000000000000",
                            "latitude": "9.500000000000000",
                            "name": "samplename",
                            "contact": "samplecontact",
                            "address": "sampleadd",
                            "instruction": "sampleInstruction",
                            "item_type_id": 7,
                            "created_at": "2021-10-07T12:55:51.000000Z",
                            "updated_at": "2021-10-07T12:55:51.000000Z",
                            "mileage": 1,
                            "landmark": "samplelandmark",
                            "item_type": {
                                "id": 7,
                                "type": "Others",
                                "created_at": "2021-10-06T14:03:59.000000Z",
                                "updated_at": "2021-10-06T14:03:59.000000Z"
                            }
                        }
                    ],
                    "customer": {
                        "id": 1,
                        "user_id": 1,
                        "customer_rating": null,
                        "created_at": "2021-10-06T14:21:26.000000Z",
                        "updated_at": "2021-10-06T15:36:05.000000Z",
                        "verified": 1,
                        "user": {
                            "id": 1,
                            "email": "email@email.com",
                            "mobile_number": "09000000000",
                            "email_verified_at": null,
                            "created_at": "2021-10-06T14:21:26.000000Z",
                            "updated_at": "2021-10-06T14:21:26.000000Z",
                            "user_info": {
                                "id": 1,
                                "user_id": 1,
                                "first_name": "driverFirstName",
                                "last_name": "driverLastName",
                                "date_of_birth": "2021-12-30",
                                "profile_picture": "FB_IMG_1621079531007_1633536717.jpg",
                                "created_at": "2021-10-06T14:21:26.000000Z",
                                "updated_at": "2021-10-06T16:11:57.000000Z",
                                "middle_name": "driverMiddleName",
                                "country": null,
                                "province": null,
                                "city_municipality": null,
                                "postal_code": null,
                                "barangay": null,
                                "address": null
                            }
                        }
                    }
                },
            ]
        }
        // Driver Get Ongoing Order Ends
        // Driver Assigned Order Starts
        let driver_response_assignedOrder = {
            "message": "Order assigned.",
            "order": {
                "id": 4,
                "driver_id": 1,
                "completed_datetime": null,
                "order_status_id": 2,
                "total_mileage": 1,
                "instruction": null,
                "payment_method_id": 2,
                "total_amount": 1,
                "total_paid": 0,
                "total_due": 0,
                "holiday": 0,
                "high_demand": 0,
                "created_at": "2021-10-04T13:09:27.000000Z",
                "updated_at": "2021-10-04T13:13:00.000000Z",
                "area_id": 1,
                "customer_id": 1,
                "vehicle_id": 1,
                "driver": null,
                "order_status": {
                    "id": 2,
                    "status": "Assigned",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "payment_method": {
                    "id": 2,
                    "method": "Cash",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "area": {
                    "id": 1,
                    "description": "cebu",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-09-30T08:09:02.000000Z",
                    "updated_at": "2021-09-30T08:09:02.000000Z",
                    "user": {
                        "id": 1,
                        "email": "email@email.com",
                        "mobile_number": "09275652944",
                        "email_verified_at": null,
                        "created_at": "2021-09-30T08:09:02.000000Z",
                        "updated_at": "2021-09-30T08:09:02.000000Z",
                        "user_info": {
                            "id": 1,
                            "user_id": 1,
                            "first_name": "firstNames",
                            "last_name": "lastNames",
                            "date_of_birth": "1990-07-20",
                            "profile_picture": null,
                            "created_at": "2021-09-30T08:09:02.000000Z",
                            "updated_at": "2021-09-30T08:09:02.000000Z"
                        }
                    }
                },
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "dropoff_locations": [
                    {
                        "id": 4,
                        "order_id": 4,
                        "longitude": "9.500000000000000",
                        "latitude": "9.500000000000000",
                        "name": "samplename",
                        "contact": "samplecontact",
                        "address": "sampleadd",
                        "instruction": "sampleInstruction",
                        "item_type_id": 7,
                        "created_at": "2021-10-04T13:09:27.000000Z",
                        "updated_at": "2021-10-04T13:09:27.000000Z",
                        "mileage": 1,
                        "landmark": "samplelandmark"
                    }
                ]
            }
        }
        // Driver Assigned Order Ends
        // Driver Update Order Starts
        let driver_request_updateOrder = {
            "order_status_id" : "12",
            "driver_id" : "1"
        }
        let driver_response_updateOrder = {
            "message": "Order updated.",
            "order": {
                "id": 2,
                "driver_id": 1,
                "completed_datetime": null,
                "order_status_id": "12",
                "total_mileage": 1,
                "instruction": null,
                "payment_method_id": 2,
                "total_amount": 1,
                "total_paid": 0,
                "total_due": 0,
                "holiday": 0,
                "high_demand": 0,
                "created_at": "2021-09-30T14:38:21.000000Z",
                "updated_at": "2021-10-04T12:57:51.000000Z",
                "area_id": 1,
                "customer_id": 1,
                "vehicle_id": 1,
                "order_status": {
                    "id": 12,
                    "status": "Cancelled",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "payment_method": {
                    "id": 2,
                    "method": "Cash",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "area": {
                    "id": 1,
                    "description": "cebu",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-09-30T08:09:02.000000Z",
                    "updated_at": "2021-09-30T08:09:02.000000Z",
                    "user": {
                        "id": 1,
                        "email": "email@email.com",
                        "mobile_number": "09275652944",
                        "email_verified_at": null,
                        "created_at": "2021-09-30T08:09:02.000000Z",
                        "updated_at": "2021-09-30T08:09:02.000000Z",
                        "user_info": {
                            "id": 1,
                            "user_id": 1,
                            "first_name": "firstNames",
                            "last_name": "lastNames",
                            "date_of_birth": "1990-07-20",
                            "profile_picture": null,
                            "created_at": "2021-09-30T08:09:02.000000Z",
                            "updated_at": "2021-09-30T08:09:02.000000Z"
                        }
                    }
                },
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "dropoff_locations": [
                    {
                        "id": 2,
                        "order_id": 2,
                        "longitude": "9.500000000000000",
                        "latitude": "9.500000000000000",
                        "name": "samplename",
                        "contact": "samplecontact",
                        "address": "sampleadd",
                        "instruction": "sampleInstruction",
                        "item_type_id": 7,
                        "created_at": "2021-09-30T14:38:21.000000Z",
                        "updated_at": "2021-09-30T14:38:21.000000Z",
                        "mileage": 1,
                        "landmark": "samplelandmark"
                    }
                ]
            }
        }
        // Driver Update Orders Ends
        // Driver Create pick up item image starts
        let driver_request_pickupImage = {
            "driver_id" : "1",
            "image" : "(image type)",
            "dropoff_location_id" : "1"
        }
        let driver_response_pickupImage = {
            "message": "Item image created.",
            "order": {
                "id": 2,
                "driver_id": 1,
                "completed_datetime": null,
                "order_status_id": 12,
                "total_mileage": 1,
                "instruction": null,
                "payment_method_id": 2,
                "total_amount": 1,
                "total_paid": 0,
                "total_due": 0,
                "holiday": 0,
                "high_demand": 0,
                "created_at": "2021-09-30T14:38:21.000000Z",
                "updated_at": "2021-10-04T12:57:51.000000Z",
                "area_id": 1,
                "customer_id": 1,
                "vehicle_id": 1,
                "dropoff_locations": [
                    {
                        "id": 2,
                        "order_id": 2,
                        "longitude": "9.500000000000000",
                        "latitude": "9.500000000000000",
                        "name": "samplename",
                        "contact": "samplecontact",
                        "address": "sampleadd",
                        "instruction": "sampleInstruction",
                        "item_type_id": 7,
                        "created_at": "2021-09-30T14:38:21.000000Z",
                        "updated_at": "2021-09-30T14:38:21.000000Z",
                        "mileage": 1,
                        "landmark": "samplelandmark"
                    }
                ],
                "pickup_item_images": [],
                "order_status": {
                    "id": 12,
                    "status": "Cancelled",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "payment_method": {
                    "id": 2,
                    "method": "Cash",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "area": {
                    "id": 1,
                    "description": "cebu",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "customer": {
                    "id": 1,
                    "user_id": 1,
                    "customer_rating": null,
                    "created_at": "2021-09-30T08:09:02.000000Z",
                    "updated_at": "2021-09-30T08:09:02.000000Z",
                    "user": {
                        "id": 1,
                        "email": "email@email.com",
                        "mobile_number": "09275652944",
                        "email_verified_at": null,
                        "created_at": "2021-09-30T08:09:02.000000Z",
                        "updated_at": "2021-09-30T08:09:02.000000Z",
                        "user_info": {
                            "id": 1,
                            "user_id": 1,
                            "first_name": "firstNames",
                            "last_name": "lastNames",
                            "date_of_birth": "1990-07-20",
                            "profile_picture": null,
                            "created_at": "2021-09-30T08:09:02.000000Z",
                            "updated_at": "2021-09-30T08:09:02.000000Z"
                        }
                    }
                },
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                }
            }
        }
        // Driver Create pick up item image ends
        // Driver Logout Starts
        let driver_response_Logout = {
            "message": "Logged out."
        }
        // Driver Logout Ends
        // Management Login Starts
        let management_request_Login = {
            "account": "09999999999",
            "password": "passwordnako"
        }
        let management_response_Login = {
            "message": "Successfully login.",
            "user": {
                "id": 3,
                "email": "management@gmail.com",
                "mobile_number": "09999999999",
                "email_verified_at": null,
                "created_at": "2021-09-30T12:39:23.000000Z",
                "updated_at": "2021-09-30T12:39:23.000000Z",
                "management": {
                    "id": 1,
                    "user_id": 3,
                    "created_at": "2021-09-30T12:39:23.000000Z",
                    "updated_at": "2021-09-30T12:39:23.000000Z",
                    "management_role_id": 1,
                    "management_role": {
                        "id": 1,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z",
                        "role": "admin"
                    }
                },
                "user_info": {
                    "id": 3,
                    "user_id": 3,
                    "first_name": "firstNameManagement",
                    "last_name": "lastNameManagement",
                    "date_of_birth": "1990-01-01",
                    "profile_picture": null,
                    "created_at": "2021-09-30T12:39:23.000000Z",
                    "updated_at": "2021-09-30T12:39:23.000000Z"
                }
            },
            "token": "12|Pb94DrhkfYt909MBffqnqczE8Zcl4jI83UlfbSO7"
        }
        // Management Login Ends
        // Management Driver List Starts
        let management_driversList = {
            "message": "Driver Lists",
            "drivers": [
                {
                    "id": 1,
                    "user_id": 2,
                    "city": "cityName",
                    "driving_license_number": null,
                    "driving_license_expiry": null,
                    "driver_license_image": null,
                    "vehicle_brand": null,
                    "vehicle_model": null,
                    "vehicle_manufacture_year": null,
                    "license_plate_number": null,
                    "nbi_clearance": null,
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "driver_rating": null,
                    "status": 0,
                    "number_of_fans": null,
                    "vax_certificate": null,
                    "created_at": "2021-09-30T11:19:29.000000Z",
                    "updated_at": "2021-09-30T11:19:29.000000Z",
                    "verification_status_id": 8,
                    "vehicle_id": 1,
                    "verification_status": {
                        "id": 8,
                        "status": "Approval",
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "user": {
                        "id": 2,
                        "email": "email@gmail.com",
                        "mobile_number": "09000000000",
                        "email_verified_at": null,
                        "created_at": "2021-09-30T11:19:29.000000Z",
                        "updated_at": "2021-09-30T11:19:29.000000Z",
                        "user_info": {
                            "id": 2,
                            "user_id": 2,
                            "first_name": "firstName",
                            "last_name": "lastName",
                            "date_of_birth": "1990-01-01",
                            "profile_picture": null,
                            "created_at": "2021-09-30T11:19:29.000000Z",
                            "updated_at": "2021-09-30T11:19:29.000000Z"
                        }
                    },
                    "vehicle": {
                        "id": 1,
                        "type": "Motorcycle",
                        "max_weight_kg": 20,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z",
                        "vehicle_dimension": {
                            "id": 1,
                            "vehicle_id": 1,
                            "length_ft": 1.6,
                            "width_ft": 1.25,
                            "height_ft": 1.6,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z"
                        },
                        "vehicle_rates": [
                            {
                                "id": 1,
                                "vehicle_id": 1,
                                "area_id": 1,
                                "base_fair": 15,
                                "charge_per_km": 8,
                                "per_add_stop": 30,
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z",
                                "area": {
                                    "id": 1,
                                    "description": "cebu",
                                    "created_at": "2021-09-30T07:45:38.000000Z",
                                    "updated_at": "2021-09-30T07:45:38.000000Z"
                                }
                            }
                        ]
                    }
                }
            ]
        }
        // Management Driver List Ends
        // Management Driver Show by ID Starts
        let management_driverShowId = {
            "message": "Driver found.",
            "driver": {
                "id": 1,
                "user_id": 2,
                "city": "cityName",
                "driving_license_number": null,
                "driving_license_expiry": null,
                "driver_license_image": null,
                "vehicle_brand": null,
                "vehicle_model": null,
                "vehicle_manufacture_year": null,
                "license_plate_number": null,
                "nbi_clearance": null,
                "deed_of_sale": null,
                "vehicle_registration": null,
                "vehicle_front": null,
                "vehicle_side": null,
                "vehicle_back": null,
                "driver_rating": null,
                "status": 0,
                "number_of_fans": null,
                "vax_certificate": null,
                "created_at": "2021-09-30T11:19:29.000000Z",
                "updated_at": "2021-09-30T11:19:29.000000Z",
                "verification_status_id": 8,
                "vehicle_id": 1,
                "verification_status": {
                    "id": 8,
                    "status": "Approval",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "user": {
                    "id": 2,
                    "email": "email@gmail.com",
                    "mobile_number": "09000000000",
                    "email_verified_at": null,
                    "created_at": "2021-09-30T11:19:29.000000Z",
                    "updated_at": "2021-09-30T11:19:29.000000Z",
                    "user_info": {
                        "id": 2,
                        "user_id": 2,
                        "first_name": "firstName",
                        "last_name": "lastName",
                        "date_of_birth": "1990-01-01",
                        "profile_picture": null,
                        "created_at": "2021-09-30T11:19:29.000000Z",
                        "updated_at": "2021-09-30T11:19:29.000000Z"
                    }
                },
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 1,
                        "vehicle_id": 1,
                        "length_ft": 1.6,
                        "width_ft": 1.25,
                        "height_ft": 1.6,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 1,
                            "vehicle_id": 1,
                            "area_id": 1,
                            "base_fair": 15,
                            "charge_per_km": 8,
                            "per_add_stop": 30,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                }
            }
        }
        // Management Driver Show by ID Ends
        // Management Driver Verification Update Starts
        let management_request_driverVerificationUpdate = {
            "verification_status_id": "9"
        }
        let management_response_driverVerificationUpdate = {
            "message": "Verification status successfully updated.",
            "driver": {
                "id": 1,
                "user_id": 2,
                "city": "cityName",
                "driving_license_number": null,
                "driving_license_expiry": null,
                "driver_license_image": null,
                "vehicle_brand": null,
                "vehicle_model": null,
                "vehicle_manufacture_year": null,
                "license_plate_number": null,
                "nbi_clearance": null,
                "deed_of_sale": null,
                "vehicle_registration": null,
                "vehicle_front": null,
                "vehicle_side": null,
                "vehicle_back": null,
                "driver_rating": null,
                "status": 0,
                "number_of_fans": null,
                "vax_certificate": null,
                "created_at": "2021-09-30T11:19:29.000000Z",
                "updated_at": "2021-09-30T13:22:26.000000Z",
                "verification_status_id": "9",
                "vehicle_id": 1,
                "verification_status": {
                    "id": 9,
                    "status": "Verified",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                },
                "user": {
                    "id": 2,
                    "email": "email@gmail.com",
                    "mobile_number": "09000000000",
                    "email_verified_at": null,
                    "created_at": "2021-09-30T11:19:29.000000Z",
                    "updated_at": "2021-09-30T11:19:29.000000Z",
                    "user_info": {
                        "id": 2,
                        "user_id": 2,
                        "first_name": "firstName",
                        "last_name": "lastName",
                        "date_of_birth": "1990-01-01",
                        "profile_picture": null,
                        "created_at": "2021-09-30T11:19:29.000000Z",
                        "updated_at": "2021-09-30T11:19:29.000000Z"
                    }
                },
                "vehicle": {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 1,
                        "vehicle_id": 1,
                        "length_ft": 1.6,
                        "width_ft": 1.25,
                        "height_ft": 1.6,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 1,
                            "vehicle_id": 1,
                            "area_id": 1,
                            "base_fair": 15,
                            "charge_per_km": 8,
                            "per_add_stop": 30,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                }
            }
        }
        // Management Driver Verification Update Ends
        // Management Logout Starts
        let management_request_Logout = {
            "authentication": "Bearer <12|Pb94DrhkfYt909MBffqnqczE8Zcl4jI83UlfbSO7>"
        }
        let management_response_Logout = {
            "message": "Logged out."
        }
        // Management Logout Ends
        // Dropdown VehicleType Starts
        let dropdown_vehicleType = {
            "message": "Vehicle Lists",
            "vehicle": [
                {
                    "id": 1,
                    "type": "Motorcycle",
                    "max_weight_kg": 20,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 1,
                        "vehicle_id": 1,
                        "length_ft": 1.6,
                        "width_ft": 1.25,
                        "height_ft": 1.6,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 1,
                            "vehicle_id": 1,
                            "area_id": 1,
                            "base_fair": 15,
                            "charge_per_km": 8,
                            "per_add_stop": 30,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                },
                {
                    "id": 2,
                    "type": "200 kg Sedan",
                    "max_weight_kg": 200,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 2,
                        "vehicle_id": 2,
                        "length_ft": 3.2,
                        "width_ft": 1.9,
                        "height_ft": 2.3,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 2,
                            "vehicle_id": 2,
                            "area_id": 1,
                            "base_fair": 120,
                            "charge_per_km": 18,
                            "per_add_stop": 45,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                },
                {
                    "id": 3,
                    "type": "300 kg MPV",
                    "max_weight_kg": 300,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 3,
                        "vehicle_id": 3,
                        "length_ft": 4,
                        "width_ft": 3.2,
                        "height_ft": 2.8,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 3,
                            "vehicle_id": 3,
                            "area_id": 1,
                            "base_fair": 145,
                            "charge_per_km": 20,
                            "per_add_stop": 60,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                },
                {
                    "id": 4,
                    "type": "600kg MPV",
                    "max_weight_kg": 600,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 4,
                        "vehicle_id": 4,
                        "length_ft": 7,
                        "width_ft": 4,
                        "height_ft": 3.5,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 4,
                            "vehicle_id": 4,
                            "area_id": 1,
                            "base_fair": 250,
                            "charge_per_km": 25,
                            "per_add_stop": 60,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                },
                {
                    "id": 5,
                    "type": "FB/L300",
                    "max_weight_kg": 1000,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_dimension": {
                        "id": 5,
                        "vehicle_id": 5,
                        "length_ft": 7,
                        "width_ft": 4,
                        "height_ft": 4,
                        "created_at": "2021-09-30T07:45:38.000000Z",
                        "updated_at": "2021-09-30T07:45:38.000000Z"
                    },
                    "vehicle_rates": [
                        {
                            "id": 5,
                            "vehicle_id": 5,
                            "area_id": 1,
                            "base_fair": 430,
                            "charge_per_km": 30,
                            "per_add_stop": 80,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "area": {
                                "id": 1,
                                "description": "cebu",
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z"
                            }
                        }
                    ]
                }
            ]
        }
        // Dropdown VehicleType Ends
        // Dropdown VehicleAreas Starts
        let dropdown_vehicleAreas = {
            "message": "Vehicle Areas",
            "areas": [
                {
                    "id": 1,
                    "description": "cebu",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "vehicle_rates": [
                        {
                            "id": 1,
                            "vehicle_id": 1,
                            "area_id": 1,
                            "base_fair": 15,
                            "charge_per_km": 8,
                            "per_add_stop": 30,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "vehicle": {
                                "id": 1,
                                "type": "Motorcycle",
                                "max_weight_kg": 20,
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z",
                                "vehicle_dimension": {
                                    "id": 1,
                                    "vehicle_id": 1,
                                    "length_ft": 1.6,
                                    "width_ft": 1.25,
                                    "height_ft": 1.6,
                                    "created_at": "2021-09-30T07:45:38.000000Z",
                                    "updated_at": "2021-09-30T07:45:38.000000Z"
                                }
                            }
                        },
                        {
                            "id": 2,
                            "vehicle_id": 2,
                            "area_id": 1,
                            "base_fair": 120,
                            "charge_per_km": 18,
                            "per_add_stop": 45,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "vehicle": {
                                "id": 2,
                                "type": "200 kg Sedan",
                                "max_weight_kg": 200,
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z",
                                "vehicle_dimension": {
                                    "id": 2,
                                    "vehicle_id": 2,
                                    "length_ft": 3.2,
                                    "width_ft": 1.9,
                                    "height_ft": 2.3,
                                    "created_at": "2021-09-30T07:45:38.000000Z",
                                    "updated_at": "2021-09-30T07:45:38.000000Z"
                                }
                            }
                        },
                        {
                            "id": 3,
                            "vehicle_id": 3,
                            "area_id": 1,
                            "base_fair": 145,
                            "charge_per_km": 20,
                            "per_add_stop": 60,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "vehicle": {
                                "id": 3,
                                "type": "300 kg MPV",
                                "max_weight_kg": 300,
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z",
                                "vehicle_dimension": {
                                    "id": 3,
                                    "vehicle_id": 3,
                                    "length_ft": 4,
                                    "width_ft": 3.2,
                                    "height_ft": 2.8,
                                    "created_at": "2021-09-30T07:45:38.000000Z",
                                    "updated_at": "2021-09-30T07:45:38.000000Z"
                                }
                            }
                        },
                        {
                            "id": 4,
                            "vehicle_id": 4,
                            "area_id": 1,
                            "base_fair": 250,
                            "charge_per_km": 25,
                            "per_add_stop": 60,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "vehicle": {
                                "id": 4,
                                "type": "600kg MPV",
                                "max_weight_kg": 600,
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z",
                                "vehicle_dimension": {
                                    "id": 4,
                                    "vehicle_id": 4,
                                    "length_ft": 7,
                                    "width_ft": 4,
                                    "height_ft": 3.5,
                                    "created_at": "2021-09-30T07:45:38.000000Z",
                                    "updated_at": "2021-09-30T07:45:38.000000Z"
                                }
                            }
                        },
                        {
                            "id": 5,
                            "vehicle_id": 5,
                            "area_id": 1,
                            "base_fair": 430,
                            "charge_per_km": 30,
                            "per_add_stop": 80,
                            "created_at": "2021-09-30T07:45:38.000000Z",
                            "updated_at": "2021-09-30T07:45:38.000000Z",
                            "vehicle": {
                                "id": 5,
                                "type": "FB/L300",
                                "max_weight_kg": 1000,
                                "created_at": "2021-09-30T07:45:38.000000Z",
                                "updated_at": "2021-09-30T07:45:38.000000Z",
                                "vehicle_dimension": {
                                    "id": 5,
                                    "vehicle_id": 5,
                                    "length_ft": 7,
                                    "width_ft": 4,
                                    "height_ft": 4,
                                    "created_at": "2021-09-30T07:45:38.000000Z",
                                    "updated_at": "2021-09-30T07:45:38.000000Z"
                                }
                            }
                        }
                    ]
                }
            ]
        }
        // Dropdown VehicleAreas Ends
        // Dropdown MangementRole Starts
        let dropdown_ManagementRole = {
            "message": "List of Management Role",
            "total_management_roles": 1,
            "management_role": [
                {
                    "id": 1,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z",
                    "role": "admin"
                }
            ]
        }
        // Dropdown ManagementRole Ends
        // Customer Starts
        document.getElementById('customer_request_OTP').textContent = JSON.stringify(customer_request_OTP, undefined, 2);
        document.getElementById('customer_response_OTP').textContent = JSON.stringify(customer_response_OTP, undefined, 2);
        document.getElementById('customer_request_otpVerify').textContent = JSON.stringify(customer_request_otpVerify, undefined, 2);
        document.getElementById('customer_response_otpVerify').textContent = JSON.stringify(customer_response_otpVerify, undefined, 2);
        document.getElementById('customer_request_registration').textContent = JSON.stringify(customer_request_registration,
            undefined,
            2);
        document.getElementById('customer_response_registration ').textContent = JSON.stringify(
            customer_response_registration,
            undefined, 2);
        document.getElementById('customer_request_login').textContent = JSON.stringify(customer_request_login,
            undefined, 2);
        document.getElementById('customer_response_login').textContent = JSON.stringify(
            customer_response_login, undefined, 2);
        document.getElementById('customer_response_profile').textContent = JSON.stringify(customer_response_profile, undefined, 2);
        document.getElementById('customer_request_profileUpdate').textContent = JSON.stringify(customer_request_profileUpdate, undefined, 2);
        document.getElementById('customer_response_profileUpdate').textContent = JSON.stringify(customer_response_profileUpdate, undefined, 2);
        document.getElementById('customer_request_createOrder').textContent = JSON.stringify(customer_request_createOrder, undefined, 2);
        document.getElementById('customer_response_createOrder').textContent = JSON.stringify(customer_response_createOrder,
            undefined, 2);
        document.getElementById('customer_response_getOrderOngoing').textContent = JSON.stringify(customer_response_getOrderOngoing,
            undefined,
            2);
        document.getElementById('customer_response_logout').textContent = JSON.stringify(customer_response_logout,
            undefined, 2);
        // Customer Ends
        // Driver Starts
        document.getElementById('driver_request_OTP').textContent = JSON.stringify(driver_request_OTP, undefined, 2);
        document.getElementById('driver_response_OTP').textContent = JSON.stringify(driver_response_OTP, undefined, 2);
        document.getElementById('driver_request_otpVerify').textContent = JSON.stringify(driver_request_otpVerify, undefined, 2);
        document.getElementById('driver_response_otpVerify').textContent = JSON.stringify(driver_response_otpVerify, undefined, 2); 
        document.getElementById('driver_request_Register').textContent = JSON.stringify(driver_request_Register, undefined,
            2);
        document.getElementById('driver_response_Register').textContent = JSON.stringify(driver_response_Register,
            undefined, 2);
        document.getElementById('driver_request_Login').textContent = JSON.stringify(driver_request_Login, undefined, 2);
        document.getElementById('driver_response_Login').textContent = JSON.stringify(driver_response_Login, undefined, 2);
        document.getElementById('driver_response_profile').textContent = JSON.stringify(driver_response_profile, undefined, 2);
        document.getElementById('driver_request_profileUpdate').textContent = JSON.stringify(driver_request_profileUpdate, undefined, 2);
        document.getElementById('driver_response_profileUpdate').textContent = JSON.stringify(driver_response_profileUpdate, undefined, 2);
        document.getElementById('driver_response_getOrderAvailable').textContent = JSON.stringify(driver_response_getOrderAvailable,
            undefined,
            2);
        document.getElementById('driver_response_ongoingOrder').textContent = JSON.stringify(driver_response_ongoingOrder, undefined, 2);
        document.getElementById('driver_response_assignedOrder').textContent = JSON.stringify(driver_response_assignedOrder,
        undefined,
        2);
        document.getElementById('driver_request_updateOrder').textContent = JSON.stringify(driver_request_updateOrder, undefined, 2);
        document.getElementById('driver_response_updateOrder').textContent = JSON.stringify(driver_response_updateOrder, undefined, 2);
        document.getElementById('driver_request_pickupImage').textContent = JSON.stringify(driver_request_pickupImage, undefined, 2);
        document.getElementById('driver_response_pickupImage').textContent = JSON.stringify(driver_response_pickupImage, undefined, 2);
        document.getElementById('driver_response_Logout').textContent = JSON.stringify(driver_response_Logout, undefined,
            2);
        // Driver Ends
        // Management Starts
        document.getElementById('management_request_Register').textContent = JSON.stringify(management_request_Register,
            undefined, 2);
        document.getElementById('management_response_Register').textContent = JSON.stringify(management_response_Register,
            undefined, 2);
        document.getElementById('management_request_Login').textContent = JSON.stringify(management_request_Login,
            undefined, 2);
        document.getElementById('management_response_Login').textContent = JSON.stringify(management_response_Login,
            undefined, 2);
        document.getElementById('management_response_Logout').textContent = JSON.stringify(management_response_Logout,
            undefined, 2);
        document.getElementById('management_driversList').textContent = JSON.stringify(management_driversList,
            undefined, 2);
        document.getElementById('management_driverShowId').textContent = JSON.stringify(management_driverShowId,
            undefined, 2);
        document.getElementById('management_request_driverVerificationUpdate').textContent = JSON.stringify(
            management_request_driverVerificationUpdate,
            undefined, 2);
        document.getElementById('management_response_driverVerificationUpdate').textContent = JSON.stringify(
            management_response_driverVerificationUpdate,
            undefined, 2);
        // Management Ends
        // Dropdown Starts
        document.getElementById('dropdown_vehicleType').textContent = JSON.stringify(dropdown_vehicleType,
            undefined, 2);
        document.getElementById('dropdown_vehicleAreas').textContent = JSON.stringify(dropdown_vehicleAreas,
        undefined, 2);
        document.getElementById('dropdown_ManagementRole').textContent = JSON.stringify(dropdown_ManagementRole,
        undefined, 2);
        // Dropdown Ends

        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }
        searchBtn.onclick = function() {
            sidebar.classList.toggle("active");
        }
        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }
    </script>
</body>

</html>
