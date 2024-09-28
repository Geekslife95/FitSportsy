<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $favicon = Common::siteGeneralSettings();
    @endphp
    <meta charset="utf-8">
    <link href="{{ $favicon->favicon ? url('images/upload/' . $favicon->favicon) : asset('/images/logo.png') }}" rel="icon" type="image/png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $favicon->app_name }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <link href="{{asset('f-vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('f-vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('f-css/main.css')}}" rel="stylesheet">
    
    @stack('styles')
    <style>
       .seva-ticket{
            background-image:url('{{asset("images/light-backgound.jpg")}}');
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
        }
        
        .seva-ticket .top-header{
            background-color:#323545;
            padding: 30px 15px;
            text-align: center;
        }
          .seva-ticket .top-body{
            padding: 20px 0px;
        }
    </style>
</head>
<body>

    <section class="seva-ticket">
        <div class="top-header">
            <a href="/"><img src="{{ $favicon->logo ? asset('/images/upload/' . $favicon->logo) : asset('/images/logo.png') }}" class="img-fluid" style="width:180px;height: auto;"></a>
        </div>
        <div class="top-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8">
                        <div class="">
                            
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{asset('f-vendor/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('f-vendor/bootstrap/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    @stack('scripts')
</body>   
</html>
