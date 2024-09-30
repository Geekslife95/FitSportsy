@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Home'))
@section('content')
<div class="pt-3 pb-3 shadow-sm home-slider">
    <div class="osahan-slider">
        @foreach ($banner as $item)
        <div class="osahan-slider-item"><a @if($item->redirect_link != null) href="{{$item->redirect_link}}" @endisset ><img
                    src="{{asset('images/upload/'.$item->image)}}" class="img-fluid rounded" alt="..."></a></div>
        @endforeach

    </div>
</div>
<div class="container mt-5">
    @foreach ($category as $item)
    @if(count($item->events))
    @if($item->banner_image!=null)
    <div class="row my-5">
        <div class="col-lg-12">
            <a class="small_banner"  @if($item->redirect_link != null) href="{{$item->redirect_link}}" @endisset target="_blank">
                <img src="{{asset('images/upload/'.$item->banner_image)}}" alt="" class="img-fluid">
            </a>
        </div>
    </div>
    @endif

    <div class="hawan_section">
        <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
            <h1 class="h4 mb-0 float-left">{{$item->name}}</h1>
            <a href="{{url('all-events?category='.$item->id)}}" class="d-sm-inline-block text-xs float-right "> Explore All ({{count($item->events)}}) </a>
        </div>
        <div class="event-block-slider">
            @foreach ($item->events as $val)
            
          
            <div class="card m-card shadow-sm border-0 listcard">
                <div>
                    <div class="m-card-cover">
                        <img src="{{asset('images/upload/'.$val->image)}}" class="card-img-top" alt="{{$val->name}}">
                    </div>
                    <div class="card-body">
                        @php
                        $num = rand(3,5);
                        @endphp
                        <div class="rating-star mb-1">
                                @for($i=1;$i<=5;$i++) <small><i class="fas fa-star {{$i<=$num ? 'active':''}}"></i></small>
                                @endfor
                                <span class="text-dark"> ({{$num}}) Ratings</span>
                        </div>
                        <h5 class="card-title mb-2"><u>{{$val->name}}</u></h5>
                          <p class="card-text mb-0">
                            <small class="text-dark" title="{{ $val->temple_name }}"><i class="fas fa-map-marker-alt pr-2"></i>
                              {{ strlen($val->temple_name) > 50 ? substr($val->temple_name, 0, 50) . '...' : $val->temple_name }}
                            </small>
                          </p>

                          @if ($val->event_type == "Recurring")
                            @php
                                $days = explode(',', $val->recurring_days);
                                $slotTime =  explode(',', $val->slot_time);
                                $currentDaySlot = array_search(date('l'), $days);
                            @endphp
                            <p class="my-1 text-light"><small><i class="fas fa-calendar-alt pr-2"></i> {{$currentDaySlot}}</small></p>
                          @else
                            <p class="my-1 text-light"><small style="font-size: 12px !important;"><i class="fas fa-calendar-alt pr-2"></i> {{date('F d | H:i A',strtotime($val->start_time))}} - {{date('F d | H:i A',strtotime($val->end_time))}}</small></p>
                          @endif

                         

                          <span class="text-warning">{{$val->event_cat}}</span>
                         <div class="mt-2 d-flex justify-content-between align-items-center">
                            @if ($val->discount_amount > 0)
                            {{-- <p class="font-weight-bold h6 text-dark mb-0">
                                 
                            </p> --}}
                            @endif 
                            <p class=" h6 text-dark mb-1">
                                <small>
                                    <del class="mr-1 text-muted "> 
                                        ₹{{$val->price}}
                                    </del>
                                </small>
                                <span class="font-weight-bold pr-2">
                                    @if ($val->discount_type == "FLAT")
                                    ₹{{($val->price) - ($val->discount_amount) }}
                                    @elseif($val->discount_type == "DISCOUNT")
                                    ₹{{($val->price) - ($val->price * $val->discount_amount)/100 }}
                                    @else
                                    ₹{{$val->price}}
                                    @endif
                                </span>
                                @if ($val->discount_amount > 0)
                                <small class="text-danger">
                                    @if ($val->discount_type == "FLAT")
                                    {{$val->discount_type}} ₹{{$val->discount_amount}} OFF
                                    @endif 
                                    @if ($val->discount_type == "DISCOUNT")
                                    {{$val->discount_amount}}% OFF
                                    @endif     
                                </small>
                                @endif     
                            </p>
                            <a href="{{url('event/'.$val->id.'/'.Str::slug($val->name))}}" class="mt-1 btn btn-success btn-sm mb-1 ">Book {{$item->name}}</a>
                        </div>
                    
                    </div>
                </div>
            </div>

            {{-- <div class="card m-card shadow-sm border-0">
                <a href="{{url('event/'.$val->id.'/'.Str::slug($val->name))}}">
                    <div class="m-card-cover">
                        <img src="{{asset('images/upload/'.$val->image)}}" class="card-img-top" alt="{{$val->name}}">
                    </div>
                    <div class="card-body p-3">
                        <h5 class="card-title mb-1 text-dark">{{$val->name}}</h5>
                        <p class="card-text mb-0"><small class="text-dark">{{$val->temple_name}}</small></p>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="font-weight-bold h6 text-dark">
                                <span>
                                    @if ($val->discount_type == "FLAT")
                                    ₹{{($val->price) - ($val->discount_amount) }}
                                    @elseif($val->discount_type == "DISCOUNT")
                                    ₹{{($val->price) - ($val->price * $val->discount_amount)/100 }}
                                    @else
                                    ₹{{$val->price}}
                                    @endif
                                </span>
                                <del class="mr-1 text-muted">
                                    @if ($val->discount_type != null)
                                    ₹{{$val->price}}
                                    @endif                                   
                                </del>
                            </small>
                            <small class="text-danger">
                                @if ($val->discount_type == "FLAT")
                                {{$val->discount_type}} ₹{{$val->discount_amount}} OFF
                                @endif 
                                @if ($val->discount_type == "DISCOUNT")
                                {{$val->discount_amount}}% OFF
                                @endif 
                            </small>
                            
                        </div>
                            @php
                            $num = rand(3,5);
                            @endphp

                            <div class="rating-star">
                                @for($i=1;$i<=5;$i++) <small><i class="fas fa-star {{$i<=$num ? 'active':''}}"></i></small>
                                    @endfor
                                    ({{$num}})
                            </div>

                    </div>
                </a>
            </div> --}}
            @endforeach
        </div>
    </div>

    @endif

    @endforeach

    <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
        <h1 class="h4 mb-0 float-left">Categories</h1>
        {{-- <a href="" class="d-sm-inline-block text-xs float-right">View All <i class="fas fa-eye fa-sm"></i></a> --}}
    </div>

    <div class="all-category mb-5">
        @foreach ($category as $cat)
        <div class="category-card">
            <a href="{{url('all-events?category='.$cat->id)}}">
                <img src="{{asset('images/upload/'.$cat->image)}}" class="category-img" alt="...">
                <div class="cat-content">
                    <p class="cat-title text-truncate">{{$cat->name}}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    @if(count($products))
    <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-3 overflow-hidden">
        <h1 class="h4 mb-0 float-left">Spiritual Products</h1>
        <a href="{{url('all-products')}}" class="d-sm-inline-block text-xs float-right"><i class="fas fa-eye fa-sm"></i>
            View All </a>
    </div>
    <div class="product-slider mb-5">
        @foreach ($products as $item)
        <div class="px-2">
            <div class="single-products-card">
                <div class="products-image">
                    <a href="{{url('product/'.$item->product_slug)}}"><img
                            src="{{asset('images/upload/'.$item->image)}}" class="img-fluid" alt="image"></a>
                </div>
                <div class="products-content">
                    <p>
                        <a
                            href="{{url('product/'.$item->product_slug)}}">{{ucwords(strtolower($item->product_name))}}</a>
                    </p>
                    <div class="d-flex justify-content-between mb-1">
                        <span>₹{{$item->product_price}}</span>
                        <div class="rating-star">
                            @for($i=1;$i<=5;$i++) @if($i<=$item->rating)
                                <i class="fas fa-star active"></i>
                                @else
                                <i class="fas fa-star"></i>
                                @endif
                                @endfor
                        </div>
                    </div>
                    <div class="add-to-cart-btn">
                        @if($item->quantity > 0)
                        <a href="javascript:void(0)" data-url="{{url('buy-product/'.$item->product_slug)}}"
                            class="btn btn-danger btn-block add_to_cart">Add To Cart</a>
                        @else
                        <a href="javscript:void(0)" class="btn btn-danger btn-block disabled">Out Of Stock</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    @endif

    @if(count($blog))
    <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-3 overflow-hidden">
        <h1 class="h4 mb-0 float-left">Blogs</h1>
        <a href="{{url('all-blogs')}}" class="d-sm-inline-block text-xs float-right">View All <i
                class="fas fa-eye fa-sm"></i></a>
    </div>
    <div class="row pb-4 mb-2">
        @foreach ($blog as $bgl)
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="blog-card shadow-sm">
                <div class="row align-items-center no-gutters">
                    <div class="col-lg-4">
                        <div class="blog-image">
                            <a href="{{ url('/blog-detail/' . $bgl->id . '/' . Str::slug($bgl->title)) }}"><img
                                    src="{{asset('images/upload/'.$bgl->image)}}" alt="image" class="img-fluid"></a>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="blog-content">
                            <div class="date"><span><i class="far fa-calendar-alt"></i>
                                    {{ Carbon\Carbon::parse($bgl->created_at)->format('d M Y') }}</span>
                            </div>
                            <h3>
                                <a
                                    href="{{ url('/blog-detail/' . $bgl->id . '/' . Str::slug($bgl->title)) }}">{{ $bgl->title }}</a>
                            </h3>
                            <p>{!! Str::substr(strip_tags($bgl->description), 0, 150).'...' !!}</p>
                            <div class="text-right">
                                <a href="{{ url('/blog-detail/' . $bgl->id . '/' . Str::slug($bgl->title)) }}"
                                    class="blog-btn btn btn-sm btn-outline-danger">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
{{-- model start --}}

@if ($popup != null)
<div class="modal fade" id="Location" tabindex="-1" aria-labelledby="LocationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-1" id="model_body">
            <button type="button" class="btn-close" id="cancel_edit"><i class="fas fa-times"></i></button>
            <a href="{{$popup->img_url}}" class="text-decoration-none">
                <img class="img-fluid" src="/upload/popup/{{$popup->image}}" alt="">
            </a>
        </div>
      </div>
    </div>
  </div>
@endif


{{-- Model End --}}
@include('alert-messages')
@endsection
@push('scripts')
<script type="text/javascript">
    $(window).on('load', function() {
        $('#Location').modal('show');
    });

    $("#cancel_edit").click(function(){
        $('#Location').modal('hide');
    });
</script>
@endpush