@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Home'))
@section('content')

<section class="cart-area section-area">
    <div class="container">
        <div>
            <div class="card shadow-sm border-0">
                <div class="card-body relative">
                   
                    @if(count($orderData))
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="7" class="text-center">My Orders</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Payment ID</th>
                                        <th scope="col">Grand Total</th>
                                        <th scope="col">Payment ID</th>
                                        <th scope="col">Pay Status</th>
                                        <th scope="col">Delivery Status</th>
                                        <th scope="col">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderData as $item)
                                        @php
                                            $inputObj = new stdClass();
                                            $inputObj->url = url('user-order-details');
                                            $inputObj->params = 'order_id='.$item->id;
                                            $encLink = Common::encryptLink($inputObj);
                                        @endphp
                                        <tr>
                                            <td class="product-price">
                                                <a href="{{$encLink}}">{{$item->order_u_id}}</a>
                                            </td>
                                            <td class="product-price">
                                                <span>{{$item->payment_id}}</span>
                                            </td>
                                            <td class="product-price">
                                                <span>₹{{$item->total_paid}}</span>
                                            </td>
                                            <td class="product-price">
                                                <span>{{$item->payment_id}}</span>
                                            </td>
                                            <td class="product-price">
                                                <span>{{$item->payment_status}}</span>
                                            </td>
                                            <td class="product-price">
                                                <span>{{$item->status}}</span>
                                            </td>
                                            <td class="product-price">
                                                <a href="{{$encLink}}"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="w-100 mt-3 num_pagination">
                                {{$orderData->appends(request()->input())->links('paginate')}}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <img src="{{asset('images/empty-box.png')}}" alt="" class="img-fluid">
                            <h4 class="mt-3">No Order Placed By You</h4>
                            <p>Cart is empty. Please go to your home page for listing it.</p>
                        </div>
                    @endif
                   
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
