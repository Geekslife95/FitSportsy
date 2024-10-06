@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Court Booking'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Court Listing</h4>
                    <a href="{{url('user/court-booking')}}" class="btn btn-primary">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr class="">
                                    <th>Venue Name</th>
                                    <th>Image</th>
                                    <th>Area</th>
                                    <th>City</th>
                                    <th>Sports Available</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($courtData as $court)
                                    <tr>
                                        <td>{{$court->venue_name}}</td>
                                        <td><img style="object-fit: cover;height:40px;width:40px;" src="{{asset('uploads/'.$court->poster_image)}}" alt=""></td>
                                        <td>{{$court->venue_area}}</td>
                                        <td>{{$court->venue_city}}</td>
                                        <td>{{implode(", ",json_decode($court->sports_available,true))}}</td>
                                        <td></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"><h5 class="text-center text-danger">NO DATA</h5></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection