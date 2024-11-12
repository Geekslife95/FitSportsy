@extends('frontend.master', ['activePage' => 'All Sports Products'])
@section('title', __('Home'))
@section('content')
<div class="container mt-5">
   @if(count($products))
        <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-3 overflow-hidden">
            <h1 class="h4 mb-0 float-left">Sports Products</h1>
          
        </div>
        <div class="row mb-5">
            @foreach ($products as $item)
                <div class="px-2 col-md-3">
                    <div class="single-products-card">
                        <div class="products-image">
                            <a href="{{url('product/'.$item->product_slug)}}"><img src="{{asset('images/upload/'.$item->image)}}" class="img-fluid" alt="image"></a>
                        </div>
                        <div class="products-content">
                            <p>
                                <a href="{{url('product/'.$item->product_slug)}}">{{ucwords(strtolower($item->product_name))}}</a>
                            </p>
                            <div class="d-flex justify-content-between mb-1">
                                <span>₹{{$item->product_price}}</span>
                                <div class="rating-star">
                                    @for($i=1;$i<=5;$i++)
                                        @if($i<=$item->rating)
                                            <i class="fas fa-star active"></i>
                                        @else
                                            <i class="fas fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="add-to-cart-btn">
                                @if($item->quantity > 0)
                                    <a href="javascript:void(0)" data-url="{{url('buy-product/'.$item->product_slug)}}" class="btn btn-danger btn-block add_to_cart">Add To Cart</a>
                                @else
                                    <a href="javscript:void(0)" class="btn btn-danger btn-block disabled">Out Of Stock</a>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>    
            @endforeach
            <div class="col-lg-12 col-md-12">
                <div class="w-100 mt-3 num_pagination">
                    {{$products->appends(request()->input())->links('paginate')}}
                </div>
            </div>
        </div>
    @endif
</div>
@include('alert-messages')
@endsection
@push('scripts')


@endpush
