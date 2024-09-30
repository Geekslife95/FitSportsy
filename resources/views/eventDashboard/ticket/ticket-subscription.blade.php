@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h3 class="page-title mb-0">Marketing Services</h3>
                    <div class="skip-btn">
                        <a href="/dashboard" class="btn btn-sm btn-primary">Skip <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @include('messages')
        <div class="row pricing-box">
            @isset($subscription)
            @if ($subscription != NULL)
                @foreach ($subscription as $item)
                    <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="pricing-header">
                                    <h2>{{$item->title}}</h2>
                                    <p>{{$item->type}}ly Price</p>
                                </div>
                                <div class="pricing-card-price">
                                    <h3 class="heading2 price">₹{{$item->price}}</h3>
                                    <p>Duration: <span>{{$item->duration}} {{$item->type}}</span></p>
                                </div>
                                @php $services = json_decode($item->services); @endphp
                                <ul class="pricing-options">
                                    @foreach ($services as $serv)
                                        <li><i class="far fa-check-circle"></i> {{$serv}}</li>
                                    @endforeach
                                </ul>
                                <button class="payBookAmount btn btn-primary btn-block" data-id="{{$item->id}}" >Get Started</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @endisset
        </div>
    </div>
</div>
<form action="/buy-subscripton" id="razorpay-form" method="post">
    @csrf
    <?php
        $settingData = Common::paymentKeysAll();
        $feeToken = Common::randomMerchantId(1);
        $card_holder_name = Auth::user()->name;
        $productinfo = 'Event Subscription - ' . $eventId->name;
        $surl = url('razor-pay-payment-success');
        $furl = url('razor-pay-payment-failed');
        $key_id =  $settingData->razorPublishKey;
        $merchant_order_id = $feeToken;
        $currency = 'INR';
    ?>
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id"/>
    <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl ?>"/>
    <input type="hidden" name="card_holder_name" id="card_holder_name" value="<?php echo $card_holder_name;?>"/>
    <input type="hidden" name="merchant_amount" id="merchant_amount" value="0"/>
    <input type="hidden" name="merchant_total" id="merchant_total" value="0"/>
    <input type="hidden" name="currency_code" id="currency_code" value="<?php echo $currency; ?>"/>
    <input type="hidden" name="event_id" id="event_id" value="<?php echo $eventId->id; ?>"/>
    <input type="hidden" name="subscription_id" id="subscription_id" value=""/>
    <input type="hidden" name="total_amount_pay" id="total_amount_pay" value=""/>
    <input type="hidden" name="payment_type" id="payment_type" value="1"/>
    <input type="hidden" name="merchant_product_info" id="merchant_product_info" value="<?php echo $productinfo; ?>"/>
</form>

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script>
        $(document).on('click','.payBookAmount',function(){
            $(this).attr('disabled','disabled').text('Processing Payment...');
            $subId  = $(this).data('id');
            document.getElementById('subscription_id').value = $subId;
            $.post('/get-subscription-amount',{'_token':'{{csrf_token()}}','id':$subId},function(data){
                console.log(data.amount);
                razorpaySubmit(data.amount);
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
            document.getElementById('total_amount_pay').value = Math.round(actualAmnt);
            var razorpay_options = {
                key: "<?php echo $key_id; ?>",
                amount: Math.round(totalAmount),
                name: "Super Show",
                description: "Transection #<?php echo $merchant_order_id; ?>",
                netbanking: true,
                currency: "INR",
                prefill: {
                    name:"{{Auth::user()->name}}",
                    email: "{{Auth::user()->email}}",
                    contact: "{{Auth::user()->phone}}"
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
@endpush
@endsection