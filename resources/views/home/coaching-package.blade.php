@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Coach Book'))
@push('styles')
    
<style>
    /* Dark Theme Styling */
    .subscription-section {
        background: #070b28;
        color: #ffffff;
        padding: 60px 0;
    }

    .subscription-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #1a1b2e;
        color: #ffffff;
        border-radius: 10px;
        padding: 25px;
        transition: transform 0.2s, background 0.3s;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
    }

    .subscription-card:hover {
        transform: translateY(-4px);
        background: #1b1b37;
    }

    .subscription-card-header {
        font-size: 1.5rem;
        font-weight: bold;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        text-align: left;
    }

    .subscription-card-body {
        /* padding: 20px 0; */
    }

    .subscription-card-title {
        font-size: 2rem;
        margin: 10px 0;
        text-align: left;
        margin-top:0px;
        margin-bottom:2px;
    }

    .price-text-muted {
        color: #b0b0b0;
        font-size: 0.9rem;
    }

    .button-primary, .button-success, .button-premium {
        display: inline-block;
        padding: 12px 25px;
        width: 100%;  /* Full width button */
        color: #ffffff;
        font-size: 1rem;
        text-align: center;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s, transform 0.2s;
        margin-top: 20px;
    }

    .button-primary {
        background: linear-gradient(90deg, #db207b, #e74c3c);
    }

    .button-primary:hover {
        background: linear-gradient(90deg, #e74c3c, #db207b);
        transform: translateY(-2px);
        color: #fff;
    }

    .button-success {
        background: linear-gradient(90deg, #28a745, #34d058);
    }

    .button-success:hover {
        background: linear-gradient(90deg, #34d058, #28a745);
        transform: translateY(-2px);
        color: #fff;

    }

    .button-premium {
        background: linear-gradient(90deg, #f39c12, #e67e22);
    }

    .button-premium:hover {
        background: linear-gradient(90deg, #e67e22, #f39c12);
        transform: translateY(-2px);
        color: #fff;

    }

    .discount-badge {
        background-color: #ff9800;
        color: #121212;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .price-list {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    .price-list li {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }

    .price-list li i {
        color: #28a745;
        margin-right: 8px;
    }



    @media (min-width: 768px) {
        .subscription-card {
            height: 100%;
        }
    }
</style>
@endpush
@section('content')
<section class="section-area single-detail-area py-3">
    <div class="container">
        <section class="subscription-section">
            <div class="container">
                <h2>{{$coachData->coaching_title.' ('. $coachData->category->category_name .')'}} Packages</h2>
                <div class="row">
                    <!-- Basic Plan -->
                    @foreach ($packageData as $package)
                        @php
                            $realPrice = $package->package_price;
                            $afterDiscountPrice = 0;
                            $showDiscount = 0;
                            if($package->discount_percent > 0 && $package->discount_percent <= 100){
                                $perc = ($realPrice * $package->discount_percent) / 100;
                                $afterDiscountPrice = round($realPrice - $perc, 2);
                                $showDiscount = 1;
                            }
                            $type = explode(" ",$package->package_duration);
                            $type = $type[0].' '.trim($type[1],'s');
                        @endphp
                        <div class="col-md-4 d-flex mb-4">
                            <div class="subscription-card flex-grow-1 d-flex flex-column position-relative">
                                <div class="subscription-card-header" style="background-color: #007bff;">
                                    <h4><i class="fas fa-gem" style="font-size: 1rem;"></i> {{ $package->package_name }}</h4>
                                    @if($showDiscount)
                                        <span class="discount-badge">{{ $package->discount_percent }}% Off</span>
                                    @endif
                                </div>
                                <div class="subscription-card-body">
                                    @if($showDiscount)
                                        <h3 class="subscription-card-title">₹{{ $afterDiscountPrice }} <small class="price-text-muted">/ {{$type}}</small></h3>
                                        <p><small class="price-text-muted">Normally ₹{{ $realPrice + 0 }} / {{$type}}</small></p>
                                    @else
                                        <h3 class="subscription-card-title">₹{{$realPrice + 0}} <small class="price-text-muted">/ {{$type}}</small></h3>
                                    @endif
                                    

                                    <ul class="price-list">
                                        <li><i class="fas fa-check"></i> Batch Size -  {{ $package->batch_size }}</li>
                                        <li><i class="fas fa-check"></i> <div>{!! $package->description !!}</div></li>
                                        {{-- <li><i class="fas fa-check"></i> Session Days - {{ implode(", ", json_decode($package->session_days, true)) }}</li> --}}
                                        {{-- <li><i class="fas fa-check"></i> {!! $package->description !!}</li> --}}
                                    </ul>
                                    @php
                                           $inputObj = new stdClass();
                                           $inputObj->params = 'id='.$package->id;
                                           $inputObj->url = url('book-coaching-package');
                                           $encLink = Common::encryptLink($inputObj);
                                    @endphp
                                    <a href="{{$encLink}}" class="button-primary">Book Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
@include('alert-messages')