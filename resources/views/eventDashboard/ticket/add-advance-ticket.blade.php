@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .hidden{display: none;}
</style>
@endpush
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-12">
                    <h3 class="page-title">Welcome Organizer!</h3>
                </div>
            </div>
        </div>
        @include('messages')
        <!-- /Page Header -->
        <form action="" method="POST" id="event_form">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card available-widget">
                        <div class="card-header">
                            <h5 class="card-title">Event Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6"><b>Event Place : </b>{{$eventDeatils->temple_name}}</div>
                                <div class="col-6"><b>Event Type : </b>{{$eventDeatils->event_type}}</div>
                                <div class="col-6"><b>Category : </b> {{$eventDeatils->category->name}}</div>
                                <div class="col-6"><b>Status :
                                    </b>{{$eventDeatils->status == 1 ? "Active" : "Inactive"}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card available-widget">
                        <div class="card-header">
                            <h5 class="card-title">Event Rows</h5>
                        </div>
                        <div class="card-body">
                            <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                <label class="radio-label selectgroup-item w-auto">
                                    <input type="checkbox" name="frontRow" value="1" data-id="#frontFrom"
                                        class="rowCheckbox selectgroup-input" checked>
                                    <span class="selectgroup-button">Front Row</span>
                                </label>
                                <label class="radio-label selectgroup-item w-auto">
                                    <input type="checkbox" name="middleRow" value="0" data-id="#middleFrom"
                                        class="rowCheckbox selectgroup-input">
                                    <span class="selectgroup-button">Middle Row</span>
                                </label>
                                <label class="radio-label selectgroup-item w-auto">
                                    <input type="checkbox" name="backRow" value="0" data-id="#backFrom"
                                        class="rowCheckbox selectgroup-input">
                                    <span class="selectgroup-button">Back Row</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="card" id="frontFrom">
                        <div class="card-header">
                            <h5 class="card-title">Front Row Ticket</h5>
                            <input type="hidden" name="event_id" value="{{$eventDeatils->id}}">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="">Ticket Type</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" data-id="#frontPrice"
                                                    name="fronttype" value="paid" checked />
                                                <span>Paid Ticket</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" data-id="#frontPrice"
                                                    name="fronttype" value="free" />
                                                <span>Free Ticket</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Front Row Ticket Name</label>
                                        <input type="text" class="form-control" name="front_name"
                                            placeholder="Enter Ticket Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Price (INR)</label>
                                        <input type="number" name="front_price" placeholder="Price" id="frontPrice"
                                            step="any" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustomUsername">Discount (In Pecentage)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="front_disc_type" class="form-control" aria-invalid="false"
                                                style="border: 1px solid rgb(193, 193, 193);">
                                                <option value="" disabled="">Select Type</option>
                                                <option value="FLAT">FLAT</option>
                                                <option value="DISCOUNT" selected="">DISCOUNT</option>
                                            </select>
                                        </div>
                                        <input type="number" min="0" class="form-control" id="validationCustomUsername"
                                            placeholder="Enter Discount" name="front_discount"
                                            aria-describedby="inputGroupPrepend"><br>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Status </label>
                                        <select name="front_status" class="form-control" required>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Ticket Description</label>
                                        <textarea name="front_description" class="form-control"
                                            placeholder="Enter Description" id="description"
                                            style="height:120px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12" id="frontRows">
                                    <div class="form-group">
                                        <label>1 Row Seats <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <input type="number" name="frontRows[]" class="form-control"
                                                placeholder="Enter 1 Row Seats" required>
                                            <button type="button" id="addFrontRow" data-id="#frontRows"
                                                data-row="2" class="btn btn-sm btn-primary" style="width:200px;">Add
                                                More Rows</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card hidden" id="middleFrom">
                        <div class="card-header">
                            <h5 class="card-title">Middle Row Ticket</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="">Ticket Type</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" data-id="#middlePrice"
                                                    name="middletype" value="paid" checked />
                                                <span>Paid Ticket</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" data-id="#middlePrice"
                                                    name="middletype" value="free" />
                                                <span>Free Ticket</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Middle Row Ticket Name</label>
                                        <input type="text" class="form-control" name="middle_name"
                                            placeholder="Ticket name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Price (INR)</label>
                                        <input type="number" name="middle_price" placeholder="Price" id="middlePrice"
                                            step="any" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustomUsername">Discount (In Pecentage)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="middle_disc_type" class="form-control" aria-invalid="false"
                                                style="border: 1px solid rgb(193, 193, 193);">
                                                <option value="" disabled="">Select Type</option>
                                                <option value="FLAT">FLAT</option>
                                                <option value="DISCOUNT" selected="">DISCOUNT</option>
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" id="validationCustomUsername"
                                            placeholder="Enter Discount" name="middle_discount"
                                            aria-describedby="inputGroupPrepend"><br>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Status </label>
                                        <select name="middle_status" class="form-control" required> 
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Ticket Description</label>
                                        <textarea name="middle_description" class="form-control "
                                            placeholder="Enter Description" id="description"
                                            style="height:120px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12" id="middleRows">
                                    <div class="form-group">
                                        <label>1 Row Seats <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <input type="number" name="middleRows[]" class="form-control"
                                                placeholder="Enter 1 Row Seats" required>
                                            <button type="button" id="addFrontRow" data-id="#middleRows"
                                                data-row="2" class="btn btn-sm btn-primary" style="width:200px;">Add
                                                More Rows</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card hidden" id="backFrom">
                        <div class="card-header">
                            <h5 class="card-title">Back Row Ticket</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="">Ticket Type</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" data-id="#backPrice"
                                                    name="backtype" value="paid" checked />
                                                <span>Paid Ticket</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" data-id="#backPrice"
                                                    name="backtype" value="free" />
                                                <span>Free Ticket</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Back Row Ticket Name</label>
                                        <input type="text" class="form-control" name="back_name"
                                            placeholder="Ticket name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Price (INR)</label>
                                        <input type="number" name="back_price" placeholder="Price" id="backPrice"
                                            step="any" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustomUsername">Discount (In Pecentage)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="back_disc_type" class="form-control" aria-invalid="false"
                                                style="border: 1px solid rgb(193, 193, 193);">
                                                <option value="" disabled="">Select Type</option>
                                                <option value="FLAT">FLAT</option>
                                                <option value="DISCOUNT" selected="">DISCOUNT</option>
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" id="validationCustomUsername"
                                            placeholder="Enter Discount" name="back_discount"
                                            aria-describedby="inputGroupPrepend"><br>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Status </label>
                                        <select name="back_status" class="form-control" required>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Ticket Description</label>
                                        <textarea name="back_description" class="form-control"
                                            placeholder="Enter Description" id="description"
                                            style="height:120px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12" id="backRows">
                                    <div class="form-group">
                                        <label>1 Row Seats <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <input type="number" name="backRows[]" class="form-control"
                                                placeholder="Enter 1 Row Seats" required>
                                            <button type="button" id="addFrontRow" data-id="#backRows" data-row="2"
                                                class="btn btn-sm btn-primary" style="width:200px;">Add More
                                                Rows</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="common">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Maximun Ticket Per Order <span class="text-danger">*</span></label>
                                        <input type="number" name="max_ticket" placeholder="Enter Maximun Ticket Per Order" id="max_ticket" min="0" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Sale Start Time</label>
                                        <input type="text" class="form-control date" name="sale_start_time" id="sale_start_time" value="" placeholder="Choose Start time" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Sale End Time</label>
                                        <input type="text" class="form-control date" name="sale_end_time" id="sale_end_time" value="" placeholder="Choose End time" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Pay Now Button</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="checkbox" name="pay_now" class="checkBox" value="1"
                                                    checked />
                                                <span>Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Pay At Event Place Button</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="checkbox" name="pay_place" class="checkBox" value="1"
                                                    checked />
                                                <span>Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                    <label for="">Who will pay SuperShow fee</label>
                                    <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                        <label class="radio-label">
                                            <input type="radio" name="superShow_fee" value="1" checked />
                                            <span>Me</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="superShow_fee" value="2" />
                                            <span>Buyer</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                    <label for="">Who will pay Payment Gateway fee</label>
                                    <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                        <label class="radio-label">
                                            <input type="radio" name="gateway_fee" value="1" checked />
                                            <span>Me</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="gateway_fee" value="2" />
                                            <span>Buyer</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                    <label for="">Platform Fee</label>
                                    <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                        <label class="radio-label">
                                            <input type="radio" name="platform_fee" value="1"  />
                                            <span>Me</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="platform_fee" value="2" checked />
                                            <span>Buyer</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="continue_btn" class="px-3 btn btn-primary">Submit Ticket</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    $("#event_form").validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "* Name is required"
            }
        },
        errorElement: 'div',
        highlight: function(element, errorClass) {
            $(element).css({
                border: '1px solid #f00'
            });
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "description") {
                error.insertAfter("#description_err");
            } else if (element.attr("name") == "event_type") {
                error.insertAfter("#event_type_err");
            } else if (element.attr("name") == "days[]") {
                error.insertAfter("#select_days_err");
            } else {
                error.insertAfter(element);
            }
        },
        unhighlight: function(element, errorClass) {
            $(element).css({
                border: '1px solid #c1c1c1'
            });
        },
        submitHandler: function(form) {
            document.event_form.submit();
            $("#continue_btn").attr('disabled', 'disabled').text('Processing...');
        }
    });
</script>
<script>
    let checkBox = document.getElementsByClassName('checkBox');
    Array.from(checkBox).forEach(element => {
        element.addEventListener('click', function() {
            if ($(this).prop('checked') == true) {
                $(this).val(1);
                $(this).siblings('span').html('Yes');
            } else {
                $(this).val(0);
                $(this).siblings('span').html('No');
            }
        })
    });
</script>
<script>
    let rowCheckbox = document.getElementsByClassName('rowCheckbox');
    Array.from(rowCheckbox).forEach(element => {
        element.addEventListener('click', function() {
            if ($(this).prop('checked') == true) {
                $(this).val(1);
                $from = $(this).data('id');
                $($from).show();
            } else {
                $(this).val(0);
                $from = $(this).data('id');
                $($from).hide();
            }
            
            if ($('.rowCheckbox:not(:checked)').length == $('.rowCheckbox').length) {
                $("#common").hide();
            }else{
                $("#common").show();
            }
        })
    });
</script>
<script>
    let tickettype = document.getElementsByClassName('tickettype');
    Array.from(tickettype).forEach(element => {
        element.addEventListener('click', function() {
            $id = $(this).data('id');
            if ($(this).val() == "free") {
                $($id).attr('disabled', true);
                $($id).val(0);
            } else {
                $($id).attr('disabled', false);
                $($id).val("");
            }
        })
    });
</script>
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