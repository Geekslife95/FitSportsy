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
    <section class="profile-area section-area">
        <div class="container list-bp">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-8">
                    @include('messages')
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <div>
                            <div class="mb-3 overflow-hidden">
                                <h1 class="h4 mb-0 float-left text-dark">My Profile </h1>
                            </div>
                            <hr>
                            @php
                                $userData = Auth::guard('appuser')->user();
                            @endphp
                            <form name="register_frm" id="register_frm" action="{{url("user/update-profile")}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="exampleInput1">First Name <span class="text-danger">*</span></label>
                                            <input id="exampleInput1" type="text" class="form-control"
                                                placeholder="First name" name="name" value="{{$userData->name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="exampleInput2">Last Name <span class="text-danger">*</span></label>
                                            <input id="exampleInput2" type="text" class="form-control"
                                                placeholder="Last name" name="last_name" value="{{$userData->last_name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="exampleInput3">Contact No. <span class="text-danger">*</span></label>
                                            <input id="exampleInput3" type="text" class="form-control"
                                                placeholder="Enter Mobile Number" name="phone" value="{{$userData->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="emailid">Email Address <span class="text-danger">*</span></label>
                                            <input id="email" type="text" class="form-control" placeholder="Enter Email" name="email" value="{{$userData->email}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address 1 <span class="text-danger">*</span></label>
                                            <textarea class="form-control" placeholder="Enter Address here" style="height:100px;" name="address">{{$userData->address}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address 2</label>
                                            <textarea class="form-control" placeholder="Enter Address here" style="height:100px;" name="address_two">{{$userData->address_two}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-right">
                                            <button type="submit" id="continue_btn" class="btn btn-primary">Update
                                                Details</button>
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
                email: {
                    required: true,
                    email: true
                },
                name:{
                    required:true,
                    maxlength:40
                },
                last_name:{
                    required:true,
                    maxlength:40
                },
                phone:{
                    required:true,
                    number:true
                },
                address:{
                    required:true,
                    maxlength:250
                }
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
