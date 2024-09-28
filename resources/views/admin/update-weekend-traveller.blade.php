@extends('master')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Update Weekend Travellers'),
    ])

    <div class="section-body">
        <h2 class="section-title mt-0">{{ __('Update Weekend Travellers') }}</h2>
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
                        <form method="post" enctype="multipart/form-data" action="/update-weekend">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    {{-- <img src="" width="40px" height="40px" class="rounded-circle" alt="">
                                    <label>Profile Image</label> --}}
                                    <div id="result_image" class="mt-3 d-flex align-items-center">
                                        <img src="/upload/weekend/{{$travellerDetails->profile_photo}}" width="auto" height="100px"
                                         alt="">
                                        <button type="button" class="ml-3 btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Upload Image</button>
                                    </div>     
                                    <input type="hidden" id="base64-image" name="profile_img" value="{{old('profile_img')}}">
                                    @error('profile_img') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select name="status" id="" class="form-control w-100">
                                        <option value="1" {{$travellerDetails->status == 1 ? "selected": ""}} >Active</option>
                                        <option value="0" {{$travellerDetails->status == 0 ? "selected": ""}} >Pending</option>
                                    </select>
                                    @error('status') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Name" value="{{$travellerDetails->name}}" class="form-control" required>
                                    <input type="hidden" name="id" value="{{$travellerDetails->id}}" >
                                    @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" placeholder="Email" value="{{$travellerDetails->email}}" class="form-control" required>
                                    @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Phone No.<span class="text-danger">*</span></label>
                                    <input type="number" name="phone" placeholder="Phone" value="{{$travellerDetails->phone}}" class="form-control" required>
                                    @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Location<span class="text-danger">*</span></label>
                                    <input type="text" name="location" placeholder="Current Location" value="{{$travellerDetails->location}}" class="form-control" required>
                                    @error('location') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Prefered Destinations</label>
                                    <input type="text" name="prefered_dest" placeholder="Prefered Destinations" value="{{$travellerDetails->prefered_destinations}}" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Weekend Avability</label>
                                    <select name="weekend_avability" id="" class="form-control w-100">
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Friday Evening To Sunday Evening" {{$travellerDetails->weekend_avability == "Friday Evening To Sunday Evening" ? "selected" : ""}}>Friday Evening To Sunday Evening</option>
                                        <option value="Saturday Evening To Sunday Evening" {{$travellerDetails->weekend_avability == "Saturday Evening To Sunday Evening" ? "selected" : ""}}>Saturday Evening To Sunday Evening</option>
                                        <option value="Sunday Morning To Sunday Evening" {{$travellerDetails->weekend_avability == "Saturday Evening To Sunday Evening" ? "selected" : ""}}>Sunday Morning To Sunday Evening</option>
                                        <option value="Friday Evening To Saturday Evening" {{$travellerDetails->weekend_avability == "Friday Evening To Saturday Evening" ? "selected" : ""}}>Friday Evening To Saturday Evening</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('weekend_avability') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Travel Interest</label>       
                                    <select name="travel_interest"  value="{{old('travel_interest')}}" id="" class="form-control w-100" >
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Nature" {{$travellerDetails->travel_interest == "Nature" ? "selected" : ""}}>Nature</option>
                                        <option value="City Exploration" {{$travellerDetails->travel_interest == "City Exploration" ? "selected" : ""}}>City Exploration</option>
                                        <option value="Relaxation" {{$travellerDetails->travel_interest == "Relaxation" ? "selected" : ""}}>Relaxation</option>
                                        <option value="Other" {{$travellerDetails->travel_interest == "Other" ? "selected" : ""}}>Other</option>
                                    </select>    
                                    @error('travel_interest') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Budget</label>                                    
                                    <input type="number" name="budget" placeholder="Budget" value="{{$travellerDetails->budget}}" class="form-control" >
                                    @error('budget') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Transportation</label>   
                                    <select name="transportation"  value="{{old('transportation')}}" id="" class="form-control w-100" >
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Car" {{$travellerDetails->transportation == "Car" ? "selected" : ""}}>Car</option>
                                        <option value="Train" {{$travellerDetails->transportation == "Train" ? "selected" : ""}}>Train</option>
                                        <option value="Bus" {{$travellerDetails->transportation == "Bus" ? "selected" : ""}}>Bus</option>
                                        <option value="Flight" {{$travellerDetails->transportation == "Flight" ? "selected" : ""}}>Flight</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Accomodation Prefered</label>    
                                    <select name="accod_prefered"  value="{{old('accod_prefered')}}" id="" class="form-control w-100" >
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Hotels" {{$travellerDetails->accomodation_prefered == "Hotels" ? "selected" : ""}}>Hotels</option>
                                        <option value="Airbnb" {{$travellerDetails->accomodation_prefered == "Airbnb" ? "selected" : ""}}>Airbnb</option>
                                        <option value="Camping" {{$travellerDetails->accomodation_prefered == "Camping" ? "selected" : ""}}>Camping</option>
                                    </select>    
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Companionship Preference</label>        
                                    <select name="comp_preference"  value="{{old('comp_preference')}}" id="" class="form-control w-100">
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Travel Alone" {{$travellerDetails->companionship_preference == "Travel Alone" ? "selected" : ""}}>Travel Alone</option>
                                        <option value="Travel with a Friends" {{$travellerDetails->companionship_preference == "Travel with a Friends" ? "selected" : ""}}>Travel with a Friends</option>
                                        <option value="Open To Meet New Travellers companions" {{$travellerDetails->companionship_preference == "Open To Meet New Travellers companions" ? "selected" : ""}}>Open To Meet New Travellers Companions</option>
                                    </select>     
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Travel Style</label>  
                                    <select name="travel_style"  value="{{old('travel_style')}}" id="" class="form-control w-100" >
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Spontaneous" {{$travellerDetails->travel_style == "Spontaneous" ? "selected" : ""}}>Spontaneous</option>
                                        <option value="Planned" {{$travellerDetails->travel_style == "Planned" ? "selected" : ""}}>Planned</option>
                                        <option value="Adventure" {{$travellerDetails->travel_style == "Adventure" ? "selected" : ""}}>Adventure</option>
                                        <option value="Other" {{$travellerDetails->travel_style == "Other" ? "selected" : ""}}>Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Language Spoken</label>
                                    <select name="language"  value="{{old('language')}}" id="" class="form-control w-100">
                                        <option value="" selected disabled>Choose Here</option>
                                        <option value="Hindi" {{$travellerDetails->lang == "Hindi" ? "selected" : ""}}>Hindi</option>
                                        <option value="English" {{$travellerDetails->lang == "English" ? "selected" : ""}}>English</option>
                                    </select>    
                                    @error('language') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Hobbies/Interest</label>                                    
                                    <input type="text" name="hobbies" placeholder="Hobbies/Interest" value=" {{$travellerDetails->hobbies}}" class="form-control">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Additional Comments</label>                                    
                                    <input type="text" name="additional_comments" placeholder="Additional Comments" value="{{$travellerDetails->additional_comments}}" class="form-control">
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