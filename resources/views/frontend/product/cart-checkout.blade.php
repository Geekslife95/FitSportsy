@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Home'))
@section('content')
<section class="section-area checkout-event-area">
    <div class="container">
        <div class="row">
            @php
                $user = Auth::guard('appuser')->user();
            @endphp
            <div class="col-md-8 order-md-1 order-2">
                <div class="card checkout-card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-3">Shipping Address</h4>
                        <hr>
                        <form method="post" action="{{url('store-payment-details')}}" id="razorpay-form" name="razorpay-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" placeholder="" value="{{$user->name}}" required="" maxlength="40">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="" value="{{$user->last_name}}" required="" maxlength="40">
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" placeholder="" maxlength="80">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone">Phone <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="phone" name="phone" value="{{$user->phone}}" placeholder="">
                                </div>
                            </div>
                           

                            <div class="mb-3">
                                <label for="address">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="" required="" maxlength="250">
                            </div>
                            <div class="mb-3">
                                <label for="address2">Address 2</label>
                                <input type="text" class="form-control" id="address2" name="address_two" placeholder="" maxlength="250">
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="state">State</label>
                                    <select class=" d-block w-100 form-control" id="state" name="state" required="">
                                        <option value="">Select State</option>
                                        @foreach (Common::statesAll() as $item)
                                            <option value="{{$item->state_title}}">{{$item->state_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="" required maxlength="80 ">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="pin_code">Pin Code</label>
                                    <input type="text" class="form-control" id="pin_code" name="pin_code" placeholder="" required="" maxlength="8">
                                   
                                </div>
                            </div>
                            <hr class="mb-4">
                            <div class="form-group">
                                <h6>Choose Payment Method</h6>
                                 <div class="radio-pannel d-flex flex-wrap" style="gap:15px">
                                    <label class="radio-label">
                                        <input type="radio" name="pay_type" value="1" checked required/>
                                        <span>Pay Online</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="pay_type" value="2" required/>
                                        <span>COD(Cash On Delivery)</span>
                                    </label>
                                </div>
                            </div>
                            <button class="btn default-btn btn-block" id="payBookAmount" type="submit">Continue to checkout</button>

                            @csrf
                            <?php
                                $payData = Common::paymentKeysAll(); 
                                $feeToken = Common::randomMerchantId($user->id);
                                $card_holder_name = $user->name.' '.$user->last_name;
                                $productinfo = 'Buy Products';
                                $txnid = time().rand(1,99);
                                $surl = url('razor-product-payment-success');
                                $furl = url('razor-product-payment-failed');
                                $key_id = $payData->razorPublishKey;
                                $merchant_order_id = $feeToken;
                                $currency = 'INR';
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
                            <input type="hidden" name="merchant_product_info" id="merchant_product_info" value="<?php echo $productinfo; ?>"/>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-md-2 order-1  mb-3">
                <div class="card checkout-card shadow-sm">
                    <div class="card-body">
                        <h4 class=" mb-3">
                          Product Details
                        </h4>
                        @php
                            $cartTotalS = 0;
                        @endphp
                        <ul class="list-group mb-3">
                            @foreach ($cartData as $item)
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0">{{(ucwords(strtolower($item->product_name)))}}</h6>
                                    </div>
                                    @php
                                        $priceT = $item->product_price * ($productArr[$item->id]);
                                        $cartTotalS+=$priceT;
                                    @endphp
                                    <span class="text-muted">₹{{$priceT}}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Sub Total (INR)</span>
                                <strong>₹{{round($cartTotalS,2)}}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Shipping Charge</span>
                                <strong>₹{{Common::shippingCharge()}}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Grand Total (INR)</strong>
                                <strong>₹{{round(($cartTotalS + Common::shippingCharge()),2)}}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script>
        $("#razorpay-form").on('submit',function(e){
            e.preventDefault();
            if($('input[name="pay_type"]:checked').val()==1){
                $("#payBookAmount").attr('disabled','disabled').text('Processing Payment...');
                $.post('{{url("get-rzr-total-product-pay")}}',{'_token':'{{csrf_token()}}'},function(data){
                    razorpaySubmit(data.amount);
                })
            }else{
                document.getElementById('razorpay-form').submit();
            }
            
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
                name: "Supershows",
                description: "Order #<?php echo $merchant_order_id; ?>",
                netbanking: true,
                currency: "INR",
                prefill: {
                    name:"<?php echo $card_holder_name; ?>",
                    email: "<?php echo $user->email; ?>",
                    contact: "<?php echo $user->phone; ?>"
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
