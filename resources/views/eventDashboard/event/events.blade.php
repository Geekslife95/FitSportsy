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
        @include('eventDashboard.common-links')
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="" method="POST" id="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            @isset($checkEvent)
                                @php $checkEvent = json_decode($checkEvent->basic_info,true);  @endphp
                            @endisset
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="event_name" class="form-label">Coaching Title</label>      
                                        <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Enter Coaching Title" value="@isset($checkEvent['event_name']){{$checkEvent['event_name']}}@endisset" required>
                                        @error('event_name') <div class="error">{{ $message }}</div>  @enderror
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="category_id" class="form-label">Select Sports</label>
                                        <select name="category_id" id="category_id" class="form-control select2" aria-invalid="false" required>
                                            <option  disabled selected>Select Sport</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}" @isset($checkEvent['category_id']){{$checkEvent['category_id'] == $item->id ? "selected" : "" }}@endisset >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="error">{{ $message }}</div>  @enderror
                                    </div>
                                
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="total_seats" class="form-label">Total Seats Available</label>
                                        <input type="number" name="total_seats" id="total_seats" class="form-control" placeholder="Total Seats Available" value="@isset($checkEvent['total_seats']){{$checkEvent['total_seats']}}@endisset"  required>   
                                        @error('total_seats') <div class="error">{{ $message }}</div>  @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="age_group" class="form-label">Age Group</label>
                                        <select name="age_group" id="age_group" class="form-control select2" aria-invalid="false" required>
                                            <option value="">Select Age Group</option>
                                            @foreach (Common::allAgeGroup() as $age)
                                                <option value="{{$age}}" @isset($checkEvent['age_group']){{$checkEvent['age_group'] ==  $age ? "selected" : "" }}@endisset>{{$age}}</option>
                                            @endforeach
                                        </select>
                                        @error('age_group') <div class="error">{{ $message }}</div>  @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="demo_session" class="form-label">Free Demo Session</label>
                                        <select name="demo_session" id="demo_session" class="form-control select2" aria-invalid="false" required>
                                            @foreach (Common::demoOptions() as $opt)
                                                <option value="{{$opt}}" @isset($checkEvent['demo_session']){{$checkEvent['demo_session'] ==  $opt ? "selected" : '' }}@endisset>{{$opt}}</option>
                                            @endforeach
                                        </select>
                                        @error('demo_session') <div class="error">{{ $message }}</div>  @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control select2" aria-invalid="false" required>
                                            <option value="1" @isset($checkEvent['status']){{$checkEvent['status'] == 1 ? "selected" : "" }}@endisset>Active</option>
                                            <option value="0" @isset($checkEvent['status']){{$checkEvent['status'] ==  0 ? "selected" : "" }}@endisset>Inactive</option>
                                        </select>
                                        @error('status') <div class="error">{{ $message }}</div>  @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12" style="display: none;">
                                    <div class="form-group">
                                        {{-- <label for="">Event Type</label> --}}
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            {{-- <label class="radio-label">
                                                <input type="radio" name="event_type" aria-invalid="false" value="1" @isset ($checkEvent['event_type']){{$checkEvent['event_type'] ==  1 ? "checked" : "" }}@endisset required @if (!isset($checkEvent['event_type'])){{"checked"}}@endif />
                                                <span>Particular</span>
                                            </label> --}}
                                            <label class="radio-label">
                                                <input type="radio" name="event_type" aria-invalid="false" value="2" required  checked/>
                                                <span>Reoccuring</span>
                                            </label>    
                                             {{-- <label class="radio-label">
                                                <input type="radio" name="event_type" aria-invalid="false" value="3" required @isset($checkEvent['event_type']){{$checkEvent['event_type'] ==  3 ? "checked" : "" }}@endisset />
                                                <span>On Demand</span>
                                            </label>     --}}
                                        </div>
                                        {{-- @error('event_type') <div class="error">{{ $message }}</div>  @enderror --}}
                                    </div>
                                </div>
                              
                                <div class="row col-lg-12" id="event_recurring">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="">Session Days</label>
                                            <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                                @isset($checkEvent['days'])
                                                    @php $arr = explode(',',$checkEvent['days']) @endphp
                                                @endisset
                                                @foreach (Common::daysArr() as $day)
                                                    <label class="radio-label selectgroup-item w-auto">
                                                        <input type="checkbox" name="days[]" value="{{$day}}" class="selectgroup-input"  @isset($arr){{in_array($day,$arr) ? 'checked':''}}@endisset>
                                                        <span class="selectgroup-button">{{$day}}</span>
                                                    </label>
                                                @endforeach  
                                            </div>
                                        </div>
                                    </div>
                                    @if (isset($checkEvent['slot_time']))
                                        @if($checkEvent)
                                            @php $timeSlots =  $checkEvent['slot_time']; @endphp
                                            @foreach ($timeSlots as  $k => $val)
                                                @if($k==0)
                                                    <div class="col-lg-12 row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Session Start Time</label>
                                                                <input type="time" value="{{$val['start_time']}}" name="slot_start[]" placeholder="Choose Start time" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Session End Time</label>
                                                                <input type="time" value="{{$val['end_time']}}" name="slot_end[]" placeholder="Choose End time" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label class="d-block">&nbsp;</label>
                                                                <button type="button" id="add_more_temples" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"> Add Session</i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-lg-12 row remove_slot_prnt" >
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Slot Start Time</label>
                                                                <input type="time" value="{{$val['start_time']}}" name="slot_start[]" placeholder="Choose Start time" class="form-control" required>
                                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Slot End Time</label>
                                                                <input type="time" value="{{$val['end_time']}}" name="slot_end[]" placeholder="Choose End time" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label class="d-block">&nbsp;</label>
                                                                <button type="button" class="btn btn-danger btn-sm remove_slot"><i class="fas fa-times"></i> Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif                                        
                                            @endforeach
                                        @endisset
                                    @else
                                        <div class="col-lg-12 row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>{{ __('Session Start Time') }}</label>
                                                    <input type="time" name="slot_start[]" placeholder="{{ __('Choose Start time') }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>{{ __('Session End Time') }}</label>
                                                    <input type="time" name="slot_end[]" placeholder="{{ __('Choose End time') }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="d-block">&nbsp;</label>
                                                    <button type="button" id="add_slot_btn" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"> Add Session</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if (Auth::user()->hasRole('admin'))
                                    <div class="col-lg-12 col-md-12 col-12 ">
                                        <div class="form-group">
                                            <label for="organizer_id" class="form-label">Organizer</label>
                                            <select name="organizer_id" id="organizer_id" class="form-control select2" required aria-invalid="false">
                                                <option  disabled selected>Select Organizer</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}" @isset($checkEvent['organizer_id']){{$checkEvent['organizer_id'] == $item->id ? "selected" : "" }}@endisset>
                                                        {{ $item->first_name . ' ' . $item->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="scanner_id" class="form-label">Scanner</label>
                                        <select name="scanner_id" id="scanner_id" class="form-control select2" aria-invalid="false">
                                            <option disabled selected>Select Scanner</option>
                                            @foreach ($scanner as $item)
                                            <option value="{{ $item->id }}"
                                                @isset($checkEvent['scanner_id']){{$checkEvent['scanner_id'] ==  $item->id ? "selected" : "" }}@endisset>
                                                    {{ $item->first_name . ' ' . $item->last_name }}</option>
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
            event_parent_id:{required:true},
            category_id:{required:true},
            organizer_id:{required:true},
            event_type:{required:true},
            start_time:{required:true},
            end_time:{required:true},
            'days[]':{required:true}
        },
        messages: {
            event_parent_id:{required:"* Event Name is required"},
            category_id:{required:"* Category is required"},
            organizer_id:{required:"* Organization is required"},
            event_type:{required:"* Event Type is require"},
            start_time:{required:"* Event Start Time is required"},
            end_time:{required:"* Event End Time is required"},
            'days[]':{required:"* Select one or more days"}
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
    $(document).on('click','input[name=event_type]',function(){
        var vl = $(this).val();
        if(vl==1){
            $("#event_recurring").hide();
            $("#event_particular").show();
        }else if(vl==2){
            $("#event_particular").hide();
            $("#event_recurring").show();
        }else{
            $("#event_particular").hide();
            $("#event_recurring").hide();
        }
    })
</script>
<script>
    var x = 1;
    $(document).on('click','#add_slot_btn',function(){
        $("#event_recurring").append(`<div class="col-lg-12 row remove_slot_prnt">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>{{ __('Slot Start Time') }}</label>
                        <input type="time" name="slot_start[]" placeholder="{{ __('Choose Start time') }}" class="form-control" required>
                    
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>{{ __('Slot End Time') }}</label>
                        <input type="time" name="slot_end[]" placeholder="{{ __('Choose End time') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="d-block">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm remove_slot"><i class="fas fa-times"></i> Remove</button>
                    </div>
                </div>
            </div>
        `);
        x++;
    });
</script>
<script>
    $(document).on('click','.remove_slot',function(){
        $(this).parents('.remove_slot_prnt').remove();
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
    });
</script>
@endpush
@endsection