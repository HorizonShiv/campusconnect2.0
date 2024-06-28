@php
    $configData = Helper::appClasses();
@endphp
<style>
    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }

    .is-hide {
        display: none;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    @include('_partials.macros', ['height' => 20])
                </span>
                <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif


    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1 ps">

        {{-- @if (Auth::user()->role == 'Super Admin') --}}
        <li class="menu-item ">
            <a href="{{ route('dashboard-crm') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-layout"></i>
                <div>Dashboard</div>
            </a>
        </li>
        {{-- @endif --}}


        @if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin')
            {{-- <li class="menu-item ">
                <a href="" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div>Users</div>
                </a>
            </li> --}}

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div>Users</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('users', ['role' => 'student']) }}" class="menu-link">
                            <div>Students</div>
                        </a>
                    </li>
                    @if (Auth::user()->role == 'Super Admin')
                        <li class="menu-item">
                            <a href="{{ route('users', ['role' => 'admin']) }}" class="menu-link">
                                <div>Admins</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 4px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </ul>

</aside>
