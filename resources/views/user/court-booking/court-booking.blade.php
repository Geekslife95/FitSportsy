@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .hidden{display:none;}
</style>
@endpush
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('user.court-booking.top-bar')
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="{{url('user/post-court-booking')}}" method="POST" id="event_form" name="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
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

@endpush
@endsection