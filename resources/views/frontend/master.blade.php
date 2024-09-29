<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $favicon = Common::siteGeneralSettings();
    @endphp
    <meta charset="utf-8">
    <link href="{{ $favicon->favicon ? url('images/upload/' . $favicon->favicon) : asset('/images/logo.png') }}"
        rel="icon" type="image/png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $favicon->app_name }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <link href="{{ asset('f-vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('f-vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('f-vendor/slick/slick.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('f-vendor/slick/slick-theme.min.css') }}" />
    <link href="{{ asset('f-css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('f-css/croppie.css') }}" rel="stylesheet">
    {!! JsonLdMulti::generate() !!}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    @stack('styles')
    {{-- <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=650e90bf5cec690019fc9188&product=sticky-share-buttons&source=platform" async="async"></script> --}}
</head>

<body>
    {{-- <div class="sharethis-sticky-share-buttons"></div> --}}
    <div class="sigma_preloader">
        <img src="{{ asset('/images/upload/' . $favicon->logo) }}" alt="preloader" style="width:150px;">
    </div>
    <header class="site-header sticky-top">
        <nav class="navbar navbar-expand navbar-dark topbar static-top shadow-sm bg-dark osahan-nav-top">
            <div class="container">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <a class="navbar-brand" href="/"><img
                            src="{{ $favicon->logo ? asset('/images/upload/' . $favicon->logo) : asset('/images/logo.png') }}"
                            class="img-fluid" alt style="height: 80px;width:auto;"></a>
                    <div class="d-none d-sm-inline-block form-inline mr-auto my-2 my-md-0 mw-100 ml-3 navbar-search">
                        <div class="input-group searchinput">
                            <input type="text" class="form-control bg-white border-0 small head-search-box"
                                placeholder="Search for adventures..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="list-group list-group-flush searchlist scrollbar search-result">

                            </div>
                            <div class="input-group-append">
                                <button class="btn bg-light" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow-sm animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <div class="form-inline mx-auto w-100 navbar-search">
                                    <div class="input-group searchinput">
                                        <input type="text"
                                            class="form-control bg-light border-0 small head-search-box"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="list-group list-group-flush searchlist scrollbar search-result">

                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item no-arrow mx-1 desk-seva-ticket">
                            <a class="nav-link" href="javascript:void(0);"  data-toggle="modal" data-target="#locationModal">
                               <i class="fas fa-map-marker-alt pr-1"></i>
                               <span>{{Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'Popular Locations'}}</span>
                            </a>
                        </li>

                        <li class="nav-item no-arrow mx-1">
                            <a class="nav-link" href="{{ url('my-cart') }}">
                                <i class="fas fa-cart-plus pr-1"></i>
                                @php
                                    $cartTotal = 0;
                                    if (Session::has('CART_DATA_BMJ')) {
                                        $cartTotal = count(json_decode(Session::get('CART_DATA_BMJ'), true));
                                    }
                                @endphp
                                <span class="badge badge-danger badge-counter">{{ $cartTotal }}</span>
                                <span class="text-light">Your Cart</span>
                            </a>
                        </li>

                        {{-- <li class="nav-item no-arrow mx-1">
                            <a class="nav-link" href="{{ url('my-cart') }}">
                                <i class="fas fa-cart-plus pr-1"></i>
                                @php
                                    $cartTotal = 0;
                                    if (Session::has('CART_DATA_BMJ')) {
                                        $cartTotal = count(json_decode(Session::get('CART_DATA_BMJ'), true));
                                    }
                                @endphp
                                <span class="badge badge-danger badge-counter">{{ $cartTotal }}</span>
                            </a>
                        </li> --}}
                        @if (Auth::guard('appuser')->check() == true || Auth::check() == true)


                            <li class="nav-item dropdown no-arrow mx-2">
                                @if (Auth::guard('appuser')->check())
                                    <a class="nav-link dropdown-toggle pr-0" href="#" id="userDropdown"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span
                                            class="mr-2 d-none d-lg-inline text-white ">{{ Auth::guard('appuser')->user()->name }}</span>
                                        <img class="img-profile rounded-circle"
                                            src="{{ asset('images/upload/' . Auth::guard('appuser')->user()->image) }}">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow-sm animated--grow-in"
                                        aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="{{ url('user/my-profile') }}">
                                            <i class="fas fa-user-circle fa-sm fa-fw mr-2 text-gray-600"></i>
                                            Profile
                                        </a>
                                        <a class="dropdown-item" href="{{ url('user/my-tickets') }}">
                                            <i class="fas fa-list-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                                            My Tickets
                                        </a>
                                        <a class="dropdown-item" href="{{ url('my-orders') }}">
                                            <i class="fas fa-list-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                                            My Orders
                                        </a>
                                        <a class="dropdown-item" href="{{ url('user/account-settings') }}">
                                            <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-600"></i>
                                            Account Settings
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="{{ url('logout-user') }}">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 "></i>
                                            Logout
                                        </a>
                                    </div>
                                @else
                                    <a class="nav-link dropdown-toggle pr-0" href="#" id="userDropdown"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span
                                            class="mr-2 d-none d-lg-inline text-white ">{{ Auth::user()->name }}</span>
                                        <img class="img-profile rounded-circle"
                                            src="{{ asset('images/upload/' . Auth::user()->image) }}">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow-sm animated--grow-in"
                                        aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="{{ url('admin/home') }}">
                                            <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-600"></i>
                                            Dashboard
                                        </a>
                                        <a class="dropdown-item text-danger" href="{{ url('logout-user') }}">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 "></i>
                                            Logout
                                        </a>
                                    </div>
                                @endif
                            </li>
                        @else
                            <li class="nav-item no-arrow align-self-center mx-2">
                                <a href="{{ url('user-login') }}" class="btn btn-danger btn-sm">Login/Sign up</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark osahan-nav-mid">
            <div class="container position-relative">
                <a class="mobile-seva-ticket text-white" href="javascript:void(0);"  data-toggle="modal" data-target="#locationModal">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'Location'}}</span>
                </a>
                <button class="navbar-toggler navbar-toggler-right btn btn-danger btn-sm " type="button"
                    data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> Menu
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav w-100">
                        @foreach (Common::allEventCategories() as $cat)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('all-events?category=' . $cat->id) }}">
                                    <span>{{$cat->name}}</span></a>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="/find-my-travel-buddy"><span>Find My Travel Buddy</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/weekend-traveller"><span>Weekend Travellers</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    @yield('content')
    {{-- <address class="bottom-location">
        <div class="container">
            <h5 class="text-white mb-3">Categories</h5>
            <div>
                <ul class="list-unstyled ">
                    @foreach (Common::allEventCategories() as $cat)
                    <li><a href="{{url('all-events?category='.$cat->id)}}">{{$cat->name}}</a></li>
                    @endforeach
                </ul>
            </div>
              <h5 class="text-white mb-3">Locations</h5>
            <div>
                    <ul class="list-unstyled ">
                        @foreach (Common::allEventCities() as $city)
                            <li><a href="{{url('all-events?city='.$city->id)}}">{{$city->city_name}}</a></li>
                        @endforeach
                       
                    </ul>
            </div>
        </div>
    </address> --}}
    {{-- <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 mt-4 col-lg-4 ">
                    <div class="resources">
                        <h6 class="footer-heading text-uppercase text-white fw-bold">Quick Links</h6>
                        <ul class="list-unstyled footer-link mt-4">
                            <li class="mb-1"><a href="{{url('all-events')}}" class="text-white text-decoration-none ">All Events</a></li>
                            <li class="mb-1"><a href="{{url('contact')}}" class="text-white text-decoration-none ">Contact Us</a></li>
                            <li class="mb-1"><a href="" class="text-white text-decoration-none ">Terms & Conditions </a></li>
                            <li class=""><a href="{{url('privacy-policy')}}" class="text-white text-decoration-none ">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mt-4 col-lg-4 ">
                  <div class="social">
                      <h6 class="footer-heading text-uppercase text-white fw-bold">Social Links</h6>
                      <ul class=" my-4">
                        <li class=""><a href="{{$favicon->Facebook}}" class="text-white mb-2"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li class=""><a href="{{$favicon->Instagram}}" class="text-white mb-2"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li class=""><a href="{{$favicon->Twitter}}" class="text-white mb-2"><i class="fab fa-twitter"></i> Twitter</a></li>
                    </ul>
                  </div>
              </div>
                <div class="col-sm-6 col-md-6 mt-4 col-lg-4 ">
                  <div class="contact">
                      <h6 class="footer-heading text-uppercase text-white fw-bold">Contact Us</h6>
                      <address class="mt-4 m-0 text-white mb-1"><i class="fas fa-map-marker-alt"></i> New South Block , Phase 8B , 160055</address>
                      <a href="tel:+" class="text-white mb-1 text-decoration-none d-block "><i class="fas fa-phone-alt"></i>  909090XXXX</a>
                      <a href="mailto:" class="text-white mb-1 text-decoration-none d-block "><i class="fas fa-envelope"></i> xyzdemomail@gmail.com</a>
                  </div>
                </div>
            </div>
        </div>
        <div class="text-center bg-dark text-white mt-4 p-1">
             <p class="m-0 text-center">Copyright &copy; 2023 | Made with by <a class="text-danger" target="_blank" href="https://applaudwebmedia.com/">Applaud Web Media</a></p>
        </div>
      </footer> --}}


    <address class="bottom-location">
        <div class="container">
            <div>
                <h5 class="text-white mb-2">Categories</h5>
                <ul class="list-unstyled ">
                    @foreach (Common::allEventCategories() as $cat)
                        <li><a href="{{ url('all-events?category=' . $cat->id) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Book Adventure Tickets</h5>
                <ul class="list-unstyled ">
                    @foreach (Common::allEventCities() as $city)
                        <li><a href="{{ url('all-events?city=' . $city->id) }}">{{ $city->city_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @foreach (Common::abhisheka() as $item)
            <div>
                <a href="{{url('all-events?category='.$item->id)}}" class="text-white mb-2 fw-bold">{{$item->name}}</a>
                <ul class="list-unstyled ">
                    @foreach ($item->events as $val)
                        <li><a href="{{url('event/'.$val->id.'/'.Str::slug($val->name))}}">{{$val->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
            {{-- <div>
                <h5 class="text-white mb-2">Abhisheka</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lord Shiva Abhisheka</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lord Vishnu/Balaji Abhisheka</a>
                    </li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lord Ganapathi Abhisheka</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lord Hanuman Abhisheka</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lord Navagraha Abhisheka</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2"> Navagraha Puja</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Navagraha Shanti Puja</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Kuja Rahu Shanti Puja</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rahu Brihaspati Shanti Puja</a>
                    </li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Shani Rahu Shanti Dosha Puja</a>
                    </li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Shukra Aditya Shanti Puja</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Homam</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Ayushya Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Chandi Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Dhanvantari Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Durga Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Ganapathi Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Hayagreeva Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Kala Bhairava Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lakshmi Ganapathi Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lakshmi Kubera Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Lakshmi Narasimha Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Maha Mrityunjaya Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Maha Sudarshana Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mahalakshmi Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Navagraha Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rudra Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Saraswati Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Sri Sukta Homam</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Vahan Puja</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Two Wheeler</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Four Wheeler</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Prasada Seva</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Birthday Prasada Seva</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Marriage Anniversary Prasada
                            Seva</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Navagraha Shanti Prasada Seva</a>
                    </li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Festivals Prasada Seva</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Religious & Spiritual Items</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Sacred Puja Materials</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rudraksha</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Incense & Sambrani</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Yoga Items</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Spiritual Books</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Samuhik Homam</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Maha Mrityunjaya Homam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Navagraha Homam</a></li>
                </ul>
            </div> --}}

            {{-- <div>
                <h5 class="text-white mb-2">Rafting</h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Auli</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Rishikesh</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Manali</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Kovalam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Vagamon</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Aamby Valley</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Gulmarg</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Goa</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Andaman</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Rafting in Bir</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Trekking </h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Auli</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Rishikesh</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Manali</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Kovalam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Vagamon</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Aamby Valley</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Gulmarg</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Goa</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Andaman</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Trekking in Bir</a></li>
                </ul>
            </div>
              <div>
                <h5 class="text-white mb-2">Bungee Jumping  </h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Auli</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Rishikesh</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Manali</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Kovalam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Vagamon</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Aamby Valley</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Gulmarg</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Goa</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Andaman</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bungee Jumping in Bir</a></li>
                </ul>
            </div>
             <div>
                <h5 class="text-white mb-2">Camping </h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Auli</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Rishikesh</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Manali</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Kovalam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Vagamon</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Aamby Valley</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Gulmarg</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Goa</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Andaman</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Camping in Bir</a></li>
                </ul>
            </div>
     <div>
                <h5 class="text-white mb-2">Mountain Biking   </h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Auli</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Rishikesh</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Manali</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Kovalam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Vagamon</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Aamby Valley</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Gulmarg</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Goa</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Andaman</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Mountain Biking in Bir</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Bike Rentals   </h5>
                <ul class="list-unstyled ">
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Auli</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Rishikesh</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Manali</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Kovalam</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Vagamon</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Aamby Valley</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Gulmarg</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Goa</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Andaman</a></li>
                    <li><a href="javascript:void(0)" style="pointer-events: none;">Bike Rentals  in Bir</a></li>
                </ul>
            </div> --}}
        </div>
    </address>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 mt-4 col-lg-4 ">
                    <div class="resources">
                        <h6 class="footer-heading text-uppercase text-white fw-bold">Quick Links</h6>
                        <ul class="list-unstyled footer-link mt-4">
                            <li class="mb-1"><a href="all-events" class="text-white text-decoration-none ">All
                                    Events</a></li>
                            <li class="mb-1"><a href="contact" class="text-white text-decoration-none ">Contact
                                    Us</a></li>
                            <li class="mb-1"><a href="{{url('terms-and-conditions')}}"
                                    class="text-white text-decoration-none ">Terms & Conditions </a></li>
                            <li class="mb-1"><a href="{{url('cancellation-policy')}}"
                                class="text-white text-decoration-none ">Cancellation Policy </a></li>
                            <li class=""><a href="{{url('privacy-policy')}}"
                                    class="text-white text-decoration-none ">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mt-4 col-lg-4">
                    <div class="social">
                        <h6 class="footer-heading text-uppercase text-white fw-bold">Social Links</h6>
                        <ul class=" my-4">
                            <li class=""><a href="{{ $favicon->Facebook }}" target="_blank"
                                    class="text-white mb-2"><i class="fab fa-facebook"></i> Facebook</a></li>
                            <li class=""><a href="{{ $favicon->Instagram }}" target="_blank"
                                    class="text-white mb-2"><i class="fab fa-instagram"></i> Instagram</a></li>
                            <li class=""><a href="{{ $favicon->Twitter }}" target="_blank"
                                    class="text-white mb-2"><i class="fab fa-twitter"></i> Twitter</a></li>
                            <!-- <li class=""><a href="#" class="text-white  mb-2"><i class="fab fa-whatsapp"></i> Whatsapp</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 mt-4 col-lg-4 ">
                    <div class="contact">
                        <h6 class="footer-heading text-uppercase text-white fw-bold">Contact Us</h6>
                        <a href="" class="mt-4 m-0 text-white mb-1"><i class="fas fa-map-marker-alt"></i>
                            No.191/3, 27th Cross, Kaggadasapura Main Rd, above Lenskart Showroom, C.V. Raman Nagar,
                            Bengaluru, Karnataka 560093</a>
                        <a href="tel:+91-7022190602" class="text-white mb-1 text-decoration-none d-block "><i
                                class="fas fa-phone-alt"></i> +91-7022190602</a>
                        <a href="mailto:support@bookmyadventurequest.com"
                            class="text-white mb-1 text-decoration-none d-block "><i class="fas fa-envelope"></i>
                            support@bookmyadventurequest.com</a>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="text-center bg-dark mt-4 p-2" style="color: #b5b5b5">
            <div class="container">
                <p class="m-0 small text-center">Copyright 2023 © GeeksLife Technology Solutions Pvt. Ltd. All Rights Reserved.</p>
                <p class="m-0 small text-center">The content and images used on the BookMyAdventureQuest website are copyright protected, and copyrights vest with the respective owners. The usage of the content and images on this website is intended to promote adventurous experiences, and no endorsement of any adventure provider or service shall be implied. Unauthorized use is prohibited and punishable by law.</p>
            </div>
           
        </div>
       
    </footer>

    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel"><i class="fas fa-map-marker-alt"></i>  Locations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="popular-location">
                     
                            {{-- <div class="w-auto">
                                <a href="{{ url('event-city?city=All' . '&redirect=' .request()->fullUrl()) }}"
                                    class="btn btn-outline-dark btn-sm w-100 mb-2">All</a>
                            </div> --}}
                            @php
                            $citiesAll = Common::allEventCities();
                            $citiesImages = [];
                            $citiesWimg = [];
                            foreach($citiesAll as $vl){
                                if(file_exists(public_path('images/city-icons/'.$vl->city_name.'.png'))){
                                    $citiesImages[] = $vl;
                                }else{
                                    $citiesWimg[] = $vl;
                                }
                            }
                            @endphp
                            @if(count($citiesImages) > 0)
                                <h6 class="text-center">Popular Cites</h6>
                            @endif
                           
                            <div class="d-flex flex-wrap justify-content-center" style="gap: 10px;">
                               
                                    @foreach ($citiesImages as $city)
                                        <div class="w-auto">
                                            <a href="{{ url('event-city?city=' . $city->city_name . '&redirect=' .request()->fullUrl()) }}" class="btn text-center btn-outline-secondary btn-sm "><img src="{{asset('images/city-icons/'.$city->city_name.'.png')}}" alt="" class="img-fluid d-block m-auto" style="width: 50px; height: 50px;object-fit: contain;">{{ $city->city_name }}</a>
                                        </div>
                                    @endforeach
                               
                            </div>
                            <h6 class="mt-3 text-center">Other Cites</h6>
                            <div class="d-flex flex-wrap justify-content-center" style="gap: 10px;">
                                <a href="{{ url('event-city?city=All' . '&redirect=' .request()->fullUrl()) }}"
                                    class="btn btn-outline-dark btn-sm w-auto ">All Cities</a>
                                @foreach ($citiesWimg as $city)
                                <div class="w-auto">
                                    <a href="{{ url('event-city?city=' . $city->city_name . '&redirect=' .request()->fullUrl()) }}" class="btn btn-outline-dark btn-sm w-100 m">{{ $city->city_name }}</a>
                                </div>
                                @endforeach
                            </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- Start Go Top Area -->
 <div class="go-top">
    <i class="fas fa-arrow-up"></i>
</div>

    <script src="{{ asset('f-vendor/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('f-vendor/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('f-vendor/slick/slick.min.js') }}"></script>
    @stack('scripts')
    <script>
        var timeout = null;
        $(".head-search-box").on('input', function(e) {
            var val = $(this).val().split(' ').join('_');
            if (val == '') {
                $(".search-result").html('')
            } else {
                if (e.which == 13 && val != '') {
                    //    
                }
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    $.get('{{ url('search-all-events') }}?search_str=' + val, function(data) {
                        $(".search-result").html(data);
                    })
                }, 200);
            }

        })
    </script>
    <script src="{{ asset('frontend/js/site_custom.js') }}" type="text/javascript"></script>
    <script>
        $(document).on('click', function(event) {
            if (!$(event.target).closest(".searchinput").length) {
                $(".search-result").html('')
            }

        })

        $(window).on('scroll', function(){
		var scrolled = $(window).scrollTop();
		if (scrolled > 600) $('.go-top').addClass('active');
		if (scrolled < 600) $('.go-top').removeClass('active');
	});  
	$('.go-top').on('click', function() {
		$("html, body").animate({ scrollTop: "0" },  500);
	});
    </script>
     @if(!Session::has('CURR_CITY'))
     <script>
         setTimeout(()=>{
             $('#locationModal').modal('show');
         },3000)
     </script>
     @endif

</body>

</html>