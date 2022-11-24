@extends('layouts.layout_legal_docs')

@push('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');

        body,
        html {

            line-height: 1.8;
            font-family: 'Poppins', sans-serif;
            color: #555e58;
            text-transform: capitalize;
            text-rendering: optimizeLegibility !important;
            -webkit-font-smoothing: antialiased !important;
            font-weight: 400;
            margin: 0px;
            padding: 0px;
        }

        .main-content {
            padding: 10px 20px 0px 20px;
            position: relative;
            width: 100%;
        }

        .top-navbar {
            width: 100%;
            z-index: 9;
            position: relative;
        }

        .navbar {
            background-color: #8C27FF;
            color: #FFFFFF;
        }

        .navbar-brand {
            color: #FFFFFF;
        }

        .nav-link {
            color: #FFFFFF;
        }

        #content {
            position: relative;
            transition: all 0.3s;
            background-color: #EEEEEE;
        }

        .card {
            margin: 10px 0;
            border-radius: 10px !important;
            box-shadow: 0 1px 2px rgb(0 0 0 / 8%);
        }

        .card-title {
            color: #8C27FF;
        }

    </style>
@endpush
@section('content')
    <div class="top-navbar">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid ms-3">
                <img src="{{ asset('assets/images/03_Logo.png') }}" alt="logo" width="100" class="pl-3">
            </div>
        </nav>
    </div>
    <div id="content">
        <div class="main-content">
            {{-- row 1 --}}
            <div class="row">
                <div class="col-sm-12 px-5">
                    <div class="card px-3">
                        <div class="card-body">
                            <h2 class="card-title text fw-bolder py-3 d-flex justify-content-center">Privacy and Policy
                            </h2>
                            <p class="card-text lh-md">Mach95 Software Development Corp. (“Mach95”, “we”, “us”, “our”) is
                                committed to protecting the personal information and privacy of our customers, partners, and
                                employees.
                            </p>
                            <p class="card-text lh-md">This Privacy Policy will outline how we may collect, process,
                                store, transmit and retain the information you provide us through the use of Yoo Philippines
                                (“Yoo”) platforms, such as but not limited to apps, websites, and social channels, as
                                required by the Data Privacy Act of 2012 (“DPA”), its Implementing Rules and Regulations
                                (“DPA IRR”), issuances of the National Privacy Commission (“NPC”) and other applicable laws
                                and regulations on data privacy.
                            </p>
                            <p class="card-text lh-md">To maintain compliance with the law, we may update this privacy
                                policy periodically. You may be notified of these updates through
                                announcements/notifications within our platforms but encourage you to frequently check this
                                notice.
                            </p>
                            <p class="card-text lh-md pb-3">By using Yoo’s platforms, the User expressly consents to the
                                collection, use, disclosure, and all other forms of processing of his/her personal data by
                                Mach95, its subsidiaries, affiliates, lawyers, consultants, and authorized third-party
                                service providers as outlined in this Privacy Policy.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- row 2 --}}
            <div class="row">
                <div class="col-sm-12 px-5">
                    <div class="card px-3">
                        <div class="card-body ">
                            <div class="">
                                <h3 class="card-title text fw-bolder py-3 d-flex justify-content-center">Information we
                                    Collect</h3>
                                <p class="card-text lh-md">The information we collect may be personal information you
                                    have
                                    expressly provided to us, through the use of Yoo’s services and other engagements
                                    such
                                    as
                                    through social media, phone, email, and events, along with other information
                                    collected
                                    through our app, automatically, as necessary, or as permitted.
                                </p>
                                <p class="card-text lh-md">This information may vary upon your usage of our services
                                    and
                                    may
                                    include:
                                </p>
                            </div>
                            <div class="row row-cols-1 row-cols-md-2 g-4 mt-1">
                                <div class="col">
                                    <div class="card px-3">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bolder py-2">Personal Data</h5>
                                            <p class="card-text lh-md">Names; mobile numbers; email addresses; mailing
                                                addresses; job titles; contact preferences; data collected from surveys;
                                                usernames; passwords; contact or authentication data; citizenship;
                                                business
                                                name, business email, business address, business fax, company website,
                                                etc.;
                                                the number of unique views and the total number of visitors when you
                                                deploy
                                                your cookie banner using our consent management solution; information in
                                                blog comments; financial or payment information (e.g., debit or credit
                                                card
                                                number, billing history, billing address, card type, issuing
                                                bank/payment
                                                method, expiration date, card origin by country); profile photo; date of
                                                birth; legal status; government-issued ids and documents; and other
                                                similar
                                                information.

                                                All personal information must be accurate and complete. Any updates or
                                                changes needed must be processed through the platforms or communicated
                                                to
                                                us.

                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-stretch">
                                    <div class="card px-3">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bolder py-2">Usage and Technology Data</h5>
                                            <p class="card-text lh-md"> Cookies; device and usage information (IP
                                                address,
                                                browser and device characteristics, operating system, language
                                                preferences,
                                                URLs, device name, country, location, system activity, error reports,
                                                Internet service provider, mobile carrier, geolocation, mobile device
                                                access
                                                (camera, contacts, microphone, storage, and other features), mobile
                                                device
                                                ID, model, and manufacturer, browser type and version, push
                                                notifications.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- row 3 --}}
            <div class="row">
                <div class="col-sm-12 px-5">
                    <div class="card px-3">
                        <div class="card-body">
                            <h3 class="card-title text fw-bolder py-3 d-flex justify-content-center">HOW WE USE YOUR
                                INFORMATION</h3>
                            <p class="card-text lh-md">We collect your personal information in order to fulfill the services
                                and offerings you may request from us, such as:
                            </p>
                            <ul>
                                <li>Account application, authentication, creation, and management</li>
                                <li>Providing customer support</li>
                                <li>Enabling peer-to-peer communication</li>
                                <li>Processing and tracking of requested services</li>
                                <li>Communication of announcements and offerings</li>
                                <li>Enforcing our terms, conditions, and policies</li>
                                <li>Communication of announcements and offerings</li>
                                <li>Monitoring and analyzing system performance and user behavior in order to enhance user
                                    experience and provide relevant services</li>
                                <li>Protecting users, preventing fraud and illegal activates and complying with governments
                                    laws and regulations</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- row 4 --}}
            <div class="row">
                <div class="col-sm-12 px-5">
                    <div class="card px-3">
                        <div class="card-body">
                            <h5 class="card-title text fw-bolder py-3 d-flex justify-content-center">SHARING OF INFORMATION
                            </h5>
                            <p class="card-text lh-md mb-3">We may provide your information to third-party service providers and
                                entities in order to support our business, provide you services, enforce our terms and
                                conditions, and comply with laws. Usage of the provided information by these entities is
                                subject
                                to the same data confidentiality policies and purpose outlined in this notice.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- row 5 --}}
            <div class="row">
                <div class="col-sm-12 px-5">
                    <div class="card px-3">
                        <div class="card-body">
                            <h5 class="card-title text fw-bolder py-3 d-flex justify-content-center">COOKIES AND TRACKING
                                TECHNOLOGIES</h5>
                            <p class="card-text lh-md">We may use cookies and other tracking technologies to access or store
                                information that may be technically necessary to operate our platforms or support its
                                performance and features. Some uses are:
                                recognizing when you visit our platforms
                                keeping the platforms secure
                                enhancing system performance
                                tracking and targeting the interests of our users to enhance their experience
                                Research, analytics, and advertising

                                You may refuse certain cookies by managing your browser settings but this may disable some
                                behavior on our platforms.
                            </p>
                            <p class="card-text lh-md mb-3">You may refuse certain cookies by managing your browser settings but
                                this may disable some
                                behavior on our platforms.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- row 6 --}}
            <div class="row">
                <div class="col-sm-12 px-5">
                    <div class="card px-3">
                        <div class="card-body">
                            <h5 class="card-title text fw-bolder py-3 d-flex justify-content-center">INFORMATION STORAGE AND
                                SECURITY</h5>
                            <p class="card-text lh-md">We have employed secure online storage platforms and cloud services
                                as
                                well as implemented technical security measures to the best of our knowledge in order to
                                keep the information we process secure. However, as safeguards over information storage
                                facilities and the web continue to evolve, so do the threats. Hence, we cannot guarantee
                                safety from all security vulnerabilities and advise users to transmit information at their
                                own risk as well as only access our platforms within a secure environment.

                                We will retain user information for as long as it serves a purpose outlined in this privacy
                                policy or as required or allowed by law. We may delete information no longer serving a
                                business need or securely store the data until it can be deleted.
                            </p>
                            <p class="card-text lh-md mb-3">We will retain user information for as long as it serves a purpose outlined in this privacy
                                policy or as required or allowed by law. We may delete information no longer serving a
                                business need or securely store the data until it can be deleted.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- row 7 --}}
            <div class="row">
                <div class="col-sm-12 px-5">
                    <div class="card px-3">
                        <div class="card-body">
                            <h5 class="card-title text fw-bolder py-3 d-flex justify-content-center">DATA PRIVACY RIGHTS</h5>
                            <p class="card-text lh-md mb-3">You have the right to request and update your personal data in our
                                possession, some of which is readily available and directly editable by you on our platforms
                                given you are able to verify your identity. For additional information and update requests,
                                you may reach out to our support channels. Depending on the request, we may require
                                identification and other supporting documents or refuse such requests if there are any
                                practical or legal limitations.
                                You have the right to withdraw consent from the collection, use, disclosure, and all other
                                forms of processing of your personal data and may do so by contacting us through our email
                                and support channels.
                                For any questions or concerns about your privacy rights and our privacy policy, you may
                                reach out to mach95sdc@gmail.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@push('scripts')

@endpush
