@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Privacy Policy')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection



@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
@endsection

@section('content')

    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)">Campus Connect</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-7">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar-ex-7">
                <div class="navbar-nav me-auto">
                    {{-- <a class="nav-item nav-link active" href="javascript:void(0)">Home</a>
                    <a class="nav-item nav-link" href="javascript:void(0)">About</a>
                    <a class="nav-item nav-link" href="javascript:void(0)">Contact</a>
                    <a class="nav-item nav-link disabled" href="javascript:void(0)">Disabled</a> --}}
                </div>
                <ul class="navbar-nav ms-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('authenticate-register') }}"><i
                                class="tf-icons navbar-icon ti ti-user-plus ti-xs me-1"></i> Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('authenticate-login') }}"><i
                                class="tf-icons navbar-icon ti ti-login ti-xs me-1"></i> Log In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-xxl container-p-y">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-6 doc-page-title">Privacy Policy</h2>
                <p class="lead">Effective Date: 1st July 2024</p>

                <hr>

                {{-- Section 1 --}}
                <h5 class="mb-2">Introduction</h5>
                <p class="">Welcome to <strong>Campus Connect by StellaNova.</strong> We are committed to protecting
                    your privacy
                    and ensuring a safe online experience. This Privacy Policy explains how we collect, use, and protect
                    your personal information when you visit our website and use our services.</p>

            </div>
        </div>

    </div>
    <div class="container-xxl container-p-y pt-0">
        <div class="accordion mt-3" id="accordionExample">




            <div class="card accordion-item active">
                <h2 class="accordion-header" id="headingOne">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne"
                        aria-expanded="true" aria-controls="accordionOne">
                        Information We Collect
                    </button>
                </h2>

                <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <p class="">To provide you with a smooth and efficient registration process, we
                            collect the following
                            information:</p>
                        <ol>
                            <li><strong>Email Address:</strong> We collect your email address to create and manage
                                your account,
                                communicate with
                                you, and send you important updates and notifications.</li>
                            <li><strong>Avatar Information:</strong> We collect your avatar or profile picture to
                                personalize your
                                user experience
                                and enhance your interaction with our services.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                        How We Use Your Information
                    </button>
                </h2>

                <div id="accordionTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                    style="">
                    <div class="accordion-body">
                        <p class="">We use the collected information for the following purposes:</p>
                        <ol>
                            <li><strong>Account Creation and Management:</strong> To set up and manage your user account,
                                ensuring you have
                                access to
                                all the features and services available.</li>
                            <li><strong>Communication:</strong> To send you important updates, notifications, and
                                promotional materials
                                related to
                                our services. You can opt out of promotional communications at any time.</li>
                            <li><strong>Personalization:</strong> To enhance your experience by personalizing your profile
                                and interactions
                                within
                                our services.</li>
                            <li><strong>Security and Fraud Prevention:</strong> To protect your account and our services
                                from unauthorized
                                access,
                                fraud, and other security threats.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">
                        Data Sharing and Disclosure
                    </button>
                </h2>

                <div id="accordionThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                    style="">
                    <div class="accordion-body">
                        <p class="">We value your privacy and do not sell, trade, or otherwise transfer your personal
                            information to outside parties without your consent, except in the following cases:</p>
                        <ol>
                            <li><strong>Service Providers: </strong>We may share your information with trusted third-party
                                service providers
                                who
                                assist us in operating our website, conducting our business, or providing services to you.
                                These
                                providers are contractually obligated to maintain the confidentiality and security of your
                                information.</li>
                            <li><strong>Legal Requirements:</strong> We may disclose your information if required to do so
                                by law or in
                                response to
                                valid requests by public authorities (e.g., a court or government agency).</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">
                        Data Security
                    </button>
                </h2>

                <div id="accordionFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                    style="">
                    <div class="accordion-body">
                        <p class="">We implement a variety of security measures to maintain the safety of your
                            personal
                            information. Your information is stored on secure servers and protected by industry-standard
                            encryption
                            technologies.</p>
                    </div>
                </div>
            </div>

            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">
                        Data Retention
                    </button>
                </h2>

                <div id="accordionFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                    style="">
                    <div class="accordion-body">
                        <p class="">We retain your personal information for as long as necessary to fulfill the
                            purposes outlined in this Privacy Policy, comply with legal obligations, resolve disputes, and
                            enforce our agreements.</p>
                    </div>
                </div>
            </div>

            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionSix" aria-expanded="false" aria-controls="accordionSix">
                        Your Rights
                    </button>
                </h2>

                <div id="accordionSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                    style="">
                    <div class="accordion-body">
                        <p class="">You have the following rights regarding your personal information:</p>
                        <ol>
                            <li><strong>Access: </strong>You can request access to the personal information we hold about
                                you.</li>
                            <li><strong>Correction: </strong>You can request that we correct any inaccurate or incomplete
                                information.</li>
                            <li><strong>Deletion:</strong> You can request that we delete your personal information, subject
                                to certain legal
                                limitations.</li>
                            <li><strong>Opt-Out:</strong> You can opt out of receiving promotional communications from us at
                                any time.</li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionSeven" aria-expanded="false" aria-controls="accordionSeven">
                        Changes to This Privacy Policy
                    </button>
                </h2>

                <div id="accordionSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                    style="">
                    <div class="accordion-body">
                        <p class="">We may update this Privacy Policy from time to time to reflect changes in our
                            practices or for other operational, legal, or regulatory reasons. We will notify you of any
                            significant changes by posting the new Privacy Policy on our website and updating the effective
                            date.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
