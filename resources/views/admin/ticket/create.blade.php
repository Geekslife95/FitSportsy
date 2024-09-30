@extends('master')
@section('content')
<style>
    .hidden{
        display: none;
    }
</style>
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Ticket'),
            'headerData' => __('Ticket'),
            'url' => $event->id . '/' . preg_replace('/\s+/', '-', $event->name) . '/tickets',
        ])
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Add Ticket') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4>Temple - {{$event->temple_name}}</h4>
                            <h4>Event Type - {{$event->event_type}}</h4>
                            @if($event->event_type=='Particular')
                                <h4>Start Date - {{date("d M Y H:i A",strtotime($event->start_time))}}</h4>
                                <h4>End Date - {{date("d M Y H:i A",strtotime($event->end_time))}}</h4>
                            @else
                                <h4>Days - {{$event->recurring_days}}</h4>
                            @endif
                        </div>
                        <div class="card-body">
                            <form method="post" class="ticket-form" id="event_form" name="event_form" action="{{ url('ticket/create') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="form-group">
                                    <div class="selectgroup">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="type"
                                                {{ old('type') == 'free' ? '' : 'checked' }} value="paid"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">{{ __('Paid') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" {{ old('type') == 'free' ? 'checked' : '' }}
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
                                                value="{{ old('name') }}"
                                                class="form-control @error('name') ? is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <input type="hidden" name="event_ticket_type" value="{{$event->ticket_type}}">
                                        </div>
                                    </div>
                                    @if ($event->ticket_type == 0)
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Quantity') }}</label>
                                                <input type="number" name="quantity" min="1"
                                                    placeholder="{{ __('Quantity') }}" value="{{ old('quantity') }}"
                                                    class="form-control @error('quantity')? is-invalid @enderror">
                                                @error('quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if ($event->ticket_type == 1)
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">Select Row</label>
                                                @isset($ticket)
                                                @php $type = []; @endphp
                                                <select name="ticket_type" id="ticket_type" class="form-control @error('ticket_type')? is-invalid @enderror" required>
                                                    @foreach ($ticket as $item)
                                                        @php array_push($type,$item->ticket_type); @endphp
                                                    @endforeach
                                                    @if (!in_array('1',$type))
                                                        <option value="1">Front Row</option>
                                                    @endif
                                                    @if (!in_array('2',$type))
                                                        <option value="2">Middle Row</option>
                                                    @endif
                                                    @if (!in_array('3',$type))
                                                        <option value="3">Back Row</option>
                                                    @endif
                                                </select>
                                                @endisset
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Price') }} ({{ Common::siteGeneralSettings()->currency }})</label>
                                            <input type="number" name="price"  placeholder="{{ __('Price') }}" id="price" step="any"
                                                value="{{ old('price') }}"
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
                                                <option value="" disabled>Select Type</option>
                                                <option value="FLAT">FLAT</option>
                                                <option value="DISCOUNT" selected>DISCOUNT</option>
                                            </select>
                                            </div>
                                            <input type="number" class="form-control" id="validationCustomUsername" placeholder="Enter Discount" name="discount" aria-describedby="inputGroupPrepend" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum ticket per order') }}</label>
                                            <input type="number" name="ticket_per_order" min="1" required
                                                placeholder="{{ __('Maximum ticket per order') }}" id="ticket_per_order"
                                                value="{{ old('ticket_per_order') }}"
                                                class="form-control @error('ticket_per_order')? is-invalid @enderror">
                                            @error('ticket_per_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Status') }}</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                    {{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if($event->event_type=='Particular')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Sale Start Time') }}</label>
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
                                                <label>{{ __('Sale End Time') }}</label>
                                                <input type="text" name="end_time" id="end_time"
                                                    value="{{ old('end_time') }}" placeholder="{{ __('Choose End time') }}"
                                                    class="form-control date @error('end_time')? is-invalid @enderror">
                                                @error('end_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row" >
                                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                                        <label for="">Who will pay SuperShow fee</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="superShow_fee" value="1" checked="">
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="superShow_fee" value="2">
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                                        <label for="">Who will pay Payment Gateway fee</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="gateway_fee" value="1" checked="">
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="gateway_fee" value="2">
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                                        <label for="">Platform Fee</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="1">
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="2" checked="">
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>{{ __('Pay Now Button') }}</label>
                                            <input type="checkbox" style="width:30px;margin-right:auto;" class="form-control checkBox" value="1" name="pay_now" id="pay_now" checked>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>{{ __('Pay At Event Place Button') }}</label>
                                            <input type="checkbox" style="width:30px;margin-right:auto;" class="form-control checkBox" value="1" name="pay_place" id="pay_place" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Description') }}</label>
                                            <textarea name="description" placeholder="{{ __('Description') }}"
                                                class="form-control @error('description')? is-invalid @enderror">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if ($event->ticket_type == 1)
                                        <div class="col-lg-12 col-md-12 col-12" id="frontRows">
                                            <div class="form-group">
                                                <label>1 Row Seats <span class="text-danger">*</span></label>
                                                <div class="d-flex">
                                                    <input type="number" name="frontRows[]" class="form-control" placeholder="Enter 1 Row Seats" required="">
                                                    <button type="button" id="addFrontRow" data-id="#frontRows" data-row="2" class="btn btn-sm btn-primary" style="width:200px;">Add More Rows</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="submit" id="continue_btn" class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
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
    $(document).on('click', '#addFrontRow', function(e) {
        $id = $(this).data('id');
        $row = $(this).data('row');
        e.preventDefault();
        $($id).append(`<div class="form-group remove_slot_prnt">
                    <label>${$row} Row Seats <span class="text-danger">*</span></label>
                    <div class="d-flex">
                    <input type="number" name="${$id.substring(1)}[]" class="form-control" placeholder="Enter ${$row} Row Seats" required>
                    <button type="button" class="remove_slot btn-sm btn btn-danger py-2 ms-2" style="width:200px;">Remove Rows</button>
                        </div>
                </div>`);
        $row = $row + 1;
        $(this).data('row', $row);
    });
</script>
<script>
    $(document).on('click', '.remove_slot', function() {
        $rows = $(this).parents('.remove_slot_prnt').siblings('div:first').find("div > button").data('row');
        $(this).parents('.remove_slot_prnt').siblings('div:first').find("div > button").data('row', $rows - 1);
        $(this).parents('.remove_slot_prnt').remove();
    })
</script>
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
