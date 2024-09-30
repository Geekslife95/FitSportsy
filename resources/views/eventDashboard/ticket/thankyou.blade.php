@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- /Page Header -->
        @include('messages')
        <div class="card ">
            <div class="card-body">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 mb-0">
                        <div class="text-center p-3">
                            <img width="350px" class="img-fluid" src="{{asset('images/thank-you.png')}}" alt="" style="    background: #fff;
                            padding: 20px;
                            border-radius: 50%;
                            object-fit: contain;
                            width: 260px;
                            height: 260px;">
                            <h5 class="mt-2 mb-3 fw-bold">"Thank you for choosing our subscription package! We're excited to enhance your experience
                                and provide valuable services. Your support means the world to us!"</h5>
                            <a href="/dashboard" class="btn btn-primary"><i class="fas fa-th-large"></i> Return To Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection