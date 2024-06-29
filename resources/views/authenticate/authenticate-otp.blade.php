@php
  $customizerHidden = 'customizer-hide';
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Otp Verification')

@section('vendor-style')
  <!-- Vendor -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
@endsection

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages-auth.js')}}"></script>
  <script src="{{asset('assets/js/pages-auth-two-steps.js')}}"></script>
@endsection

@section('content')
  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">

      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
          <img src="{{ asset('assets/img/illustrations/auth-two-step-illustration-'.$configData['style'].'.png') }}"
               alt="auth-two-steps-cover" class="img-fluid my-5 auth-illustration"
               data-app-light-img="illustrations/auth-two-step-illustration-light.png"
               data-app-dark-img="illustrations/auth-two-step-illustration-dark.png">

          <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}"
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
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span
                class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
            </a>
          </div>
          <!-- /Logo -->
          @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
          @endif

          @if(count($errors) > 0)
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
          @endif
          <h3 class="mb-1">OTP Verification <i class="fa fa-mail-bulk"></i> / <i class="fa fa-phone"></i></h3>
          <p class="text-start mb-4">
            We sent a verification code to your mobile/Email. Enter the code from the mobile/Email in the field below.
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
          <p class="mb-0 fw-medium">Type your 6 digit security code</p>
          <form id="twoStepsForm" action="{{ route('verifyOtp') }}" method="post">

            @csrf
            <div class="mb-3">
              <div class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                       maxlength="1" autofocus>
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                       maxlength="1">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                       maxlength="1">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                       maxlength="1">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                       maxlength="1">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                       maxlength="1">
              </div>
              <!-- Create a hidden field which is combined by 3 fields above -->
              <input type="hidden" name="otp"/>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
              Verify my account
            </button>

          </form>
          <div class="text-center">Didn't get the code?
            <form action="" method="GET">
                {{-- {{ route('resendOTP') }} --}}
              <button class="btn btn-sm btn-outline-primary" type="submit">Resend OTP</button>
            </form>
          </div>
        </div>
      </div>
      <!-- /Two Steps Verification -->
    </div>
  </div>
@endsection
