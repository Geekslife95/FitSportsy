@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('Book Event Tickets'))

@section('content')
    <section class="section-area slot-booking">
        <div class="container">
            @php
                $availableTickets = $type=='Particular' ?
                    (($ticketData->total_orders_sum_quantity!=null && ($ticketData->quantity > $ticketData->total_orders_sum_quantity)) ? $ticketData->quantity - $ticketData->total_orders_sum_quantity : $ticketData->quantity)
                 : $ticketData->quantity;


            @endphp
            <form method="post" id="register_frm" action="{{$ticketPostLink}}" name="register_frm">
                @csrf
                <div class="row justify-content-center">
                    @include('messages')
                    <input type="hidden" name="e_type" value="{{$type}}">
                    <div class="col-lg-12 col-md-12 col-12 relative">
                        <div id="loader_parent">
                            <span class="loader"></span>
                        </div>
                        

                        <div class="slot-details shadow-sm">
                            <div class="d-flex justify-content-between">
                                <h3 class="slot-title">{{ ucwords(strtolower($ticketData->event->name)) }}</h3>
                                <div>
                                    <span
                                        class="badge badge-pill badge-warning eventcat">{{ ucwords(strtolower($ticketData->event->cat_name)) }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-between mb-3">
                                <div class="col-lg-8 col-md-8 col-12">
                                    <div class="time-slot-card">
                                        <div class="slot-card-header">
                                            <p class="mb-0">Event Time Slots</p>
                                        </div>
                                        
                                        <div class="slot-card-body">
                                            @if($type=='Recurring')
                                                <div class="datebox">
                                                    <ul class="radio-pannel list-unstyled">
                                                        @foreach($daysArr as $v)
                                                            <li>
                                                                <label class="radio-label">
                                                                    <input type="radio" class="date_radio" name="date_radio" value="{{$v}}" required/>
                                                                    @php
                                                                        $dt = explode(' ',$v);
                                                                    @endphp
                                                                    <span>
                                                                        <b class="date-day text-uppercase">{{date("D",strtotime($v))}} </b>
                                                                        <b class="date-title text-uppercase">{{$dt[0]}}</b>
                                                                        <b class="date-month text-uppercase">{{$dt[1]}}</b>
                                                                    </span>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <p class="m-0 error" id="date_radio_err"></p>
                                                </div>
                                                <hr>
                                                <div class="radio-pannel d-flex flex-wrap">
                                                    @foreach ($timeSlots as $item)
                                                        @php
                                                            $start = date("h:iA",strtotime($item->start_time));
                                                            $end = date("h:iA",strtotime($item->end_time));
                                                            $times = $start.' - '.$end;
                                                        @endphp
                                                        <label class="radio-label">
                                                            <input type="radio" class="time_radio" name="time_radio" required value="{{$times}}"/>
                                                            <span>{{$times}}</span>
                                                        </label>
                                                    @endforeach
                                                    
                                                </div>
                                                <p class="m-0 d-block error" id="time_radio_err"></p>
                                            @elseif($type=="Particular")
                                                <div class="datebox text-center">
                                                    <p>{{date('d M Y',strtotime($ticketData->start_time)).' - '.date('d M Y',strtotime($ticketData->end_time))}}</p>
                                                </div>
                                            @else
                                            <div class="datebox text-center">
                                                <p>Organizer will confirm events timings</p>
                                            </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="time-slot-card">
                                        <div class="slot-card-header">
                                            <p class="mb-0">Available Tickets</p>
                                        </div>
                                        <div class="slot-card-body text-center">
                                            <h5 class="display-3 mb-0" id="available_ticket">{{ $availableTickets }}</h5>

                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                    <option value="Birthday">Birthday</option>
                                                    <option value="Party">Party</option>
                                                    <option value="Wedding">Wedding</option>
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
                                        <input type="checkbox" name="whattsapp_subscribe" class="form-check-input" id="whattsapp_subscribe" value="1">
                                        <label class="form-check-label" for="whattsapp_subscribe"><i class="fab fa-whatsapp-square" style="color:#25d366;font-size:18px;"></i> Subscribe to Whatsapp messages.</label>
                                    </div>
                                    <div class="mt-3">
                                        <div style="background: #efe4b0;width:fit-content;color:#000;" class="py-1 px-3 mb-2">
                                            <p class="m-0">Supershows Cares : Your contribution makes a difference!</p>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="donate_checked" class="form-check-input" id="donate_checked" value="1">
                                            <label class="form-check-label" for="donate_checked"><i class="fas fa-heart" style="color:#e64c31;"></i> Donate Rs.5 to support spiritual and devotional initiatives.</label>
                                        </div>
                                        @if($availableTickets > 0) 
                                            <button type="submit" class="btn default-btn w-100">Proceed To Pay Rs.<span id="ticket_price">{{ $ticketData->price }}</span></button>
                                        @else
                                            <button type="button" class="btn btn-warning w-100">Event Housefull</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                    </div>
                </div>
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
                                    <li> Please arrive at the temple at least 15 minutes before the scheduled events time to allow for check-in and seating arrangements. Kindly follow the dress code guidelines provided by the temple for the events.
                                    </li>
                                    <li>Your e-ticket, displayed on your mobile device, is your entry pass for the events. Please have it ready for scanning upon arrival.
                                    </li>
                                    <li>Photography and mobile phone usage may be restricted during the events. Please respect the temple's rules and guidelines.</li>
                                    <li>Before entering the temple premises, please remove your shoes and place them in the designated area.
                                    </li>
                                    <li>Maintain a respectful and quiet atmosphere within the temple premises, especially during the events.
                                    </li>
                                    <li>Follow the ushers' instructions for seating arrangements. Ensure that you occupy the seat assigned to you on your ticket.
                                    </li>
                                    <li>If the events involves offering items, kindly follow the instructions of the priest and participate with reverence.
                                    </li>
                                    <li>If you need to bring your mobile phone inside, please ensure it is switched to silent mode during the events.
                                    </li>
                                    <li>If you are bringing children or infants, please ensure they are calm and not disruptive during the events.
                                    </li>
                                    <li>If you arrive after the events has started, please wait quietly until a suitable break or pause to enter and be seated.
                                    </li>
                                    <li>Smoking and consuming food within the temple premises are generally not permitted. Please adhere to the temple's guidelines.
                                    </li>
                                    <li>In case of any questions or assistance needed, feel free to approach the temple authorities or volunteers.
                                    </li>
                                    <li>Familiarize yourself with the location of emergency exits and follow safety protocols provided by the temple.
                                    </li>
                                    <li>Review the terms and conditions regarding refunds and cancellations on your ticket purchase page.
                                    </li>
                                    <li>We value your feedback. If you have any suggestions or feedback about the events experience, please share it with us.
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
            </form>
        </div>
    </section>
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
    <script>
        var max_oreder = parseInt("{{ $availableTickets >= $ticketData->ticket_per_order ? $ticketData->ticket_per_order :  $availableTickets}}");
        var tick_price = parseFloat("{{ $ticketData->price }}");
        var x = 1;
        $("#add_devotee").on('click', function() {
            var length = $('.dev_total').length;
            if (length < max_oreder) {
                $("#ticket_price").text((length+1) * tick_price);
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
                            <option>Birthday</option>
                            <option>Party</option>
                            <option>Wedding</option>
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
    </script>
    <script>
        $(document).on('click','.remove_dev',function(){
            var length = $('.dev_total').length;
            $("#ticket_price").text((length-1) * tick_price);
            $(this).parents('.dev_total').remove();
        })
    </script>
    <script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
    <script> 
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
    </script>

    <script>
        $('#continue_btn').on('click',function(){
            $("#loader_parent").css('display','flex');
            document.register_frm.submit();
            $("#continue_btn").attr('disabled','disabled').text('Processing...');
        })
    </script>

    <script>
        $(".date_radio,.time_radio").on('click',function(){
            var dt = $(".date_radio:checked").val();
            var tm = $(".time_radio:checked").val();
            if(dt!=undefined && dt!='' && tm!='' && tm!=undefined){
                $("#loader_parent").css('display','flex');
                $.post('{{$ticketCheckLink}}',{'_token':'{{csrf_token()}}','dt':dt,'tm':tm},function(data){
                    $("#available_ticket").html(data);
                    $("#loader_parent").hide();
                });
            }
        });
    </script>

@endpush
