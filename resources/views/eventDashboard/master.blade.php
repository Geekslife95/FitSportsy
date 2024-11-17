<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $logo = Common::siteGeneralSettings()->logo;
        $favicon = Common::siteGeneralSettings();
    @endphp
    <meta charset="utf-8">
   
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link rel="manifest" href="{{ asset('/organizer_manifest.json') }}">

    <link href="{{ $favicon->favicon ? url('images/upload/' . $favicon->favicon) : asset('/images/logo.png') }}"
        rel="icon" type="image/png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $favicon->app_name }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light only">
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <link href="{{ asset('f-vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('f-vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('f-vendor/slick/slick.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('f-vendor/slick/slick-theme.min.css') }}" />

    <link href="{{ asset('event-dashboard/css/select2.min.css') }}" rel="stylesheet">
   
    <link href="{{ asset('f-css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('event-dashboard/css/dashboard.css') }}" rel="stylesheet">
    {!! JsonLdMulti::generate() !!}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <a href="user-dashboard.php" class="logo logo-small">
                    <img src="{{ $logo ? asset('/images/upload/' . $logo) : asset('/images/logo.png') }}" alt="Logo" class="img-fluid">
                </a>
            </div>
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-align-left"></i>
            </a>
            <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
                <i class="fas fa-align-left"></i>
            </a>
            <ul class="nav user-menu">

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="/images/upload/{{Auth::user()->image}}" width="40" alt="{{Auth::user()->name}}">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/organization/home">Switch Main Dashboard</a>
                        <a class="dropdown-item" href="/dashboard-logout">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->
            </ul>
        </div>
        <!-- /Header -->
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <a href="/">
                    <img src="{{ $logo ? asset('/images/upload/' . $logo) : asset('/images/logo.png') }}" class="img-fluid" alt="">
                </a>
            </div>
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    @php
                        $url = url('/');
                        $ticketArray = ["$url/dashboard-ticket-listing","$url/dashboard-add-basic-ticket","$url/dashboard-add-advance-ticket"];
                        $eventArray = ["$url/dashboard-events","$url/dashboard-event-location","$url/dashboard-event-description","$url/dashboard-event-photos"];
                    @endphp
                    @php
                        $step = Common::checkstepCount();
                        $step = ($step != NULL ? $step->step_count : 0 );
                    @endphp
                    <ul>
                        <li class="{{Request::url() == url('/').'/dashboard' ? "active" : ""}}">
                            <a href="/dashboard"><i class="fas fa-border-all"></i> <span> Dashboard</span></a>
                        </li>
                        
                        <li class="">
                            <a href="/user/bookings-at-center"><i class="fas fa-border-all"></i> <span> Bookings At Centre</span></a>
                        </li>
                        
                        {{-- <li class="{{in_array(Request::url(),$ticketArray) ? "active" : ""}}">
                            <a href="javascript:void(0)"><i class="far fa-calendar-check"></i> <span>Add Tickets</span></a>
                        </li> --}}

                        <li>
                            <a href="/organization/home"><i class="fas fa-border-all"></i> <span> Main Dashboard</span></a>
                        </li>
                        {{-- <li>
                            <a href="/user/court-booking-list"><i class="fas fa-border-all"></i> <span> Courts</span></a>
                        </li> --}}
                        <li>
                            <a href="/user/coach-booking-list"><i class="fas fa-border-all"></i> <span> Coaching Sessions</span></a>
                        </li>
                        <li>
                            <a href="/user/coaching-bookings"><i class="fas fa-border-all"></i> <span> Coaching Sessions Bookings</span></a>
                        </li>
                        <li>
                            <a href="/dashboard-logout"><i class="fas fa-cog"></i> <span> Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Sidebar -->
        @yield('content')
    </div>
    <script src="{{ asset('f-vendor/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('f-vendor/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('f-vendor/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('f-vendor/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('event-dashboard/js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('event-dashboard/js/select2.min.js')}}"></script>
    <script src="{{asset('event-dashboard/js/dashboard.js')}}"></script>
    @stack('scripts')
    <script>
        $(document).ready(function(){
            $('#toggle_btn').on('click',function(){
                if($('body').hasClass('mini-sidebar')){
                    
                }else{
                    // alert('jjj');
                    $('.sublist').hide();
                }
            })
        })
    </script>
</body>

</html>