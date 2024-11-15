@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Add Coaching Package'))
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                            <h5 class="card-title">Package Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="package_name" class="form-label">Package Name <span class="text-danger">*</span></label>      
                                        <input type="text" name="package_name" id="package_name" class="form-control" placeholder="Enter Package Name"  required>
                                    </div>
                                </div>
                            
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="package_price" class="form-label">Package Price (In ₹)<span class="text-danger">*</span></label>      
                                        <input type="number" name="package_price" id="package_price" class="form-control" placeholder="Enter Package Price" required>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="batch_size" class="form-label">Batch Size <span class="text-danger">*</span></label>      
                                        <input type="text" name="batch_size" id="batch_size" class="form-control" placeholder="Enter Batch Size" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="package_discount" class="form-label">Discount(In %) <span class="text-danger">*</span></label>      
                                        <input type="number" max="100" min="0" name="package_discount" id="package_discount" class="form-control" placeholder="Enter Discount" value="0" required>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="platform_fee" class="form-label">Who will pay Fitsportsy fee <span class="text-danger">*</span></label>      
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="{{$packageFee['plateform_fee_me']}}" checked />
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="{{$packageFee['plateform_fee_buyer']}}" />
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
                                                <input type="radio" name="gateway_fee" value="{{$packageFee['gateway_fee_me']}}" checked />
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="gateway_fee" value="{{$packageFee['gateway_fee_buyer']}}" />
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>      
                                        <textarea name="description" id="description" class="form-control" placeholder="Enter Description" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <h6>Session Timing</h6>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>      
                                        <input type="text" name="start_time" id="start_time" class="form-control time_picker" placeholder="Enter Start Time" required>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>      
                                        <input type="text" name="end_time" id="end_time" class="form-control time_picker" placeholder="Enter End Time" required>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <h6 for="">Session Days <span class="text-danger">*</span></h6>
                                        <p id="check_err" class="text-danger"></p>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            @foreach (Common::daysArr() as $day)
                                                <label class="radio-label selectgroup-item w-auto">
                                                    <input type="checkbox" name="session_days[]" value="{{$day}}" class="selectgroup-input">
                                                    <span class="selectgroup-button">{{$day}}</span>
                                                </label>
                                            @endforeach  
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="duration" class="form-label">Duration (No. of week/month/year) <span class="text-danger">*</span></label>      
                                        <input type="number" name="duration" id="duration" class="form-control" placeholder="Enter Duration" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="duration_type" class="form-label">Duration Type <span class="text-danger">*</span></label>      
                                        <select name="duration_type" id="duration_type" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach (Common::packageDurationTypes() as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="continue_btn" class="btn btn-primary d-block">Save Package</button>  
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
            var checkedLength = 0;
            $("input[name='session_days[]']").each(function(){
                if($(this).is(':checked')){
                    checkedLength++;
                }
            })
            if(checkedLength < 1){
                $("#check_err").html('select one or more session days').focus() ;
            }else{
                document.event_form.submit();
                $("#continue_btn").attr('disabled','disabled').text('Processing...');
            }
            
        }
    });
</script>

@endpush
@endsection