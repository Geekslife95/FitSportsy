@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Home'))
@section('content')
<section class="cart-area section-area">
    <div class="container">
        <form>
            <div class="card shadow-sm border-0">
                <div class="card-body relative">
                    <div id="loader_parent">
                        <span class="loader"></span>
                    </div>
                    @if(count($cartData))
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cartTotalS = 0;
                                        $i=1;
                                    @endphp
                                    @foreach ($cartData as $item)
                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#">
                                                    <img src="{{asset('images/upload/'.$item->image)}}" alt="item">
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="{{url('product/'.$item->product_slug)}}">{{$item->product_name}}</a>
                                            </td>
                                            <td class="product-price">
                                                <span class="unit-amount">₹{{$item->product_price + 0}}</span>
                                            </td>
                                            <td class="product-quantity">
                                                @php
                                                    $inputObj = new stdClass();
                                                    $inputObj->url = url('add-quantity-to-cart');
                                                    $inputObj->params = 'id='.$item->id;
                                                    $encLink = Common::encryptLink($inputObj);
                                                @endphp
                                                <div class="input-counter" data-id="{{$encLink}}" data-price="{{$item->product_price + 0}}" data-cnt="{{$i}}">
                                                    <span class="minus-btn"><i class="fas fa-minus"></i></span>
                                                    <input type="text" class="prod_cnt" value="{{$productArr[$item->id]}}" min="1" max="{{$item->quantity}}">
                                                    <span class="plus-btn"><i class="fas fa-plus"></i></span>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                @php
                                                    $priceT = $item->product_price * ($productArr[$item->id]);
                                                    $cartTotalS+=$priceT;
                                                @endphp
                                                <span class="subtotal-amount" id="subtotal_{{$i}}">₹{{$priceT}}</span>
                                                @php
                                                    $inputObj = new stdClass();
                                                    $inputObj->params = 'id='.$item->id;
                                                    $inputObj->url = url('remove-from-cart');
                                                    $encLink = Common::encryptLink($inputObj);
                                                @endphp
                                                <a href="{{$encLink}}" class="remove"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-6 col-md-12 col-12 relative">
                                <div class="cart-totals">
                                    <h3>Cart Totals</h3>
                                    <ul>
                                        <li class="d-flex justify-content-between align-items-center">Subtotal <span id="sub_total">₹{{round($cartTotalS,2)}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Shipping Charge <span id="shipping_charge">₹{{Common::shippingCharge()}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Grand Total <span id="grand_total">₹{{round($cartTotalS + Common::shippingCharge(),2)}}</span></li>
                                    </ul>
                                    <div class="text-right">
                                        <a href="{{url('cart-checkout')}}" class="btn default-btn">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12 mt-3 ">
                                <div class="row align-items-center ">
                                      <div class="col-lg-3 col-md-3 col-6 text-center border border-dark p-3">
                                        <img src="{{asset('images/shipping.png')}}" alt="" class="img-fluid mb-1" width="50">
                                        <p class="mb-0">Free Shipping</p>
                                    </div>
                                        <div class="col-lg-3 col-md-3 col-6 text-center border border-dark p-3">
                                      <img src="{{asset('images/24hours.png')}}" alt="" class="img-fluid mb-1" width="50">
                                       <p class="mb-0">Within 24-48 hours Fast Dispatches</p>
                                    </div>
                                        <div class="col-lg-3 col-md-3 col-6 text-center border border-dark p-3">
                                       <img src="{{asset('images/securepayment.png')}}" alt="" class="img-fluid mb-1" width="50">
                                         <p class="mb-0">Secure Payments</p>
                                    </div>
                                          <div class="col-lg-3 col-md-3 col-6 text-center border border-dark p-3">
                                         <img src="{{asset('images/holistics.png')}}" alt="" class="img-fluid mb-1" width="50">
                                        <p class="mb-0">Holistic Well-being</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    @else
                        <div class="text-center">
                            <img src="{{asset('images/empty-box.png')}}" alt="" class="img-fluid">
                            <h4 class="mt-3">Your Cart List Is Empty</h4>
                              <p>Cart is empty. Please go to your home page for listing it.</p>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
