@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Coach Booking'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('user.coach-booking.edit-top-bar',['bookData' => $bookData, 'type' => 'basic_info'])
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="{{$updateLink}}" method="POST" id="event_form" name="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="coaching_title" class="form-label">Coaching Title <span class="text-danger">*</span></label>      
                                        <input type="text" name="coaching_title" id="coaching_title" class="form-control" placeholder="Enter Coaching Title" value="{{$bookData->coaching_title}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="category_id" class="form-label">Select Sport <span class="text-danger">*</span></label>      
                                        <select name="category_id" id="category_id" class="form-control select2"  required>
                                            <option value="">Select Sport</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}" {{$bookData->category_id==$item->id ? 'selected':''}}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="age_group" class="form-label">Age Group <span class="text-danger">*</span></label>
                                        <select name="age_group" id="age_group" class="form-control select2" aria-invalid="false" required>
                                            <option value="">Select Age Group</option>
                                            @foreach (Common::allAgeGroup() as $age)
                                                <option value="{{$age}}" {{$bookData->age_group==$age ? 'selected':''}}>{{$age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="free_demo_session" class="form-label">Free Demo Session <span class="text-danger">*</span></label>
                                        <select name="free_demo_session" id="free_demo_session" class="form-control select2" aria-invalid="false" required>
                                            @foreach (Common::demoOptions() as $opt)
                                                <option value="{{$opt}}" {{$bookData->free_demo_session==$opt ? 'selected':''}}>{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Skill Level</label>
                                        @php
                                            $exSkills = !empty($bookData->skill_level) ? json_decode($bookData->skill_level,true) : [];
                                        @endphp
                                        <select name="skill_level[]" class="form-control select2Tags" multiple>
                                            <option disabled>Select Skill</option>
                                            @foreach (Common::allSkillsArr() as $skill)
                                                <option  {{in_array($skill,$exSkills) ? 'selected':''}}>{{$skill}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="bring_own_equipment" class="form-label">Bring Your Own Equipment <span class="text-danger">*</span></label>
                                        <select name="bring_own_equipment" id="bring_own_equipment" class="form-control select2" required>
                                            @foreach (Common::equipmentOptions() as $opt)
                                                <option value="{{$opt}}" {{$bookData->bring_own_equipment==$opt ? 'selected':''}}>{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                               
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="venue_name" class="form-label">Venue Name <span class="text-danger">*</span></label>      
                                        <input type="text" name="venue_name" id="venue_name" class="form-control" placeholder="Enter Venue Name" value="{{$bookData->venue_name}}" required>
                                    </div>
                                </div>
                            
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="venue_area" class="form-label">Venue Area <span class="text-danger">*</span></label>      
                                        <input type="text" name="venue_area" id="venue_area" class="form-control" placeholder="Enter Venue Area" value="{{$bookData->venue_area}}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="venue_address" class="form-label">Venue Address <span class="text-danger">*</span></label>      
                                        <textarea name="venue_address" id="venue_address" class="form-control" placeholder="Enter Venue Address" required>{{$bookData->venue_address}}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="venue_city" class="form-label">Venue City <span class="text-danger">*</span></label>      
                                        <select name="venue_city" id="venue_city" class="form-control select2"  required>
                                            <option value="">Select City</option>
                                            @foreach(Common::allCities() as $city)
                                                <option value="{{$city->city_name}}" {{$bookData->venue_city==$city->city_name ? 'selected':''}}>{{$city->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @if (Auth::user()->hasRole('admin'))
                                    <div class="col-lg-6 col-md-6 col-12 ">
                                        <div class="form-group">
                                            <label for="organiser_id" class="form-label">Organizer <span class="text-danger">*</span></label>
                                            <select name="organiser_id" id="organiser_id" class="form-control select2" required aria-invalid="false">
                                                <option value="">Select Organizer</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}" {{$item->id==$bookData->organiser_id ? 'selected':''}}>
                                                        {{ $item->first_name . ' ' . $item->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="continue_btn" class="btn btn-primary d-block">Next Step</button>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
     $("#event_form").validate({
        rules: {
           
        },
        messages: {
           
        },
        errorElement: 'div',
        highlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #f00' });
        },
        errorPlacement: function(error, element) {
            console.log(element);
            if (element.hasClass('select2')) {
                error.insertAfter(element.next('.select2'));
            }else if (element.hasClass('select2Tags')) {
                error.insertAfter(element.next('.select2Tags'));
            }else{
                error.insertAfter(element);
            }
        },
        unhighlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #c1c1c1' });
        },
        submitHandler: function(form) {
            document.event_form.submit();
            $("#continue_btn").attr('disabled','disabled').text('Processing...');
        }
    });
</script>

@endpush
@endsection