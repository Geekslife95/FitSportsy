@extends('frontend.master', ['activePage' => 'register'])
@section('title', __('Book My Pooja Organizer Register'))
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
                <div class="card o-hidden  shadow-sm border-0  ">
                    <div class="card-body p-0">
                        @if(Session::has('success'))
                        <div class="text-center mb-3">
                            <img src="{{asset('images/checked.png')}}" alt="" class="img-fluid" style="height: 150px;">
                            <h5 class="mt-3">Approval Pending</h5>
                        </div>
                        @endif
                        @include('messages')
                        @if(!Session::has('success'))
                        <div class="p-lg-5 p-3">
                            <div class="text-center">
                            </div>
                            <div class="text-center">
                                <h1 class="h3 text-white mb-4">Create Organizer Account</h1>
                                <p class="ot_err text-danger text-left"></p>
                            </div>

                            <form class="user" method="post" name="register_frm" id="register_frm">
                                @csrf
                                {{-- <div class="form-group">
                                                        <h6>Register as a:</h6>
                                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                                            <label class="radio-label">
                                                                <input type="radio" name="logintype" value="1" checked/>
                                                                <span>User</span>
                                                            </label>
                                                            <label class="radio-label">
                                                                <input type="radio" name="logintype" value="2" />
                                                                <span>Organizer</span>
                                                            </label>
                                                        </div>
                                                    </div> --}}
                                <div class="form-group">
                                    <label class="form-label">Organisation Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control form-control-user"
                                        value="{{old('first_name')}}" id="first_name" placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control form-control-user"
                                        value="{{old('last_name')}}" name="last_name" id="last_name"
                                        placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-user" value="{{old('email')}}"
                                        name="email" id="email" placeholder="Enter Email Adress">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mobile Number <span class="text-danger">*</span> <span
                                            style="font-size:10px;" class="text-muted">10 digit mobile
                                            number</span></label>
                                    <input type="number" class="form-control form-control-user"
                                        value="{{old('mobile_number')}}" id="mobile_number" name="mobile_number"
                                        placeholder="Enter Mobile number">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control form-control-user" id="password"
                                        autocomplete="new-password" name="password" placeholder="Password">
                                </div>
                                {{-- <div class="form-group">
                                    <label class="form-label">Address 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-user"
                                        value="{{old('address_one')}}" name="address_one" id="address_one"
                                        placeholder="Enter Address 1">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address 2</label>
                                    <input type="text" class="form-control form-control-user"
                                        value="{{old('address_two')}}" name="address_two" id="address_two"
                                        placeholder="Enter Address 2">
                                </div> --}}
                                <div class="form-group">
                                    <div id="recaptcha-container" class="mb-3"></div>
                                </div>

                                <button type="submit" id="continue_btn" class="btn default-btn btn-user btn-block">
                                    Register
                                </button>
                            </form>
                            <div class="mt-4" id="otp_frm" style="display: none;">
                                <p>Enter OTP sent to your mobile number</p>
                                <div class="form-group">
                                    <label class="form-label">OTP (One Time Password) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-user" id="otp_password"
                                        placeholder="OTP">
                                </div>
                                <button type="button" onclick="verify()" id="verify_btn"
                                    class="btn default-btn btn-user btn-block">
                                    Continue
                                </button>
                            </div>
                            <hr>
                            <div class="text-center">
                                <a href="{{url('organizer-login')}}">Already have an account, <b>Login</b> here</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyANStzowYhfrm3ZKv77e-gS6IY6xBI_1cA",
        authDomain: "wealthyfy-website.firebaseapp.com",
        projectId: "wealthyfy-website",
        storageBucket: "wealthyfy-website.appspot.com",
        messagingSenderId: "353694442485",
        appId: "1:353694442485:web:e25391f435c7d5e75836bc",
        measurementId: "G-VSSJ508GQJ"
    };
    firebase.initializeApp(firebaseConfig);
</script>

<script>
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible',
    });
</script>

<script>
    var sel_mob_number = '-';

    function sendOtpToMobile() {
        var number = "+91" + $("#mobile_number").val();
        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;
            $("#register_frm").hide();
            $("#otp_frm").show();
        }).catch(function(error) {
            $("#continue_btn").removeAttr('disabled').text('Register');
            $(".ot_err").text('something went wrong ...OTP not sent..check mobile number or contact administrator');
        });
    }
</script>
<script>
    $("#register_frm").validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 190
            },
            last_name: {
                maxlength: 250
            },
            email: {
                required: true,
                email: true
            },
            mobile_number: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {
            mobile_number: {
                minlength: 'Enter valid 10 digit mobile number',
                maxlength: 'Enter valid 10 digit mobile number'
            }
        },
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
        submitHandler: function(form, event) {
            event.preventDefault();
            $("#continue_btn").attr('disabled', 'disabled').text('Generating OTP...');
            sendOtpToMobile();
            // document.register_frm.submit();
        }
    });
</script>

<script>
    function verify() {
        var code = $("#otp_password").val();
        if (code != "") {
            $("#verify_btn").attr('disabled', 'disabled').text('Processing...');
            coderesult.confirm(code).then(function(result) {
                setTimeout(() => {
                    document.register_frm.submit()
                }, 2000);
            }).catch(function(error) {
                $("#verify_btn").removeAttr('disabled').text('Continue');
                $(".ot_err").prepend(`please enter valid otp sent to your mobile number`);
            });
        }
    }
</script>

@endpush