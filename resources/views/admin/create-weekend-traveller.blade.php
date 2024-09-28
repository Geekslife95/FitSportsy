@extends('master')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Add Weekend Travellers'),
    ])

    <div class="section-body">
        <h2 class="section-title mt-0">{{ __('Add Weekend Travellers') }}</h2>
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
                        <form method="post" enctype="multipart/form-data" action="/create-weekend-traveller">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Profile Image</label>
                                    <div id="result_image mt-3" class="d-flex align-items-center">
                                        <img src="" alt="">
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
                                    <label>Weekend Avability<span class="text-danger">*</span></label>
                                    <select name="weekend_avability" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Friday Evening To Sunday Evening">Friday Evening To Sunday Evening</option>
                                        <option value="Saturday Evening To Sunday Evening">Saturday Evening To Sunday Evening</option>
                                        <option value="Sunday Morning To Sunday Evening">Sunday Morning To Sunday Evening</option>
                                        <option value="Friday Evening To Saturday Evening">Friday Evening To Saturday Evening</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('weekend_avability') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Travel Interest<span class="text-danger">*</span></label>       
                                    <select name="travel_interest"  value="{{old('travel_interest')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Nature">Nature</option>
                                        <option value="City Exploration">City Exploration</option>
                                        <option value="Relaxation">Relaxation</option>
                                        <option value="Other">Other</option>
                                    </select>    
                                    @error('travel_interest') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Budget<span class="text-danger">*</span></label>                                    
                                    <input type="number" name="budget" placeholder="Budget" value="{{old('budget')}}" class="form-control" required>
                                    @error('budget') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Transportation<span class="text-danger">*</span></label>   
                                    <select name="transportation"  value="{{old('transportation')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Car">Car</option>
                                        <option value="Train">Train</option>
                                        <option value="Bus">Bus</option>
                                        <option value="Flight">Flight</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Accomodation Prefered<span class="text-danger">*</span></label>    
                                    <select name="accod_prefered"  value="{{old('accod_prefered')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Hotels">Hotels</option>
                                        <option value="Airbnb">Airbnb</option>
                                        <option value="Camping">Camping</option>
                                    </select>    
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Companionship Preference<span class="text-danger">*</span></label>        
                                    <select name="comp_preference"  value="{{old('comp_preference')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Travel Alone">Travel Alone</option>
                                        <option value="Travel with a Friends">Travel with a Friends</option>
                                        <option value="Open To Meet New Travellers companions">Open To Meet New Travellers Companions</option>
                                    </select>     
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Travel Style<span class="text-danger">*</span></label>  
                                    <select name="travel_style"  value="{{old('travel_style')}}" id="" class="form-control w-100" required>
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Spontaneous">Spontaneous</option>
                                        <option value="Planned">Planned</option>
                                        <option value="Adventure">Adventure</option>
                                        <option value="Other">Other</option>
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