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
                                        <input type="hidden" name="event_ticket_type" value="{{$event->ticket_type}}">
                                    </div>
                                    @if ($event->ticket_type == 0)
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
                                    @endif
                                    @if ($event->ticket_type == 1)
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">Select Row</label>
                                                <select name="ticket_type" id="ticket_type"  class="form-control @error('ticket_type')? is-invalid @enderror">
                                                    <option value="{{ $ticket->ticket_type}}">{{($ticket->ticket_type == 1) ? "First" : ($ticket->ticket_type == 2 ? "Middle" : "Back") }} Row</option>
                                                </select>
                
                                            </div>
                                        </div>
                                    @endif
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Status') }}</label>
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
                                    @if (Auth::user()->hasRole('admin'))
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustomUsername">SuperShow Fee Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <select name="superShow_fee_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="FLAT" {{$ticket->superShow_fee_type == "FLAT" ? "selected" : "" }}>FLAT</option>
                                                <option value="DISCOUNT" {{$ticket->superShow_fee_type == "DISCOUNT" ? "selected" : "" }}>DISCOUNT</option>
                                            </select>
                                          </div>
                                          <input type="number" class="form-control" id="validationCustomUsername" placeholder="SuperShow Fee Amount" value="{{$ticket->superShow_fee_amount}}" name="superShow_fee_amount" aria-describedby="inputGroupPrepend" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustomUsername">Payment Gateway Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <select name="gateway_fee_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="FLAT" {{$ticket->gateway_fee_type == "FLAT" ? "selected" : "" }}>FLAT</option>
                                                <option value="DISCOUNT" {{$ticket->gateway_fee_type == "DISCOUNT" ? "selected" : "" }}>DISCOUNT</option>
                                            </select>
                                          </div>
                                          <input type="number" class="form-control" id="validationCustomUsername" placeholder="Payment Gateway Amount" value="{{$ticket->gateway_fee_amount}}" name="gateway_fee_amount" aria-describedby="inputGroupPrepend" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustomUsername">Platform Fee Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <select name="platform_fee_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="FLAT" {{$ticket->platform_fee_type == "FLAT" ? "selected" : "" }}>FLAT</option>
                                                <option value="DISCOUNT" {{$ticket->platform_fee_type == "DISCOUNT" ? "selected" : "" }}>DISCOUNT</option>
                                            </select>
                                          </div>
                                          <input type="number" class="form-control" id="validationCustomUsername" placeholder="Platform Fee Amount" value="{{$ticket->platform_fee_amount}}" name="platform_fee_amount" aria-describedby="inputGroupPrepend" required>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Ticket Sold') }}</label>
                                            <select name="ticket_sold" class="form-control select2">
                                               <option value="0" {{$ticket->ticket_sold == 0 ? 'selected': ''}}>NO</option>
                                               <option value="1" {{$ticket->ticket_sold == 1 ? 'selected': ''}}>YES</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                                        <label for="">Who will pay SuperShow fee</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="superShow_fee" value="1" {{$ticket->superShow_fee == 1 ? "checked" : ""}}>
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="superShow_fee" value="2" {{$ticket->superShow_fee == 2 ? "checked" : ""}}>
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                                        <label for="">Who will pay Payment Gateway fee</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="gateway_fee" value="1" {{$ticket->gateway_fee == 1 ? "checked" : ""}}>
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="gateway_fee" value="2" {{$ticket->gateway_fee == 2 ? "checked" : ""}}>
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                                        <label for="">Who will pay Platform Fee</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="1" {{$ticket->platform_fee == 1 ? "checked" : ""}}>
                                                <span>Me</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="platform_fee" value="2" {{$ticket->platform_fee == 2 ? "checked" : ""}}>
                                                <span>Buyer</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>{{ __('Pay Now Button') }}</label>
                                            <input type="checkbox" style="width:30px;margin-right:auto;" class="form-control checkBox" value="{{$ticket->pay_now}}" name="pay_now" id="pay_now" {{ $ticket->pay_now == '1' ? 'checked' : '' }} >
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>{{ __('Pay At Event Place Button') }}</label>
                                            <input type="checkbox" style="width:30px;margin-right:auto;" class="form-control checkBox" value="{{$ticket->pay_place}}" name="pay_place" id="pay_place" {{ $ticket->pay_place == '1' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label>{{ __('Description') }}</label>
                                        <textarea name="description" placeholder="{{ __('Description') }}"
                                            class="form-control @error('description')? is-invalid @enderror">{{ $ticket->description }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @if ($event->ticket_type == 1)
                                    <div class="" id="frontRows">
                                        @foreach (json_decode($ticket->ticket_row) as $item)
                                            @php $totalRows = count(json_decode($ticket->ticket_row)); @endphp
                                            @if ($loop->first)
                                                <div class="form-group">
                                                    <label>{{$loop->index+1}} Row Seats <span class="text-danger">*</span></label>
                                                    <div class="d-flex">
                                                        <input type="number" name="frontRows[]" class="form-control" placeholder="Enter {{$loop->index+1}} Row Seats" value="{{$item}}" required="">
                                                        <button type="button" id="addFrontRow" data-id="#frontRows" data-row="{{$totalRows+1}}" class="btn btn-sm btn-primary" style="width:200px;">Add
                                                            More Rows</button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-group remove_slot_prnt">
                                                    <label>{{$loop->index+1}} Row Seats <span class="text-danger">*</span></label>
                                                    <div class="d-flex">
                                                        <input type="number" name="frontRows[]" class="form-control" placeholder="Enter {{$loop->index+1}} Row Seats" value="{{$item}}" required>
                                                        <button type="button" class="remove_slot btn-sm btn btn-danger py-2 ms-2" style="width:200px;">Remove Rows</button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
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
