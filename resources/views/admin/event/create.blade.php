@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Event'),
            'headerData' => __('Event'),
            'url' => 'events',
        ])
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Add Event') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="event-form" action="{{ url('events') }}" id="event_form" name="event_form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <input type="hidden" name="img_name" id="img_name">
                                        <div class="form-group center">
                                            <label>{{ __('Post Card') }} (400 x 250) <span class="text-danger">*</span></label>
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label"> <i
                                                        class="fas fa-plus"></i></label>
                                                <input type="file" name="image" id="image-upload"/>
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary" id="openGallery">Pick From Gallery</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group center">
                                            <label>{{ __('Banner Image') }} (1280 x 500)</label>
                                            <div id="image-preview2" class="image-preview">
                                                <label for="image-upload2" id="image-label2"> <i
                                                        class="fas fa-plus"></i></label>
                                                <input type="file" name="banner" id="image-upload2" />
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-group">
                                            <label>{{ __('Select Event Category') }} <span class="text-danger">*</span></label>
                                            <select onchange="checkTicket(this.value);" name="event_type_cat" class="form-control select2" required>
                                                <option value="">{{ __('Select Event Category') }}</option>
                                                <option value="online">Online Event</option>
                                                <option value="physical">Physical Event</option>
                                                <option value="virtual">Virtual Event</option>
                                            </select>
                                            @error('event_type_cat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>{{ __('Event Ticket Type') }} <span class="text-danger">*</span></label>
                                            <select name="ticket_type" class="form-control" required>
                                                <option value="0">Basic</option>
                                                <option value="1" id="advance" style="display:none;">Advance</option>
                                            </select>
                                            @error('ticket_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Select Event Name') }} <span class="text-danger">*</span></label>
                                            <select name="event_parent_id" class="form-control select2" required>
                                                <option value="">{{ __('Select Event Name') }}</option>
                                                @foreach ($eventsData as $item)
                                                        <option value="{{$item->id}}">{{$item->event_name}}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="name" value="{{ old('name') }}"
                                                placeholder="{{ __('Name') }}"
                                                class="form-control @error('name')? is-invalid @enderror"> --}}
                                            @error('event_parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Category') }} <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control select2">
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == old('category') ? 'Selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <p id="category_error"></p>
                                            @error('category')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="form-label">{{ __('Event Type') }} <span class="text-danger">*</span></label>
                                        <div class="selectgroup selectgroup-pills">
                                            <label class="selectgroup-item">
                                              <input type="radio" value="1" class="selectgroup-input" name="event_type" checked>
                                              <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check-circle"></i> Particular Event </span>
                                            </label>
                                            <label class="selectgroup-item">
                                              <input type="radio" value="2" class="selectgroup-input" name="event_type">
                                              <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check-circle"></i> Recurring Event</span>
                                            </label>
                                            <label class="selectgroup-item">
                                              <input type="radio" value="3" class="selectgroup-input" name="event_type">
                                              <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check-circle"></i> OnDemand Event</span>
                                            </label>
                                        </div>
                                          <div id="event_type_err"></div>
                                    </div>
                                </div>

                                <div class="row" id="event_particular">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Start Time') }}</label>
                                            <input type="text" name="start_time" id="start_time"
                                                value="{{ old('start_time') }}"
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
                                                value="{{ old('end_time') }}" placeholder="{{ __('Choose End time') }}"
                                                class="form-control date @error('end_time')? is-invalid @enderror">
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="event_recurring" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="form-group">
                                                <label class="form-label">Select Days</label>
                                                <div id="select_days_err"></div>
                                                <div class="selectgroup selectgroup-pills">
                                                    @foreach (Common::daysArr() as $day)
                                                        <label class="selectgroup-item w-auto">
                                                            <input type="checkbox" name="days[]" value="{{$day}}" class="selectgroup-input">
                                                            <span class="selectgroup-button">{{$day}}</span>
                                                        </label>
                                                    @endforeach  
                                                </div>
                                              </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>{{ __('Slot Start Time') }}</label>
                                                <input type="time" name="slot_start[]" id="slot_start_0" placeholder="{{ __('Choose Start time') }}" class="form-control" required>
                                            
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>{{ __('Slot End Time') }}</label>
                                                <input type="time" name="slot_end[]" id="slot_end_time_0" placeholder="{{ __('Choose End time') }}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="d-block">&nbsp;</label>
                                                <button type="button" id="add_slot_btn" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"> Add Slot</i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="slot_dv">

                                    </div>
                                </div>
                               
                                <div class="row">
                                    @if (Auth::user()->hasRole('admin'))
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Organization') }} <span class="text-danger">*</span></label>
                                            <select name="user_id" class="form-control select2" id="org-for-event">
                                                <option value="">{{ __('Choose Organization') }} </option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == old('user_id') ? 'Selected' : '' }}>
                                                        {{ $item->first_name . ' ' . $item->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>                                    
                                @endif
                                <div class="col-lg-6">
                                    <div class="scanner">
                                        <div class="form-group">
                                            <label>{{ __('Scanner') }}</label>
                                            <select name="scanner_id"  class="form-control  select2" id="scanner_id">
                                                <option value="">{{ __('Choose Scanner') }}</option>
                                                @foreach ($scanner as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == old('scanner_id') ? 'Selected' : '' }}>
                                                        {{ $item->first_name . ' ' . $item->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('scanner_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>                                    
                                </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum people will join in this event') }} <span class="text-danger">*</span></label>
                                            <input type="number" min='1' name="people" id="people"
                                                value="{{ old('people') }}"
                                                placeholder="{{ __('Maximum people will join in this event') }}"
                                                class="form-control @error('people')? is-invalid @enderror">
                                            @error('people')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('status') }} <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control select2">
                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0">{{ __('Inactive') }}</option>
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
                                            <input type="text" name="tags" value="{{ old('tags') }}"
                                                class="form-control inputtags @error('tags')? is-invalid @enderror">
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
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('event_description_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                    {{-- <div class="form-group">
                                        <label>{{ __('Description') }} <span class="text-danger">*</span></label>
                                        <textarea name="description" Placeholder="Description"
                                            class="textarea_editor @error('description')? is-invalid @enderror">
                                            {{ old('description') }}
                                        </textarea>
                                        @error('description')
                                            <div class="invalid-feedback block">{{ $message }}</div>
                                        @enderror
                                        <div id="description_err">
                                            
                                        </div>
                                    </div> --}}
    
                                    
                                </div>
                                

                                <h6 class="text-muted mt-4 mb-4">{{ __('Location Detail') }}</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Temple Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="temple_name[]" value="" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Event Address') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="address[]" placeholder="{{ __('Event Address') }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('City Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="city_name[]" placeholder="{{ __('City Name') }}"
                                                class="form-control @error('city_name')? is-invalid @enderror">
                                            @error('city_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">-</label>
                                        <button class="btn btn-warning d-block" id="add_more_temples" type="button">Add More</button>
                                    </div>
                                    
                                </div>
                                <div class="row" id="more_temples">

                                </div>
                                <div class="row">
                                    {{-- <div class="col-lg-6">
                                        <div class="location-detail">
                                            <div class="form-group">
                                                <label>{{ __('Event Address') }} <span class="text-danger">*</span></label>
                                                <input type="text" name="address" id="address"
                                                    placeholder="{{ __('Event Address') }}"
                                                    class="form-control @error('address')? is-invalid @enderror">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-lg-6">
                                        <div class="location-detail">
                                            <div class="form-group">
                                                <label>{{ __('City Name') }} <span class="text-danger">*</span></label>
                                                <input type="text" name="city_name" id="city_name"
                                                    placeholder="{{ __('City Name') }}"
                                                    class="form-control @error('city_name')? is-invalid @enderror">
                                                @error('city_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <h6 class="text-muted mt-4 mb-4">{{ __('Gallery Images') }}</h6>
                                <div class="buttons">
                                    <button type="button" class="btn  btn-info" id="add_more_image_btn"><i class="fas fa-plus"></i>Add More</button>
                                </div>
                                
                                <div class="row" id="more_images">
                                    <div class="col-md-3 mb-2">
                                        <div class="image-preview-n image-preview-n-0">
                                            <label for="image-upload" class="image-label-n image-label-n-0"> <i
                                                    class="fas fa-plus"></i></label>
                                            <input type="file" name="gallery_image[]" class="image-upload-n image-upload-n-0" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-4">
                                    <button type="submit" id="continue_btn"  class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                      

                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Event Images</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="galleryBody">
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

@endsection
@push('scripts')
<script> 
    $("#event_form").validate({
        rules: {
           
           
            category_id:{required:true},
            user_id:{required:true},
            // temple_name:{required:true},
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
            // temple_name:{required:"* Template name is required"},
            address:{required:"* Event address is required"},
            city_name:{required:"* City name is required"},
            people:{required:"* Maximum people field is required"},
         
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
                        <input type="time" name="slot_start[]" id="slot_start_${x}" placeholder="{{ __('Choose Start time') }}" class="form-control" required>
                    
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>{{ __('Slot End Time') }}</label>
                        <input type="time" name="slot_end[]" id="slot_end_time_${x}" placeholder="{{ __('Choose End time') }}" class="form-control" required>
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
<script>
    var x = 1;
    $("#add_more_image_btn").on('click',function(){
        if($('.image-preview-n').length<5){
            $("#more_images").append(`<div class="col-md-3 mb-2 rem_gall">
                                <div class="image-preview-n image-preview-n-${x}">
                                    <label for="image-upload" class="image-label-n image-label-n-${x}"> <i
                                            class="fas fa-plus"></i></label>
                                    <input type="file" name="gallery_image[]" class="image-upload-n image-upload-n-${x}" />
                                </div>
                                <button class="btn btn-sm btn-danger remove_gall"><i class="fas fa-trash-alt"></i> Remove</button>
                            </div>`);
            $.uploadPreview({
                input_field: `.image-upload-n-${x}`,
                preview_box: `.image-preview-n-${x}`,
                label_field: `.image-label-n-${x}`,
                label_default: "<i class='fas fa-plus'></i>",
                label_selected: "<i class='fas fa-plus'></i>",
                no_label: false,
                success_callback: null
            });   
            x++; 
        }else{
            alert('Only 5 images allowed to upload at a time')
        }
                       
    })
</script>
<script>
    $(document).on('click','.remove_gall',function(){
        $(this).parents(".rem_gall").remove();
    })
</script>
<script>
    $("#add_more_temples").on('click',function(){
        $("#more_temples").append(` <div class="col-md-12 remove_temp_prnt">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ __('Temple Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="temple_name[]" value="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ __('Event Address') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="address[]" placeholder="{{ __('Event Address') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ __('City Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="city_name[]" placeholder="{{ __('City Name') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">-</label>
                                                <button class="btn btn-danger d-block remove_temp" type="button">Remove</button>
                                            </div>    
                                        </div>
                                       
                                    </div>`);
    })
</script>
<script>
    $(document).on('click','.remove_temp',function(){
        $(this).parents(".remove_temp_prnt").remove();
    })
</script>

<script>
    $("#openGallery").on('click',function(){
        $("#galleryModal").modal('show');
        $("#galleryBody").html('<h5 class="text-center mt-4">Loading Galleries Please wait...</h5>')
        $.get('{{url("get-event-galleries")}}',function(data){
            $("#galleryBody").html(data)
        }); 
    })
</script>

<script>
    $(document).on('click','.img_gallery',function(){
       var img = $(this).attr('src');
       var imgName = $(this).data('id');
        $("#img_name").val(imgName);
        $("#image-preview").css('background-image','url("'+img+'")')
        $("#galleryModal").modal('hide');
    })
</script>

<script>
    $(document).on('click','.page-link',function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        $("#galleryBody").html('<h5 class="text-center mt-4">Loading Galleries Please wait...</h5>')
        $.get(link,function(data){
            $("#galleryBody").html(data)
        }); 
    })
</script>
<script>
    function checkTicket(val){
        console.log(val);
        let advance = document.getElementById('advance');
        if(val == "physical"){
            advance.style.display = "block";
        }else{
            advance.style.display = "none";
        }

    }
</script>

@endpush