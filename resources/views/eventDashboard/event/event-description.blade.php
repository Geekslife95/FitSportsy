@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.css" integrity="sha512-m52YCZLrqQpQ+k+84rmWjrrkXAUrpl3HK0IO4/naRwp58pyr7rf5PO1DbI2/aFYwyeIH/8teS9HbLxVyGqDv/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
ul.amenities {
    list-style-type: none;
  }
  
  .amenities li {
    display: inline-block;
  }
  
  .amenities input[type="checkbox"][id^="myCheckbox"] {
    display: none;
  }
  
  .amenities label {
    border: 1px solid #fff;
    padding: 10px;
    display: block;
    position: relative;
    margin: 10px;
    cursor: pointer;
  }
  
  .amenities label:before {
    background-color: white;
    color: white;
    content: " ";
    display: block;
    border-radius: 50%;
    border: 1px solid grey;
    position: absolute;
    top: -5px;
    left: -5px;
    width: 25px;
    height: 25px;
    text-align: center;
    line-height: 28px;
    transition-duration: 0.4s;
    transform: scale(0);
  }
  
  .amenities label img {
    height: 100px;
    width: 100px;
    transition-duration: 0.2s;
    transform-origin: 50% 50%;
  }
  
  :checked + label {
    border-color: #ddd;
  }
  
  :checked + label:before {
    content: "✓";
    background-color: rgb(6, 249, 59);
    transform: scale(1);
  }
  
  :checked + label img {
    transform: scale(0.9);
    /* box-shadow: 0 0 5px #333; */
    z-index: -1;
  }
  </style>
@endpush
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('eventDashboard.common-links')
        @include('messages')
        @isset($checkEvent) @php $checkEvent = json_decode($checkEvent->description_info,true); @endphp @endisset
        {{-- @php dd($checkEvent); @endphp --}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="" method="POST" id="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Description</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Tags</label>
                                        <select name="tags[]" class="form-control select2Tags" multiple>
                                            <option disabled>Select Tags</option>
                                            @isset($checkEvent['tags'])
                                                @foreach ($checkEvent['tags'] as $item)
                                                    <option value="{{$item}}" selected>{{$item}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Skill Level</label>
                                        @php
                                            $exSkills = [];
                                            if(isset($checkEvent['skill_level'])){
                                                $exSkills = $checkEvent['skill_level'];
                                            }
                                        @endphp
                                        <select name="skill_level[]" class="form-control select2Tags" multiple required>
                                            <option disabled>Select Skill</option>
                                            @foreach (Common::allSkillsArr() as $skill)
                                                <option  {{in_array($skill,$exSkills) ? 'selected':''}}>{{$skill}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="session_plan" class="form-label">Coaching Session Plan</label>
                                        <select name="session_plan" id="session_plan" class="form-control select2" required>
                                            @foreach (Common::sessionPlanArr() as $opt)
                                                <option value="{{$opt}}" @isset($checkEvent['session_plan']){{$checkEvent['session_plan']==$opt ? 'selected':''}}@endisset>{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="coaching_fee" class="form-label">Coaching Fee (₹)</label>
                                        <input type="number" name="coaching_fee" id="coaching_fee" class="form-control" value="@isset($checkEvent['coaching_fee']){{$checkEvent['coaching_fee']}}@endisset" required>
                                    </div>
                                </div>


                                
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="bring_equipment" class="form-label">Bring Your Own Equipment</label>
                                        <select name="bring_equipment" id="bring_equipment" class="form-control select2" required>
                                            @foreach (Common::equipmentOptions() as $opt)
                                                <option value="{{$opt}}" @isset($checkEvent['bring_equipment']){{$checkEvent['bring_equipment']==$opt ? 'selected':''}}@endisset>{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="desc_title" class="form-label">Coaching Description Title <span class="text-danger">*</span></label>
                                        <input type="text" name="desc_title" id="desc_title" class="form-control" placeholder="Enter Description Title" value="@isset($checkEvent['desc_title']){{$checkEvent['desc_title']}}@endisset">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="eventdescription" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea name="event_description" id="summernote" class="form-control" style="height: 500px;">@isset($checkEvent['event_description']){{$checkEvent['event_description']}}@endisset</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Sports Available</label>
                                        <ul class="amenities">
                                            @php
                                                $exAmenities = [];
                                                if(isset($checkEvent['sports_available'])){
                                                    $exAmenities = $checkEvent['sports_available'];
                                                }
                                            @endphp
                                            @foreach (Common::availableSportsArr() as $key=> $ameniti)
                                                <li>
                                                    <input type="checkbox" name="sports_available[]" value="{{$ameniti['sport']}}" id="myCheckbox{{$key+100}}" {{in_array($ameniti['sport'],$exAmenities) ? 'checked':""}}/>
                                                    <label for="myCheckbox{{$key+100}}"><img src="{{$ameniti['image']}}" /></label>
                                              </li>
                                            @endforeach
                                           
                                        </ul>
                                    </div>                                    
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Amenities</label>
                                        <ul class="amenities">
                                            @php
                                                $exAmenities = [];
                                                if(isset($checkEvent['amenities'])){
                                                    $exAmenities = $checkEvent['amenities'];
                                                }
                                            @endphp
                                            @foreach (Common::amenitiesArr() as $key=> $ameniti)
                                                <li>
                                                    <input type="checkbox" name="amenities[]" value="{{$ameniti['sport']}}" id="myCheckbox{{$key}}" {{in_array($ameniti['sport'],$exAmenities) ? 'checked':""}}/>
                                                    <label for="myCheckbox{{$key}}"><img src="{{$ameniti['image']}}" /></label>
                                              </li>
                                            @endforeach
                                           
                                        </ul>
                                    </div>                                    
                                </div>
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
@endsection

@push('scripts')

<script>
    $("#event_form").validate({
       rules: {
           desc_title:{required:true},
           summernote:{required:true},
       },
       messages: {
           desc_title:{required:"* Description Title is required"},
           summernote:{required:"* Event Description is required"},
       },       
       errorElement: 'div',
       highlight: function(element, errorClass) {
           $(element).css({ border: '1px solid #f00' });
       },
       submitHandler: function(form) {
           document.event_form.submit();
           $("#continue_btn").attr('disabled','disabled').text('Processing...');
       }
   });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js" integrity="sha512-6rE6Bx6fCBpRXG/FWpQmvguMWDLWMQjPycXMr35Zx/HRD9nwySZswkkLksgyQcvrpYMx0FELLJVBvWFtubZhDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
         $('#summernote').summernote({
                height: 200,
                minHeight: 100
        });
    });
</script>

@endpush