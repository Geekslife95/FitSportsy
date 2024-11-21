@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Home'))
@section('content')
<div class="pt-3 pb-3 shadow-sm home-slider">
    <div class="osahan-slider">
      
    </div>
</div>
<div class="container my-5">
    <div class="hawan_section">
        <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
            <h1 class="h4 mb-0 float-left">Coachings In {{$cityName}}</h1>
        </div>
        <div class="row list-bp">
            @forelse ($coachingData as $coaching)
                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                    <div class="card m-card shadow-sm border-0 listcard">
                        <div>
                            <div class="m-card-cover">
                                <img src="{{asset('uploads/'.$coaching->poster_image)}}" class="card-img-top" alt="{{$coaching->coaching_title}}">
                            </div>
                            <div class="card-body">
                                <div class="rating-star mb-1">
                                    {!!Common::randomRatings()!!}
                                </div>
                                <h5 class="card-title mb-2"><u>{{$coaching->coaching_title}}</u></h5>
                                <p class="card-text mb-0">
                                    <small class="text-dark" title="{{ $coaching->venue_name }}"><i class="fas fa-map-marker-alt pr-2"></i>
                                    {{ strlen($coaching->venue_name) > 50 ? substr($coaching->venue_name, 0, 50) . '...' : $coaching->venue_name }}
                                    </small>
                                </p>
    
                                @php
                                    // $sessionDays = isset($coaching->coachingPackage->session_days) ? json_decode($coaching->coachingPackage->session_days, true) : [];
                                @endphp
                                <p class="my-1 text-light"><small> {{ $coaching->venue_area.', '.$coaching->venue_address.', '.$coaching->venue_city }}</small></p>
    
                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                {!!Common::showDiscountLabel($coaching->coachingPackage->package_price, $coaching->coachingPackage->discount_percent )!!}  
                                
                                    <a href="{{url('coaching-book/'.$coaching->id.'/'.Str::slug($coaching->coaching_title))}}" class="mt-1 btn btn-success btn-sm mb-1 ">Book Now</a>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-xl-12 text-center">
                    <div class="card m-card shadow-sm border-0 listcard py-5">
                        <h3>NO COACHING ...</h3>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    
</div>

@endsection
