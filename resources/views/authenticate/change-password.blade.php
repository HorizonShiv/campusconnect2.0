@php
    $customizerHidden = 'customizer-hide';
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Password Change')

@section('vendor-style')
    <!-- Vendor -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
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
    <script src="{{ asset('assets/js/pages-auth-two-steps.js') }}"></script>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">

            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/illustrations/auth-two-step-illustration-' . $configData['style'] . '.png') }}"
                        alt="auth-two-steps-cover" class="img-fluid my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-two-step-illustration-light.png"
                        data-app-dark-img="illustrations/auth-two-step-illustration-dark.png">

                    <img src="{{ asset('assets/img/illustrations/bg-shape-image-' . $configData['style'] . '.png') }}"
                        alt="auth-two-steps-cover" class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Two Steps Verification -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-4 p-sm-5">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <h3 class="mb-1">Change Password <i class="fa fa-mail-bulk"></i> / <i class="fa fa-lock"></i></h3>
                    <p class="text-start mb-4">
                        OTP has been verified now you can enter the new password
                        <span class="fw-medium d-block mt-2">
                            @php
                                $email = Session::get('email');
                                $emailParts = explode('@', $email);
                                $firstCharacter = $emailParts[0][0];
                                $beforeAtStars = str_repeat('*', strlen($emailParts[0]) - 1);
                                echo "$firstCharacter$beforeAtStars@$emailParts[1]\n";
                            @endphp
                        </span>
                    </p>
                    <p class="mb-0 fw-medium">Enter the new password</p>
                    <form id="twoStepsForm" onsubmit="return checkData()" action="{{ route('changePassword') }}"
                        method="post">
                        @csrf
                        <div class="mb-3">
                            <!-- Create a hidden field which is combined by 3 fields above -->
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span onclick="changePasswordType()" class="input-group-text cursor-pointer"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                            Change Password
                        </button>

                    </form>
                </div>
            </div>
            <!-- /Two Steps Verification -->
        </div>
    </div>

@endsection
<script>
    // toast-top-center
    function checkData() {
        var password = document.getElementById("password").value;
        if (password == "") {
            toastr.error('Enter the password');
            return false;
        } else {
            return true;
        }
    }

    function changePasswordType() {
        var passwordField = document.getElementById("password").value;
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>
