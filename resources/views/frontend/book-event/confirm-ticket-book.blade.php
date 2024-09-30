@extends('frontend.master', ['activePage' => 'Confirm Ticket Booking'])
@section('title', __('Book Event Tickets'))

@section('content')
@php
$superShowFee = 0;
$gateWayFee = 0;
$playFormFee = 0;
$totalAmntTC = 0;
$orgComm = 0;
@endphp
<section class="section-area checkout-event-area">
    <div class="container">
        @php $payData = Common::paymentKeysAll(); @endphp
        <form action="{{$subLink}}" id="razorpay-form" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8 ">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            @if (is_array(json_decode($ticketData)))
                                <h3 class="mb-2">{{ $ticketData[0]->event->name }}</h3>
                                <p class="mb-0 small">Event Place : {{ $ticketData[0]->event->temple_name  }}</p>
                                <p class="mb-0 small">Event Location :
                                    {{ $ticketData[0]->event->address.', '.$ticketData[0]->event->city_name  }}</p>
                                @if(Session::has('eventTicketBook'))
                                <p class="mb-0 small">Seat Number :
                                    @php
                                       $counter=0;
                                       $ticketCode =  Session::get('eventTicketBook');
                                       foreach ($ticketCode['seatSlot'] as $key) {
                                        $key = json_decode($key);
                                        if( $counter == count( $ticketCode['seatSlot'] ) - 1){
                                            echo $key[0].$key[1];
                                        }else{
                                            echo $key[0].$key[1].", ";
                                        }
                                        $counter++;
                                       }
                                    @endphp
                                </p>
                                @endif
                            @else
                                <h3 class="mb-2">{{ $ticketData->event->name }}</h3>
                                <p class="mb-0 small">Event Place : {{ $ticketData->event->temple_name  }}</p>
                                <p class="mb-0 small">Event Location :
                                    {{ $ticketData->event->address.', '.$ticketData->event->city_name  }}</p>
                            @endif
                            <h4 class="my-3 d-inline-block"
                                style="background:#db207b;color:#fff;padding:7px 20px 7px 10px;">Share your Contact
                                Details</h4>
                            <p class="text-danger mb-2" id="errors"></p>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="card_holder_name" name="card_holder_name"
                                        class="form-control" placeholder="Enter Your Name" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="name">Phone Number <span class="text-danger">*</span></label>
                                    <input type="number" id="number" name="number" class="form-control"
                                        placeholder="Enter Your Number" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="name">Email Id <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Enter Your Email" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="name">Address </label>
                                    <input type="text" id="address" name="address" class="form-control"
                                        placeholder="Enter Your Address">
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check my-2">
                                        <input type="checkbox" name="whattsapp_subscribe" class="form-check-input"
                                            id="whattsapp_subscribe" value="1" checked="">
                                        <label class="form-check-label" for="whattsapp_subscribe"><i
                                                class="fab fa-whatsapp-square"
                                                style="color:#25d366;font-size:18px;"></i> Subscribe to Whatsapp
                                            messages.</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div style="background: #efe4b0;width:fit-content;color:#000;" class="py-1 px-3 mb-2">
                                        <p class="m-0">Super Show Cares : Your contribution makes a difference!</p>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="donate_checked_amount" class="form-check-input"
                                            id="donate_checked_amount" value="5">
                                        <label class="form-check-label" for="donate_checked_amount"><i
                                                class="fas fa-heart" style="color:#e64c31;"></i> Donate Rs.5 to support
                                            spiritual and devotional initiatives.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4  mb-4">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            <h4 class=" mb-3">
                                <span class="text-muted">Payment Summary</span>
                            </h4>
                            <p class="text-danger m-0" id="coupon_err"></p>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="promo_text" placeholder="Promo code">
                                <div class="input-group-append">
                                    <button type="button" id="apply_btn" class="btn btn-dark">Apply</button>
                                </div>

                            </div>

                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Total Tickets</p>
                                    </div>
                                    <span class="text-muted">{{ $totalPersons }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Tickets Amount</p>
                                    </div>

                                    @if (is_array(json_decode($ticketData)))
                                        @foreach ($ticketData as $item)
                                            @php
                                                $fAmount = $item->price;
                                                if($item->discount_type == "FLAT"){
                                                    $fAmount = ($fAmount) - ($item->discount_amount);
                                                }elseif($item->discount_type == "DISCOUNT"){
                                                    $fAmount = ($fAmount) - ($fAmount * $item->discount_amount)/100;
                                                }
                                                $cntt = $arrCnt[$item->id];
                                                $totalAmntTC = ($totalAmntTC + $fAmount) * $cntt;
                                            @endphp
                                        @endforeach
                                        @php $ticketAmount = $totalAmntTC; @endphp
                                    @else
                                        @php
                                            $totalAmntTC = $ticketData->price;
                                            if($ticketData->discount_type == "FLAT"){
                                                $totalAmntTC = ($ticketData->price) - ($ticketData->discount_amount);
                                            }elseif($ticketData->discount_type == "DISCOUNT"){
                                                $totalAmntTC = ($ticketData->price) - ($ticketData->price *
                                                $ticketData->discount_amount)/100;
                                            }
                                           $ticketAmount = $totalPersons * $totalAmntTC; 

                                        @endphp
                                    @endif
                                    @php $orgComm = round($ticketAmount, 2); @endphp
                                    <span class="text-muted">₹{{ round($ticketAmount, 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Donation Amount</p>
                                    </div>
                                    <span class="text-muted" id="donationAmount">₹0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Convenience Fee</p>
                                    </div>
                                    @if (is_array(json_decode($ticketData)))
                                        {{-- SuperShow Fee --}}
                                        @if ($ticketData[0]->superShow_fee == 2)
                                            @if ($ticketData[0]->superShow_fee_type == "FIXED")
                                                @php $superShowFee = ($ticketData[0]->superShow_fee_amount) @endphp
                                            @else
                                                @php $superShowFee = ($ticketAmount * $ticketData[0]->superShow_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @else 
                                            @if ($ticketData[0]->superShow_fee_type == "FIXED")
                                                @php $orgComm -= ($ticketData[0]->superShow_fee_amount) @endphp
                                            @else
                                                @php $orgComm -= ($ticketAmount * $ticketData[0]->superShow_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @endif

                                        {{-- Payment Gatway Fee  --}}
                                        @if ($ticketData[0]->gateway_fee == 2)
                                            @if ($ticketData[0]->gateway_fee_type == "FIXED")
                                                @php $gateWayFee = ($ticketData[0]->gateway_fee_amount) @endphp
                                            @else
                                                @php $gateWayFee = ($ticketAmount * $ticketData[0]->gateway_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @else
                                            @if ($ticketData[0]->gateway_fee_type == "FIXED")
                                                @php $orgComm -= ($ticketData[0]->gateway_fee_amount) @endphp
                                            @else
                                                @php $orgComm -= ($ticketAmount * $ticketData[0]->gateway_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @endif

                                        {{-- PlatForm Fee --}}
                                        @if ($ticketData[0]->platform_fee == 2)
                                            @if ($ticketData[0]->platform_fee_type == "FIXED")
                                                @php $playFormFee = ($ticketData[0]->platform_fee_amount) @endphp
                                            @else
                                                @php $playFormFee = ($ticketAmount * $ticketData[0]->platform_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @else
                                            @if ($ticketData[0]->platform_fee_type == "FIXED")
                                                @php $orgComm -= ($ticketData[0]->platform_fee_amount) @endphp
                                            @else
                                                @php $orgComm -= ($ticketAmount * $ticketData[0]->platform_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @endif
                                    @else
                                        {{-- SuperShow Fee --}}
                                        @if ($ticketData->superShow_fee == 2)
                                            @if ($ticketData->superShow_fee_type == "FIXED")
                                                @php $superShowFee = ($ticketData->superShow_fee_amount) @endphp
                                            @else
                                                @php $superShowFee = ($ticketAmount * $ticketData->superShow_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @else
                                            @if ($ticketData->superShow_fee_type == "FIXED")
                                                @php $orgComm -= ($ticketData->superShow_fee_amount) @endphp
                                            @else
                                                @php $orgComm -= ($ticketAmount * $ticketData->superShow_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @endif

                                        {{-- Payment Gatway Fee  --}}
                                        @if ($ticketData->gateway_fee == 2)
                                            @if ($ticketData->gateway_fee_type == "FIXED")
                                                @php $gateWayFee = ($ticketData->gateway_fee_amount) @endphp
                                            @else
                                                @php $gateWayFee = ($ticketAmount * $ticketData->gateway_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @else
                                            @if ($ticketData->gateway_fee_type == "FIXED")
                                                @php $orgComm -= ($ticketData->gateway_fee_amount) @endphp
                                            @else
                                                @php $orgComm -= ($ticketAmount * $ticketData->gateway_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @endif

                                        {{-- PlatForm Fee --}}
                                        @if ($ticketData->platform_fee == 2)
                                            @if ($ticketData->platform_fee_type == "FIXED")
                                                @php $playFormFee = ($ticketData->platform_fee_amount) @endphp
                                            @else
                                                @php $playFormFee = ($ticketAmount * $ticketData->platform_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @else
                                            @if ($ticketData->platform_fee_type == "FIXED")
                                                @php $orgComm -= ($ticketData->platform_fee_amount) @endphp
                                            @else
                                                @php $orgComm -= ($ticketAmount * $ticketData->platform_fee_amount)/100;
                                                @endphp
                                            @endif
                                        @endif
                                    @endif
                                    <span class="text-muted">₹{{ $charges = round($superShowFee + $gateWayFee + $playFormFee,2)}}</span>
                                </li>
                                @php $totalTax = 0; @endphp
                                @foreach ($taxData as $tax)
                                @php
                                $txamount = $tax->price;
                                if($tax->amount_type=='percentage'){
                                $txamount = ((($charges+$ticketAmount) * $tax->price) / 100);
                                }
                                $ticketAmount += $txamount;
                                $totalTax += $txamount;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    @if ($txamount > 0)
                                    <div>
                                        <p class="my-0">{{$tax->name}}
                                            {{$tax->amount_type=='percentage' ? '('.$tax->price.'%)' : ''}}</p>
                                    </div>
                                    <span class="text-muted">₹{{round($txamount,2)}}</span>
                                    @else
                                    <p class="my-0">GST</p>
                                    <span class="text-muted">0/-</span>
                                    @endif
                                </li>
                                @endforeach
                                <li class="list-group-item d-flex justify-content-between bg-dark">
                                    <div class="text-warning">
                                        <h6 class="my-0">Coupon Discount</h6>
                                    </div>
                                    <span class="text-warning" id="coupon_disc">-₹0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Total </strong>
                                    <input type="hidden" value="{{round($ticketAmount+$charges,2)}}"
                                        id="pretotalAmount">
                                    <strong id="total_amount">₹{{round($ticketAmount+$charges,2)}}</strong>
                                </li>
                            </ul>
                            <p>Show the ticket content QR Code on your mobile to enter the event place. By Proceeding, I
                                express my consent to complete this Transaction.</p>
                                @if (is_array(json_decode($ticketData)))
                                    @if($ticketData[0]->ticket_sold!=1)
                                    <div class="radio-pannel d-flex flex-wrap mb-3">
                                        @if ($ticketData[0]->pay_now == 1)
                                        <label class="radio-label mr-2">
                                            <input type="radio" class="time_radio" name="payment_method" value="1" checked>
                                            <span>Pay Now</span>
                                        </label>
                                        @endif
                                        @if ($ticketData[0]->pay_place == 1)
                                        <label class="radio-label">
                                            <input type="radio" class="time_radio" name="payment_method" value="2">
                                            <span>Pay At Event Place</span>
                                        </label>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn default-btn btn-block" id="payBookAmount">Continue To
                                        Checkout</button>
                                    @else
                                    <button type="submit" class="btn default-btn btn-block disabled">Tickets Soldout</button>
                                    @endif
                                @else
                                @if($ticketData->ticket_sold!=1)
                                    <div class="radio-pannel d-flex flex-wrap mb-3">
                                        @if ($ticketData->pay_now == 1)
                                        <label class="radio-label mr-2">
                                            <input type="radio" class="time_radio" name="payment_method" value="1" checked>
                                            <span>Pay Now</span>
                                        </label>
                                        @endif
                                        @if ($ticketData->pay_place == 1)
                                        <label class="radio-label">
                                            <input type="radio" class="time_radio" name="payment_method" value="2">
                                            <span>Pay At Event Place</span>
                                        </label>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn default-btn btn-block" id="payBookAmount">Continue To
                                        Checkout</button>
                                    @else
                                    <button type="submit" class="btn default-btn btn-block disabled">Tickets Soldout</button>
                                    @endif
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- Razor Pay Details --}}
            @php
            if (is_array(json_decode($ticketData))) {
               $EventName =  $ticketData[0]->event->name;
            }else{
                $EventName =  $ticketData->event->name;
            }
            $feeToken = Common::randomMerchantId(1);
            $productinfo = 'Book Show - '. $EventName;
            $txnid = time().rand(1,99999);
            $surl = url('razor-event-book-payment-success');
            $furl = url('razor-event-book-payment-failed');
            $key_id = $payData->razorPublishKey;
            $merchant_order_id = $feeToken;
            $currency = 'INR';
            @endphp
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
            <input type="hidden" name="merchant_order_id" id="merchant_order_id"
                value="<?php echo $merchant_order_id; ?>" />
            <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>" />
            <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>" />
            <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl ?>" />
            <input type="hidden" name="merchant_amount" id="merchant_amount" value="0" />
            <input type="hidden" name="merchant_total" id="merchant_total" value="0" />
            <input type="hidden" name="currency_code" id="currency_code" value="<?php echo $currency; ?>" />
            <input type="hidden" name="total_tax" id="total_tax" value="<?php echo round($totalTax,2); ?>" />
            <input type="hidden" name="org_commission" value="{{$orgComm}}">
            <input type="hidden" name="merchant_product_info" id="merchant_product_info"
                value="<?php echo $productinfo; ?>" />
            <input type="hidden" name="coupon_id" id="coupon_id" value="0" />
            <input type="hidden" name="coupon_discount" id="coupon_discount" value="0" />
            <input type="hidden" name="total_amount_pay" id="total_amount_pay"
                value="{{round($ticketAmount+$charges,2)}}" />
            <input type="hidden" name="payment_type" id="payment_type" value="1" />
            <input type="hidden" name="fee" id="fee" value="{{$charges}}" />
            <input type="hidden" name="donate_checked" id="donate_checked" value="0" />
            <input type="hidden" name="discount_amount" id="discount_amount"
                value="<?php
                    if (is_array(json_decode($ticketData))) {
                        echo round($ticketData[0]->price - $ticketAmount,2);
                    }else{
                        echo round($ticketData->price - $ticketAmount,2);
                    } ?>" />
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>

<script>
    $("#payBookAmount").on('click', function() {
        $name = $('#card_holder_name').val();
        $number = $('#number').val();
        $email = $('#email').val();
        if ($name != "" && $number != "" && $email != "") {
            $("#payBookAmount").attr('disabled', 'disabled').text('Processing Payment...');
            $.post('{{$ticketCheckLink}}', {
                '_token': '{{csrf_token()}}',
                'coupon': $("#promo_text").val(),
                'donation': $('#donate_checked').val(),
            }, function(data) {
                if ($('input[name="payment_method"]:checked').val() == 2) {
                    $("#payment_type").val('2');
                    setTimeout(() => {
                        document.getElementById('razorpay-form').submit();
                    }, 2000);
                } else {
                    console.log(data);
                    razorpaySubmit(data.amount);
                }
            })
        } else {
            $('#errors').html('Please Fill Required Details');
        }
    })
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
            name: "Super Show",
            description: "Order #<?php echo $merchant_order_id; ?>",
            netbanking: true,
            currency: "INR",
            prefill: {
                name: $('#card_holder_name').val(),
                email: $('#email').val(),
                contact: $('#number').val()
            },
            handler: function(transaction) {
                document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                document.getElementById('razorpay-form').submit();
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
    $("#apply_btn").on('click', function() {
        var txt = $("#promo_text").val();
        if (txt != '') {
            $("#apply_btn").text('Processing...').attr('disabled', 'disabled');
            $.get('{{url("get-promo-discount")}}?code=' + txt + '&amount={{$ticketAmount+$charges}}', function(
                data) {
                if (data.s == 1) {
                    $("#coupon_err").text("");
                    $("#coupon_disc").text('-₹' + data.amount)
                    $("#total_amount").text('₹' + data.famount)
                    $("#coupon_id").val(data.id)
                    $("#coupon_discount").val(data.amount)
                    $("#pretotalAmount").val(data.famount)
                } else {
                    $("#coupon_err").text('Invalid coupon code or coupon is expired');
                }
                $("#apply_btn").text('Apply').removeAttr('disabled');
            })
        }
    })
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#donate_checked_amount', function() {
            $total = $('#pretotalAmount').val();
            if ($('#donate_checked_amount').prop('checked') == true) {
                $(this).val(5);
                $('#donationAmount').html('₹5');
                $total = parseFloat($('#pretotalAmount').val()) + 5.00;
                $('#total_amount').html('₹' + $total);
                $('#donate_checked').val(5);
                $('#total_amount_pay').val($total);
            } else {
                $(this).val(0);
                $('#total_amount_pay').val($total);
                $('#donate_checked').val(0);
                $('#total_amount').html('₹' + $total);
                $('#donationAmount').html('₹0');
            }
        })
    })
</script>
@endpush