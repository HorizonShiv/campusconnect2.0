@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Account settings - Security')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-account-settings.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-security.js') }}"></script>
    <script src="{{ asset('assets/js/modal-enable-otp.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Account Settings /</span> Security
    </h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                <li class="nav-item"><a class="nav-link" href="{{ route('users-profile', ['userId' => $userId]) }}"><i
                            class="ti-xs ti ti-users me-1"></i> Account</a></li>
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                            class="ti-xs ti ti-lock me-1"></i> Security</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('users-notification', ['userId' => $userId]) }}"><i
                            class="ti-xs ti ti-bell me-1"></i> Notifications</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('users-connection', ['userId' => $userId]) }}"><i
                            class="ti-xs ti ti-link me-1"></i> Connections</a></li>
            </ul>
            <!-- Change Password -->
            <div class="card mb-4">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <form id="formAccountSettings" action="{{ route('users-password', $userId) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="currentPassword">Current Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" name="currentPassword" id="currentPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="newPassword">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="newPassword" name="newPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" name="confirmPassword" id="confirmPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <h6>Password Requirements:</h6>
                                <ul class="ps-3 mb-0">
                                    <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                                    <li class="mb-1">At least one lowercase character</li>
                                    <li>At least one number, symbol, or whitespace character</li>
                                </ul>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Change Password -->

            <!-- Two-steps verification -->
            <div class="card mb-4">
                <h5 class="card-header">Two-steps verification</h5>
                <div class="card-body">
                    <h5 class="mb-3">Two factor authentication is not enabled yet.</h5>
                    <p class="w-75">Two-factor authentication adds an additional layer of security to your account by
                        requiring more than just a password to log in.
                        <a href="javascript:void(0);">Learn more.</a>
                    </p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#enableOTP">Enable
                        two-factor authentication</button>
                </div>
            </div>
            <!-- Modal -->
            @include('_partials/_modals/modal-enable-otp')
            <!-- /Modal -->

            <!--/ Two-steps verification -->


            <!-- Recent Devices -->
            <div class="card mb-4">
                <h5 class="card-header">Recent Devices</h5>
                <div class="table-responsive">
                    <table class="table border-top">
                        <thead>
                            <tr>
                                <th class="text-truncate">Browser</th>
                                <th class="text-truncate">Device</th>
                                <th class="text-truncate">Location</th>
                                <th class="text-truncate">Recent Activities</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td class="text-truncate"><i class='ti ti-brand-windows text-info me-2 ti-sm'></i> <span
                                        class="fw-medium">Chrome on Windows</span></td>
                                <td class="text-truncate">HP Spectre 360</td>
                                <td class="text-truncate">Switzerland</td>
                                <td class="text-truncate">10, July 2021 20:07</td>
                            </tr>
                            <tr>
                                <td class="text-truncate"><i class='ti ti-device-mobile text-danger me-2 ti-sm'></i> <span
                                        class="fw-medium">Chrome on iPhone</span></td>
                                <td class="text-truncate">iPhone 12x</td>
                                <td class="text-truncate">Australia</td>
                                <td class="text-truncate">13, July 2021 10:10</td>
                            </tr>
                            <tr>
                                <td class="text-truncate"><i class='ti ti-brand-android text-success me-2 ti-sm'></i>
                                    <span class="fw-medium">Chrome on Android</span>
                                </td>
                                <td class="text-truncate">Oneplus 9 Pro</td>
                                <td class="text-truncate">Dubai</td>
                                <td class="text-truncate">14, July 2021 15:15</td>
                            </tr>
                            <tr>
                                <td class="text-truncate"><i class='ti ti-brand-apple me-2 ti-sm'></i> <span
                                        class="fw-medium">Chrome on MacOS</span></td>
                                <td class="text-truncate">Apple iMac</td>
                                <td class="text-truncate">India</td>
                                <td class="text-truncate">16, July 2021 16:17</td>
                            </tr>
                            <tr>
                                <td class="text-truncate"><i class='ti ti-brand-windows text-info me-2 ti-sm'></i> <span
                                        class="fw-medium">Chrome on Windows</span></td>
                                <td class="text-truncate">HP Spectre 360</td>
                                <td class="text-truncate">Switzerland</td>
                                <td class="text-truncate">20, July 2021 21:01</td>
                            </tr>
                            <tr class="border-transparent">
                                <td class="text-truncate"><i class='ti ti-brand-android text-success me-2 ti-sm'></i>
                                    <span class="fw-medium">Chrome on Android</span>
                                </td>
                                <td class="text-truncate">Oneplus 9 Pro</td>
                                <td class="text-truncate">Dubai</td>
                                <td class="text-truncate">21, July 2021 12:22</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Recent Devices -->

        </div>
    </div>

@endsection
