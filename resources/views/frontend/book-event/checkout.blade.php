@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('Book Event Tickets'))

@section('content')
<div id="loader_parent">
    <span class="loader"></span>
</div>
<form method="post" id="register_frm" action="{{$ticketPostLink}}" name="register_frm">
    @csrf
    <input type="hidden" value="" name="ticket_id" id="ticket_id">
    <input type="hidden" name="max_order" id="max_order" value="{{ $ticket->ticket_per_order }}">
    <input type="hidden" name="tick_order" id="tick_order" value="{{ $ticket->price }}">
    <section class="py-3 slot-booking">
        <div class="container">
            <div class="slot-details shadow-sm">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-3">Devotee Details
                    </h5>
                    <button type="button" class="btn btn-primary btn-sm mb-3" id="add_devotee">+ Add Devotee</button>
                </div>
                <div class="table-responsive mb-3">
                    <table class="table slot-table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name <span class="text-danger">*</span></th>
                                <th scope="col">Gotra</th>
                                <th scope="col">Rashi</th>
                                <th scope="col">Nakshtra</th>
                                <th scope="col">Occassion <span class="text-danger">*</span></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="pst_hre">
                            <tr class="dev_total">
                                <td data-label="Name">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="full_name[0]"
                                            value="{{ Auth::guard('appuser')->check() ? (Auth::guard('appuser')->user()->name . ' ' . Auth::guard('appuser')->user()->last_name) : '' }}"
                                            placeholder="" required>
                                    </div>
                                </td>
                                <td data-label="Gotra">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="gotra[0]"
                                            placeholder="">
                                    </div>
                                </td>
                                <td data-label="Rashi">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="rashi[0]"
                                            placeholder="">
                                    </div>
                                </td>
                                <td data-label="Nakshtra">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="nakshatra[0]"
                                            placeholder="">
                                    </div>
                                </td>
                                <td data-label="Occassion">
                                    <select class="form-control default-select" name="occasion[0]" required>
                                        <option value="" selected>Choose occasion</option>
                                        <option value="Festivals">Festivals</option>
                                        <option value="Birthdays">Birthdays</option>
                                        <option value="Anniversaries">Anniversaries</option>
                                        <option value="New Home or Business">New Home or Business</option>
                                        <option value="Graduation or Educational Achievements">Graduation or Educational Achievements</option>
                                        <option value="Naming Ceremony">Naming Ceremony</option>
                                        <option value="Vehicle Puja">Vehicle Puja</option>
                                        <option value="Weddings">Weddings</option>
                                        <option value="Harvest or Agricultural Celebrations">Harvest or Agricultural Celebrations</option>
                                        <option value="Death Anniversaries">Death Anniversaries</option>
                                        <option value="Astrologically Auspicious Days">Astrologically Auspicious Days</option>
                                        <option value="Special Personal Intentions">Special Personal Intentions</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 mb-3">

                        <div style="background: #efe4b0;width:fit-content;color:#000;" class="py-1 px-3 mb-2">
                            <p class="m-0">Tickets and event-related materials will be couriered to this address only for online Supershows bookings.</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <tbody>
                                    <tr>
                                        <td scope="row" class="w-25">Name <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control"
                                                    name="prasada_name" placeholder="" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">Address </td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control"
                                                    name="prasada_address" placeholder="">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">City </td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control" name="prasada_city" placeholder="">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12  mb-3">
                        <div style="background: #efe4b0;width:fit-content;color:#000;" class="py-1 px-3 mb-2">
                            <p class="m-0">Your ticket will be sent to these details</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <tbody>


                                    <tr>
                                        <td scope="row" class="w-25">Mobile No. <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">

                                                <input type="number" class="form-control"
                                                    name="prasada_mobile" placeholder="" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">Email <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="email" class="form-control"
                                                    name="prasada_email" placeholder="" required>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="form-check my-2">
                            <input type="checkbox" name="whattsapp_subscribe" class="form-check-input" id="whattsapp_subscribe" value="1" checked>
                            <label class="form-check-label" for="whattsapp_subscribe"><i class="fab fa-whatsapp-square" style="color:#25d366;font-size:18px;"></i> Subscribe to Whatsapp messages.</label>
                        </div>
                        <div class="mt-3">
                            <div style="background: #efe4b0;width:fit-content;color:#000;" class="py-1 px-3 mb-2">
                                <p class="m-0">Supershows : Your contribution makes a difference!</p>
                            </div>

                            <div class="form-check mb-2">
                                <input type="checkbox" name="donate_checked" class="form-check-input" id="donate_checked" value="5">
                                <label class="form-check-label" for="donate_checked"><i class="fas fa-heart" style="color:#e64c31;"></i> Donate Rs.5 to support spiritual and devotional initiatives.</label>
                            </div>
                                @php
                                    $totalAmnt = $ticket->price;
                                    if($ticket->discount_type == "FLAT"){
                                        $totalAmnt = ($ticket->price) - ($ticket->discount_amount);
                                    }elseif($ticket->discount_type == "DISCOUNT"){
                                        $totalAmnt = ($ticket->price) - ($ticket->price * $ticket->discount_amount)/100;
                                    }
                                @endphp
                            <button type="submit" id="btn-text" class="btn default-btn w-100">Proceed To Pay Rs.<span id="ticket_price">{{$totalAmnt}}</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<!-- terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Notes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
                <ol>
                    <li> Please arrive at the temple at least 15 minutes before the scheduled event time to allow for check-in and seating arrangements. Kindly follow the dress code guidelines provided by the temple for the event.
                    </li>
                    <li>Your e-ticket, displayed on your mobile device, is your entry pass for the event. Please have it ready for scanning upon arrival.
                    </li>
                    <li>Photography and mobile phone usage may be restricted during the event. Please respect the temple's rules and guidelines.</li>
                    <li>Before entering the temple premises, please remove your shoes and place them in the designated area.
                    </li>
                    <li>Maintain a respectful and quiet atmosphere within the temple premises, especially during the event.
                    </li>
                    <li>Follow the ushers' instructions for seating arrangements. Ensure that you occupy the seat assigned to you on your ticket.
                    </li>
                    <li>If the event involves offering items, kindly follow the instructions of the priest and participate with reverence.
                    </li>
                    <li>If you need to bring your mobile phone inside, please ensure it is switched to silent mode during the event.
                    </li>
                    <li>If you are bringing children or infants, please ensure they are calm and not disruptive during the event.
                    </li>
                    <li>If you arrive after the event has started, please wait quietly until a suitable break or pause to enter and be seated.
                    </li>
                    <li>Smoking and consuming food within the temple premises are generally not permitted. Please adhere to the temple's guidelines.
                    </li>
                    <li>In case of any questions or assistance needed, feel free to approach the temple authorities or volunteers.
                    </li>
                    <li>Familiarize yourself with the location of emergency exits and follow safety protocols provided by the temple.
                    </li>
                    <li>Review the terms and conditions regarding refunds and cancellations on your ticket purchase page.
                    </li>
                    <li>We value your feedback. If you have any suggestions or feedback about the event experience, please share it with us.
                    </li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="continue_btn" class="btn btn-primary">Accept</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="error_modal" tabindex="-1" aria-labelledby="error_ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="error_ModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body" id="error_modal_body">

            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
<script>
var max_oreder = parseInt(document.getElementById('max_order').value);
        var tick_price = parseFloat(document.getElementById('tick_order').value);
        var x = 1;
        $("#add_devotee").on('click', function() {
            var length = $('.dev_total').length;
            if (length < max_oreder) {
                $("#ticket_price").text((1) * tick_price);
                $("#pst_hre").append(`<tr class="dev_total">
                    <td data-label="Name">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="full_name[${x}]" id="full_name_${x}">
                        </div>
                    </td>
                    <td data-label="Gotra">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="gotra[${x}]" placeholder="">
                        </div>
                    </td>
                    <td data-label="Rashi">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="rashi[${x}]" placeholder="">
                        </div>
                    </td>
                    <td data-label="Nakshatra">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="nakshatra[${x}]" placeholder="">
                        </div>
                    </td>
                    <td data-label="Occasion">
                        <select class="form-control default-select" name="occasion[${x}]" required>
                            <option value="" selected disabled>Choose occasion</option>
                            <option value="Festivals">Festivals</option>
                            <option value="Birthdays">Birthdays</option>
                            <option value="Anniversaries">Anniversaries</option>
                            <option value="New Home or Business">New Home or Business</option>
                            <option value="Graduation or Educational Achievements">Graduation or Educational Achievements</option>
                            <option value="Naming Ceremony">Naming Ceremony</option>
                            <option value="Vehicle Puja">Vehicle Puja</option>
                            <option value="Weddings">Weddings</option>
                            <option value="Harvest or Agricultural Celebrations">Harvest or Agricultural Celebrations</option>
                            <option value="Death Anniversaries">Death Anniversaries</option>
                            <option value="Astrologically Auspicious Days">Astrologically Auspicious Days</option>
                            <option value="Special Personal Intentions">Special Personal Intentions</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove_dev"><i class="fa fa-trash-alt"></i></button>
                    </td>
                </tr>`);
                $(`#full_name_${x}`).rules('add',{
                    required:true,
                });
                x++;
            }
        })

$(document).on('click','.remove_dev',function(){
    var length = $('.dev_total').length;
    $("#ticket_price").text((1) * tick_price);
    $(this).parents('.dev_total').remove();
})

$("#register_frm").validate({
    rules: {
        'full_name[0]':'required'
    },
    messages: {},
    errorElement: 'div',
    highlight: function(element, errorClass) {
        $(element).css({ border: '1px solid #f00' });
    },
    unhighlight: function(element, errorClass) {
        $(element).css({ border: '1px solid #c1c1c1' });
    },
    errorPlacement: function(error, element) {
        if (element.attr("name") == "date_radio") {
            $("#date_radio_err").text('Select Event Date')
        }else if(element.attr("name") == "time_radio"){
            $("#time_radio_err").text('Select Event Time Slot')
        }else{
            error.insertAfter(element);
        }
        $("#error_modal_body").html(`
            <p class="text-danger">Below fields are required to book tickets</p>
            <ul style="color:red;">
                <li>Event Time Slot is required</li>
                <li>Customer name is required</li>
                <li>Customer Occastion is required</li>
                <li>Event address name is required</li>
                <li>Event address mobile is required</li>
                <li>Event address email is required</li>
            </ul>
        `);
        $("#error_modal").modal('show');
    },
    submitHandler: function(form,event) {
        event.preventDefault();
        $("#termsModal").modal('show');
    }
});

$('#continue_btn').on('click',function(){
    $("#loader_parent").css('display','flex');
    document.register_frm.submit();
    $("#continue_btn").attr('disabled','disabled').text('Processing...');
})
</script>
<script>
    $('#donate_checked').on('click',function(){
        if ($(this).prop('checked')==true){ 
            $('#ticket_price').html({{$totalAmnt}}+5);
        }else{
            $('#ticket_price').html({{$totalAmnt}});
        }
    })
</script>
@endpush
