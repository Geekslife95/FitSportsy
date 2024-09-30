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
        <div class="row">
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card available-widget">
                    <div class="card-header">
                        <h5 class="card-title">Event Information</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><span>Event Place </span>{{$eventDeatils->temple_name}}</li>
                            <li><span>Event Type </span>{{$eventDeatils->event_type}}</li>
                            <li><span>Category </span> {{$eventDeatils->category->name}}</li>
                            <li><span>Status </span>{{$eventDeatils->status == 1 ? "Active" : "Inactive"}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-12">
                <form action="" method="POST" id="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Ticket</h5>
                            <input type="hidden" name="event_id" value="{{$eventDeatils->id}}">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="">Ticket Type</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" name="type" value="paid" checked />
                                                <span>Paid Ticket</span>
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" class="tickettype" name="type" value="free" />
                                                <span>Free Ticket</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Ticket name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="quantity" placeholder="Enter Quantity">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Price (INR)</label>
                                        <input type="number" name="price" placeholder="Price" id="price" step="any" value="" class="form-control " >
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustomUsername">Discount (In Pecentage)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="disc_type" class="form-control" aria-invalid="false" style="border: 1px solid rgb(193, 193, 193);">
                                                <option value="" disabled="">Select Type</option>
                                                <option value="FLAT">FLAT</option>
                                                <option value="DISCOUNT" selected="">DISCOUNT</option>
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" id="validationCustomUsername" placeholder="Enter Discount" name="discount" aria-describedby="inputGroupPrepend" required=""><br>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Maximum ticket Per Order</label>
                                        <input type="number" name="ticket_per_order" min="1" required="" placeholder="Maximum ticket per order" id="ticket_per_order" value="" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 ">
                                    <div class="form-group">
                                        <label for="" class="form-label">Status </label>
                                        <select name="status" class="form-control">
                                            <option value="1" selected>Active</option>
                                            <option value="0" >Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Sale Start Time</label>
                                        <input type="text" class="form-control date" name="sale_start_time" id="sale_start_time" value="" placeholder="Choose Start time" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Sale End Time</label>
                                        <input type="text" class="form-control date" name="sale_end_time" id="sale_end_time" value="" placeholder="Choose End time" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Pay Now Button</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="checkbox" name="pay_now" class="checkBox" value="1" checked />
                                                <span>Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Pay At Event Place Button</label>
                                        <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                            <label class="radio-label">
                                                <input type="checkbox" name="pay_place" class="checkBox" value="1" checked/>
                                                <span>Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
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
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
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
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
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
                                <div class="col-lg-12 col-md-12 col-12 ">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Ticket Description</label>
                                        <textarea name="description" class="form-control " placeholder="Enter Description" id="description" style="height:120px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary d-block">Submit Ticket</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script> 
    $("#event_form").validate({
        rules: {
            name:{required:true},
            quantity :{required:true},
            price:{required:true},
            ticket_per_order:{required:true},
        },
        messages: {
            name:{required:"* Name is required"},
            quantity:{required:"* Quantity is required"},
            price:{required:"* Price is required"},
            ticket_per_order:{required:"* Ticket per order is required"},
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
                $(this).siblings('span').html('Yes');
            }else{
                $(this).val(0);
                $(this).siblings('span').html('No');
            }
        })
    });
</script>
<script>
    let tickettype = document.getElementsByClassName('tickettype');
    Array.from(tickettype).forEach(element => {
        element.addEventListener('click',function(){
            if ($(this).val() == "free"){
                $('#price').attr('disabled',true);
                $('#price').val(0);
            }else{
                $('#price').attr('disabled',false);
                $('#price').val("");
            }
        })
    });
</script>
<script>
    function ticket($value){
        if($value == "Yes"){
            $('#showPreview').show();
        }else{
            $('#showPreview').hide();
        }
    }
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