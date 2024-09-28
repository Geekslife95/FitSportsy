@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Find My Travel Buddy'))
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{asset('f-css/ion.rangeSlider.min.css')}}">
@endpush
<section class="section-area all-event-area">
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between  mb-3 overflow-hidden">
            <h1 class="h3 mb-0 float-left">Find Weekend Traveller</h1>
            <a href="/create-traveller" class="btn btn-dark cstm_btn px-4">Create Weekend Traveller</a>
        </div>
        <div class="row mt-4">
            <div class="col-xl-3 col-lg-4">
                <div class="filters shadow-sm rounded bg-white mb-3">
                    <div class="filters-header border-bottom p-3">
                        <h5 class="m-0 text-dark">Filter By</h5>
                    </div>
                    <form action="/filter-weekend" method="POST">
                        @csrf
                        <div class="filters-body">
                            <div id="accordion">
                                <div class="filters-card border-bottom p-3">
                                    <div class="filters-card-header" id="categoryheading">
                                        <h6 class="mb-0">
                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#categorycollapse" aria-expanded="true" aria-controls="categorycollapse">
                                                Travel Interest
                                                <i class="fas fa-angle-down float-right"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="categorycollapse" class="collapse show" aria-labelledby="headingTwo">
                                        <div class="filters-card-body card-shop-filters">
                                            <div class="radio-pannel d-flex flex-wrap">
                                                <label class="radio-label" for="cat_1">
                                                    <input type="checkbox" value="Nature" name="locationcheckbox[]" id="cat_1" class="categories">
                                                    <span>Nature</span>
                                                </label>
                                                <label class="radio-label" for="cat_2">
                                                    <input type="checkbox" value="City Exploration" name="locationcheckbox[]" id="cat_2" class="categories">
                                                    <span>City Exploration</span>
                                                </label>
                                                <label class="radio-label" for="cat_3">
                                                    <input type="checkbox" value="Relaxation" name="locationcheckbox[]" id="cat_3" class="categories">
                                                    <span>Relaxation</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filters-card border-bottom p-3">
                                    <div class="filters-card-header" id="priceheading">
                                        <h6 class="mb-0">
                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#pricecollapse" aria-expanded="true" aria-controls="pricecollapse">
                                                Budget <i class="fas fa-angle-down float-right"></i>
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
                                    <div class="filters-card-header" id="headinglocation">
                                        <h6 class="mb-0">
                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapselocation" aria-expanded="true" aria-controls="collapselocation">Current Locations<i class="fas fa-angle-down float-right"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="collapselocation" class="collapse show" aria-labelledby="headinglocation">
                                        <div class="filters-card-body card-shop-filters">
                                            <div class="radio-pannel d-flex flex-wrap">
                                                @foreach ($Destinations as $item)
                                                    <label class="radio-label" for="city_{{$item->id}}">
                                                        <input type="checkbox" value="{{$item->location}}" id="city_{{$item->id}}" name="cities[]" >
                                                        <span>{{$item->location}}</span>
                                                    </label>
                                                @endforeach
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-search"></i> Search Filters </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="row list-bp">
                   @if(!$weekends->isEmpty())
                        @foreach ($weekends as $item)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-6">
                            <div class="card buddy-card shadow-sm border-0">
                                <div class="m-card-cover">
                                    <img src="{{asset('/upload/weekend/'.$item->profile_photo)}}" class="card-img-top h-auto" alt="...">
                                </div>
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center  mb-2">
                                        <h5 class="text-white mb-0 text-truncate">{{ucfirst($item->name)}} </h5>
                                        <img src="{{asset('images/verified.png')}}" alt="" width="30">  
                                    </div>
                                    
                                    <div class="d-flex flex-wrap mb-1">
                                        <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Travel Interest"><small><i class="far fa-star"></i> {{$item->travel_interest}}</small> </p>
                                        <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Language Spoken"><small ><i class="fas fa-globe"></i> {{$item->lang}}</small> </p>
                                        <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Prefered Destination"><small ><i class="fas fa-plane-departure"></i> {{$item->prefered_destinations}}</small> </p>
                                        <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Hobbies"><small ><i class="fas fa-trophy"></i> {{$item->hobbies}}</small> </p>
                                        <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Travel Style"><small ><i class="fas fa-suitcase-rolling"></i> {{$item->travel_style}}</small> </p>
                                    </div>
                                    <a href="/weekend-details/{{$item->id}}" class="mt-2 cstm_btn btn btn-outline-light text-white btn-sm btn-block">I'm interested!</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-lg-12 col-md-12">
                            <div class="w-100 mt-3 num_pagination">
                                
                            </div>
                        </div>
                        @else
                    <div class="col-md-12 text-center">
                        <img src="{{asset('images/no-event.jpg')}}" alt="" srcset="" class="img-fluid" width="300">
                        <h4 class="mt-3">Oops! No Weekend Traveller For Now</h4>
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
        min: {{$min == $max ? 0 : $min}},
        max: {{$max}},
        from: "0",
        to: "{{$max}}",
        grid: true
    });
</script>
@endpush