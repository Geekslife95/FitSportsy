@extends('frontend.master', ['activePage' => 'contact'])
@section('title', __('Contact Us'))
@section('content')
    @php
        $social = \App\Models\Setting::select('Instagram','Facebook','Twitter')->find(1);
        $lat = $data->lat;
        $long = $data->long;
    @endphp
    <section class="section-area ">
        <div class="container">
            <div class="row">
                @include('messages')
                <div class="col-lg-6 col-md-6 mb-3">
                    <div class="p-4 bg-white rounded position-relative shadow-sm ">
                        <h4 class="mt-0 mb-4 text-dark">Get In Touch</h4>
                        <h6 class="text-dark"><i class="fa fa-map fa-fw pr-1"></i> Address :</h6>
                        <p class="pl-4">{{$data->address}}</p>
                        <h6 class="text-dark"><i class="fa fa-phone-alt fa-fw pr-1"></i> Phone :</h6>
                        <p class="pl-4">{{$data->phone}}</p>
                        <h6 class="text-dark"><i class="fa fa-envelope fa-fw pr-1"></i>Email :</h6>
                        <p class="pl-4"><a href="" >{{$data->email}}</a></p>
                         <h6 class="text-dark"><i class="fa fa-envelope fa-fw pr-1"></i>Social :</h6>
                        <p class="pl-4"> <a href="{{$social->Facebook}}" class="btn btn-outline-primary btn-sm mb-2"><i class="fab fa-facebook"></i> </a>
                        <a href="{{$social->Instagram}}" class="btn btn-outline-primary btn-sm mb-2"><i class="fab fa-instagram"></i> </a>
                        <a href="{{$social->Twitter}}" class="btn btn-outline-primary btn-sm mb-2"><i class="fab fa-twitter"></i> </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mb-3">
                     <div class="p-1 bg-white rounded  position-relative shadow-sm">
                        @php
                            echo '<iframe src = "https://maps.google.com/maps?q='.$lat.','.$long.'&hl=es;z=14&amp;output=embed"  width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>';
                        @endphp
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                   <div class="p-4 bg-white rounded  position-relative shadow-sm ">
                        <h4 class="mt-0 mb-4 text-dark">Enquiry Form</h4>
                        <form  id="contactForm" name="contactForm" action="{{ url('/send-to-admin') }}" method="post">
                            @csrf
                            <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Full Name" class="form-control" id="name" name="name" required >
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="email" placeholder="Email Address" class="form-control" id="email" name="email" required >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Subject <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Topic" class="form-control" name="subject" required>
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                   <div class="form-group">
                                    <label>Message <span class="text-danger">*</span></label>
                                    <textarea rows="2" cols="100" name="msg" placeholder="Message" class="form-control" id="message" required maxlength="999" ></textarea>
                                </div>
                                </div>
                            </div>
                            <div class="text-right">
                                 <button type="submit" class="btn default-btn" id="continue_btn">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
    <script> 
        $("#contactForm").validate({
            rules: {
              
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
                document.contactForm.submit();
                $("#continue_btn").attr('disabled','disabled').text('Processing...');
            }
        });
    </script>
@endpush