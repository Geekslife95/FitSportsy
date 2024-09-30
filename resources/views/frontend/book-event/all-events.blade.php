@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Booked Event Tickets'))
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{asset('f-css/ion.rangeSlider.min.css')}}">
@endpush
<section class="section-area all-event-area">
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between  mb-3 overflow-hidden">
            <h1 class="h3 mb-0 float-left">Events</h1>
            @if($filtered==1)
            <a href="{{url('all-events')}}" class="float-right d-sm-inline-block btn btn-sm btn-primary shadow-sm-sm">Reset Filters <i class="fas fa-times fa-sm text-white-50"></i></a>
            @endif
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="filters shadow-sm rounded mb-3">
                    <div class="filters-header border-bottom p-3">
                        <h5 class="m-0 text-light">Filter By</h5>
                    </div>
                    <div class="filters-body">
                        <div id="accordion">

                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="categoryheading">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#organisationcollapse" aria-expanded="true" aria-controls="organisationcollapse">
                                            Events
                                            <i class="fas fa-angle-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="organisationcollapse" class="collapse show" aria-labelledby="headingTwo" >
                                    <div class="filters-card-body card-shop-filters">
                                        <div class="form-group">
                                            <input type="text" id="organisation_name" class="form-control" value="{{$searchStr}}" placeholder="seach events">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="categoryheading">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#categorycollapse" aria-expanded="true" aria-controls="categorycollapse">
                                            Category
                                            <i class="fas fa-angle-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="categorycollapse" class="collapse show" aria-labelledby="headingTwo" >
                                    {{-- <div class="filters-card-body card-shop-filters">
                                        @foreach (Common::allEventCategories() as $cat)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" value="{{$cat->id}}" class="custom-control-input categories" id="cat_{{$cat->id}}" {{in_array($cat->id,$catArr) ? 'checked':''}}>
                                                <label class="custom-control-label" for="cat_{{$cat->id}}">{{$cat->name}}</label>
                                            </div>
                                        @endforeach
                                    </div> --}}

                                    <div class="filters-card-body card-shop-filters">
                                        <div class="radio-pannel d-flex flex-wrap">
                                            @foreach (Common::allEventCategories() as $cat)
                                            <label class="radio-label" for="cat_{{$cat->id}}">
                                                <input type="checkbox" value="{{$cat->id}}" name="locationcheckbox" id="cat_{{$cat->id}}" class="categories" {{in_array($cat->id,$catArr) ? 'checked':''}}/>
                                                <span>{{$cat->name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="priceheading">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#pricecollapse" aria-expanded="true" aria-controls="pricecollapse">
                                            Price <i class="fas fa-angle-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="pricecollapse" class="collapse show" aria-labelledby="headingOne" >
                                    <div class="filters-card-body card-shop-filters">
                                        <div class="form-group">
                                            <input type="text" class="js-range-slider" name="my_range" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="typelocation">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#typelocationcollapse" aria-expanded="true" aria-controls="typelocationcollapse">
                                            Type <i class="fas fa-angle-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="typelocationcollapse" class="collapse show" aria-labelledby="typelocation" >
                                    <div class="filters-card-body card-shop-filters">
                                <div class="radio-pannel d-flex flex-wrap">
                                    <label class="radio-label pr-2" for="offline_type">
                                        <input type="checkbox" value="Offline" id="offline_type" class="type" {{in_array('Offline',$typeArr) ? 'checked':''}}/>
                                        <span>Offline</span>
                                    </label>
                                    <label class="radio-label" for="online_type">
                                        <input type="checkbox" value="Online" id="online_type" class="type" {{in_array('Online',$typeArr) ? 'checked':''}}/>
                                        <span>Online</span>
                                    </label>
                                   
                                </div>
                                </div>
                                </div>
                            </div>
                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="headinglocation">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapselocation" aria-expanded="true" aria-controls="collapselocation">
                                           Location <i class="fas fa-angle-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapselocation" class="collapse show" aria-labelledby="headinglocation" >
                                    <div class="filters-card-body card-shop-filters">
                                        {{-- @foreach ($cities as $item)
                                             <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input cities" id="city_{{$item->id}}" value="{{$item->id}}" {{in_array($item->id,$cityArr) ? 'checked':''}}>
                                                <label class="custom-control-label" for="city_{{$item->id}}">{{$item->city_name}} </label>
                                            </div>
                                        @endforeach --}}

                                        <div class="radio-pannel d-flex flex-wrap">
                                            @foreach ($cities as $item)
                                            <label class="radio-label" for="city_{{$item->id}}">
                                                <input type="checkbox" value="{{$item->id}}" id="city_{{$item->id}}" class="cities" {{in_array($item->id,$cityArr) || in_array($item->city_name,$cityArr) ? 'checked':''}}/>
                                                <span>{{$item->city_name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <button class="btn btn-primary btn-block" id="search_event_btn"><i class="fas fa-search"></i> Search Filters </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="row list-bp">

                    
                   
                   @if($events->total() > 0)
                        @foreach ($events as $item)
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                            <div class="card m-card shadow-sm border-0 listcard">
                                <div>
                                    <div class="m-card-cover">
                                        <img src="{{asset('images/upload/'.$item->image)}}" class="card-img-top" alt="{{$item->name}}">
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
                                        <h5 class="card-title mb-2"><u>{{$item->name}}</u></h5>
                                          <p class="card-text mb-0">
                                            <small class="text-dark" title="{{ $item->temple_name }}"><i class="fas fa-map-marker-alt pr-2"></i>
                                              {{ strlen($item->temple_name) > 50 ? substr($item->temple_name, 0, 50) . '...' : $item->temple_name }}
                                            </small>
                                          </p>
                
                                          @if ($item->event_type == "Recurring")
                                            @php
                                                $days = explode(',', $item->recurring_days);
                                                $slotTime =  explode(',', $item->slot_time);
                                                $currentDaySlot = array_search(date('l'), $days);
                                            @endphp
                                            <p class="my-1 text-light"><small><i class="fas fa-calendar-alt pr-2"></i> {{$currentDaySlot}}</small></p>
                                          @else
                                            <p class="my-1 text-light"><small style="font-size: 12px !important;"><i class="fas fa-calendar-alt pr-2"></i> {{date('F d | H:i A',strtotime($item->start_time))}} - {{date('F d | H:i A',strtotime($item->end_time))}}</small></p>
                                          @endif
                
                                         
                
                                          <span class="text-warning">{{$item->event_cat}}</span>
                                         <div class="mt-2 d-flex justify-content-between align-items-center">
                                            @if ($item->discount_amount > 0)
                                            {{-- <p class="font-weight-bold h6 text-dark mb-0">
                                                 
                                            </p> --}}
                                            @endif 
                                            <p class=" h6 text-dark mb-1">
                                                <small>
                                                    <del class="mr-1 text-muted "> 
                                                        ₹{{$item->price}}
                                                    </del>
                                                </small>
                                                <span class="font-weight-bold pr-2">
                                                    @if ($item->discount_type == "FLAT")
                                                    ₹{{($item->price) - ($item->discount_amount) }}
                                                    @elseif($item->discount_type == "DISCOUNT")
                                                    ₹{{($item->price) - ($item->price * $item->discount_amount)/100 }}
                                                    @else
                                                    ₹{{$item->price}}
                                                    @endif
                                                </span>
                                                @if ($item->discount_amount > 0)
                                                <small class="text-danger">
                                                    @if ($item->discount_type == "FLAT")
                                                    {{$item->discount_type}} ₹{{$item->discount_amount}} OFF
                                                    @endif 
                                                    @if ($item->discount_type == "DISCOUNT")
                                                    {{$item->discount_amount}}% OFF
                                                    @endif     
                                                </small>
                                                @endif     
                                            </p>
                                            <a href="{{url('event/'.$item->id.'/'.Str::slug($item->name))}}" class="mt-1 btn btn-success btn-sm mb-1 ">Book {{$item->category->name}}</a>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>




                            {{-- <div class="card m-card shadow-sm border-0 listcard">
                                <div>
                                    <div class="m-card-cover">
                                        <img src="{{asset('images/upload/'.$item->image)}}" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        @php
                                        $num = rand(3,5);
                                        @endphp
                                        <div class="rating-star mb-1">
                                                @for($i=1;$i<=5;$i++) <small><i class="fas fa-star {{$i<=$num ? 'active':''}}"></i></small>
                                                @endfor
                                                <span class="text-light"> ({{$num}}) Ratings</span>
                                        </div>
                                        <h5 class="card-title mb-0">{{$item->name}}</h5>
                                         <p class="card-text mb-0"><small class="text-light">{{$item->temple_name}}</small></p>
                                         <div class="mt-2">
                                            <p class="font-weight-bold h6 text-light mb-0">
                                                 <small>
                                                    <del class="mr-1 text-muted "> 
                                                        @if ($item->discount_amount > 0)
                                                        ₹{{$item->price}}
                                                        @endif    
                                                    </del>
                                                </small>
                                            </p>
                                            <p class=" h6 text-light mb-1">
                                                <span class="font-weight-bold pr-2">
                                                    @if ($item->discount_type == "FLAT")
                                                    ₹{{($item->price) - ($item->discount_amount) }}
                                                    @elseif($item->discount_type == "DISCOUNT")
                                                    ₹{{($item->price) - ($item->price * $item->discount_amount)/100 }}
                                                    @else
                                                    ₹{{$item->price}}
                                                    @endif
                                                </span>
                                                @if ($item->discount_amount > 0)
                                                <small class="text-danger">
                                                    @if ($item->discount_type == "FLAT")
                                                    {{$item->discount_type}} ₹{{$item->discount_amount}} OFF
                                                    @endif 
                                                    @if ($item->discount_type == "DISCOUNT")
                                                    {{$item->discount_amount}}% OFF
                                                    @endif 
                                                </small>
                                                @endif 
                                            </p>
                                            <a href="{{url('event/'.$item->id.'/'.Str::slug($item->name))}}" class="btn btn-success btn-sm w-100">Book {{$item->category->name}}</a>
                                         
                                           
                                        </div>
                                    
                                    </div>
                                </div>
                            </div> --}}
                            
                           
                        </div>
                        @endforeach
                        <div class="col-lg-12 col-md-12">
                            <div class="w-100 mt-3 num_pagination">
                                {{$events->appends(request()->input())->links('paginate')}}
                            </div>
                        </div>
                    @else
                    <div class="col-md-12 text-center">
                        <img src="{{asset('images/no-event.jpg')}}" alt="" srcset="" class="img-fluid" width="300">
                        <h4 class="mt-3">Oops! No Events For Now</h4>
                        <p>Watch this space for upcoming events.</p>
                    </div>
                       
                    @endif


                </div>
                
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{asset('f-js/ion.rangeSlider.min.js')}}" type="text/javascript"></script>
<script>
    $("#search_event_btn").on('click',function(){
        $(this).attr('disabled','disabled').text('Processing...');
        var categories = 'all';
        var cities = 'all';
        var type = 'all';
        var arr = [];
        var locationArr = [];
        var typeArr = [];
        var org_name = 'all';
        if($('.categories:checked').length > 0){
            $('.categories:checked').each(function(){
                arr.push($(this).val());
            })
            categories = arr.join(",");
        }
       
        if($('.cities:checked').length > 0){
            $('.cities:checked').each(function(){
                locationArr.push($(this).val());
            })
            cities = locationArr.join(",");
        }
       
        if($('.type:checked').length > 0){
            $('.type:checked').each(function(){
                typeArr.push($(this).val());
            })
            type = typeArr.join(",");
        }
        if($("#organisation_name").val()!=''){
            org_name = $("#organisation_name").val();
        }

        var a = $(".js-range-slider").data("ionRangeSlider");
        var price = a.result.from+'-'+a.result.to;
        window.location.href = '{{url("all-events")}}?category='+categories+'&city='+cities+'&price='+price+'&type='+type+'&s='+org_name
    })
</script>
<script>
      $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 2000,
        from: "{{$from}}",
        to: "{{$to}}",
        grid: true
    });
</script>
@endpush