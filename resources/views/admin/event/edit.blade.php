@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Event'),
            'headerData' => __('Event'),
            'url' => 'events',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Edit Event') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="event-form" id="event_form" name="event_form" action="{{ route('events.update', [$event->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group center">
                                            <label>{{ __('Post Card') }} (400 x 250)</label>
                                            <div id="image-preview" class="image-preview"
                                                style="background-image: url({{ url('images/upload/' . $event->image) }})">
                                                <label for="image-upload" id="image-label"> <i
                                                        class="fas fa-plus"></i></label>
                                                <input type="file" name="image" id="image-upload" />
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group center">
                                            <label>{{ __('Banner Image') }} (1280 x 500)</label>
                                            <div id="image-preview2" class="image-preview"
                                                style="background-image: url({{ url('images/upload/' . $event->banner_img) }})">
                                                <label for="image-upload2" id="image-label2"> <i
                                                        class="fas fa-plus"></i></label>
                                                <input type="file" name="banner" id="image-upload2" />
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Event Category') }}</label>
                                            <input type="text" name="" id="ticket_type" value="{{ ucFirst($event->event_cat)}} Event" class="form-control" disabled readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Ticket Type') }}</label>
                                            <input type="text" name="" id="ticket_type"
                                                value="{{ $event->ticket_type == 1 ? "Advance" : "Basic" }}"
                                                placeholder="{{ __('Choose Start time') }}"
                                                class="form-control  @error('ticket_type')? is-invalid @enderror" disabled readonly>
                                            @error('ticket_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Select Event Name') }} <span class="text-danger">*</span></label>
                                            <select name="event_parent_id" class="form-control select2" required>
                                                <option >{{ __('Select Event Name') }}</option>
                                                
                                                @foreach ($eventsData as $item)
                                                    <option value="{{$item->id}}" {{$item->id == $event->event_parent_id ? 'selected' : '' }}>{{$item->event_name}}</option>
                                                @endforeach
                                                
                                            </select>
                                            @error('event_parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Category') }}</label>
                                            <select name="category_id" class="form-control select2">
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $event->category_id ? 'Selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-md-12 form-group">
                                        <label class="form-label">{{ __('Event Type') }} <span class="text-danger">*</span></label>
                                        <div class="selectgroup selectgroup-pills">
                                            <label class="selectgroup-item">
                                              <input type="radio" value="1" class="selectgroup-input" name="event_type" {{$event->event_type=='Particular' ? 'checked':''}}>
                                              <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check-circle"></i> Particular Event </span>
                                            </label>
                                            <label class="selectgroup-item">
                                              <input type="radio" value="2" class="selectgroup-input" name="event_type" {{$event->event_type=='Recurring' ? 'checked':''}}>
                                              <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check-circle"></i> Recurring Event</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" value="3" class="selectgroup-input" name="event_type" {{$event->event_type=='OnDemand' ? 'checked':''}}>
                                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check-circle"></i> OnDemand Event</span>
                                            </label>
                                        </div>
                                          <div id="event_type_err"></div>
                                    </div>
                                </div>
                                <div class="row" id="event_particular"  style="display: {{$event->event_type=='Particular' ? 'flex':'none'}};">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Start Time') }}</label>
                                            <input type="text" name="start_time" id="start_time"
                                                value="{{ $event->start_time }}"
                                                placeholder="{{ __('Choose Start time') }}"
                                                class="form-control date @error('start_time')? is-invalid @enderror">
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('End Time') }}</label>
                                            <input type="text" name="end_time" id="end_time"
                                                value="{{ $event->end_time }}" placeholder="{{ __('Choose End time') }}"
                                                class="form-control date @error('end_time')? is-invalid @enderror">
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div id="event_recurring" style="display: {{$event->event_type=='Recurring' ? 'block':'none'}};">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="form-group">
                                                <label class="form-label">Select Days</label>
                                                <div id="select_days_err"></div>
                                                <div class="selectgroup selectgroup-pills">
                                                    @php
                                                        $arr = explode(',',$event->recurring_days)
                                                    @endphp
                                                    @foreach (Common::daysArr() as $day)
                                                        <label class="selectgroup-item w-auto">
                                                            <input type="checkbox" name="days[]" value="{{$day}}" class="selectgroup-input" {{in_array($day,$arr) ? 'checked':''}}>
                                                            <span class="selectgroup-button">{{$day}}</span>
                                                        </label>
                                                    @endforeach  
                                                </div>
                                              </div>
                                              
                                        </div>
                                    </div>
                                    
                                    @if($event->time_slots!=null)
                                        @php
                                            $timeSlots = json_decode($event->time_slots);
                                        @endphp
                                        @foreach ($timeSlots as  $k=>$val)
                                            @if($k==0)
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>{{ __('Slot Start Time') }}</label>
                                                            <input type="time" value="{{$val->start_time}}" name="slot_start[]" placeholder="{{ __('Choose Start time') }}" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>{{ __('Slot End Time') }}</label>
                                                            <input type="time" value="{{$val->end_time}}" name="slot_end[]" placeholder="{{ __('Choose End time') }}" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="d-block">&nbsp;</label>
                                                            <button type="button" id="add_slot_btn" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"> Add Slot</i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row remove_slot_prnt">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>{{ __('Slot Start Time') }}</label>
                                                            <input type="time" value="{{$val->start_time}}" name="slot_start[]" placeholder="{{ __('Choose Start time') }}" class="form-control" required>
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>{{ __('Slot End Time') }}</label>
                                                            <input type="time" value="{{$val->end_time}}" name="slot_end[]" placeholder="{{ __('Choose End time') }}" class="form-control" required>
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
                                    @else
                                        <div class="row">
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
                                                    <button type="button" id="add_slot_btn" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"> Add Slot</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div id="slot_dv">
                                    </div>
                                </div>
                                @if (Auth::user()->hasRole('admin'))
                                    <div class="form-group">
                                        <label>{{ __('Organization') }}</label>
                                        <select name="user_id" class="form-control select2" id="org-for-event">
                                            <option value="">{{ __('Choose Organization') }}</option>
                                            @foreach ($users as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $event->user_id ? 'Selected' : '' }}>
                                                    {{ $item->first_name . ' ' . $item->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="scanner {{ $event->type == 'online' ? 'hide' : 'demo' }}">
                                    <div class="form-group">
                                        <label>{{ __('Scanner') }}</label>
                                        <select name="scanner_id" class="form-control  select2" id="scanner_id">
                                            <option value="">{{ __('Choose Scanner') }}</option>
                                            @foreach ($scanner as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $event->scanner_id ? 'Selected' : '' }}>
                                                    {{ $item->first_name . ' ' . $item->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('scanner_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum people will join in this event') }}</label>
                                            <input type="number" name="people" id="people"
                                                value="{{ $event->people }}"
                                                placeholder="{{ __('Maximum people will join in this event') }}"
                                                class="form-control @error('people')? is-invalid @enderror">
                                            @error('people')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('status') }}</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1" {{ $event->status == '1' ? 'selected' : '' }}>
                                                    {{ __('Active') }}</option>
                                                <option value="0" {{ $event->status == '0' ? 'Selected' : '' }}>
                                                    {{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Tags') }}</label>
                                            @if (json_decode($event->tags) != NULL)
                                                <input type="text" name="tags" value="{{ implode(',', json_decode($event->tags)) }}"
                                                class="form-control inputtags @error('tags') ? is-invalid @enderror">
                                            @else
                                                <input type="text" name="tags" value="{{$event->tags}}"
                                                class="form-control inputtags @error('tags')? is-invalid @enderror">
                                            @endif
                                            
                                            @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Select Event Description') }} <span class="text-danger">*</span></label>
                                            <select name="event_description_id" class="form-control select2" required>
                                                <option value="">{{ __('Select Event Description') }}</option>
                                                @foreach ($descriptionData as $item)
                                                        <option value="{{$item->id}}" {{$item->id==$event->event_description_id ? 'selected':''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('event_description_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted mt-4 mb-4">{{ __('Location Detail') }}</h6>
                                <div class="location-detail">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ __('Temple Name') }} <span class="text-danger">*</span></label>
                                                <input type="text" name="temple_name" value="{{$event->temple_name}}" id="temple_name"  placeholder="{{ __('Temple Name') }}"
                                                    class="form-control @error('temple_name')? is-invalid @enderror">
                                                @error('temple_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="location-detail">
                                                <div class="form-group">
                                                    <label>{{ __('Event Address') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="address" id="address" value="{{$event->address}}"
                                                        placeholder="{{ __('Event Address') }}"
                                                        class="form-control @error('address')? is-invalid @enderror">
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="location-detail">
                                                <div class="form-group">
                                                    <label>{{ __('City Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="city_name" id="city_name" value="{{$event->city_name}}"
                                                        placeholder="{{ __('City Name') }}"
                                                        class="form-control @error('city_name')? is-invalid @enderror">
                                                    @error('city_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary demo-button" id="continue_btn">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script> 
    $("#event_form").validate({
        rules: {
           
            category_id:{required:true},
            user_id:{required:true},
            temple_name:{required:true},
            address:{required:true},
            city_name:{required:true},
            people:{required:true},
            event_type:{required:true},
            start_time:{required:true},
            end_time:{required:true},
            'days[]':{required:true}
        },
        messages: {
          
            category_id:{required:"* Category is required"},
            user_id:{required:"* Organization is required"},
            temple_name:{required:"* Template name is required"},
            address:{required:"* Event address is required"},
            city_name:{required:"* City name is required"},
            people:{required:"* Maximum people field is required"},
            description:{required:"* Description is required"},
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
        $("#slot_dv").append(`
            <div class="row remove_slot_prnt">
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
@endpush
