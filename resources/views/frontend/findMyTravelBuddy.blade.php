@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Find My Travel Buddy'))
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{asset('f-css/ion.rangeSlider.min.css')}}">
@endpush
<section class="section-area all-event-area">
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between  mb-3 overflow-hidden">
            <h1 class="h3 mb-0 float-left">Find Spiritual Volunteers</h1>
            <a href="/create-spiritual-volunteers" class="cstm_btn btn btn-dark px-4">Create Spiritual Volunteers</a>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="filters shadow-sm rounded bg-white mb-3">
                    <div class="filters-header border-bottom p-3">
                        <h5 class="m-0 text-dark">Filter By</h5>
                    </div>
                    <form action="/filter-spiritual-volunteers" method="POST">
                        @csrf
                        <div class="filters-body">
                            <div id="accordion">
                                <div class="filters-card border-bottom p-3">
                                    <div class="filters-card-header" id="categoryheading">
                                        <h6 class="mb-0">
                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#categorycollapse" aria-expanded="true" aria-controls="categorycollapse">
                                                Areas of Interest
                                                <i class="fas fa-angle-down float-right"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="categorycollapse" class="collapse show" aria-labelledby="headingTwo">
                                        <div class="filters-card-body card-shop-filters">
                                            <div class="radio-pannel d-flex flex-wrap">
                                                <label class="radio-label" for="cat_1">
                                                    <input type="checkbox" value="Event Coordination" name="locationcheckbox[]" id="cat_1" class="categories">
                                                    <span>Event Coordination</span>
                                                </label>
                                                <label class="radio-label" for="cat_2">
                                                    <input type="checkbox" value="Teaching and Education" name="locationcheckbox[]" id="cat_2" class="categories">
                                                    <span>Teaching and Education</span>
                                                </label>
                                                <label class="radio-label" for="cat_3">
                                                    <input type="checkbox" value="Community Outreach" name="locationcheckbox[]" id="cat_3" class="categories">
                                                    <span>Community Outreach</span>
                                                </label>
                                                <label class="radio-label" for="cat_4">
                                                    <input type="checkbox" value="Administrative Support" name="locationcheckbox[]" id="cat_4" class="categories">
                                                    <span>Administrative Support</span>
                                                </label>
                                                <label class="radio-label" for="cat_5">
                                                    <input type="checkbox" value="Rituals and Ceremonies" name="locationcheckbox[]" id="cat_5" class="categories">
                                                    <span>Rituals and Ceremonies</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filters-card border-bottom p-3">
                                    <div class="filters-card-header" id="categoryheading2">
                                        <h6 class="mb-0">
                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#categorycollapse2" aria-expanded="true" aria-controls="categorycollapse2">
                                                Preferred Spiritual Tradition
                                                <i class="fas fa-angle-down float-right"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="categorycollapse2" class="collapse show" aria-labelledby="headingTwo">
                                        <div class="filters-card-body card-shop-filters">
                                            <div class="radio-pannel d-flex flex-wrap">
                                                <label class="radio-label" for="tradition_1">
                                                    <input type="checkbox" value="Hinduism" name="spritualTradition[]" id="tradition_1" class="categories">
                                                    <span>Hinduism</span>
                                                </label>
                                                <label class="radio-label" for="tradition_2">
                                                    <input type="checkbox" value="Buddhism" name="spritualTradition[]" id="tradition_2" class="categories">
                                                    <span>Buddhism</span>
                                                </label>
                                                <label class="radio-label" for="tradition_3">
                                                    <input type="checkbox" value="Christianity" name="spritualTradition[]" id="tradition_3" class="categories">
                                                    <span>Christianity</span>
                                                </label>
                                                <label class="radio-label" for="tradition_4">
                                                    <input type="checkbox" value="Islam" name="spritualTradition[]" id="tradition_4" class="categories">
                                                    <span>Islam</span>
                                                </label>
                                                <label class="radio-label" for="tradition_5">
                                                    <input type="checkbox" value="Sikhism" name="spritualTradition[]" id="tradition_5" class="categories">
                                                    <span>Sikhism</span>
                                                </label>
                                                <label class="radio-label" for="tradition_6">
                                                    <input type="checkbox" value="Jainism" name="spritualTradition[]" id="tradition_6" class="categories">
                                                    <span>Jainism</span>
                                                </label>
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
                   @if(!$buddys->isEmpty())
                        @foreach ($buddys as $item)

                            <div class="col-xl-3 mb-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-6">
                                <div class="card buddy-card shadow-sm border-0">
                                    <div class="m-card-cover">
                                        <img src="{{asset('/upload/buddy/'.$item->profile_photo)}}" class="card-img-top h-auto" alt="...">
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center  mb-2">
                                            <h6 class="text-white mb-0 text-truncate">{{ucfirst($item->name)}} </h6>
                                            <img src="{{asset('images/verified.png')}}" alt="" width="30">  
                                        </div>
                                    
                                       
                                        <div class="d-flex flex-wrap mb-1">
                                            <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Travel Interest"><small style="font-size:9px;"><i class="far fa-star"></i> {{$item->travel_interests}}</small> </p>
                                            <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Language Spoken"><small style="font-size:9px;" ><i class="fas fa-globe"></i> {{$item->lang}}</small> </p>
                                            <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Travel Preference"><small style="font-size:9px;" ><i class="fas fa-plane-departure"></i> {{$item->travel_preference}}</small> </p>
                                            <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Hobbies"><small style="font-size:9px;" ><i class="fas fa-trophy"></i> {{$item->hobbies}}</small> </p>
                                            <p class="card-text mb-1 mx-1 bg-dark text-white rounded-pill px-2" title="Travel Style"><small style="font-size:9px;" ><i class="fas fa-suitcase-rolling"></i> {{$item->travel_style}}</small> </p>
                                        </div>
                                        <a href="/spiritual-volunteers-details/{{$item->id}}" class="mt-2 cstm_btn btn btn-outline-light text-white btn-sm btn-block">I'm interested!</a>
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
                        <h4 class="mt-3">Oops! No Travel Buddy For Now</h4>
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
@endpush