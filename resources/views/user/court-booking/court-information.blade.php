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
                                
                                <div class="top-block" style="border:1px solid #ddd;padding:15px;margin-bottom:15px;">
                                    <div class="row add_more_fld">
                                        <div class="col-lg-6 col-md-12 col-12 ">
                                            <div class="form-group">
                                                <label for="court_name_{{$k}}" class="form-label">Court Name <span class="text-danger">*</span></label>      
                                                <input type="text" name="court_name[{{$k}}]" id="court_name_{{$k}}" class="form-control" placeholder="Enter Court Name" value="{{$item->court_name}}" required>
                                            </div>
                                        </div>
                                        @if($k>0)
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-danger btn_top_remove">Remove</button>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="add_more_bt_block" data-id="{{$k}}">
                                        @foreach ($item->schedule_data as $i=>$val)
                                      
                                            <div class="row scdl_block">
                                                <div class="col-md-2 mb-3 scdl_dt">
                                                    <label for="">From Date</label>
                                                    <input type="date" name="from_date[{{$k}}][]" placeholder="From Date" class="form-control" value="{{$val->from_date}}" required>
                                                </div>
                                                <div class="col-md-2 mb-3 scdl_dt">
                                                    <label for="">To Date</label>
                                                    <input type="date" name="to_date[{{$k}}][]" placeholder="To Date" class="form-control" value="{{$val->to_date}}" required>
                                                </div>
                                                <div class="col-md-2 mb-3 scdl_dt">
                                                    <label for="">From Time</label>
                                                    <input type="time" name="from_time[{{$k}}][]" placeholder="" class="form-control" value="{{$val->from_time}}" required>
                                                </div>
                                                <div class="col-md-2 mb-3 scdl_dt">
                                                    <label for="">To Time</label>
                                                    <input type="time" name="to_time[{{$k}}][]" placeholder="" class="form-control" value="{{$val->to_time}}" required>
                                                </div>
                                                <div class="col-md-2 mb-3 scdl_dt">
                                                    <label for="">Duration</label>
                                                    <select name="duration[{{$k}}][]" class="form-control" required>
                                                        <option value="">Select</option>
                                                        @foreach (Common::courtBookDurationArr() as $kkk=>$duration)
                                                            <option value="{{$kkk}}" {{$kkk==$val->duration ? 'selected':''}}>{{$duration}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-3 scdl_dt">
                                                    <label for="">Price(₹)</label>
                                                    <input type="number" name="duration_amount[{{$k}}][]" placeholder="Price" class="form-control" value="{{$val->duration_amount}}" required>
                                                </div>
                                                <div class="col-md-2 mb-3 scdl_dt">
                                                   
                                                    @if($i==0)
                                                        <button type="button" class="btn btn-warning add_more"><i class="far fa-plus-square"></i> Add More</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger rmv_btm_btn scdl_dt"> Remove</button>
                                                    @endif
                                                </div>  
                                            </div>
                                        @endforeach
                                    </div>
                                    @php
                                        $k++;
                                    @endphp
                                </div>

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
    $("#event_form").on('submit',function(){
        $("#continue_btn").attr('disabled','disabled').text('Processing...');
    });
</script>

<script>
    var x = parseInt('{{$k}}');
    $("#add_more_court").on('click',function(){
        $("#pst_hre").append(`
            <div class="top-block" style="border:1px solid #ddd;padding:15px;margin-bottom:15px;">
                <div class="row add_more_fld">
                    <div class="col-lg-6 col-md-12 col-12 ">
                        <div class="form-group">
                            <label for="court_name_${x}" class="form-label">Court Name <span class="text-danger">*</span></label>      
                            <input type="text" name="court_name[${x}]" id="court_name_${x}" class="form-control" placeholder="Enter Court Name" value="" required>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-danger btn_top_remove">Remove</button>
                    </div>
                </div>
                <div class="add_more_bt_block" data-id="${x}">
                    <div class="row scdl_block">
                        <div class="col-md-2 mb-3">
                            <label for="">From Date</label>
                            <input type="date" name="from_date[${x}][]" placeholder="From Date" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="">To Date</label>
                            <input type="date" name="to_date[${x}][]" placeholder="To Date" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="">From Time</label>
                            <input type="time" name="from_time[${x}][]" placeholder="" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="">To Time</label>
                            <input type="time" name="to_time[${x}][]" placeholder="" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="">Duration</label>
                             <select name="duration[${x}][]" class="form-control" required>
                                <option value="">Select</option>
                                @foreach (Common::courtBookDurationArr() as $kkk=>$duration)
                                    <option value="{{$kkk}}">{{$duration}}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-md-2 mb-3 scdl_dt">
                            <label for="">Price(₹)</label>
                            <input type="number" name="duration_amount[${x}][]" placeholder="Price" class="form-control" value="" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="button" class="btn btn-warning add_more"><i class="far fa-plus-square"></i> Add More</button>
                        </div>  
                    </div>
                </div>  
            </div>
        `);
        x++;
        $("input[type=time]").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    });
</script>

<script>
    $(document).on('click','.add_more',function(){
        var xx = $(this).parents('.add_more_bt_block').data('id');
        $(this).parents(".add_more_bt_block").append(`
            <div class="row scdl_block">
                <div class="col-md-2 mb-3">
                    <label for="">From Date</label>
                    <input type="date" name="from_date[${xx}][]" placeholder="From Date" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">To Date</label>
                    <input type="date" name="to_date[${xx}][]" placeholder="To Date" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">From Time</label>
                    <input type="time" name="from_time[${xx}][]" placeholder="" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">To Time</label>
                    <input type="time" name="to_time[${xx}][]" placeholder="" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">Duration</label>
                     <select name="duration[${xx}][]" class="form-control" required>
                        <option value="">Select</option>
                        @foreach (Common::courtBookDurationArr() as $kkk=>$duration)
                            <option value="{{$kkk}}">{{$duration}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3 scdl_dt">
                            <label for="">Price(₹)</label>
                            <input type="number" name="duration_amount[${xx}][]" placeholder="Price" class="form-control" value="" required>
                        </div>
                <div class="col-md-2 mb-3">
                    <button type="button" class="btn btn-danger rmv_btm_btn"> Remove</button>
                </div>    
            </div>
        `);
        $("input[type=time]").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    })
</script>

<script>
    $(document).on('click','.rmv_btm_btn',function(){
        $(this).parents('.scdl_block').remove();
    })
</script>
<script>
    $(document).on('click','.btn_top_remove',function(){
        $(this).parents('.top-block').remove();
    })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $("input[type=time]").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });
</script>

@endpush
@endsection