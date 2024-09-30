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
                        <form method="post" enctype="multipart/form-data" action="/update-spiritualVolunteers">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <div class="mt-3 d-flex align-items-center" id="result_image">
                                        <img src="/upload/buddy/{{$buddyDetails->profile_photo}}" width="auto"
                                            height="100px" alt="">
                                        <button type="button" class="ml-3 btn btn-danger" data-toggle="modal"
                                            data-target="#exampleModalCenter">Upload New Image</button>
                                    </div>
                                    <input type="hidden" id="base64-image" name="profile_img" value="">
                                    @error('profile_img') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select name="status" id="" class="form-control w-100">
                                        <option value="1" {{$buddyDetails->status == 1 ? "selected": ""}}>Active
                                        </option>
                                        <option value="0" {{$buddyDetails->status == 0 ? "selected": ""}}>Pending
                                        </option>
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
                                    <input type="email" name="email" placeholder="Email"
                                        value="{{$buddyDetails->email}}" class="form-control">
                                    @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Phone No.<span class="text-danger">*</span></label>
                                    <input type="text" name="number" placeholder="Phone"
                                        value="{{$buddyDetails->phone}}" class="form-control">
                                    @error('number') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>Gender<span class="text-danger">*</span></label>
                                    <select name="gender" id="" class="form-control w-100">
                                        <option value="1" {{$buddyDetails->gender == 1 ? "selected": ""}}>Male</option>
                                        <option value="2" {{$buddyDetails->gender == 2 ? "selected": ""}}>Female
                                        </option>
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
                                    <label>Languages Spoken: <span class="text-danger">*</span></label>
                                    <select name="language" id="" class="form-control w-100" required="">
                                        <option value="" selected="" disabled="">Choose Here</option>
                                        <option value="English" {{$buddyDetails->lang == "English" ? "selected" : ""}}>English</option>
                                        <option value="Hindi" {{$buddyDetails->lang == "Hindi" ? "selected" : ""}}>Hindi</option>
                                        <option value="Spanish" {{$buddyDetails->lang == "Spanish" ? "selected" : ""}}>Spanish</option>
                                        <option value="Mandarin" {{$buddyDetails->lang == "Mandarin" ? "selected" : ""}}>Mandarin</option>
                                        <option value="Tamil" {{$buddyDetails->lang == "Tamil" ? "selected" : ""}}>Tamil</option>
                                        <option value="Others" {{$buddyDetails->lang == "Others" ? "selected" : ""}}>Others</option>
                                    </select>
                                    @error('language') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label>Location <span class="text-danger">*</span></label>
                                        <input type="text" name="location" placeholder="Location" 
                                            class="form-control" required="" value="{{$buddyDetails->location}}">
                                        @error('location') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label>Availability <span class="text-danger">*</span></label>
                                        <select name="availability"  id="" class="form-control w-100"
                                            required="">
                                            <option value="" selected="" disabled="">Choose Here</option>
                                            <option value="Full-Time" {{$buddyDetails->availability == "Full-Time" ? "selected" : ""}}>Full-Time</option>
                                            <option value="Part-Time" {{$buddyDetails->availability == "Part-Time" ? "selected" : ""}}>Part-Time</option>
                                            <option value="Weekends" {{$buddyDetails->availability == "Weekends" ? "selected" : ""}}>Weekends</option>
                                            <option value="Evenings" {{$buddyDetails->availability == "Evenings" ? "selected" : ""}}>Evenings</option>
                                        </select>
                                        @error('availability') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Areas of Interest: <span class="text-danger">*</span></label>
                                    <select name="interest"  id="" class="form-control w-100" required="">
                                        <option value="" selected="" disabled="">Choose Here</option>
                                        <option value="Event Coordination" {{$buddyDetails->areas_of_interest == "Event Coordination" ? "selected" : ""}}>Event Coordination</option>
                                        <option value="Rituals and Ceremonies" {{$buddyDetails->areas_of_interest == "Rituals and Ceremonies" ? "selected" : ""}}>Rituals and Ceremonies</option>
                                        <option value="Teaching and Education" {{$buddyDetails->areas_of_interest == "Teaching and Education" ? "selected" : ""}}>Teaching and Education</option>
                                        <option value="Community Outreach" {{$buddyDetails->areas_of_interest == "Community Outreach" ? "selected" : ""}}>Community Outreach</option>
                                        <option value="Administrative Support" {{$buddyDetails->areas_of_interest == "Administrative Support" ? "selected" : ""}}>Administrative Support</option>
                                        <option value="Other" {{$buddyDetails->areas_of_interest == "Other" ? "selected" : ""}}>Others </option>
                                    </select>
                                    @error('interest') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Skills and Expertise: <span class="text-danger">*</span></label>
                                    <select name="skills"  id="" class="form-control w-100" required="">
                                        <option value="" selected="" disabled="">Choose Here</option>
                                        <option value="Ritual Knowledge" {{$buddyDetails->skills == "Ritual Knowledge" ? "selected" : ""}}>Ritual Knowledge</option>
                                        <option value="Communication" {{$buddyDetails->skills == "Communication" ? "selected" : ""}}>Communication</option>
                                        <option value="Leadership" {{$buddyDetails->skills == "Leadership" ? "selected" : ""}}>Leadership</option>
                                        <option value="Teaching" {{$buddyDetails->skills == "Teaching" ? "selected" : ""}}>Teaching</option>
                                        <option value="Event Planning" {{$buddyDetails->skills == "Planning" ? "selected" : ""}}>Event Planning</option>
                                        <option value="Languages Spoken" {{$buddyDetails->skills == "Languages Spoken" ? "selected" : ""}}>Languages Spoken</option>
                                        <option value="Others" {{$buddyDetails->skills == "Others" ? "selected" : ""}}>Others</option>
                                    </select>
                                    @error('skills') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Preferred Spiritual Tradition:<span class="text-danger">*</span></label>
                                    <select name="tradition" id="" class="form-control w-100" required="">
                                        <option value="" selected="" disabled="">Choose Here</option>
                                        <option value="Hinduism" {{$buddyDetails->spiritual_tradition == "Hinduism" ? "selected" : ""}}>Hinduism</option>
                                        <option value="Buddhism" {{$buddyDetails->spiritual_tradition == "Buddhism" ? "selected" : ""}}>Buddhism</option>
                                        <option value="Christianity" {{$buddyDetails->spiritual_tradition == "Christianity" ? "selected" : ""}}>Christianity</option>
                                        <option value="Islam" {{$buddyDetails->spiritual_tradition == "Islam" ? "selected" : ""}}>Islam</option>
                                        <option value="Sikhism" {{$buddyDetails->spiritual_tradition == "Sikhism" ? "selected" : ""}}>Sikhism</option>
                                        <option value="Jainism" {{$buddyDetails->spiritual_tradition == "Jainism" ? "selected" : ""}}>Jainism</option>
                                        <option value="Others" {{$buddyDetails->spiritual_tradition == "Others" ? "selected" : ""}}>Others</option>
                                    </select>
                                    @error('tradition') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label>Volunteer Experience:</label>
                                        <input type="text" name="experience" placeholder="Volunteer Experience" 
                                            class="form-control" value="{{$buddyDetails->experience}}">
                                    </div>
                                    @error('experience') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label>References:</label>
                                        <input type="text" name="references" placeholder="References" 
                                            class="form-control" value="{{$buddyDetails->refer}}">
                                    </div>
                                    @error('references') <span class="text-danger">{{$message}}</span> @enderror
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