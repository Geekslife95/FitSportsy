@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Home'))
@section('content')
@push('styles')
    <style>
        @media print {
        @page { margin: 0; }
        * {
    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
    color-adjust: exact !important;                 /* Firefox 48 – 96 */
    print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
}
         header,footer,#print_ticket,.bottom-location{
            display: none;
        }
      }
    </style>
@endpush
<section class="cart-area section-area">
    <div class="container">
        <div>
            <div class="card shadow-sm border-0">
                <div class="card-body relative">
                    <div id="loader_parent">
                        <span class="loader"></span>
                    </div>
                   
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">ORDER DETAILS</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderData->order_details as $item)
                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#">
                                                    <img src="{{asset('images/upload/'.$item->product->image)}}" alt="item" >
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="javascript:void(0)">{{$item->product->product_name}}</a>
                                            </td>
                                            <td class="product-price">
                                                <span class="unit-amount">₹{{$item->unit_price + 0}}</span>
                                            </td>
                                            <td class="product-quantity">
                                               {{$item->quantity}}
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="subtotal-amount">₹{{$item->total_price}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="product-thumbnail">
                                        <td colspan="4" class="text-center">Shipping Charges</td>
                                        <td class="product-subtotal"><span class="subtotal-amount">₹{{$orderData->delivery_charge + 0}}</span></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end">
                            @php
                                $shippingDetails = json_decode($orderData->shipping_details);
                                
                            @endphp
                            <div class="col-lg-6 col-md-12 col-12 relative">
                                <div class="cart-totals">
                                    <h3>Shipping Details</h3>
                                    <ul>
                                        <li class="d-flex justify-content-between align-items-center">Name <span class="pl-2">{{$shippingDetails->first_name.' '.$shippingDetails->last_name}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Email <span class="pl-2">{{$shippingDetails->email}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Phone <span class="pl-2">{{$shippingDetails->phone}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Address <span class="pl-2" style="font-size:16px;color:#000;">{{$shippingDetails->address.' '.$shippingDetails->address_two.' '.$shippingDetails->city.' '.$shippingDetails->state.' '.$shippingDetails->pin_code}}</span></li>
                                      
                                    </ul>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 relative">
                                <div class="cart-totals">
                                    <h3>Payment Details</h3>
                                    <ul>
                                        <li class="d-flex justify-content-between align-items-center">Total Amount <span class="pl-2">₹{{$orderData->total_paid + 0}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Order ID <span class="pl-2">{{$orderData->order_u_id}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Payment ID <span class="pl-2">{{$orderData->payment_id}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Payment Status <span class="pl-2">{{$orderData->payment_status}}</span></li>
                                        <li class="d-flex justify-content-between align-items-center">Delivery Status <span style="font-size:16px;color:#000;" class="pl-2">{{$orderData->status}}</span></li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-3">
                            <button class="btn default-btn" id="print_ticket"><i class="fas fa-print"></i> Print Order</button>
                      </div>
                   
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        $("#print_ticket").click(function () {
            window.print();
        });
    </script>
@endpush
