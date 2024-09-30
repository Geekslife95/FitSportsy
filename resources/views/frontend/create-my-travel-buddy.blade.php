@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Create My Travel Buddy'))
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('f-css/ion.rangeSlider.min.css')}}">
<link rel="stylesheet" href="{{asset('f-css/croppie.css')}}">
@endpush
<section class="section-area buddy-section">
    <div class="container">
        <img src="{{asset('/images/buddy-banner.jpg')}}" class="rounded img-fluid w-100 mb-5" alt="">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row justify-content-center">
           
            <div class="col-lg-12 col-md-12 col-12">
                @include('messages')
                <form method="post" enctype="multipart/form-data" action="/create-spiritual-volunteers">
                    @csrf
                    
                    <div class="form-card card mb-4">
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
                                        <label>Gender<span class="text-danger">*</span></label>
                                        <select name="gender" id="" class="form-control w-100" required>
                                            <option value="{{old('gender')}}" disable>Select Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                            <option value="3">Other</option>
                                        </select>
                                        @error('gender') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Date Of Birth</label>
                                        <input type="date" name="dob" placeholder="DOB" value="{{old('dob')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <label>Languages Spoken: <span class="text-danger">*</span></label>
                                    <select name="language" value="{{old('language')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="English">English</option>
                                        <option value="Hindi">Hindi</option>
                                        <option value="Spanish">Spanish</option>
                                        <option value="Mandarin">Mandarin</option>
                                        <option value="Tamil">Tamil</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    @error('language') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-card card mb-4">
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
                                    <input type="text" name="number" placeholder="Phone" value="{{old('number')}}" class="form-control" required>
                                    @error('number') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-card card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Additional Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Location <span class="text-danger">*</span></label>
                                        <input type="text" name="location" placeholder="Location" value="{{old('Location')}}" class="form-control" required>
                                        @error('Location') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Availability <span class="text-danger">*</span></label>
                                        <select name="availability" value="{{old('availability')}}" id="" class="form-control w-100" required>
                                            <option value="" selected disabled>Choose Here</option>
                                            <option value="Full-Time">Full-Time</option>
                                            <option value="Part-Time">Part-Time</option>
                                            <option value="Weekends">Weekends</option>
                                            <option value="Evenings">Evenings</option>
                                        </select>
                                        @error('availability') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12 mb-2">
                                    <label>Areas of Interest: <span class="text-danger">*</span></label>
                                    <select name="interest" value="{{old('interest')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Event Coordination">Event Coordination</option>
                                        <option value="Rituals and Ceremonies">Rituals and Ceremonies</option>
                                        <option value="Teaching and Education">Teaching and Education</option>
                                        <option value="Other">Community Outreach</option>
                                        <option value="Other">Administrative Support</option>
                                        <option value="Other">Others </option>
                                    </select>
                                    @error('interest') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-lg-12 col-12 mb-2">
                                    <label>Skills and Expertise: <span class="text-danger">*</span></label>
                                    <select name="skills" value="{{old('skills')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Ritual Knowledge">Ritual Knowledge</option>
                                        <option value="Communication">Communication</option>
                                        <option value="Leadership">Leadership</option>
                                        <option value="Teaching">Teaching</option>
                                        <option value="Event Planning">Event Planning</option>
                                        <option value="Languages Spoken">Languages Spoken</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    @error('skills') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-lg-12 col-12 mb-2">
                                    <label>Preferred Spiritual Tradition:<span class="text-danger">*</span></label>
                                    <select name="tradition" value="{{old('tradition')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Hinduism">Hinduism</option>
                                        <option value="Buddhism">Buddhism</option>
                                        <option value="Christianity">Christianity</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Sikhism">Sikhism</option>
                                        <option value="Jainism">Jainism</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    @error('tradition') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>Volunteer Experience:</label>
                                        <input type="text" name="experience" placeholder="Volunteer Experience" value="{{old('experience')}}" class="form-control">
                                        @error('experience') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>References:</label>
                                        <input type="text" name="references" placeholder="References" value="{{old('references')}}" class="form-control">
                                        @error('references') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 demo-button">Submit</button>
                </form>
            </div>
        </div>
    </div>
 </div>
</section>

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