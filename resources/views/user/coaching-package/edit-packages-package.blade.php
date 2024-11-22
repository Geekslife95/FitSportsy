@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Update Coaching Package'))
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.css" integrity="sha512-m52YCZLrqQpQ+k+84rmWjrrkXAUrpl3HK0IO4/naRwp58pyr7rf5PO1DbI2/aFYwyeIH/8teS9HbLxVyGqDv/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .hidden{display:none;}
</style>
@endpush
<section class="page-wrapper">
    <div class="content container-fluid">
      
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="{{$addLink}}" method="POST" id="event_form" name="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Package Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="package_name" class="form-label">Package Name <span class="text-danger">*</span></label>      
                                        <input type="text" name="package_name" id="package_name" class="form-control" placeholder="Enter Package Name" value="{{$packageData->package_name}}"  required>
                                    </div>
                                </div>
                            
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="package_price" class="form-label">Package Price (In ₹)<span class="text-danger">*</span></label>      
                                        <input type="number" name="package_price" id="package_price" class="form-control" placeholder="Enter Package Price" value="{{$packageData->package_price + 0}}" required>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="batch_size" class="form-label">Batch Size <span class="text-danger">*</span></label>      
                                        <input type="text" name="batch_size" id="batch_size" value="{{$packageData->batch_size}}" class="form-control" placeholder="Enter Batch Size" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="package_discount" class="form-label">Discount(In %) <span class="text-danger">*</span></label>      
                                        <input type="number" max="100" min="0" name="package_discount" id="package_discount" class="form-control" placeholder="Enter Discount" value="{{$packageData->discount_percent}}" value="0" required>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="platform_fee" class="form-label">Who will pay Fitsportsy fee <span class="text-danger">*</span></label>      
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="{{$packageFee['plateform_fee_me']}}" {{$packageFee['plateform_fee_me']==$packageData['platform_fee_pay_by'] ? 'checked': ''}} />
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="{{$packageFee['plateform_fee_buyer']}}"  {{$packageFee['plateform_fee_buyer']==$packageData['platform_fee_pay_by'] ? 'checked': ''}} />
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="gateway_fee" class="form-label">Who will pay Payment Gateway fee <span class="text-danger">*</span></label>      
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="gateway_fee" value="{{$packageFee['gateway_fee_me']}}" {{$packageFee['gateway_fee_me']==$packageData['gateway_fee_pay_by'] ? 'checked': ''}} />
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="gateway_fee" value="{{$packageFee['gateway_fee_buyer']}}" {{$packageFee['gateway_fee_buyer']==$packageData['gateway_fee_pay_by'] ? 'checked': ''}} />
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>      
                                        <textarea name="description" id="description" class="form-control" placeholder="Enter Description" rows="5" required>{{$packageData->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 d-none">
                                    <h6>Session Timing</h6>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12 d-none">
                                    <div class="form-group">
                                        <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>      
                                        <input type="text" name="start_time" id="start_time" class="form-control time_picker" placeholder="Enter Start Time" value="{{$packageData->session_start_time}}" required>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-12 col-12 d-none">
                                    <div class="form-group">
                                        <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>      
                                        <input type="text" name="end_time" id="end_time" class="form-control time_picker" placeholder="Enter End Time" value="{{$packageData->session_end_time}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12 d-none">
                                    <div class="form-group">
                                        <h6 for="">Session Days <span class="text-danger">*</span></h6>
                                        <p id="check_err" class="text-danger"></p>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            @php
                                                // $days = json_decode($packageData->session_days,true);
                                                $days = [];
                                            @endphp
                                            @foreach (Common::daysArr() as $day)
                                                <label class="radio-label selectgroup-item w-auto">
                                                    <input type="checkbox" name="session_days[]" value="{{$day}}" class="selectgroup-input" {{in_array($day,$days) ? 'checked':''}}>
                                                    <span class="selectgroup-button">{{$day}}</span>
                                                </label>
                                            @endforeach  
                                        </div>
                                    </div>
                                   
                                </div>

                                @php
                                    $packageT = explode(" ",($packageData->package_duration == null ? '1 Mo' : $packageData->package_duration));

                                @endphp

                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="duration" class="form-label">Duration (No. of week/month/year) <span class="text-danger">*</span></label>      
                                        <input type="number" name="duration" id="duration" class="form-control" placeholder="Enter Duration" value="{{$packageT[0]}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="duration_type" class="form-label">Duration Type <span class="text-danger">*</span></label>      
                                        <select name="duration_type" id="duration_type" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach (Common::packageDurationTypes() as $type)
                                                <option value="{{ $type }}" {{$packageT[1] == $type ? 'selected' : ''}}>{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_sold_out" class="form-label">Sold Out <span class="text-danger">*</span></label>      
                                        <select name="is_sold_out" id="is_sold_out" class="form-control" required>
                                            <option value="1" {{$packageData->is_sold_out == 1 ? "selected"  : ""}}>Yes</option>
                                            <option value="0" {{$packageData->is_sold_out == 0 ? "selected"  : ""}}>No</option>
                                        </select>
                                    </div>
                                </div>
                               

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <h6>Payment Buttons <span>(Select to show on payment page)</span></h6>
                                        <div class="d-flex">
                                            <div class="custom-checkbox mr-3">
                                              <input type="checkbox" id="pay_now" name="is_pay_now" value="1" {{$packageData->is_pay_now == 1 ? "checked"  : ""}}>
                                              <label for="pay_now" class="ml-2">Pay Now</label>
                                            </div>
                                            <div class="custom-checkbox ml-3">
                                              <input type="checkbox" id="pay_venue" name="is_venue_pay" value="1" {{$packageData->is_venue_pay == 1 ? "checked"  : ""}}>
                                              <label for="pay_venue" class="ml-2">Pay At Venue</label>
                                            </div>
                                          </div>
                                    </div>
                                   
                                      <p id="check_err" class="text-danger"></p>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="continue_btn" class="btn btn-primary d-block">Update Package</button>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js" integrity="sha512-6rE6Bx6fCBpRXG/FWpQmvguMWDLWMQjPycXMr35Zx/HRD9nwySZswkkLksgyQcvrpYMx0FELLJVBvWFtubZhDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
         $('#description').summernote({
                height: 200,
                minHeight: 100,
                toolbar: [],
        });
    });
</script>
<script>
    $(".time_picker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });
</script>
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
            if($("input[name='is_pay_now']:checked").length < 1 && $("input[name='is_venue_pay']:checked").length < 1){
                $("#check_err").html('select payment buttons to show').focus() ;
            }else{
                document.event_form.submit();
                $("#continue_btn").attr('disabled','disabled').text('Processing...');
            }
            // var checkedLength = 0;
            // $("input[name='session_days[]']").each(function(){
            //     if($(this).is(':checked')){
            //         checkedLength++;
            //     }
            // })
            // if(checkedLength < 1){
                // $("#check_err").html('select one or more session days').focus() ;
            // }else{
                // document.event_form.submit();
                // $("#continue_btn").attr('disabled','disabled').text('Processing...');
            // }
            
        }
    });
</script>

@endpush
@endsection