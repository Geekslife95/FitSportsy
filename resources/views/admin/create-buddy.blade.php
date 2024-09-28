@extends('master')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Add Buddy'),
    ])

    <div class="section-body">
        <h2 class="section-title mt-0">{{ __('Add Buddy') }}</h2>
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
                        <form method="post" enctype="multipart/form-data" action="/create-buddy">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Profile Image</label>
                                    <div id="result_image" class="d-flex align-items-center">
                                        <img src="" alt="">
                                        <button type="button" class="ml-3 btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Upload Image</button>
                                    </div>     
                                    <input type="hidden" id="base64-image" name="profile_img" value="{{old('profile_img')}}">
                                    @error('profile_img') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Name" value="{{old('name')}}" class="form-control">
                                    @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" placeholder="Email" value="{{old('email')}}" class="form-control">
                                    @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Phone No.<span class="text-danger">*</span></label>
                                    <input type="text" name="number" placeholder="Phone" value="{{old('number')}}" class="form-control">
                                    @error('number') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>Gender<span class="text-danger">*</span></label>
                                    <select name="gender" id="" class="form-control w-100">
                                        <option value="{{old('gender')}}" disable>Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Other</option>
                                    </select>
                                    @error('gender') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Date Of Birth</label>
                                    <input type="date" name="dob" placeholder="DOB" value="{{old('dob')}}" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Current Location<span class="text-danger">*</span></label>
                                    <input type="text" name="location" placeholder="Current Location" value="{{old('location')}}" class="form-control">
                                    @error('location') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Destination<span class="text-danger">*</span></label>
                                    <input type="text" name="destination" placeholder="Destination" value="{{old('destination')}}" class="form-control">
                                    @error('destination') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Travel Date<span class="text-danger">*</span></label>
                                    <input type="date" name="travel_date" placeholder="Travel Date" value="{{old('travel_date')}}" class="form-control">
                                    @error('travel_date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Travel Interest</label>
                                    <select name="travel_interest" value="{{old('travel_interest')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Nature">Nature</option>
                                        <option value="City Exploration">City Exploration</option>
                                        <option value="Relaxation">Relaxation</option>
                                        <option value="Other">Other</option>
                                    </select>    
                                    @error('travel_interest') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Budget<span class="text-danger">*</span></label>                                    
                                    <input type="number" name="budget" placeholder="Budget" value="{{old('budget')}}" class="form-control">
                                    @error('budget') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Travel Preference</label>    
                                    <select name="travel_preference"  value="{{old('travel_preference')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Hotels">Hotels</option>
                                        <option value="Airbnb">Airbnb</option>
                                        <option value="Camping">Camping</option>
                                    </select>  
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Language Spoken<span class="text-danger">*</span></label>                                    
                                    <select name="language"  value="{{old('language')}}" id="" class="form-control w-100" required>
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
                                <div class="form-group col-lg-6">
                                    <label>Travel Style</label>                                    
                                    <input type="text" name="travel_style" placeholder="Travel Style" value="{{old('travel_style')}}" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Trip Description<span class="text-danger">*</span></label>                                    
                                    <input type="text" name="travel_description" placeholder="Travel Description" value="{{old('travel_description')}}" class="form-control">
                                    @error('travel_description') <span class="text-danger">{{$message}}</span> @enderror
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
</section>

{{-- model --}}
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
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
          $(function () {
            $('#exampleModalCenter').modal('toggle');
          });
      });
    });
  </script>
@endsection