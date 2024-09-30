@extends('frontend.master', ['activePage' => 'Confirm Ticket Booking'])
@section('title', __('Book Event Tickets'))

@section('content')
    <section class="section-area checkout-event-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-3">{{ "Ticket Name" }}</h4>
                            {{-- <div class="event-img">
                                @if ($ticketData->event->gallery != null)
                                    @php
                                        $gallery = explode(',', $ticketData->event->gallery);
                                    @endphp
                                    <img src="{{ asset('images/upload/' . $gallery[0]) }}" alt="" class="img-fluid">
                                @endif
                            </div> --}}
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
                                    <span class="text-muted">{{ "2" }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Tickets Amount</p>
                                    </div>

                                    @php
                                        // $totalAmntTC = $ticketData->price;
                                        // if($ticketData->discount_type == "FLAT"){
                                        //     $totalAmntTC = ($ticketData->price) - ($ticketData->discount_amount);
                                        // }elseif($ticketData->discount_type == "DISCOUNT"){
                                        //     $totalAmntTC = ($ticketData->price) - ($ticketData->price * $ticketData->discount_amount)/100;
                                        // }

                                        // if($ticketData->convenience_type == "FIXED"){
                                        //     $totalAmntTC = $totalAmntTC + ($ticketData->convenience_amount);
                                        // }elseif($ticketData->convenience_type == "PERCENTAGE"){
                                        //     $dd = $totalAmntTC - ($totalAmntTC * $ticketData->discount_amount)/100;
                                        //     $totalAmntTC = $totalAmntTC + $dd;
                                        // }

                                    @endphp

                                    @php
                                    //    $ticketAmount =  $totalPersons * $totalAmntTC;
                                    @endphp
                                    {{-- <span class="text-muted">₹{{ round($ticketAmount, 2) }}</span> --}}
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Donation Amount</p>
                                    </div>
                                    {{-- <span class="text-muted">₹{{$data['donate_checked']}}</span> --}}
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Convenience Fee</p>
                                    </div>
                                    {{-- @php
                                    if($ticketData->convenience_type == "FIXED"){
                                        $con_fee = ($ticketData->convenience_amount);
                                    }elseif($ticketData->convenience_type == "PERCENTAGE"){
                                        $con_fee = ( $ticketData->price * $ticketData->convenience_amount)/100;
                                        // $con_fee = $totalAmntTC + $dd;
                                    }
                                   @endphp   --}}
                                    {{-- <span class="text-muted">₹<?php if(isset($con_fee)){echo $con_fee;}else{echo $con_fee=0;} ?></span> --}}
                                </li>
                                                         
                                {{-- @php
                                    $totalTax = 0;
                                @endphp
                                @foreach ($taxData as $tax)
                                    @php
                                        $txamount = $tax->price;
                                        if($tax->amount_type=='percentage'){
                                            $txamount = ((($con_fee+$ticketAmount+$data['donate_checked']) * $tax->price) / 100);
                                        }
                                        $ticketAmount+=$txamount;
                                        $totalTax+=$txamount;
                                    @endphp 
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        @if ($txamount > 0)
                                            <div>
                                                <p class="my-0">{{$tax->name}} {{$tax->amount_type=='percentage' ? '('.$tax->price.'%)' : ''}}</p>
                                            </div>
                                            <span class="text-muted">₹{{$txamount}}</span>
                                        @else
                                            <p class="my-0">GST</p>
                                            <span class="text-muted">0/-</span>
                                        @endif                                        
                                    </li>
                                @endforeach --}}
                                <li class="list-group-item d-flex justify-content-between bg-light">
                                    <div class="text-success">
                                        <h6 class="my-0">Coupon Discount</h6>
                                    </div>
                                    <span class="text-success" id="coupon_disc">-₹0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Total </strong>
                                    {{-- <strong id="total_amount">₹{{$ticketAmount+$data['donate_checked']+$con_fee}}</strong> --}}
                                </li>
                            </ul>
                            <p>Show the ticket content QR Code on your mobile to enter the event place. By Proceeding, I express my consent to complete this Transaction.</p>
                            {{-- @if($ticketData->ticket_sold!=1) --}}
                                <div class="radio-pannel d-flex flex-wrap mb-3">
                                    {{-- @if ($ticketData->pay_now == 1) --}}
                                        <label class="radio-label mr-2">
                                            <input type="radio" class="time_radio" name="payment_method"  value="1" checked>
                                            <span>Pay Now</span>
                                        </label>
                                    {{-- @endif --}}
                                    {{-- @if ($ticketData->pay_place == 1) --}}
                                    <label class="radio-label">
                                        <input type="radio" class="time_radio" name="payment_method"  value="2">
                                        <span>Pay At Event Place</span>
                                    </label>
                                    {{-- @endif --}}
                                </div> 
                                <button type="button" class="btn default-btn btn-block" id="payBookAmount">Continue To
                                    Checkout</button>
                            {{-- @else --}}
                                <button type="button" class="btn default-btn btn-block disabled">Tickets Soldout</button>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- @php
            $name = $data['prasada_name'];
            $email = $data['prasada_email'];
            $phone = $data['prasada_mobile'];
            $donate = $data['donate_checked'];
            $payData = Common::paymentKeysAll(); 
        @endphp
        <form action="{{$subLink}}" id="razorpay-form" method="post">
            @csrf
            <?php
                $feeToken = Common::randomMerchantId(1);
                $card_holder_name = $name;
                $productinfo = 'Book Event - '.$ticketData->event->name;
                $txnid = time().rand(1,99999);
                $surl = url('razor-event-book-payment-success');
                $furl = url('razor-event-book-payment-failed');
                $key_id = $payData->razorPublishKey;
                $merchant_order_id = $feeToken;
                $currency = 'INR';
                $donation = $data['donate_checked'];
            ?>
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id"/>
            <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
            <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
            <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
            <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl ?>"/>
            <input type="hidden" name="card_holder_name" id="card_holder_name" value="<?php echo $card_holder_name;?>"/>
            <input type="hidden" name="merchant_amount" id="merchant_amount" value="0"/>
            <input type="hidden" name="merchant_total" id="merchant_total" value="0"/>
            <input type="hidden" name="currency_code" id="currency_code" value="<?php echo $currency; ?>"/>
            <input type="hidden" name="total_tax" id="total_tax" value="<?php echo $totalTax; ?>"/>
            <input type="hidden" name="merchant_product_info" id="merchant_product_info" value="<?php echo $productinfo; ?>"/>
            <input type="hidden" name="coupon_id" id="coupon_id" value="0"/>
            <input type="hidden" name="coupon_discount" id="coupon_discount" value="0"/>
            <input type="hidden" name="total_amount_pay" id="total_amount_pay" value="{{$ticketAmount+$donation+$con_fee}}"/>
            <input type="hidden" name="payment_type" id="payment_type" value="1"/>
            <input type="hidden" name="fee" id="fee" value="{{$con_fee}}"/>
            <input type="hidden" name="donate_checked" id="donate_checked" value="<?php if($donation != 0){ echo "1";} ?>"/>
            <input type="hidden" name="discount_amount" id="discount_amount" value="{{$ticketData->price - $ticketAmount}}"/>
        </form> --}}
    </section>
@endsection



@push('scripts')
    {{-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script>
        $("#payBookAmount").on('click',function(){
            $("#payBookAmount").attr('disabled','disabled').text('Processing Payment...');
            $.post('{{$ticketCheckLink}}',{'_token':'{{csrf_token()}}','coupon':$("#promo_text").val()},function(data){
                if($('input[name="payment_method"]:checked').val()==2){
                    $("#payment_type").val('2');
                    setTimeout(() => {
                        document.getElementById('razorpay-form').submit(); 
                    }, 2000);
                }else{
                    console.log(data);
                    razorpaySubmit(data.amount);
                }
                
            })
        })
    </script>
    <script>
        var razorpay_submit_btn, razorpay_instance;
        function razorpaySubmit(amount){
            actualAmnt = amount;
            totalAmount = actualAmnt * 100;
            document.getElementById('merchant_amount').value = Math.round(actualAmnt);
            document.getElementById('merchant_total').value = Math.round(totalAmount);
            var razorpay_options = {
                key: "<?php echo $key_id; ?>",
                amount: Math.round(totalAmount),
                name: "BookMyPujaSeva",
                description: "Order #<?php echo $merchant_order_id; ?>",
                netbanking: true,
                currency: "INR",
                prefill: {
                    name:"<?php echo $name; ?>",
                    email: "<?php echo $email; ?>",
                    contact: "<?php echo $phone; ?>"
                },
                handler: function (transaction) {
                    document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                    document.getElementById('razorpay-form').submit();
                },
                "modal": {
                    "ondismiss": function(){
                        location.reload()
                    }
                }
            };
            if(actualAmnt > 0 && totalAmount > 0){
                if(typeof Razorpay == 'undefined'){
                    setTimeout(razorpaySubmit, 200);
                }else {
                    if(!razorpay_instance){
                        razorpay_instance = new Razorpay(razorpay_options);
                    }
                    razorpay_instance.open();
                }
            }
        }  
    </script>
    <script>
        $("#apply_btn").on('click',function(){
            var txt = $("#promo_text").val();
            if(txt!=''){
                $("#apply_btn").text('Processing...').attr('disabled','disabled');
                $.get('{{url("get-promo-discount")}}?code='+txt+'&amount={{$ticketAmount}}',function(data){
                    if(data.s==1){
                        $("#coupon_err").text("");
                        $("#coupon_disc").text('-₹'+data.amount)
                        $("#total_amount").text('₹'+data.famount)
                        $("#coupon_id").val(data.id)
                        $("#coupon_discount").val(data.amount)
                    }else{
                        $("#coupon_err").text('Invalid coupon code or coupon is expired');
                    }
                    $("#apply_btn").text('Apply').removeAttr('disabled');
                })
            }
        })
    </script> --}}
@endpush
