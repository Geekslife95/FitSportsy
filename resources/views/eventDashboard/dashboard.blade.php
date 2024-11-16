@extends('eventDashboard.master', ['activePage' => 'category'])
@section('title', __('All categories'))
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-12">
                    <h3 class="page-title">Select Event Type</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card text-center  border">
                    <div class="card-body">
                        <img src="{{asset('/images/Court-Booking.png')}}" alt="" style="width:100%;object-fit:contain;" class="mb-3 bg-light" height="250px">
                        <h5 class="text-primary">Coach Management</h5>
                        <p>Explore innovation and connect globally! Join our online event for insightful discussions,
                            expert talks, and networking opportunities. Don't miss out!</p>
                        <a href="{{url('user/coach-book')}}" class="btn btn-primary w-100"><i class="fas fa-plus-circle"></i> Create Now</a>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4 col-md-4 col-12">
                <div class="card text-center  border">
                    <div class="card-body">
                        <img src="{{asset('/images/physical.jpg')}}" alt="" style="width:100%;object-fit:contain;"  class="mb-3 bg-light" height="250px">
                        <h5 class="text-primary">Court Booking</h5>
                        <p>Experience live excitement! Join our physical event for hands-on workshops, engaging talks,
                            and networking. Uncover opportunities and connect in person.</p>
                        <a href="{{url('user/court-booking')}}" class="btn btn-primary w-100"><i class="fas fa-plus-circle"></i>
                            Create Now</a>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-lg-4 col-md-4 col-12">
                <div class="card text-center  border">
                    <div class="card-body">
                        <img src="{{asset('/images/virtual.jpg')}}" alt="" style="width:100%;object-fit:contain;"  class="mb-3 bg-light" height="250px">
                        <h5 class="text-primary">Virtual Event</h5>
                        <p>Dive into a virtual realm of knowledge and networking! Join our online event for insightful
                            discussions, expert talks, and global connections.</p>
                            @php
                                $inputObjB2 = new \stdClass();
                                $inputObjB2->url = url('dashboard-events');
                                $inputObjB2->params = 'event_type=virtual';
                                $subLink2 = Common::encryptLink($inputObjB2);
                            @endphp
                        <a href="{{$subLink2}}" class="btn btn-primary w-100"><i class="fas fa-plus-circle"></i>
                            Create Now</a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection