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
        @include('user.coach-booking.top-bar')
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="{{url('user/post-coach-book-information')}}" method="POST" id="event_form" name="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Sports Available</label>
                                        <ul class="amenities">
                                            @php
                                                $exAmenities = $bookData->sports_available;
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
                                                $exAmenities = $bookData->amenities;
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

                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea name="description" id="summernote" class="form-control" style="height: 500px;">{{$bookData->description}}</textarea>
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
            if (element.attr("name") == "description") {
                error.insertAfter("#description_err");
            }else if (element.attr("name") == "event_type") {
                error.insertAfter("#event_type_err");
            }else if (element.attr("name") == "days[]") {
                error.insertAfter("#select_days_err");
            }
            else{
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js" integrity="sha512-6rE6Bx6fCBpRXG/FWpQmvguMWDLWMQjPycXMr35Zx/HRD9nwySZswkkLksgyQcvrpYMx0FELLJVBvWFtubZhDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
         $('#summernote').summernote({
                height: 200,
                minHeight: 100,
                toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["fontname", ["fontname"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                //["table", ["table"]],
                //["insert", ["link", "picture", "video"]],
                ["view", ["fullscreen", "codeview", "help"]]
            ],
        });
    });
</script>
@endpush
@endsection