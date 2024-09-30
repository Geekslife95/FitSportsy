@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('Book Event Tickets'))

@php
$availableTickets = $type=='Particular' ?
(($ticketData->total_orders_sum_quantity!=null && ($ticketData->quantity > $ticketData->total_orders_sum_quantity)) ?
$ticketData->quantity - $ticketData->total_orders_sum_quantity : $ticketData->quantity)
: $ticketData->quantity;
@endphp
@section('content')

@php
    $inputObj = new stdClass();
    $inputObj->params = 'id='.$ticketData->event->id;
    $inputObj->url = url('post-book-ticket');
    $encLink = Common::encryptLink($inputObj);
@endphp

<form method="post" id="register_frm" action="{{$encLink}}" name="register_frm">
    @csrf
    <input type="hidden" value="" name="ticket_id" id="ticket_id">
    <input type="hidden" name="max_order" id="max_order" value="4">
    <input type="hidden" name="tick_order" id="tick_order" value="0">
    <section class="book-slot-detail">
        <div class="book-sheader">
            <div class="container">
                <h3 class="slot-title">{{ ucwords(strtolower($ticketData->event->name)) }}</h3>
            </div>
        </div>
        <div class="book-sbody">
            <div class="container">
                <div class="datebox">
                    <ul class="radio-pannel list-unstyled">
                        @foreach($daysArr as $k=>$v)
                        @php $dt = explode(' ',$v); @endphp
                        <li>
                            <label class="radio-label">
                                <input type="radio" class="date_radio" name="date_radio" value="{{$v}}"
                                    {{$k==0 ? 'checked':''}} required />
                                <span>
                                    <b class="date-day">{{date("D",strtotime($v))}} </b>
                                    <b class="date-title">{{$dt[0]}}</b>
                                    <b class="date-month">{{$dt[1]}}</b>
                                </span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                    <p class="m-0 error" id="date_radio_err"></p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-3 slot-booking">
        <div class="container">
            <div class="slot-details shadow-sm mb-3" id="event_list">
            </div>
        </div>
    </section>
    <div class="modal fade" id="seatModal" tabindex="-1" aria-labelledby="seatModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seatModalLabel">Number of Seats</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="seat-pannel text-center">
                        <img src="{{asset('/images/seat.gif')}}" alt="" class="img-fluid">
                        <ul class="radio-pannel list-unstyled">
                            @for ($i = 1; $i <= $ticketData->ticket_per_order; $i++)
                                <li>
                                    <label class="radio-label" for="seatcheckbox<?=$i;?>">
                                        <input type="radio" value="<?= $i;?>" name="seatcheck" id="seatcheckbox<?=$i;?>"
                                            {{$i == 1 ? "checked" : ""}} required>
                                        <span>
                                            <?= $i;?>
                                        </span>
                                    </label>
                                </li>
                                @endfor
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="seatSubmit" class="btn btn-primary">Continue</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- <div class="modal fade" id="ticket_modal" tabindex="-1" aria-labelledby="error_ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="error_ModalLabel">Tickets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body" id="ticket_modal_body">

            </div>
        </div>
    </div>
</div> --}}

<div class="row temple-row d-none" id="template">
    <div class="col-lg-4">
        <div class="temple-details">
            <h6 class="mb-1 temple_name">template_name </h6><span class="badge badge-danger event_type">test</span>
            <p class="text-warning address"><small>address</small></p>
        </div>
    </div>
    <div class="col-lg-4 time__slot">
        <div class="radio-pannel temple-slots">
        </div>
        <span class="text-center text-danger d-none date__error">*Please Select Time</span>
    </div>
    <div class="col-lg-4">
        <div class="temple-check">
            <button class="btn btn-sm btn-light select_tickets" type="button" data-toggle="modal"
                data-target="#seatModal" disabled><span class="btn__overlay">Select {{ ucwords(strtolower($ticketData->event->name)) }} Ticket</span></button>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $(document).on('click','#seatSubmit',function(){
            document.register_frm.submit();
        })
    })
</script>

<script>
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
                        <li>Super Show Time Slot is required</li>
                        <li>Devotee name is required</li>
                        <li>Devotee Occastion is required</li>
                        <li>Prasada address name is required</li>
                        <li>Prasada address mobile is required</li>
                        <li>Prasada address email is required</li>
                    </ul>
                `);
            $("#error_modal").modal('show');
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            $("#termsModal").modal('show');
        }
    });
</script>

<script>
    $('#continue_btn').on('click', function() {
        $("#loader_parent").css('display', 'flex');
        document.register_frm.submit();
        $("#continue_btn").attr('disabled', 'disabled').text('Processing...');
    })
</script>

<script>
    // $(document).on('click', ".select_tickets", function() {
    //     var url = $(this).data('id');
    //     var date = $('input[name=date_radio]:checked').val();
    //     $("#ticket_modal").modal('show');
    //     $("#ticket_modal_body").html('<h5 class="text-center mt-4">Loading tickets please wait...</h5>')
    //     $.post(url, {
    //         '_token': '{{csrf_token()}}',
    //         'date': date
    //     }, function(data) {
    //         $("#ticket_modal_body").html(data);
    //     })
    // });
</script>

<script>
    function setTicketCheckout(ticket_id, tick_order, date, time) {
        let formData = new FormData();
        formData.append('ticket_id', ticket_id);
        formData.append('tick_order', tick_order);
        formData.append('date', date);
        formData.append('time', time);
        fetch(`{{ route('set-ticket-checkout') }}`, {
            headers: {
                'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            },
            body: formData,
            method: 'POST'
        }).then(res => res.json()).then(data => {
            if (data.success) {
                console.log(data);
                window.location.href = `${data.redirection_link}`;
            }
        });
    }
    $(document).on('click', '.buy_ticket_click', function() {
        var id = $(this).data('id');
        $("#ticket_id").val(id);
        $("#tick_order").val($(this).data('amount'));
        $("#ticket_modal").modal('hide');
        $("#ticket_modal_body").html('')
        var timeRadioBtns = document.querySelectorAll('input[name="time_radio"]');
        var selectedTime = "";
        timeRadioBtns.forEach(function(timeRadioBtn) {
            if (timeRadioBtn.checked) {
                selectedTime = timeRadioBtn.value;
            }
        });
        var dateRadioBtns = document.querySelectorAll('input[name="date_radio"]');
        var selectedDate = "";
        dateRadioBtns.forEach(function(dateRadioBtn) {
            if (dateRadioBtn.checked) {
                selectedDate = dateRadioBtn.value;
            }
        });
        setTicketCheckout($("#ticket_id").val(), $("#tick_order").val(), selectedDate, selectedTime)
    })
</script>

@php
$dd = (date("H") * 60) + date('i');
@endphp

<script>
    let eventListEles = [];
    var curr_time = "{{$dd}}";
    class EventListElement {
        constructor(event) {
            this.template = document.getElementById('template').cloneNode(true);
            this.template.removeAttribute('id');
            this.template.classList.remove('d-none');
            this.event = event;
            this.addDetails();
            if (event.event_type === 'OnDemand') {
                this.enableTicketBtn();
            }else {
                this.addEventListeners();
            }
            document.getElementById('event_list').append(this.template);
        }
        addDetails() {
            this.template.querySelector('.temple_name').innerText = this.event.temple_name;
            this.template.querySelector('.address').innerText = this.event.address;
            this.template.querySelector('.select_tickets').dataset.id = this.event.ticket_link;
            this.template.querySelector('.event_type').innerText = this.event.event_type;
            if (this.event.event_type == 'Recurring' && JSON.parse(this.event.time_slots) !== null) {
                this.timeSlots = JSON.parse(this.event.time_slots);
                this.current_time = this.event.current_time;
                var cnt = 0;
                for (this.i = 0; this.i < this.timeSlots.length; this.i++) {
                    if (checkTimeEx(this.timeSlots[this.i].end_time, this.event.dateS)) {
                        cnt++;
                        this.template.querySelector('.temple-slots').innerHTML += `
                            <label class="radio-label">
                                <input type="radio" class="time_radio" name="time_radio" required value="${tConvert(this.timeSlots[this.i].start_time)} - ${tConvert(this.timeSlots[this.i].end_time)}" />
                                <span>${tConvert(this.timeSlots[this.i].start_time)} - ${tConvert(this.timeSlots[this.i].end_time)}</span>
                            </label>`;
                    }
                }
                if (cnt == 0) {
                    this.template.querySelector('.select_tickets').classList.add('d-none');
                    this.template.querySelector('.temple-slots').innerHTML =
                        '<h5 class="text-danger">NO EVENTS</h5>';
                }
                this.template.querySelector('.event_type').classList.add('d-none')
            } else {
                if (this.event.event_type === 'Particular') {
                    if (checkTimeEx(this.event.end_time, this.event.dateS)) {
                        this.template.querySelector('.temple-slots').innerHTML = `
                                <label class="radio-label">
                                    <input type="radio" class="time_radio" name="time_radio" required value="${tConvert(this.event.start_time)} - ${tConvert(this.event.end_time)}" />
                                    <span>${tConvert(this.event.start_time)} - ${tConvert(this.event.end_time)}</span>
                                </label>
                            `;
                        this.template.querySelector('.event_type').classList.add('d-none');
                    }
                }
            }
        }
        addEventListeners() {
            this.template.querySelector('.time__slot').addEventListener('click', () => {
                this.template.querySelector('.date__error').classList.add('d-none');
            })
            console.log(this.template.querySelector('.btn__overlay'));
            this.template.querySelector('.btn__overlay').addEventListener('click', () => {
                if (this.template.querySelector('.select_tickets').disabled) {
                    this.template.querySelector('.date__error').classList.remove('d-none');
                }
            })
            this.template.querySelectorAll('.time_radio').forEach((time_radio) => {
                if (time_radio.dataset.event === undefined) {
                    time_radio.addEventListener('change', () => {
                        eventListEles.forEach(eventEle => {
                            if (this == eventEle) {
                                eventEle.enableTicketBtn()
                            } else {
                                if (eventEle.event.event_type !== 'OnDemand') {
                                    eventEle.disableTicketBtn();
                                }
                            }
                        })
                    })
                }
                time_radio.dataset.event = true;
            })
        }
        disableTicketBtn() {
            this.template.querySelector('.select_tickets').setAttribute('disabled', 'disabled');
        }
        enableTicketBtn() {
            this.template.querySelector('.select_tickets').removeAttribute('disabled');
        }
    }
    const getEventList = (date) => {
        const formData = new FormData();
        formData.append('date', date);
        formData.append('name', `{{ $ticketData->event->name }}`)
        eventListEles = [];
        document.getElementById('event_list').innerHTML = `<div class="text-center" style="display: flex;justify-content: center;">
                                                                    <div style="width:150px">
                                                                        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                    viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                                                        <path fill="#e82525" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                                                        <animateTransform
                                                                            attributeName="transform"
                                                                            attributeType="XML"
                                                                            type="rotate"
                                                                            dur="1s"
                                                                            from="0 50 50"
                                                                            to="360 50 50"
                                                                            repeatCount="indefinite" />
                                                                    </path>
                                                                    </svg>
                                                                    </div>
                                                                    </div>`;
        fetch(`{{ route('get-event-list',['eq'=>request('eq')]) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            }).then(res => res.json())
            .then(data => {
                document.getElementById('event_list').innerHTML = '';
                if (data.data.length > 0) {
                    data.data.forEach(event => {
                        eventListEles.push(new EventListElement(event));
                    })
                } else {
                    document.getElementById('event_list').innerHTML =
                        `<h2 class="text-center">No Events Found.</h2>`;
                }
            }).catch(error => {
                console.error('Error:', error);
            });
    }
    async function addDateEvents() {
        await document.querySelectorAll('.date_radio').forEach((date) => {
            if (date.dataset.event === undefined) {
                date.addEventListener('click', () => {
                    getEventList(date.value);
                });
                date.dataset.event = true;
            }
        });
    }
    addDateEvents().then(() => {
        document.querySelector('.date_radio').click();
    })
</script>
<script>
    function tConvert(time) {
        // Check correct time format and split into components
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }
</script>

<script>
    function checkTimeEx(time, chk) {
        if (chk == 1) {
            return true;
        }
        var arr = time.split(':');
        var minutes = (parseInt(arr[0]) * 60) + parseInt(arr[1]);
        if (curr_time < minutes) {
            return true;
        }
        return false;
    }
</script>

@endpush