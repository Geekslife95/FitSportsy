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
                    <h5 class="mb-3">Participant Details
                    </h5>
                    <button type="button" class="btn btn-primary btn-sm mb-3" id="add_devotee">+ Add
                        Participant</button>
                </div>
                <div class="table-responsive mb-3">
                    <table class="table slot-table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name <span class="text-danger">*</span></th>
                                <th scope="col">Age</th>
                                <th scope="col">Gender <span class="text-danger">*</span></th>
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
                                <td data-label="Age">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="gotra[0]" placeholder="">
                                    </div>
                                </td>
                                <td data-label="Gender">
                                    <select class="form-control default-select" name="occasion[0]" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <div style="background: #EFE4B0;width:fit-content;" class="py-1 px-3 mb-2">
                            <p class="m-0">Emergency contact details</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <tbody>
                                    <tr>
                                        <td scope="row" class="w-25">Name <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control" name="prasada_name"
                                                    placeholder="" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">Address </td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control" name="prasada_address"
                                                    placeholder="">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">City </td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control" name="prasada_city"
                                                    placeholder="">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12  mb-3">
                        <div style="background: #EFE4B0;width:fit-content;" class="py-1 px-3 mb-2">
                            <p class="m-0">Your ticket will be sent to these details</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <tbody>
                                    <tr>
                                        <td scope="row" class="w-25">Mobile No. <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="number" class="form-control" name="prasada_mobile"
                                                    placeholder="" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">Email <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="email" class="form-control" name="prasada_email"
                                                    placeholder="" required>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-check my-2">
                            <input type="checkbox" name="whattsapp_subscribe" class="form-check-input"
                                id="whattsapp_subscribe" value="1">
                            <label class="form-check-label" for="whattsapp_subscribe"><i class="fab fa-whatsapp-square"
                                    style="color:#25d366;font-size:18px;"></i> Subscribe to Whatsapp messages.</label>
                        </div>
                        <div class="mt-3">
                            <div style="background: #EFE4B0;width:fit-content;" class="py-1 px-3 mb-2">
                                <p class="m-0">BookMyAdventureQuest Cares : Your contribution makes a difference!</p>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="donate_checked" class="form-check-input"
                                    id="donate_checked" value="5">
                                <label class="form-check-label" for="donate_checked"><i class="fas fa-heart"
                                        style="color:#e64c31;"></i> Donate Rs.5 to support.</label>
                            </div>
                            {{-- @if($availableTickets > 0) --}}
                           @php
                                    $totalAmnt = $ticket->price;
                                    if($ticket->discount_type == "FLAT"){
                                        $totalAmnt = ($ticket->price) - ($ticket->discount_amount);
                                    }elseif($ticket->discount_type == "DISCOUNT"){
                                        $totalAmnt = ($ticket->price) - ($ticket->price * $ticket->discount_amount)/100;
                                    }
                                @endphp
                            <button type="submit" class="btn default-btn w-100">Proceed To Pay Rs.<span id="ticket_price">{{$totalAmnt}}</span></button>
                            {{-- @else --}}
                            {{-- <button type="button" class="btn btn-warning w-100">Event Housefull</button> --}}
                            {{-- @endif --}}
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
                    <li> Arrival Time: Please arrive at the adventure location at least 15 minutes before the scheduled
                        start time to complete check-in and necessary preparations.
                    </li>
                    <li>Dress Code: Follow any specific dress code or attire recommendations provided for your
                        adventure, ensuring your safety and comfort during the experience.
                    </li>
                    <li>E-Ticket Access: Your e-ticket, accessible on your mobile device, serves as your entry pass for
                        the adventure. Have it ready for verification upon arrival.</li>
                    <li>Photography and Mobile Use: Be aware that photography and mobile phone usage may be restricted
                        during certain portions of the adventure. Please comply with the adventure organizer's rules and
                        guidelines.</li>
                    <li>Footwear: Depending on the adventure location, you may be required to remove your shoes before
                        starting. Follow the instructions provided for footwear placement.</li>
                    <li>Respectful Atmosphere: Maintain a respectful and quiet atmosphere throughout the adventure,
                        particularly during critical moments.</li>
                    <li>Seating and Assignments: Follow the instructions of adventure guides and organizers regarding
                        seating arrangements. Occupy the designated spot as indicated on your ticket.</li>
                    <li>Participation in Activities: If the adventure involves activities or interactions, please follow
                        the guidance of the adventure instructors and participate with enthusiasm and respect.</li>
                    <li>Mobile Phones: If you need to bring your mobile phone, ensure it is set to silent mode to avoid
                        disrupting the adventure experience.</li>
                    <li>Children and Infants: If you are bringing children or infants, ensure they remain calm and
                        considerate to maintain a pleasant adventure environment for everyone.</li>
                    <li>Late Arrival: If you arrive after the adventure has commenced, kindly wait quietly for a
                        suitable break or pause before entering and taking your designated spot.</li>
                    <li>Smoking and Food: Smoking and consuming food during the adventure may not be permitted. Adhere
                        to the adventure organizer's guidelines regarding these activities.</li>
                    <li>Assistance: If you have questions or require assistance during the adventure, feel free to
                        approach adventure guides, organizers, or volunteers.</li>
                    <li>Safety Protocols: Familiarize yourself with the location of emergency exits and any safety
                        protocols provided by the adventure organizers. Your safety is paramount.</li>
                    <li>Refunds and Cancellations: Review the terms and conditions regarding refunds and cancellations
                        on your adventure booking page for clarity on such matters.</li>
                    <li>Feedback: We highly value your feedback. If you have any suggestions or comments about your
                        adventure experience, please share them with us. Your insights are invaluable for continuous
                        improvement.</li>
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
                            <input type="text" class="form-control" name="full_name[${x}]" id="full_name_${x}"
                                value="{{ Auth::guard('appuser')->check() ? (Auth::guard('appuser')->user()->name . ' ' . Auth::guard('appuser')->user()->last_name) : '' }}"
                                placeholder="" required>
                        </div>
                    </td>
                    <td data-label="Age">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="gotra[${x}]" placeholder="">
                        </div>
                    </td>
                    <td data-label="Gender">
                        <select class="form-control default-select" name="occasion[${x}]" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove_dev"><i class="fa fa-trash-alt"></i></button>
                    </td>
                </tr>`);
            $(`#full_name_${x}`).rules('add', {
                required: true,
            });
            x++;
        }
    })
    $(document).on('click', '.remove_dev', function() {
        var length = $('.dev_total').length;
        $("#ticket_price").text((1) * tick_price);
        $(this).parents('.dev_total').remove();
    })
    $("#register_frm").validate({
        rules: {
            'full_name[0]': 'required'
        },
        messages: {},
        errorElement: 'div',
        highlight: function(element, errorClass) {
            $(element).css({
                border: '1px solid #f00'
            });
        },
        unhighlight: function(element, errorClass) {
            $(element).css({
                border: '1px solid #c1c1c1'
            });
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "date_radio") {
                $("#date_radio_err").text('Select Event Date')
            } else if (element.attr("name") == "time_radio") {
                $("#time_radio_err").text('Select Event Time Slot')
            } else {
                error.insertAfter(element);
            }
            $("#error_modal_body").html(`
            <p class="text-danger">Below fields are required to book tickets</p>
            <ul style="color:red;">
                <li>Participant name is required</li>
                <li>Name is required</li>
                <li>Participant Gender is required</li>
                <li>Mobile No. is required</li>
                <li>Email is required</li>
            </ul>
        `);
            $("#error_modal").modal('show');
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            $("#termsModal").modal('show');
        }
    });
    $('#continue_btn').on('click', function() {
        $("#loader_parent").css('display', 'flex');
        document.register_frm.submit();
        $("#continue_btn").attr('disabled', 'disabled').text('Processing...');
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
