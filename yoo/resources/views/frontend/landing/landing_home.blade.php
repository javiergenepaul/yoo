@extends('layouts.layout_landing')



@push('css')
    <style>
        @font-face {
            font-family: Poppins;
            src: url('{{ asset('assets/fonts/Poppins-Regular.ttf') }}');
        }

        * {
            padding: 0;
            margin: 0;
            font-family: Poppins;
            color: #fff;
        }

        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: inherit;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Poppins;
            padding: 0;
            margin: 0;
            width: 100vw;
            max-height: 100%;
            overflow-x: hidden;
        }

        /*Container**/
        .container {
            width: 90%;
            max-width: 100%;
            overflow: hidden;
            margin: auto;
        }

        header {
            color: #ffffff;
            padding-top: 30px;
            padding-left: 200;
            height: 100px;
            text-align: center;
            position: sticky;
        }

        header a {
            color: #ffffff;
            font-size: 20px;
            text-decoration: none;
            padding: 10px 30px 10px 30px;
        }

        header li {
            float: left;
            padding: 15px 30px 0px 30px;
            display: inline;
        }

        header .branding {
            float: left;
            font-size: 25px;
        }

        header nav {
            float: right;
        }

        header .current a {
            border-radius: 40px;
            outline-color: #5100AD;
            outline-style: solid;
            color: #5100AD;
        }

        header a:hover {
            color: #5100AD;
            font-weight: bold;
        }

        .branding .logo {
            height: 60px;
            width: 135px;
            max-height: 100%;
            max-width: 100%;
            float: left;
        }

        .main-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
        }

        .yoo-details .highlight {
            color: #B26FFF;
        }

        .yoo-details {
            text-align: center;
        }

        h6.subtext {
            font-size: 10px;
            font-weight: 200;
        }

        .btn {
            display: inline-flex;
            height: 35px;
            padding: 5px;
            background: #6500D8;
            border-radius: 15px;
            border: none;
            outline: none;
            overflow: hidden;
            cursor: pointer;
            align-items: center;
            margin: 20px;
        }

        .btn2 {
            display: inline-flex;
            height: 35px;
            padding: 10px;
            background: #6500D8;
            border-radius: 15px;
            border: none;
            outline: none;
            overflow: hidden;
            cursor: pointer;
            align-items: center;
            margin: 20px;
            position: absolute;
            left: 80%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .button-text,
        .button-icon {
            display: inline-flex;
            align-items: center;
            padding: 20px 10px 20px 10px;
            color: #fff;
            height: 100%;
        }

        .yoo-details p,
        h1,
        h2 {
            color: white;
            justify-content: center;
            align-content: center;
        }

        .yoo-details h1 {
            font-size: 60px;
            font-style: italic;
            font-weight: 500;
        }

        .yoo-details p {
            font-size: 16px;
            font-weight: 300;
        }

        .yoo-details h2 {
            font-size: 30px;
            font-style: italic;
            font-weight: 600;
        }

        .how-content h1 {
            font-style: italic;
            font-weight: 500;
            padding: auto;
        }

        .how-content p {
            line-height: 30px;
            color: #fff;
        }

        .how-image {
            position: relative;
            background: url('{{ asset('assets/images/07_How it works.png') }}') no-repeat;
            height: 700px;
            width: 1100px;
            max-width: 100%;
            max-height: 100%;
            background-size: 100%;
            float: left;
        }

        .how-content {
            float: right;
            margin: 30px 100px 0 0;
        }

        .apply {
            position: absolute;
            left: 50%;
            top: 15%;
            transform: translate(-50%, -50%);
        }

        .apply h1 {
            color: rgba(152, 83, 229, 1);
            font-size: 55px;
            font-weight: 500;
            font-style: italic;
        }

        .apply-content1 {
            position: absolute;
            left: 41%;
            top: 29%;
            transform: translate(-50%, -50%);
        }

        .apply-content2 {
            position: absolute;
            left: 59%;
            top: 30%;
            transform: translate(-50%, -50%);
        }

        .apply-content1 p {
            text-align: left;
            font-size: 15px;
        }

        .apply-content2 p {
            text-align: left;
            font-size: 15px;
        }

        .apply-details {
            position: absolute;
            left: 50%;
            top: 20%;
            transform: translate(-50%, -50%);
            text-align: center;
            justify-content: center;
        }

        .apply-image {
            text-align: center;
            position: absolute;
            width: 1600px;
            height: 286px;
            right: 13%;
            top: 24%;
            max-width: 100%;
            max-height: 100%;
            background-size: 100%;
        }

        .apply-details h1,
        p {
            color: black;
        }

        .faq-image {
            background: url('{{ asset('assets/images/011_FAQs.png') }}');
            position: absolute;
            width: 520px;
            height: 500px;
            left: 65%;
            top: 25%;
            max-width: 100%;
            max-height: 100%;
            background-size: 100%;
        }

        .faq {
            position: absolute;
            left: 50%;
            top: 10%;
            transform: translate(-50%, -50%);
            padding: 25px 25px 25px 25px;
        }

        .faq h1 {
            color: rgba(152, 83, 229, 1);
            font-size: 55px;
            font-weight: 500;
            font-style: italic;
        }

        .accordion {
            float: right;
            height: 40%;
            max-height: 100%;
            margin: 5px;
        }

        .accordion-item {
            background-color: #edebeb;
            width: 40%;
            margin-bottom: 5px;
            overflow: hidden;
            cursor: pointer;
            padding: 5px 20px;
        }

        .accordion-link {
            font-size: 20px;
            color: black;
            text-decoration: none;
            background-color: #EEECEC;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .accordion-link i {
            color: black;
            padding: .5rem;
        }

        .accordion-link .bi-chevron-up {
            display: none;
        }

        .answer {
            max-height: 0;
            overflow: hidden;
            position: relative;
            background-color: #d6d2d2;
            transition: max-height 650ms;
        }

        .answer::before {
            content: "";
            position: absolute;
            width: 5px;
            height: 100%;
            background-color: #8C27FF;
        }

        .answer p {
            color: black;
            font-size: 16px;
            padding: 10px;
        }

        .accordion-item:target .answer {
            max-height: 20rem;
        }

        .accordion-item:target .accordion-link .bi-chevron-up {
            display: block;
        }

        .accordion-item:target .accordion-link .bi-chevron-down {
            display: none;
        }

        section {
            height: 100vh;
            position: relative;
        }

        #about-us {
            background: linear-gradient(to right, rgba(24, 10, 46, 0.54), rgba(24, 10, 46, 0.54)),
                url('{{ asset('assets/images/01_Background.png') }}') no-repeat;
            background-size: cover;
        }

        #how-it-works {
            background-color: #A85CFF;
            display: flex;
            align-content: center;
        }

        #faqs {
            background-color: #D1ACFC;
            display: flex;
        }

        #apply-now {
            background-color: #E6CFFF;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer {
            height: auto;
            background: linear-gradient(180deg, #6404D1 0%, #160030 100%);
            padding: 40px 0 30px 0;
            color: #fff;
        }

        .footer-content {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .footer-content p {
            color: #fff;
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .footer-bottom p {
            color: #fff;
            font-size: 12px;
        }

        .curve1 {
            position: absolute;
            background: url('{{ asset('assets/images/curve1.png') }}') no-repeat;
            height: 280px;
            width: 4983px;
            max-width: 100%;
            max-height: 100%;
            background-size: 100%;
            bottom: -5%;
            left: 0;
        }

        .curve2 {
            position: absolute;
            background: url('{{ asset('assets/images/curve2.png') }}') no-repeat;
            height: 172px;
            width: 2357px;
            max-width: 100%;
            max-height: 100%;
            background-size: 100%;
            top: -5%;
            left: 0;
        }

        .curve3 {
            position: absolute;
            background: url('{{ asset('assets/images/curve3.png') }}') no-repeat;
            height: 470px;
            width: 5400px;
            max-width: 100%;
            max-height: 100%;
            background-size: 100%;
            bottom: 0;
            left: 0;
        }

        .curve4 {
            position: absolute;
            background: url('{{ asset('assets/images/curve4.png') }}') no-repeat;
            height: 300px;
            width: 5400px;
            max-width: 100%;
            max-height: 100%;
            background-size: 100%;
            top: 0;
            left: 0;
        }

        @media(max-width: 1700px) {
            .faq {
                display: none;
            }

            .curve1,
            .curve2,
            .curve3,
            .curve4 {
                display: none;
            }

            .apply-image {
                display: none;
                text-align: center;
            }

            .apply h1 {
                font-size: 35px;
            }

            .apply-content1 {
                position: absolute;
                left: 50%;
                top: 29%;
                transform: translate(-50%, -50%);
            }

            .apply-content2 {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            .apply-content1 p,
            .apply-content2 p {
                font-size: 17px;
            }

        }

        @media(max-width: 2000px) {
            body {
                overflow-x: hidden;
                width: 100vw;
                max-width: 100%;
            }

            #about-us {
                background-size: cover;
            }

            nav a {
                font-size: 15px;
            }

            .branding .logo {
                float: none;
                text-align: center;
            }

            .container {
                width: 80%;
            }

            .main-content {
                width: 70%;
            }

            .yoo-details h1 {
                font-size: 40px;
                font-style: italic;
                font-weight: 300;
            }

            .yoo-details p {
                font-size: 15px;
                font-weight: 300;
            }

            .yoo-details h2 {
                font-size: 25px;
                font-style: italic;
                font-weight: 600;
            }

            .how-content h1 {
                font-size: 20px;
            }

            .how-content p {
                font-size: 12px;
            }

            .how-content h1 {
                font-size: 35px;
            }

            .how-content {
                align-items: center;
                padding: 100px 0 0 0;
                float: none;
            }

            .button-text {
                font-size: 12px;
                padding: 10px;
            }

            .btn2 {
                left: 47%;
                top: 65%;
            }

            .faq h1 {
                font-size: 35px;
            }

            .faq {
                top: 10%;
            }

            #faqs {
                text-align: center;
            }

            .accordion-item {
                width: 100%;
                padding: 5px 10px;
            }

            .accordion-item:target .answer {
                max-height: 10rem;
            }

            .accordion-link {
                font-size: 15px;
            }

            .faq-image {
                display: none;
            }

            .accordion {
                text-align: center;
            }

            .answer p {
                font-size: 12px;
            }

            .answer::before {
                display: none;
            }

            .footer-bottom p {
                font-size: 10px;
            }

            .faq-image {
                display: none;
            }
        }

        @media(max-width:1200px) {

            header .branding {
                float: none;
                text-align: center;
            }

            nav {
                display: none;
            }

            .button-text {
                font-size: 10px;
                padding: 10px;
            }

            .how-image {
                height: 700px;
                width: 1100px;
            }
        }

        @media(max-width:600px) {
            body {
                overflow-x: hidden;
            }

            .container {
                width: 90%;
            }

            .yoo-details h1 {
                font-size: 25px;
            }

            .yoo-details p {
                font-size: 11px;
            }

            .yoo-details h2 {
                font-size: 16px;
            }

            .how-content p {
                font-size: 12px;
            }

            .how-content h1 {
                font-size: 25px;
            }

            .apply h1 {
                font-size: 25px;
            }

            .how-content {
                padding: 35px 0 0 0;
            }

            .how-image {
                display: none;
            }

            .accordion {
                display: flex;
                flex-direction: column;
                float: auto;
            }

            .faq {
                display: none;
            }

            .apply-content1 {
                position: absolute;
                left: 50%;
                top: 35%;
                transform: translate(-50%, -50%);
            }

            .apply-content2 {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            .apply-content1 p,
            .apply-content2 p {
                font-size: 13px;
            }

            .accordion-link {
                font-size: 12px;
            }

            .answer p {
                font-size: 10px;
            }

            .button-text {
                font-size: 10px;
                padding: 5px;
            }

            .bigcontainer {
                display: none;
            }
        }

        @media(min-width:600px) and (max-width:2000px) {
            .smallcontainer {
                display: none;
            }

            .how-content p {
                font-size: 15px;
            }

            .how-content h1 {
                font-size: 30px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- ABOUT US -->
    <section id="about-us">
        <header>
            <div class="container">
                <div class="branding">
                    <img src="{{ asset('assets/images/03_Logo.png') }}" class="logo">
                </div>
                <nav>
                    <ul>
                        <li> <a href="#about-us">About Us</a></li>
                        <li> <a href="#how-it-works">How it works</a></li>
                        <li> <a href="#faqs">FAQs</a></li>
                        <li class="current"> <a href="#apply-now">Apply Now</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="container">
            <div class="main-content">
                <div class="yoo-details">
                    <h1><span class="highlight">YOO</span> delivery app</h1>
                    <p>Yoo prioritizes the highest quality of service with affordable rates, security and<br> peace of mind
                        provided by our well trained Yoo Riders.</p>
                    <h2>We take care of our people, your time and money.<br>
                        We Value<span class="highlight">Yoo</span>, because <span class="highlight">Yoo</span>
                        Matter!</h2>
                    {{-- <a href="https://play.google.com/store/apps/details?id=com.mach95.yoo_rider" class="btn">
                        <span class="button-text">Download on Google Play</span>
                        <span class="button-icon"><i class="bi bi-download"></i></span>
                    </a>

                    <a href="https://play.google.com/store/apps/details?id=com.mach95.yoo_rider" class="btn">
                        <span class="button-text">Android Direct Download</span>
                        <span class="button-icon"><i class="bi bi-download"></i></span>
                    </a> --}}
                    <br>
                    <div class="container-fluid">
                        <div class="bigcontainer">
                            <div class="row align-items-start">
                                <div class="col">
                                    <h5>For Customers</h5>
                                </div>
                                <div class="col">
                                    <h5>For Drivers</h5>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col-sm-6">
                                    <a href="https://play.google.com/store/apps/details?id=com.mach95.yoo">
                                        <img class="google" src="{{ asset('assets/images/googleplay.png') }}">
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="https://play.google.com/store/apps/details?id=com.mach95.yoo_rider">
                                        <img class="google" src="{{ asset('assets/images/googleplay.png') }}">
                                    </a>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col">
                                    <a href="{{ route('download.directDownloadCustomerApk') }}" class="btn">
                                        <span class="button-text">Android Direct Download</span>
                                        <span class="button-icon"><i class="bi bi-download"></i></span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('download.directDownloadDriverApk') }}" class="btn">
                                        <span class="button-text">Android Direct Download</span>
                                        <span class="button-icon"><i class="bi bi-download"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="smallcontainer">
                            <div class="row">
                                <div class="customer">
                                    <h5>For Customers</h5>
                                    <a href="https://play.google.com/store/apps/details?id=com.mach95.yoo">
                                        <img class="google" src="{{ asset('assets/images/googleplay.png') }}"
                                            width="200" height="75">
                                    </a>
                                    <a href="{{ route('download.directDownloadCustomerApk') }}" class="btn">
                                        <span class="button-text">Android Direct Download</span>
                                        <span class="button-icon"><i class="bi bi-download"></i></span>
                                    </a>
                                </div>
                                <div class="driver">
                                    <h5>For Drivers</h5>
                                    <a href="https://play.google.com/store/apps/details?id=com.mach95.yoo_rider">
                                        <img class="google" src="{{ asset('assets/images/googleplay.png') }}"
                                            width="200" height="75">
                                    </a>
                                    <a href="{{ route('download.directDownloadDriverApk') }}" class="btn">
                                        <span class="button-text">Android Direct Download</span>
                                        <span class="button-icon"><i class="bi bi-download"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <h6 class="subtext">Available on Android</h6> --}}
                </div>
            </div>
        </div>
        <div class="curve1"></div>
    </section>
    <!-- HOW IT WORKS -->
    <section id="how-it-works">
        <div class="curve2"></div>
        <div class="curve3"></div>
        <div class="container">
            <div class="how-content">
                <div class="row align-items-start">
                    <div class="col-lg-4">
                        <h1>How it works</h1>
                        <p>1.&nbsp;&nbsp;&nbsp; Set pick up and drop off location</p>
                        <p>2.&nbsp;&nbsp;&nbsp; Rider is found</p>
                        <p>3.&nbsp;&nbsp;&nbsp; Track your order</p><br><br><br>
                        <p>Download the rider app now!</p>
                    </div>
                    <div class="col-lg-8">
                        <div class="how-image"></div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <!-- APPLY NOW -->
    <section id="apply-now">
        <div class="curve4"></div>
        <div class="container">
            <div class="apply">
                <h1>How to apply</h1>
            </div>
            <div class="row align-items-start">
                <div class="col-lg-6">
                    <div class="apply-content1">
                        <p>Fill up information<br>below and submit the<br>needed requirement.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="apply-content2">
                        <p>Once done on first step<br>you will have to wait till<br>your account get fully<br>verified.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="apply-image"><img src="{{ asset('assets/images/08_ApplyNow.png') }}"></div>
    </section>
    <!-- FAQs -->
    <section id="faqs">
        <div class="container">
            <div class="faq-image"></div>
            <div class="faq">
                <h1>Frequently Asked Questions</h1>
            </div>
            <div class="accordion">
                <div>
                    <h5>CUSTOMERS</h5>
                </div>
                <div class="accordion-item" id="faqs2">
                    <a class="accordion-link" href="#faqs2">
                        How to register?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>Download the app from Google Play or download the apk directly from <a
                                href="https://yoo.ph">https://yoo.ph</a></p>
                    </div>
                </div>
                <!-- <div class="accordion-item" id="faqs3">
                                                <a class="accordion-link" href="#faqs3">
                                                    What can Yoo deliver?
                                                    <i class="bi bi-chevron-up"></i>
                                                    <i class="bi bi-chevron-down"></i>
                                                </a>
                                                <div class="answer">
                                                    <p>We can deliver items that fit the maximum weight and dimension limit for each vehicle including food, clothing, documents, electronics, and the like. The following items are NOT allowed: illegal drugs, livestock, flammable/poisonous materials, and other dangerous materials.</p>
                                                </div>
                                            </div> -->
                <div class="accordion-item" id="faqs4">
                    <a class="accordion-link" href="#faqs4">
                        Where can Yoo deliver?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>We will be launching first in Metro Manila, Cebu, and Davao.</p>
                    </div>
                </div>
                <!-- <div class="accordion-item" id="faqs5">
                                                <a class="accordion-link" href="#faqs5">
                                                    What payment methods do you support?
                                                    <i class="bi bi-chevron-up"></i>
                                                    <i class="bi bi-chevron-down"></i>
                                                </a>
                                                <div class="answer">
                                                    <p>We are currently only accepting cash payments but may coordinate with rider on other preferred methods.</p>
                                                </div>
                                            </div> -->
                <div>
                    <h5>DRIVERS</h5>
                </div>
                <div class="accordion-item" id="faqs6">
                    <a class="accordion-link" href="#faqs6">
                        How can drivers register?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>Download the App. Make sure to use the sponsor code provided by your operator. If you do not have
                            an operator, you may use <b style="color: black;">yoophofficial</b> to register as an in-house
                            rider</p>
                    </div>
                </div>
                <div class="accordion-item" id="faqs7">
                    <a class="accordion-link" href="#faqs7">
                        What are the requirements for drivers?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">

                        <p>Own vehicle or if not owned, Signed Letter of Authorization with vehicle owner’s Valid ID or Deed
                            of Sale
                            <br>Professional Driver's License
                            <br>Valid NBI Clearance (3 months valid)
                            <br>Official Receipt of Vehicle Registration (OR)
                            <br>Vehicle Certificate of Registration (CR)
                            <br>Vehicle Photos with Plate Number
                            <br>Profile Photo with a plain background and no accessories
                        </p>
                    </div>
                </div>
                <div class="accordion-item" id="faqs8">
                    <a class="accordion-link" href="#faqs8">
                        What vehicles does Yoo accept?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>We are currently accepting motorcycles and sedans</p>
                    </div>
                </div>
                <!-- <div class="accordion-item" id="faqs9">
                                                <a class="accordion-link" href="#faqs9">
                                                    Do I need to deliver full-time?
                                                    <i class="bi bi-chevron-up"></i>
                                                    <i class="bi bi-chevron-down"></i>
                                                </a>
                                                <div class="answer">
                                                    <p>You can accept Yoo orders at your own time. There is no full-time requirement.</p>
                                                </div>
                                            </div> -->
                <div class="accordion-item" id="faqs10">
                    <a class="accordion-link" href="#faqs10">
                        How can I earn from Yoo?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>You can earn from Yoo through delivery fees. We currently only support Cash payment which
                            Drivers can receive in full. There is no need to remit any amount to Yoo. After every order,
                            Yoo will deduct 20% of delivery fee from Rider's wallet. To help riders get started, riders
                            receive 200 credits after first registration and may accepts orders up to 1000 pesos in value
                            before their first top-up.</p>
                    </div>
                </div>
                <div class="accordion-item" id="faqs11">
                    <a class="accordion-link" href="#faqs11">
                        Are there additional fees in order to accept Yoo orders?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>There is NO registration fee, NO required uniform or equipment or fixed deposit but you will need
                            to top-up at least 20% of order value to accept orders</p>
                    </div>
                </div>
                <div class="accordion-item" id="faqs12">
                    <a class="accordion-link" href="#faqs12">
                        Is there a minimum top-up?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>You can top-up as low as 100 pesos and accept orders worth 5 times value. (i.e. 100 peso orders
                            and 100 top-up can accept up to 500 peso orders)</p>
                    </div>
                </div>
                <!-- <div class="accordion-item" id="faqs10">
                                                <a class="accordion-link" href="#faqs10">
                                                    Do you offer rider insurance?
                                                    <i class="bi bi-chevron-up"></i>
                                                    <i class="bi bi-chevron-down"></i>
                                                </a>
                                                <div class="answer">
                                                    <p>As of the moment, Yoo does not provide any insurance but encourage operators and riders to avail of their own</p>
                                                </div>
                                            </div> -->
                {{-- <div class="accordion-item" id="faqs13">
                    <a class="accordion-link" href="#faqs13">
                        How long after I apply can I start accepting deliveries?
                        <i class="bi bi-chevron-up"></i>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="answer">
                        <p>Yoo is currently in the pre-launch phase focused on recruiting riders. Yoo is targeted to launch
                            in about a month. Once Yoo launches, you will be able to start accepting orders after you've
                            completed training and are verified . We will be updating our facebook page with more
                            announcements and contact you through your registered mobile number so look out for them!</p>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <div>
                <span>
                    <i class="bi bi-envelope"></i>
                </span>
                <span>yooph.info.gmail.com</span>
            </div>
            <div>
                <span>
                    <i class="bi bi-telephone"></i>
                </span>
                <span>(0947) 864 3950</span>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2021 Copyright: Mach95 Software Development Corp.</p>
        </div>
    </footer>
@endsection
