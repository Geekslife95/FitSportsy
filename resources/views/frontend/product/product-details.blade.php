@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Home'))
@section('content')

<section class="products-details-area section-area">
    <div class="container">
        <div class="card p-3 rounded shadow-sm mb-3">
              <div class="row align-items-center">
            <div class="col-lg-4 col-md-12">
                <div class="products-details-image">
                    <a href="javascript:void(0)">
                        <img src="{{asset("images/upload/".$productdata->image)}}" alt="image" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="products-details-desc">
                    <div class="d-flex align-items-center p-3 border bg-light mb-3" style="width: fit-content;">
                        <div class="mr-3">
                           <i class="fas fa-sun fa-3x text-warning"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-md">10% of proceeds from all products sales are used to  bring well-being to people and communities.</p>
                        </div>
                    </div>
                    <h3>{{ucwords(strtolower($productdata->product_name))}}</h3>
                    <div class="price">
                        <span class="new-price">₹{{$productdata->product_price + 0}}</span>
                    </div>
                    <div class="products-meta mb-3">
                        <p>Rating:
                            <span class="in-rating rating-star">
                            @for($i=1;$i<=5;$i++)
                                @if($i<=$productdata->rating)
                                    <i class="fas fa-star active"></i>
                                @else
                                    <i class="fas fa-star"></i>
                                @endif
                            @endfor
                        </span>
                    </p>
                    </div>
                    <div class="products-add-to-cart ">
                        @if($productdata->quantity>0)
                            <a href="{{url('buy-product/'.$productdata->product_slug)}}" class="btn btn-danger"><span><i class="fas fa-external-link-alt"></i>Buy Now</span></a>
                            <a href="javascript:void(0)" data-url="{{url('buy-product/'.$productdata->product_slug)}}" class="btn btn-dark add_to_cart"><span><i class="fas fa-cart-plus"></i>Add to Cart</span></a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-danger disabled"><span>Out Of Stock</span></a>
                        @endif
                    </div>
                
                <div class="bg-light mt-3">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-3 col-6 text-center py-3">
                            <img src="{{asset('images/shipping.png')}}" alt="" class="img-fluid mb-1" width="50">
                            <p class="mb-0">Free Shipping</p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 text-center py-3">
                            <img src="{{asset('images/24hours.png')}}" alt="" class="img-fluid mb-1" width="50">
                            <p class="mb-0">Fast Dispatches</p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 text-center py-3">
                            <img src="{{asset('images/securepayment.png')}}" alt="" class="img-fluid mb-1" width="50">
                            <p class="mb-0">Secure Payments</p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 text-center py-3">
                            <img src="{{asset('images/holistics.png')}}" alt="" class="img-fluid mb-1" width="50">
                            <p class="mb-0">Holistic Well-being</p>
                        </div>
                    </div>
                </div>
            </div>
                




            </div>
        </div>
        </div>
        
       <div class="card p-3 rounded shadow-sm">
           <h4>Description</h4>
           <hr>
           {!!$productdata->description!!}
       </div>
    </div>
</section>
@include('alert-messages')
@endsection