@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Booked Event Tickets'))
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('f-css/ion.rangeSlider.min.css')}}">
@endpush
<style>
    .hidden {
        display: none;
    }
</style>

@isset($bookDetails)
@php $booking = json_decode($bookDetails); @endphp
@endisset

<section class="book-slot-detail">
    <div class="book-sbody border-bottom">
        <div class="container">
            <h5 class="slot-title mb-1">@isset($event->name) {{$event->name}} @endisset</h5>
            <p class="mb-1 "><i class="fas fa-map-marker-alt"></i> @isset($event->temple_name ) {{$event->temple_name }}
                @endisset @isset($event->address ) {{$event->address }}, @endisset @isset($event->city_name
                ){{ $event->city_name }} @endisset</p>
            <span class="text-success mb-2 mr-2"><i class="fas fa-ticket-alt"></i> @isset($booking)
                {{$booking->seatcheck}} @endisset Tickets</span>
            <span class="text-success  mb-2 mr-2"><i class="far fa-calendar-alt"></i> @isset($booking)
                {{$booking->date_radio}} @endisset</span>
            <span class="text-success  mb-2"><i class="far fa-clock"></i> @isset($booking) {{$booking->time_radio}}
                @endisset</span>
            @isset($booking) <input type="hidden" id="totalSeats" value="{{$booking->seatcheck}}"> @endisset

        </div>
    </div>
</section>
<section class="seatlayout_area">
    <div class="container">
        <div class="">
            <div class="row">
                @foreach ($ticket as $item)
                <div class="col-lg-4">
                    <form action="" method="POST" id="bookSeat">
                        @csrf
                        <div class="event-ticket card shadow-sm mb-3">
                            <div class="card-body">
                                <div class="single-ticket">
                                    <span class="badge badge-pill badge-success">Buy Now</span>
                                    <p class="my-2 ticket-tile">{{$item->name}}</p>
                                    <h5 class="price">
                                        @if ($item->discount_amount > 0)
                                        <del class="pl-1 pr-2 text-muted fs-4 text-danger"> ₹{{$item->price}}</del>@endif<span>
                                            @php
                                            $totalAmnt = $item->price;
                                            if($item->discount_type == "FLAT"){
                                            $totalAmnt = ($item->price) - ($item->discount_amount);
                                            }elseif($item->discount_type == "DISCOUNT"){
                                            $totalAmnt = ($item->price) - ($item->price *
                                            $item->discount_amount)/100;
                                            }
                                            @endphp
                                            ₹{{$totalAmnt}}
                                        </span>
                                    </h5>
                                    <span class="avalable-tickets ">
                                        @if($event->event_type == 'Particular')
                                        <b class="text-success  d-block">{{(($item->total_orders_sum_quantity!=null) && ($item->quantity - $item->total_orders_sum_quantity > 0)) ? ($item->quantity - $item->total_orders_sum_quantity) : $item->quantity}}
                                            Ticket Available</b>
                                        @else
                                        <b class="text-success  d-block">{{$item->quantity}} Ticket Available</b>
                                        @endif
                                    </span>
                                    <div class="ticket-description">
                                        <p>{{$item->description}}</p>
                                        <input type="hidden" class="ticketId" name="ticketId" value="{{$item->id}}">
                                    </div>
                                    <button type="submit" class="btn default-btn w-100">Buy Ticket Now</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
@endpush