@extends('frontend.master', ['activePage' => 'login'])
@section('title', __('Book My Pooja Login'))
@section('content')
<section class="section-area login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        @include('messages')
                        <div class="text-center">
                            <h1 class="h3 text-gray-900 ">Reset Password</h1>
                        </div>
                        <hr>
                        <form class="user" action="{{url('user/resetPassword')}}" method="post" name="register_frm" id="register_frm">
                            @csrf
                            <div class="form-group">
                                 <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                    <label class="radio-label">
                                        <input type="radio" name="logintype" value="1" checked />
                                        <span>User</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="logintype" value="2"/>
                                        <span>Organizer</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                            	  <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Enter Email Address...">
                            </div>
                           
                             <button type="submit" id="continue_btn" class="btn default-btn btn-user btn-block">
                                Reset Password
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                        </div>
                        <div class="text-center">
                            <a href="{{url('user-login')}}">Back To Login!</a>
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
                email:{required:true,email:true},
            },
            messages: {},
            errorElement: 'div',
            highlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #f00' });
            },
            unhighlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #c1c1c1' });
            },
            submitHandler: function(form) {
                document.register_frm.submit();
                $("#continue_btn").attr('disabled','disabled').text('Processing...');
            }
        });
    </script>
@endpush