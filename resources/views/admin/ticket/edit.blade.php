@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Ticket'),
            'headerData' => __('Ticket'),
            'url' => $event->id . '/' . preg_replace('/\s+/', '-', $event->name) . '/tickets',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Edit Ticket') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="event_form" name="event_form" class="ticket-form" action="{{ url('ticket/update/' . $ticket->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="form-group">
                                    <div class="selectgroup">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="type"
                                                {{ $ticket->type == 'free' ? '' : 'checked' }} value="paid"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">{{ __('Paid') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" {{ $ticket->type == 'free' ? 'checked' : '' }}
                                                name="type" value="free" class="selectgroup-input">
                                            <span class="selectgroup-button">{{ __('Free') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" placeholder="{{ __('Name') }}"
                                                value="{{ $ticket->name }}"
                                                class="form-control @error('name')? is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Quantity') }}</label>
                                            <input type="number" name="quantity" min="1"
                                                placeholder="{{ __('Quantity') }}" value="{{ $ticket->quantity }}"
                                                class="form-control @error('quantity')? is-invalid @enderror">
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Price') }} ({{ Common::siteGeneralSettings()->currency }})</label>
                                            <input type="number" name="price" 
                                                {{ $ticket->type == 'free' ? 'disabled' : '' }}
                                                placeholder="{{ __('Price') }}" id="price"
                                                value="{{ $ticket->price }}" step="any"
                                                class="form-control @error('price')? is-invalid @enderror">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustomUsername">Discount (In Pecentage)</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <select name="disc_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="FLAT" {{$ticket->discount_type == "FLAT" ? "selected" : "" }}>FLAT</option>
                                                <option value="DISCOUNT" {{$ticket->discount_type == "DISCOUNT" ? "selected" : "" }}>DISCOUNT</option>
                                            </select>
                                          </div>
                                          <input type="number" class="form-control" id="validationCustomUsername" placeholder="Discount" value="{{$ticket->discount_amount}}" name="discount" aria-describedby="inputGroupPrepend" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum ticket per order') }}</label>
                                            <input type="number" name="ticket_per_order" min="1"
                                                placeholder="{{ __('Maximum ticket per order') }}" id="ticket_per_order"
                                                value="{{ $ticket->ticket_per_order }}"
                                                class="form-control @error('ticket_per_order')? is-invalid @enderror">
                                            @error('ticket_per_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustomUsername">Convenience Fee</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <select name="convenience_type" class="form-control">
                                                <option value="" disabled>Select Fee</option>
                                                <option value="FIXED" {{$ticket->convenience_type == "FIXED" ? "selected" : "" }}>FIXED</option>
                                                <option value="PERCENTAGE" {{$ticket->convenience_type == "PERCENTAGE" ? "selected" : "" }}>PERCENTAGE</option>
                                            </select>
                                          </div>
                                          <input type="number" class="form-control" id="validationCustomUsername" placeholder="Enter Convenience Fee" name="convenience_fee" value="{{$ticket->convenience_amount}}" aria-describedby="inputGroupPrepend" required>
                                        </div>
                                    </div>
                                </div>
                                @if($event->event_type=='Particular')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Sale Start Time') }}</label>
                                                <input type="text" name="start_time" id="start_time"
                                                    value="{{ $ticket->start_time }}"
                                                    placeholder="{{ __('Choose Start time') }}"
                                                    class="form-control date @error('start_time')? is-invalid @enderror">
                                                @error('start_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Sale End Time') }}</label>
                                                <input type="text" name="end_time" id="end_time"
                                                    value="{{ $ticket->end_time }}" placeholder="{{ __('Choose End time') }}"
                                                    class="form-control date @error('end_time')? is-invalid @enderror">
                                                @error('end_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum Check-ins (leave blank to allow unlimited)') }}</label>
                                            <input type="number" name="maximum_checkins" 
                                                placeholder="{{ __('Maximum Check-ins') }}" id="maximum_checkins"
                                                value="{{ $ticket->maximum_checkins }}"
                                                class="form-control @error('maximum_checkins')? is-invalid @enderror">
                                            @error('maximum_checkins')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('status') }}</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1" {{ $ticket->status == '1' ? 'selected' : '' }}>
                                                    {{ __('Active') }}</option>
                                                <option value="0" {{ $ticket->status == '0' ? 'selected' : '' }}>
                                                    {{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group text-center">
                                            <label>Pay Now Button</label>
                                            <input type="checkbox" class="form-control checkBox" value="{{$ticket->pay_now}}" name="pay_now" id="pay_now" {{$ticket->pay_now == 1 ? 'checked': ''}}>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group text-center">
                                            <label>Pay At Event Place Button</label>
                                            <input type="checkbox" class="form-control checkBox" value="{{$ticket->pay_place}}" name="pay_place" id="pay_place" {{$ticket->pay_place == 1 ? 'checked': ''}}>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Ticket Sold') }}</label>
                                            <select name="ticket_sold" class="form-control select2">
                                               <option value="0" {{$ticket->ticket_sold==0 ? 'selected': ''}}>NO</option>
                                               <option value="1" {{$ticket->ticket_sold==1 ? 'selected': ''}}>YES</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Description') }}</label>
                                    <textarea name="description" placeholder="{{ __('Description') }}"
                                        class="form-control @error('description')? is-invalid @enderror">{{ $ticket->description }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                

                                <div class="form-group">
                                    <button type="submit" id="continue_btn"
                                        class="btn btn-primary demo-button">{{ __('Submit') }}</button>
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
            name:{required:true},
            quantity :{required:true},
            price:{required:true},
            ticket_per_order:{required:true},
            start_time:{required:true},
            end_time:{required:true},
        },
        messages: {
            name:{required:"* Name is required"},
            quantity:{required:"* Quantity is required"},
            price:{required:"* Price is required"},
            ticket_per_order:{required:"* Ticket per order is required"},
            start_time:{required:"*Ticket Sale Start Time is required"},
            end_time:{required:"*Ticket Sale  End Time is required"},
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
    let checkBox = document.getElementsByClassName('checkBox');
    Array.from(checkBox).forEach(element => {
        element.addEventListener('click',function(){
            if ($(this).prop('checked')==true){
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        })
    });
</script>
@endpush
