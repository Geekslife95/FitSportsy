@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Coach Booking'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Coach Listing</h4>
                    <a href="{{url('user/coach-book')}}" class="btn btn-primary">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr class="">
                                    <th>Coaching Title</th>
                                    <th>Venue Name</th>
                                    <th>Image</th>
                                    <th>Area</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($coachData as $coach)
                                    <tr>
                                        <td>{{$coach->coaching_title}}</td>
                                        <td>{{$coach->venue_name}}</td>
                                        <td><img style="object-fit: cover;height:40px;width:40px;" src="{{asset('uploads/'.$coach->poster_image)}}" alt=""></td>
                                        <td>{{$coach->venue_area}}</td>
                                        <td>{{$coach->venue_city}}</td>
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
                    <div class="mt-4">
                        {{$coachData->links('paginate')}}
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection