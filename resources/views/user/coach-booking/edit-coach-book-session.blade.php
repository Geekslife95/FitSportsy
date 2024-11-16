@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Information'))
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
        @include('user.coach-booking.edit-top-bar', ['type' => 'session_details', 'bookData' => $bookData])
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="{{ $updateLink }}" method="POST" id="event_form" name="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Session Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="session_duration" class="form-label">Session Duration (In Min)<span class="text-danger">*</span></label>      
                                        <input type="number" name="session_duration" id="session_duration" class="form-control" placeholder="Enter Session Duration (In Min)" value="{{$bookDataSD->session_duration}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="act_more">
                                @foreach ($bookDataSD->activities as $k=>$activity)
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group">
                                                <label for="activity_{{$k}}" class="form-label">Activity<span class="text-danger">*</span></label>      
                                                <input type="text" name="activity[{{$k}}]" id="activity_{{$k}}" class="form-control" placeholder="Enter Activity" value="{{$activity->activity}}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group">
                                                <label for="time_{{$k}}" class="form-label">Activity Duration (In Min)<span class="text-danger">*</span></label>      
                                                <input type="number" name="time[{{$k}}]" id="time_{{$k}}" class="form-control" placeholder="Enter Duration" value="{{$activity->activity_duration}}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group">
                                                <label for="" class="d-block">-</label>
                                                <button type="button" class="btn btn-sm btn-primary" id="add_more_activ">Add More</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label for="calories" class="form-label">Calories<span class="text-danger">*</span></label>      
                                        <select name="calories" id="calories" class="form-control">
                                            <option value="">Select Calories</option>
                                            @foreach (Common::caloriesArr() as $calory)
                                                <option value="{{ $calory }}" {{ $calory == $bookDataSD->calories ? 'selected' : '' }}>{{ $calory }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" name="calories" id="calories" class="form-control" placeholder="Enter Calories" value="{{$bookDataSD->calories}}" required> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label for="intensity" class="form-label">Intensity<span class="text-danger">*</span></label>      
                                        <select name="intensity" class="form-control" id="intensity" required>
                                            <option value="">Select</option>
                                            @foreach (Common::sportIntensityArr() as $intensity)
                                                <option value="{{ $intensity }}" {{ $intensity == $bookDataSD->intensity ? 'selected' : '' }}>{{ $intensity }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Benefits<span class="text-danger">*</span></label>
                                        @php
                                            $benefits = !is_array($bookDataSD->benefits) ? json_decode($bookDataSD->benefits,true) : $bookDataSD->benefits;
                                        @endphp
                                        <select name="benefits[]" class="form-control select2" multiple required>
                                            <option disabled>Select Benefits</option>
                                            @foreach (Common::allBenefits($categoryId) as $benefit)
                                                <option  {{in_array($benefit,$benefits) ? 'selected':''}}>{{$benefit}}</option>
                                            @endforeach
                                        </select>
                                        <div id="benefits_err"></div>
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
            if (element.attr("name") == "benefits[]") {
                error.insertAfter("#benefits_err");
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

<script>
    var x = '{{count($bookDataSD->activities)}}';
    $(document).on('click',"#add_more_activ",function(){
        $(".act_more").append(`
        <div class="row prnt_dv">
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <label for="activity_${x}" class="form-label">Activity<span class="text-danger">*</span></label>      
                    <input type="text" name="activity[${x}]" id="activity_${x}" class="form-control" placeholder="Enter Activity" value="" required>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <label for="time_${x}" class="form-label">Activity Duration (In Min)<span class="text-danger">*</span></label>      
                    <input type="number" name="time[${x}]" id="time_${x}" class="form-control" placeholder="Enter Duration" value="" required>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <label for="" class="d-block">-</label>
                    <button type="button" class="btn btn-sm btn-danger rem_act">Remove</button>
                </div>
            </div>
        </div>`);
        x++;
    })
</script>

<script>
    $(document).on('click','.rem_act',function(){
        $(this).parents('.prnt_dv').remove();
    })
</script>

@endpush
@endsection