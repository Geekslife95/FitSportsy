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
                <form action="{{url('user/post-court-information')}}" method="POST" id="event_form" name="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Court Information</h5>
                        </div>
                        <div class="card-body" id="pst_hre">
                            <div class="row">
                                <div class="col-md-12 mb-3 text-right">
                                    <button class="btn btn-warning" type="button" id="add_more_court"><i class="far fa-plus-square"></i> Add More</button>
                                </div>
                            </div>
                            @php
                                $k = 0;
                            @endphp
                            @foreach ($bookData as $key=> $item)
                                <div class="row add_more_fld" data-id="{{$k}}" style="border:1px solid #ddd;padding-top:5px;padding-bottom:15px;margin-bottom:15px;">
                                    <div class="col-lg-6 col-md-12 col-12 ">
                                        <div class="form-group">
                                            <label for="court_name_{{$k}}" class="form-label">Court Name <span class="text-danger">*</span></label>      
                                            <input type="text" name="court_name[{{$k}}]" id="court_name_{{$k}}" class="form-control" placeholder="Enter Court Name" value="{{$key}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12"></div>
                                   
                                    @foreach ($item as $i=>$val)
                                        <div class="col-md-2 mb-3">
                                            <label for="">From Date</label>
                                            <input type="date" name="from_date[{{$k}}][]" placeholder="From Date" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">To Date</label>
                                            <input type="date" name="to_date[{{$k}}][]" placeholder="To Date" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">From Time</label>
                                            <input type="time" name="from_time[{{$k}}][]" placeholder="From Time" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">To Time</label>
                                            <input type="time" name="to_time[{{$k}}][]" placeholder="To Time" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Duration</label>
                                            <input type="text" name="duration[{{$k}}][]" placeholder="Duration" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="" class="d-block">-</label>
                                            @if($i==0)
                                                <button type="button" class="btn btn-warning add_more"><i class="far fa-plus-square"></i> Add More</button>
                                            @else
                                                <button type="button" class="btn btn-warning"> Remove</button>
                                            @endif
                                        </div>  
                                    @endforeach
                                      


                                </div>
                                @php
                                    $k++;
                                @endphp
                            @endforeach
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

<script>
    var x = parseInt('{{$k}}');
    $("#add_more_court").on('click',function(){
        $("#pst_hre").append(`
             <div class="row add_more_fld" data-id="${x}" style="border:1px solid #ddd;padding-top:5px;padding-bottom:15px;margin-bottom:15px;">
                <div class="col-lg-6 col-md-12 col-12 ">
                    <div class="form-group">
                        <label for="court_name_${x}" class="form-label">Court Name <span class="text-danger">*</span></label>      
                        <input type="text" name="court_name[${x}]" id="court_name_${x}" class="form-control" placeholder="Enter Court Name" value="" required>
                    </div>
                </div>
                <div class="col-md-12"></div>
                <div class="col-md-2 mb-3">
                    <label for="">From Date</label>
                    <input type="date" name="from_date[${x}][]" placeholder="From Date" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">To Date</label>
                    <input type="date" name="to_date[${x}][]" placeholder="To Date" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">From Time</label>
                    <input type="time" name="from_time[${x}][]" placeholder="From Time" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">To Time</label>
                    <input type="time" name="to_time[${x}][]" placeholder="To Time" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">Duration</label>
                    <input type="text" name="duration[${x}][]" placeholder="Duration" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="" class="d-block">-</label>
                    <button type="button" class="btn btn-warning add_more" data-id="${x}"><i class="far fa-plus-square"></i> Add More</button>
                </div>    
            </div>
        `);
        x++;
    });
</script>

<script>
    $(document).on('click','.add_more',function(){
        var xx = $(this).parents('.add_more_fld').data('id');
        $(this).parents(".add_more_fld").append(`
                <div class="col-md-2 mb-3">
                    <label for="">From Date</label>
                    <input type="date" name="from_date[${xx}][]" placeholder="From Date" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">To Date</label>
                    <input type="date" name="to_date[${xx}][]" placeholder="To Date" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">From Time</label>
                    <input type="time" name="from_time[${xx}][]" placeholder="From Time" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">To Time</label>
                    <input type="time" name="to_time[${xx}][]" placeholder="To Time" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">Duration</label>
                    <input type="text" name="duration[${xx}][]" placeholder="Duration" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="" class="d-block">-</label>
                    <button type="button" class="btn btn-warning"> Remove</button>
                </div>    
        `);
    })
</script>

@endpush
@endsection