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
                    <h4 class="card-title">Coach Session Bookings</h4>
                    {{-- <a href="{{url('user/coach-book')}}" class="btn btn-primary">Add New</a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr class="">
                                    <th>Booking ID</th>
                                    <th>Package Name</th>
                                    <th>Coaching</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Payment Type</th>
                                    <th>Transaction ID</th>
                                    <th>Paid Amount</th>
                                    <th>Expiry Date</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($bookingData as $booking)
                                    <tr>
                                        <td>{{$booking->booking_id}}</td>
                                        <td>{{$booking->package_name}}</td>
                                        <td>{{$booking->coaching_title}}</td>
                                        <td>{{$booking->full_name}}</td>
                                        <td>{{$booking->email}}</td>
                                        <td>{{$booking->mobile_number}}</td>
                                        <td>{{$booking->payment_type == 2 ? 'Pay At Venue' : 'Paid Online'}}</td>
                                        <td>{{$booking->transaction_id}}</td>
                                        <td>₹{{$booking->paid_amount}}</td>
                                        <td>{{date("d M Y",strtotime($booking->expiry_date))}}</td>
                                        <td>{{date("d M Y H:i A",strtotime($booking->created_at))}}</td>
                                        <td>
                                            <div class="d-flex">
                                                @php
                                                    $inputObj = new stdClass();
                                                    $inputObj->params = 'booking_id='.$booking->id;
                                                    $inputObj->url = url('user/remove-coaching-booking');
                                                    $encLinkD = Common::encryptLink($inputObj);

                                                    $inputObjD = new stdClass();
                                                    $inputObjD->params = 'package_booking_id='.$booking->id;
                                                    $inputObjD->url = url('booked-coaching-package-details');
                                                    $encLink = Common::encryptLink($inputObjD);

                                                @endphp
                                                <a href="{{$encLink}}" target="_blank" class="btn text-white btn-primary package_link" >Print</a>
                                                <a href="javascript:Void(0);" class="btn btn-danger remove_coach_list text-white ml-1" data-link="{{$encLinkD}}"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11"><h5 class="text-center text-danger">NO DATA</h5></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{$bookingData->links('paginate')}}
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>

   

</section>
@endsection