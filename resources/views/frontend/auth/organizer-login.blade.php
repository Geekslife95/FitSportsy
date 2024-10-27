@extends('frontend.master', ['activePage' => 'login'])
@section('title', __('Book My Pooja Login'))
@section('content')
@php
$favicon = Common::siteGeneralSettings();
@endphp
<style>
    @media all and (display-mode: standalone) {
        body>* {
            display: none;
        }

        #loginMobileview {
            display: block;
        }
    }
</style>
<section class="section-area login-section" id="loginMobileview">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden  shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="p-lg-5 p-3">
                            <div class="text-center">
                                {{-- <img src="{{ $favicon->logo ? asset('/images/upload/' . $favicon->logo) : asset('/images/logo.png') }}"
                                alt="" width="160" class="img-thumbnail mb-2"> --}}
                                <h1 class="h3 text-white mb-4">Organizer Login</h1>
                            </div>
                            @include('messages')
                            <form class="user" method="post" name="register_frm" id="register_frm">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control form-control-user" id="email"
                                        placeholder="Enter Email Address...">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control form-control-user"
                                        id="password" placeholder="Password">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck"
                                                name="remember_me">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{url('user/forgot-password')}}">Forgot Password?</a>
                                    </div>
                                </div>
                                <button type="submit" id="continue_btn" class="btn default-btn btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <hr>

                            <div class="text-center">
                                <a href="{{url('organizer-register')}}">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
<script>
    $("#register_frm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {},
        errorElement: 'div',
        highlight: function(element, errorClass) {
            $(element).css({
                border: '1px solid #f00'
            });
        },
        unhighlight: function(element, errorClass) {
            $(element).css({
                border: '1px solid #c1c1c1'
            });
        },
        submitHandler: function(form) {
            document.register_frm.submit();
            $("#continue_btn").attr('disabled', 'disabled').text('Loggin In...');
        }
    });
</script>
<script>
    // let main_btn = document.getElementById('main_btn');
    // let radio = document.getElementsByClassName('type_user');
    // Array.from(radio).forEach(element => {
    //     element.addEventListener('click',function(element){
    //         console.log(element.target.getAttribute("data-id"));
    //         main_btn.setAttribute("href", element.target.getAttribute("data-id"));
    //     })
    // });
</script>
@endpush