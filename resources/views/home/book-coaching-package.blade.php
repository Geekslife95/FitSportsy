@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('Book Event Tickets'))

@section('content')
@push('styles')
    <style>
        td{
            color: #ffffff;
        }
    </style>
@endpush
<div id="loader_parent">
    <span class="loader"></span>
</div>
<form method="post" id="register_frm" action="{{$encLink}}" name="register_frm">
    @csrf
    @php
        $realPrice = $coachingData->package_price;
        $afterDiscountPrice = $coachingData->package_price;
        if($coachingData->discount_percent > 0 && $coachingData->discount_percent <= 100){
            $perc = ($realPrice * $coachingData->discount_percent) / 100;
            $afterDiscountPrice = round($realPrice - $perc, 2);
            $showDiscount = 1;
        }

        $merchant_order_id = Common::randomMerchantId(1);

        $txnid = time().rand(1,99999);
        $surl = url('razor-event-book-payment-success');
        $furl = url('razor-event-book-payment-failed');
        $payData = Common::paymentKeysAll();
        $key_id = $payData->razorPublishKey;

    @endphp

    <section class="py-3 slot-booking text-white">
        <div class="container">
            <div class="slot-details shadow-sm">
               <div class="row">
                <div class="col-md-12">
                    <h6>{{ $coachingData->coaching->coaching_title }}</h6>
                </div>
               </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 mb-3">

                        <div style="background: #efe4b0;width:fit-content;color:#000;" class="py-1 px-3 mb-2">
                            <p class="m-0">Package Details</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <tbody>
                                    <tr>
                                        <td scope="row" class="w-25">Package Name </td>
                                        <td class="w-75">
                                            {{ $coachingData->package_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">Price </td>
                                        <td class="w-75">
                                            ₹{{ $afterDiscountPrice + 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">Duration </td>
                                        <td class="w-75">
                                            {{$coachingData->package_duration}}
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td scope="row" class="w-25">Session Timing </td>
                                        <td class="w-75">
                                           {{date("h:i A",strtotime($coachingData->session_start_time))}} - {{date("h:i A",strtotime($coachingData->session_end_time))}}
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td scope="row" class="w-25">Session  </td>
                                        <td class="w-75">
                                            {{-- {{implode(", ", json_decode($coachingData->session_days, true))}} --}}
                                            {!! $coachingData->description !!}
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
                            <input  value="{{ $afterDiscountPrice }}" type="hidden" name="payable_amout" id="payable_amout">
                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                            <input type="hidden" name="merchant_order_id" id="merchant_order_id"
                                value="<?php echo $merchant_order_id; ?>" />
                            <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>" />
                            <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>" />
                            <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl ?>" />
                            <input type="hidden" name="merchant_amount" id="merchant_amount" value="0" />
                            <input type="hidden" name="merchant_total" id="merchant_total" value="0" />
                            <input type="hidden" name="currency_code" id="currency_code" value="INR" />
                            <table class="table border mb-0">
                                <tbody>
                                    <tr>
                                        <td scope="row" class="w-25">Name <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">

                                                <input type="text" class="form-control"
                                                    name="full_name" placeholder="" id="full_name" required>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td scope="row" class="w-25">Address <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">

                                                <input type="text" class="form-control"
                                                    name="address" placeholder="" id="address" required>
                                            </div>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td scope="row" class="w-25">Mobile No. <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">

                                                <input type="number" class="form-control"
                                                    name="mobile_number" placeholder="" id="mobile_number" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="w-25">Email <span class="text-danger">*</span></td>
                                        <td class="w-75">
                                            <div class="form-group mb-0">
                                                <input type="email" class="form-control" id="email"
                                                    name="email" placeholder="" required>
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
                                <p class="m-0">Fitsportsy : Your contribution makes a difference!</p>
                            </div>

                            <div class="form-check mb-2">
                                <input type="checkbox" name="donate_checked" class="form-check-input" id="donate_checked" value="5">
                                <label class="form-check-label" for="donate_checked"><i class="fas fa-heart" style="color:#e64c31;"></i> Donate Rs.5 to support sports initiatives and inspire future champions.</label>
                            </div>
                                
                            <button type="submit" id="btn-text" class="btn default-btn w-100">Proceed To Pay Rs.<span id="ticket_price">{{$afterDiscountPrice + 0}}</span></button>
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
<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script>

$("#register_frm").validate({
    rules: {
    },
    messages: {},
    errorElement: 'div',
    highlight: function(element, errorClass) {
        $(element).css({ border: '1px solid #f00' });
    },
    unhighlight: function(element, errorClass) {
        $(element).css({ border: '1px solid #c1c1c1' });
    },
    submitHandler: function(form,event) {
        event.preventDefault();
        $("#termsModal").modal('show');
    }
});

$('#continue_btn').on('click',function(){
    $("#loader_parent").css('display','flex');
    // document.register_frm.submit();
    $("#continue_btn").attr('disabled','disabled').text('Processing...');
    razorpaySubmit(parseFloat($('#payable_amout').val()));
});
</script>

<script>
    var razorpay_submit_btn, razorpay_instance;

    function razorpaySubmit(amount) {
        actualAmnt = amount;
        totalAmount = actualAmnt * 100;
        document.getElementById('merchant_amount').value = Math.round(actualAmnt);
        document.getElementById('merchant_total').value = Math.round(totalAmount);
        var razorpay_options = {
            key: "<?php echo $key_id; ?>",
            amount: Math.round(totalAmount),
            name: "Fitsportsy",
            description: "Order #<?php echo $merchant_order_id; ?>",
            netbanking: true,
            currency: "INR",
            prefill: {
                name: $('#full_name').val(),
                email: $('#email').val(),
                contact: $('#mobile_number').val()
            },
            handler: function(transaction) {
                document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                document.getElementById('register_frm').submit();
            },
            "modal": {
                "ondismiss": function() {
                    location.reload()
                }
            }
        };
        if (actualAmnt > 0 && totalAmount > 0) {
            if (typeof Razorpay == 'undefined') {
                setTimeout(razorpaySubmit, 200);
            } else {
                if (!razorpay_instance) {
                    razorpay_instance = new Razorpay(razorpay_options);
                }
                razorpay_instance.open();
            }
        }
    }
</script>

<script>
    $('#donate_checked').on('click',function(){
        var newAmount = parseFloat('{{$afterDiscountPrice + 0}}'); 
        if ($(this).prop('checked')==true){
           newAmount = parseFloat($("#payable_amout").val()) + parseFloat($("#donate_checked").val()); 
        }else{
            newAmount = parseFloat($("#payable_amout").val()) - parseFloat($("#donate_checked").val()); 
        }
        console.log(newAmount);
        $('#payable_amout').val(newAmount);
        $('#ticket_price').text(newAmount);
    })
</script>



@endpush