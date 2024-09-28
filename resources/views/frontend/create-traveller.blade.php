@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Create My Travel Buddy'))
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('f-css/ion.rangeSlider.min.css')}}">
@endpush
<section class="section-area buddy-section">
    <div class="container">
        <img src="{{asset('/images/traveller-banner.jpg')}}" class="rounded img-fluid w-100 mb-5" alt="">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                @include('messages')
                <form method="post" enctype="multipart/form-data" action="/create-traveller">
                    @csrf
                    <div class="form-card card">
                        <div class="card-header">
                            <h4 class="card-title">Personal Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <div id="result_image" class="d-flex align-items-center">
                                            <img src="/images/defaultuser1.png" width="auto" height="100px" alt="">
                                            <button type="button" class="ml-3 btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Upload Image</button>
                                        </div>
                                        <input type="hidden" id="base64-image" name="profile_img" value="{{old('profile_img')}}">
                                        @error('profile_img') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" placeholder="Name" value="{{old('name')}}" class="form-control" required>
                                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                              
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Language Spoken</label>
                                        <select name="language" value="{{old('language')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Hindi">Hindi</option>
                                            <option value="English">English</option>
                                        </select>
                                        @error('language') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Hobbies/Interest</label>
                                        <input type="text" name="hobbies" placeholder="Hobbies/Interest" value="{{old('hobbies')}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-card card">
                        <div class="card-header">
                            <h4 class="card-title">Contact Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Email<span class="text-danger">*</span></label>
                                        <input type="email" name="email" placeholder="Email" value="{{old('email')}}" class="form-control" required>
                                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <label>Phone No.<span class="text-danger">*</span></label>
                                    <input type="number" name="phone" placeholder="Phone" value="{{old('phone')}}" class="form-control" required>
                                     @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-card card">
                        <div class="card-header">
                            <h4 class="card-title">Travel Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Weekend Avability</label>
                                        <select name="weekend_avability" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Friday Evening To Sunday Evening">Friday Evening To Sunday Evening</option>
                                            <option value="Saturday Evening To Sunday Evening">Saturday Evening To Sunday Evening</option>
                                            <option value="Sunday Morning To Sunday Evening">Sunday Morning To Sunday Evening</option>
                                            <option value="Friday Evening To Saturday Evening">Friday Evening To Saturday Evening</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Travel Style</label>
                                        <select name="travel_style" value="{{old('travel_style')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Spontaneous">Spontaneous</option>
                                            <option value="Planned">Planned</option>
                                            <option value="Adventure">Adventure</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <label>Travel Interest</label>
                                    <select name="travel_interest" value="{{old('travel_interest')}}" id="" class="form-control w-100">
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Nature">Nature</option>
                                        <option value="City Exploration">City Exploration</option>
                                        <option value="Relaxation">Relaxation</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-card card">
                        <div class="card-header">
                            <h4 class="card-title">Trip Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Location<span class="text-danger">*</span></label>
                                        <input type="text" name="location" placeholder="Current Location" value="{{old('location')}}" class="form-control" required>
                                        @error('location') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Prefered Destinations</label>
                                        <input type="text" name="prefered_dest" placeholder="Prefered Destinations" value="{{old('prefered_dest')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Budget<span class="text-danger">*</span></label>
                                        <input type="number" name="budget" placeholder="Budget" value="{{old('budget')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Transportation</label>
                                        <select name="transportation" value="{{old('transportation')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Car">Car</option>
                                            <option value="Train">Train</option>
                                            <option value="Bus">Bus</option>
                                            <option value="Flight">Flight</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Accomodation Prefered</label>
                                        <select name="accod_prefered" value="{{old('accod_prefered')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Hotels">Hotels</option>
                                            <option value="Airbnb">Airbnb</option>
                                            <option value="Camping">Camping</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Companionship Preference</label>
                                        <select name="comp_preference" value="{{old('comp_preference')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Travel Alone">Travel Alone</option>
                                            <option value="Travel with a Friends">Travel with a Friends</option>
                                            <option value="Open To Meet New Travellers companions">Open To Meet New Travellers Companions</option>
                                        </select>
                                    </div>
                                </div>

                               
                            </div>
                        </div>
                    </div>
                    <div class="form-card card">
                        <div class="card-header">
                            <h4 class="card-title">Additional Comments</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        {{-- <label>Additional Comments</label> --}}
                                        <textarea name="additional_comments" placeholder="Additional Comments" value="{{old('additional_comments')}}" class="form-control" style="height: 100px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 demo-button">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>



{{-- 
<section class="section-area all-event-area">
    <div class="container mb-5">
        <img src="{{asset('/images/traveller-banner.jpg')}}" class="rounded img-fluid w-100" alt="">
    </div>
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between  mb-3 overflow-hidden">
            <h1 class="h3 mb-0 float-left">Create My Travel Buddy</h1>
        </div>
        <div class="section-body">
            <p class="section-lead"></p>
            <div class="row mt-sm-4">
                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @include('messages')
                            <form method="post" enctype="multipart/form-data" action="/create-traveller">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                   
                                        <div id="result_image" class="d-flex align-items-center">
                                            <img src="/images/defaultuser1.png" width="auto" height="100px" alt="">
                                            <button type="button" class="ml-3 btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Upload Image</button>
                                        </div>
                                        <input type="hidden" id="base64-image" name="profile_img" value="{{old('profile_img')}}">
                                        @error('profile_img') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" placeholder="Name" value="{{old('name')}}" class="form-control" required>
                                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Email<span class="text-danger">*</span></label>
                                        <input type="email" name="email" placeholder="Email" value="{{old('email')}}" class="form-control" required>
                                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Phone No.<span class="text-danger">*</span></label>
                                        <input type="number" name="phone" placeholder="Phone" value="{{old('phone')}}" class="form-control" required>
                                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Location<span class="text-danger">*</span></label>
                                        <input type="text" name="location" placeholder="Current Location" value="{{old('location')}}" class="form-control" required>
                                        @error('location') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Prefered Destinations</label>
                                        <input type="text" name="prefered_dest" placeholder="Prefered Destinations" value="{{old('prefered_dest')}}" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Weekend Avability</label>
                                        <select name="weekend_avability" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Friday Evening To Sunday Evening">Friday Evening To Sunday Evening</option>
                                            <option value="Saturday Evening To Sunday Evening">Saturday Evening To Sunday Evening</option>
                                            <option value="Sunday Morning To Sunday Evening">Sunday Morning To Sunday Evening</option>
                                            <option value="Friday Evening To Saturday Evening">Friday Evening To Saturday Evening</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Travel Interest</label>
                                        <select name="travel_interest" value="{{old('travel_interest')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Nature">Nature</option>
                                            <option value="City Exploration">City Exploration</option>
                                            <option value="Relaxation">Relaxation</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Budget<span class="text-danger">*</span></label>
                                        <input type="number" name="budget" placeholder="Budget" value="{{old('budget')}}" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Transportation</label>
                                        <select name="transportation" value="{{old('transportation')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Car">Car</option>
                                            <option value="Train">Train</option>
                                            <option value="Bus">Bus</option>
                                            <option value="Flight">Flight</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Accomodation Prefered</label>
                                        <select name="accod_prefered" value="{{old('accod_prefered')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Hotels">Hotels</option>
                                            <option value="Airbnb">Airbnb</option>
                                            <option value="Camping">Camping</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Companionship Preference</label>
                                        <select name="comp_preference" value="{{old('comp_preference')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Travel Alone">Travel Alone</option>
                                            <option value="Travel with a Friends">Travel with a Friends</option>
                                            <option value="Open To Meet New Travellers companions">Open To Meet New Travellers Companions</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Travel Style</label>
                                        <select name="travel_style" value="{{old('travel_style')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Spontaneous">Spontaneous</option>
                                            <option value="Planned">Planned</option>
                                            <option value="Adventure">Adventure</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Language Spoken</label>
                                        <select name="language" value="{{old('language')}}" id="" class="form-control w-100">
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Hindi">Hindi</option>
                                            <option value="English">English</option>
                                        </select>
                                        @error('language') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Hobbies/Interest</label>
                                        <input type="text" name="hobbies" placeholder="Hobbies/Interest" value="{{old('hobbies')}}" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Additional Comments</label>
                                        <input type="text" name="additional_comments" placeholder="Additional Comments" value="{{old('additional_comments')}}" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <button type="submit" class="btn btn-primary demo-button">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}


{{-- model --}}
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    @csrf
                    <input type="file" name="image" id="image-input" class="mb-3" accept="image/*">
                    <img src="" id="image-preview">
                    {{-- <input type="hidden" name="base64_image" id="base64-image"> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="uploadIMg">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stack('scripts')
<script src="{{ asset('f-js/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('f-js/croppie.js') }}" type="text/javascript"></script>
{{-- Model End --}}
<script>
$(document).ready(function() {
    var preview = new Croppie($('#image-preview')[0], {
        boundary: { width: 600, height: 500 },
        viewport: { width: 300, height: 400, type: 'rectangle' },
        // enableResize: true,
        // enableOrientation: true,
        // enableExif: true,
    });

    $('#image-input').on('change', function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function() {
            var base64data = reader.result;
            $('#base64-image').val(base64data);

            preview.bind({
                url: base64data
            }).then(function() {
                console.log('Croppie bind complete');
            });
        }
        reader.readAsDataURL(file);
    });

    $('#uploadIMg').on('click', function(e) {
        e.preventDefault();
        preview.result('base64').then(function(result) {
            $('#base64-image').val(result);
            $('#result_image img').attr('src', result);
        });
        $(function() {
            $('#exampleModalCenter').modal('toggle');
        });
    });
});
</script>
@endsection