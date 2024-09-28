@extends('master')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Update Buddy'),
    ])

    <div class="section-body">
        <h2 class="section-title mt-0">{{ __('Update Buddy') }}</h2>
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
                        <form method="post" enctype="multipart/form-data" action="/update-buddy">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    {{-- <img src="/upload/buddy/{{$buddyDetails->profile_photo}}" class="rounded-circle"
                                        height="40px" width="40px" alt=""> --}}
                                        <div class="mt-3 d-flex align-items-center" id="result_image">
                                            <img src="/upload/buddy/{{$buddyDetails->profile_photo}}" width="auto"
                                                height="100px" alt="">
                                            <button type="button" class="ml-3 btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Upload New Image</button>
                                       </div>
                                    <input type="hidden" id="base64-image" name="profile_img" value="">
                                    @error('profile_img') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            <div class="form-group col-lg-6">
                                <label>Status<span class="text-danger">*</span></label>
                                <select name="status" id="" class="form-control w-100">
                                    <option value="1" {{$buddyDetails->status == 1 ? "selected": ""}}>Active</option>
                                    <option value="0" {{$buddyDetails->status == 0 ? "selected": ""}}>Pending</option>
                                </select>
                                @error('status') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" placeholder="Name" value="{{$buddyDetails->name}}"
                                    class="form-control">
                                <input type="hidden" name="id" value="{{$buddyDetails->id}}">
                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="email" name="email" placeholder="Email" value="{{$buddyDetails->email}}"
                                    class="form-control">
                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Phone No.<span class="text-danger">*</span></label>
                                <input type="text" name="number" placeholder="Phone" value="{{$buddyDetails->phone}}"
                                    class="form-control">
                                @error('number') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-2">
                                <label>Gender<span class="text-danger">*</span></label>
                                <select name="gender" id="" class="form-control w-100">
                                    <option value="1" {{$buddyDetails->gender == 1 ? "selected": ""}}>Male</option>
                                    <option value="2" {{$buddyDetails->gender == 2 ? "selected": ""}}>Female</option>
                                    <option value="3" {{$buddyDetails->gender == 3 ? "selected": ""}}>Other</option>
                                </select>
                                @error('gender') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Date Of Birth</label>
                                <input type="date" name="dob" placeholder="DOB" value="{{$buddyDetails->dob}}"
                                    class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Current Location<span class="text-danger">*</span></label>
                                <input type="text" name="location" placeholder="Current Location"
                                    value="{{$buddyDetails->location}}" class="form-control">
                                @error('location') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Destination</label>
                                <input type="text" name="destination" placeholder="Destination"
                                    value="{{$buddyDetails->destination}}" class="form-control">
                                @error('destination') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Travel Date</label>
                                <input type="date" name="travel_date" placeholder="Travel Date"
                                    value="{{$buddyDetails->travel_dates}}" class="form-control">
                                @error('travel_date') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Travel Interest</label>
                                <input type="text" name="travel_interest" placeholder="Travel Interest"
                                    value="{{$buddyDetails->travel_interests}}" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Budget</label>
                                <input type="number" name="budget" placeholder="Budget"
                                    value="{{$buddyDetails->budget}}" class="form-control">
                                @error('budget') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Travel Preference</label>
                                <input type="text" name="travel_preference" placeholder="Travel Preference"
                                    value="{{$buddyDetails->travel_preference}}" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Language Spoken</label>
                                <input type="text" name="language" placeholder="Language Spoken"
                                    value="{{$buddyDetails->lang}}" class="form-control">
                                @error('language') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Hobbies/Interest</label>
                                <input type="text" name="hobbies" placeholder="Hobbies/Interest"
                                    value="{{$buddyDetails->hobbies}}" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Travel Style</label>
                                <input type="text" name="travel_style" placeholder="Travel Style"
                                    value="{{$buddyDetails->travel_style}}" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Trip Description</label>
                                <input type="text" name="travel_description" placeholder="Travel Description"
                                    value="{{$buddyDetails->trip_desc}}" class="form-control">
                                @error('travel_description') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Additional Comments</label>
                                <input type="text" name="additional_comments" placeholder="Additional Comments"
                                    value="{{$buddyDetails->Additional_comment}}" class="form-control">
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
            boundary: {
                width: 600,
                height: 500
            },
            viewport: {
                width: 300,
                height: 400,
                type: 'rectangle'
            },
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