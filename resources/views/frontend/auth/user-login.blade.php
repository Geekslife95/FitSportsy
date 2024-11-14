@extends('frontend.master', ['activePage' => 'login'])
@section('title', __('Book My Pooja Login'))
@section('content')
<style>
    @media all and (display-mode: standalone) {
        #organizerLoginRadio {
            display: none;
        }
    }
</style>
<section class="section-area login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden  shadow-sm border-0  ">
                   <div class="card-body p-0">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="p-lg-5 p-3">
                                <div class="text-center">
                                </div>
                                <div class="text-center">
                                    <h1 class="h3  mb-4">Login to FitSportsy</h1>
                                </div>
                                @include('messages')
                                <form class="user" method="post" name="register_frm" id="register_frm">
                                    @csrf
                                    <div class="form-group" style="display: none;">
                                        <h6>Login as a:</h6>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" class="type_user" name="logintype" value="1"
                                                    checked sty />
                                                <span>User</span>
                                            </label>
                                            <label class="radio-label" id="organizerLoginRadio">
                                                <input type="radio" class="type_user" name="logintype" value="2" />
                                                <span>Organiser</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control form-control-user"
                                            id="email" placeholder="Enter Email Address...">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password"
                                            class="form-control form-control-user" id="password"
                                            placeholder="Password">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember_me">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{url('user/resetPassword')}}">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <button type="submit" id="continue_btn"
                                        class="btn default-btn btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center pb-3">
                                    <a href="{{url('login-with-google')}}" class="social-use-btn ">
                                        <img src="{{asset('images/google.png')}}" alt="" class="img-fluid">
                                        <span class="ps-2">Login with Google</span>
                                    </a>
                                </div>
                                <div class="text-center">
                                    <a href="{{url('user-register')}}">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card o-hidden  shadow-sm border-0  ">
            <div class="card-body p-0">
                <div class="row justify-content-center">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"
                        style="background-image: url('{{url("images/login.png")}}');">
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center align-items-center h-100">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="p-lg-5 p-3">
                                    <div class="text-center">
                                    </div>
                                    <div class="text-center">
                                        <h1 class="h3 text-gray-900 mb-4">Login to Super Show</h1>
                                    </div>
                                    @include('messages')
                                    <form class="user" method="post" name="register_frm" id="register_frm">
                                        @csrf
                                        <div class="form-group">
                                            <h6>Login as a:</h6>
                                            <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                                <label class="radio-label">
                                                    <input type="radio" class="type_user" name="logintype" value="1"
                                                        checked />
                                                    <span>User</span>
                                                </label>
                                                <label class="radio-label" id="organizerLoginRadio">
                                                    <input type="radio" class="type_user" name="logintype" value="2" />
                                                    <span>Purohit/Temple</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="email" placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password"
                                                class="form-control form-control-user" id="password"
                                                placeholder="Password">
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck"
                                                        name="remember_me">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{url('user/resetPassword')}}">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <button type="submit" id="continue_btn"
                                            class="btn default-btn btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center pb-3">
                                        <a href="{{url('login-with-google')}}" class="social-use-btn ">
                                            <img src="{{asset('images/google.png')}}" alt="" class="img-fluid">
                                            <span class="ps-2">Login with Google</span>
                                        </a>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{url('user-register')}}">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
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