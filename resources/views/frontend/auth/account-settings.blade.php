@extends('frontend.master', ['activePage' => 'My Profile'])
@section('title', __('My Profile'))
@push('styles')
    <style>
        label{
            color: #000;
        }
    </style>
@endpush
@section('content')
    <section class="profile-area section-area" style="min-height: 65vh;">
        <div class="container list-bp">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6">
                    @include('messages')
                    <div class="bg-white p-3 widget shadow-sm rounded ">
                        <div>
                            <div class="mb-3 overflow-hidden">
                                <h1 class="h4 mb-0 float-left text-dark">Change Password </h1>
                            </div>
                            <hr>
                            <form name="register_frm" id="register_frm" action="{{url("user/update-user-password")}}" method="post">
                                @csrf
                               
                                <div class="row">
                                    
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="exampleInput3">Password <span class="text-danger">*</span></label>
                                            <input id="exampleInput3" type="password" class="form-control"  placeholder="Password" name="password" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="exampleInput4">Confirm Password <span class="text-danger">*</span></label>
                                            <input id="exampleInput4" type="text" class="form-control" placeholder="Confirm Password" name="confirm_password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-left">
                                            <button type="submit" id="continue_btn" class="btn btn-primary">Update
                                                Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                password: {
                    required: true,
                },
                confirm_password:{
                    required:true,
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
                $("#continue_btn").attr('disabled', 'disabled').text('Processing...');
            }
        });
    </script>
@endpush
