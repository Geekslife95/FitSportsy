@extends('frontend.master', ['activePage' => 'My Tickets'])
@section('title', __('My Tickets'))
@section('content')
<section class="profile-area section-area" style="min-height: 65vh;">
    <div class="container list-bp">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                    <div >
                        <div class="mb-3 overflow-hidden">
                            <h1 class="h4 mb-0 float-left">My Tickets</h1>
                        </div>
                        <hr>
                        <div class="row">
                            @forelse ($ticketData as $val)
                                @php
                                    $inputObj = new stdClass();
                                    $inputObj->url = url('booked-coaching-package-details');
                                    $inputObj->params = 'package_booking_id='.$val->id;
                                    $encLink = Common::encryptLink($inputObj);
                                @endphp
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card m-card shadow-sm border-0">
                                        <a href="{{$encLink}}">
                                            <div class="m-card-cover">
                                                <img src="{{asset('uploads/'.$val->coachingPackage->coaching->poster_image)}}" class="card-img-top" alt="...">
                                            </div>
                                            <div class="card-body p-3">
                                                <h5 class="card-title text-white mb-1">{{$val->coachingPackage->coaching->coaching_title}}</h5>
                                                <p class="card-text"><small class="text-white">{{$val->coachingPackage->coaching->venue_name}}</small> <small class="text-danger ml-2"><i class="fas fa-calendar-alt fa-sm"></i> ₹{{$val->actual_amount}}</small> </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-xl-12 col-md-12 mb-4">
                                    <h4 class="text-center text-danger">No Ticket Booked Yet!</h4>
                                </div>
                            @endforelse

                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$ticketData->appends(request()->input())->links('paginate')}}
                                </div>
                            </div>
                            

                        </div>
                        {{-- paginate --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
