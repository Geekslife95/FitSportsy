@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Coach Book'))
@push('styles')
<style>
    /* Overall Dark Theme */
    .text-muted {
        color: #888 !important;
    }

    .dark-gap {
        margin-right: 1.5rem;
    }

    /* Custom positioning for overlay content in dark theme */
    .dark-absolute {
        position: absolute;
        top: 15px;
        left: 20px;
        right: 16px;
    }

    @media (min-width: 768px) {
        .dark-absolute {
            top: 60px;
            left: 130px;
            right: 8px;
        }
    }

    @media (min-width: 992px) {
        .dark-absolute {
            top: 80px;
            left: 140px;
            right: 16px;
        }
    }

    /* Intensity Bar */
    .dark-intensity-bar {
        display: flex;
        width: 100%;
        max-width: 24rem;
        height: 0.5rem;
        background-color: #333;
        border-radius: 9999px;
        gap: 4px;
    }

    .dark-bar-section {
        flex: 1;
        height: 100%;
    }

    .rounded-left {
        border-top-left-radius: 9999px;
        border-bottom-left-radius: 9999px;
    }

    .rounded-right {
        border-top-right-radius: 9999px;
        border-bottom-right-radius: 9999px;
    }

    /* Custom Progress Bar */
    .dark-progress {
        display: flex;
        width: 100%;
        max-width: 100%;
        height: 8px;
        background-color: #444;
        border-radius: 9999px;
    }

    .dark-progress-bar {
        height: 100%;
    }

    .dark-progress-bar:first-child {
        width: 15%;
    }

    .dark-progress-bar:nth-child(2) {
        width: 20%;
    }

    .dark-progress-bar:nth-child(3) {
        width: 50%;
    }

    .dark-progress-bar:last-child {
        width: 15%;
    }

    /* Utility Classes */


    .dark-coach-image {
        width: 100px;
        height: 120px;
    }

    .dark-icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .border-dark-theme {
        border-color: #444 !important;
    }

    .bg-dark-theme {
        background-color: #1a1b2e;
        border-radius: 10px;
    }

    /* Responsive Design Enhancements */


    .single-detail-area h2,
    .single-detail-area h3,
    .single-detail-area h4 {
        font-weight: bold;
        color: #e0e0e0;
    }

    .single-detail-area p {
        font-size: 1rem;
        line-height: 1.6;
        color: #b0b0b0;
    }

    @media (min-width: 768px) {
        .single-detail-area p {
            font-size: 1.125rem;
        }

        .dark-gap {
            margin-right: 2rem;
        }
    }

    /* Card layout for available sports */
    .available-sports {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 20px;
    }

    .available-sport-card {
        padding: 10px 15px;
        border: 1px solid #444;
        border-radius: 8px;
        width: auto;
        text-align: center;
        color: #fff;
        white-space: nowrap
    }

    .available-sport-card span {
        font-size: 1.5rem;
    }

    /* Buttons */
    .btn-dark-theme {
        background-color: #444;
        color: #fff;
        border: 1px solid #555;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
    }

    .btn-dark-theme:hover {
        background-color: #555;
        border-color: #666;
    }

    /* Dark Progress Section */
    .progress-section {
        margin-top: 20px;
    }

    .dark-progress-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .progress-label {
        color: #b0b0b0;
    }

    .dark-progress-bar-wrapper {
        flex-grow: 1;
    }

    /* Icon Box for Sessions */
    .dark-icon-box {
        background-color: #444;
        width: 32px;
        height: 12px;
        border-radius: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #e0e0e0;
    }

    .dark-session-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #36384a;
    }

    /* Coaches Hover Effects */
    .coach-card {
        padding: 15px;
        height: 100%;
    }


    .coach-image {
        width: 100px;
        height: 100px;
        transition: transform 0.3s ease;
    }

    .coach-details {
        margin-top: 10px;
    }

    @media (max-width: 576px) {


        .coach-image {
            width: 80px;
            height: 80px;
        }
    }
</style>
    
        
    
    <style>
        .btn-success, .default-btn {  
            animation: glowing 800ms infinite;
        }

        @keyframes  glowing {
        0% {  box-shadow: 0 0 3px #fff; }
        50% {  box-shadow: 0 0 8px #fff; }
        100% {  box-shadow: 0 0 3px #fff; }
        }

    </style>
@endpush
@section('content')
<section class="section-area single-detail-area py-3">
    <div class="container">
        <div class="slider eventbannerslider mb-4">
            <div class="position-relative mx-auto">
                <img src="{{ asset('uploads/'.$coachData->description_image) }}" alt="{{ $coachData->category->category_name }} Coaching" class="img-fluid">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8 col-12">
                <h2 >{{ $coachData->coaching_title }}</h2>
                <div class="d-flex flex-column flex-md-row dark-gap font-weight-bold h5 mb-4">
                    <p class="dark-gap">Sport name: {{ $coachData->category->category_name }}</p>
                    <div class="d-flex">
                        <p class="mr-3">👨‍👩‍👧‍👦 Age group: {{ $coachData->age_group }}</p>
                        <p>🏸 BYOE: {{ $coachData->bring_own_equipment }}</p>
                    </div>
                </div>
        
                <div class="d-flex flex-column flex-md-row font-weight-bold h5">
                    <p class="mr-4">📍 Venue: {{ $coachData->venue_name.', '.$coachData->venue_area.', '.$coachData->venue_address.', '.$coachData->venue_city }}</p>
                    <p>🎟️ Free Demo session: {{ $coachData->free_demo_session }}</p>
                </div>
                @if($coachData->sports_available != null)
                    <h4>Available Sports</h4>
                    <div class="available-sports">
                        @foreach (json_decode($coachData->sports_available) as $sport)
                            <div class="available-sport-card">
                                <img src="{{ Common::SportsSvgArr(str_replace(" ","_",$sport)) }}" alt="" width="36" height="36">
                                <p class="mb-0" style="font-size:14px; ">{{ $sport }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                    
                @php
                    $sessionDurationData = json_decode($coachData->session_duration, true);
                @endphp
                <!-- Intensity and Calories Section -->
                <div class="mt-4 mb-3">
                    <h5>{{ $coachData->category->category_name }}</h5>
                    <div class="d-flex flex-row align-items-start w-100">
                        <div class="mr-4">
                            <span class="text-muted">CALORIES</span>
                            <div>
                                <span>🔥</span>
                                <span class="ml-2 font-weight-bold">{{ $sessionDurationData['calories'] }}</span>
                            </div>
                        </div>
                        <div class="w-100">
                            <span class="text-muted">INTENSITY</span>
                            <div class="dark-intensity-bar mt-2">
                                <div class="dark-bar-section rounded-left" style="background:{!! Common::intensityColors($sessionDurationData['intensity']) !!};"></div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="mb-3">
                    <h5 class="">Benefits</h5>
                    <p class="text-muted">{{ implode("| ",$sessionDurationData['benefits']) }}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="event-ticket card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="single-ticket">
                            <a href="" class="btn default-btn w-100">Continue To Book Workshops</a>
                        </div>
                    </div>
                </div>
        
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="products-reviews">
                            <h3>Reviews</h3>
                            <div class="rating">
                                <h4 class="h3">4.5</h4>
                                <div>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star"></span>
                                </div>
                                <div>
                                    <p class="mb-0">501 review</p>
                                </div>
                            </div>
                            <div class="rating-count">
                                <span>Total review count and overall rating based on Visitor and Tripadvisior reviews</span>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>5 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-5"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>02</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>4 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-4"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>03</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>3 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-3"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>04</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>2 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-2"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>05</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>1 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-1"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       



        

        <!-- Progress Section -->
        <div class="progress-section mb-4 mt-4">
            <h4>Overview {{ $coachData->category->category_name }} Session</h4>
            <div class="dark-progress-container mb-3">
                <div class="progress-label">Begin</div>
                <div class="dark-progress-bar-wrapper">
                    <div class="dark-progress">
                        @php
                            $activityDurationD = $sessionDurationData['activities'];
                            $lastKey = array_key_last($activityDurationD);
                        @endphp
                        @foreach ($activityDurationD as $key => $activity)
                            @php
                                $perc = ceil(($activity['activity_duration'] / $sessionDurationData['session_duration']) * 100)
                            @endphp
                            <div class="dark-progress-bar {{ $key==0 ? 'rounded-left' : ($key == $lastKey ? 'rounded-right' : '')}}" style="background:{!! Common::sessionColors($key) !!};width:{{ $perc }}%;"></div>
                        @endforeach
                    </div>
                </div>
                <div class="progress-label">{{ $sessionDurationData['session_duration'] }} Min</div>
            </div>

            <!-- Session Breakdown -->
            <div class=" p-3 bg-dark-theme mb-3">
                @foreach ($activityDurationD as $k => $act)
                <div class="dark-session-item mb-3">
                    <div class="dark-icon-box" style="background: {!! Common::sessionColors($k) !!};"></div>
                    <div class="ml-3 d-flex flex-grow-1 justify-content-start">
                        <span>{{ $act['activity_duration'] }} Mins</span>
                        <span class="text-muted ml-5">{{ $act['activity'] }}</span>
                    </div>
                </div>
                @endforeach
                
            </div>

            <p class="h5">
                {!! $coachData->description !!}
            </p>

            @if($coachData->ameneties != null)
                <!-- Amenities Section -->
                <div class="mt-5">
                    <h4 class="font-weight-bold h5 mb-3">Amenities</h4>
                    <div class="d-flex">
                        @foreach (json_decode($coachData->ameneties) as $ameniti)
                            <div class="text-center p-3 border border-dark rounded mr-2">
                                <img src="{{ Common::amenitiesSvgArr(str_replace(" ","_",$ameniti)) }}" alt="Badminton"
                                    style="width: 32px; height: 32px;">
                            </div>
                        @endforeach
                    </div>

                </div>
            @endif

            <div class="mt-4">
                <h4 class="font-weight-bold h5 mb-3">Best in Class Coaches</h4>
                <hr>
                <div class="row">
                    <!-- Coach Card 1 -->
                    @foreach(json_decode($coachData->coaches_info) as $coach)
                        <div class="col-xl-2  col-lg-3 col-md-6 col-6 mb-4">
                            <div class="card bg-dark-theme border-dark-theme coach-card">
                                <div class="text-center">
                                    <img src="{{ asset("uploads/".$coach->image) }}" alt="{{ $coach->name }}"
                                        class="coach-image img-fluid rounded-circle">
                                </div>
                                <div class="coach-details text-center">
                                    <h5 class="text-white">{{ $coach->name }}</h5>
                                    <p class="text-muted">{{ $coach->experience }} </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    

                    

                </div>

            </div>


        </div>
    </div>
</section>
@endsection
@include('alert-messages')