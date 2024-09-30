@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Booked Event Tickets'))
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{asset('f-css/ion.rangeSlider.min.css')}}">
@endpush
<style>
    .hidden{
        display: none;
    }
    .disabled{
        background: rgb(174, 174, 174) !important;
        color: #000000;
        border: 1px solid rgb(174, 174, 174) !important;
    }
</style>

@isset($bookDetails)
    @php $booking = json_decode($bookDetails); @endphp
@endisset

<section class="book-slot-detail">
    <div class="book-sbody border-bottom">
        <div class="container">
            <h5 class="slot-title mb-1">@isset($event->name) {{$event->name}} @endisset</h5>
            <p class="mb-1 "><i class="fas fa-map-marker-alt"></i> @isset($event->temple_name ) {{$event->temple_name }} @endisset @isset($event->address ) {{$event->address }}, @endisset @isset($event->city_name ){{ $event->city_name }} @endisset</p>
            <span class="text-success mb-2 mr-2"><i class="fas fa-ticket-alt"></i> @isset($booking) {{$booking->seatcheck}} @endisset  Tickets</span>
            <span class="text-success  mb-2 mr-2"><i class="far fa-calendar-alt"></i> @isset($booking) {{$booking->date_radio}} @endisset</span>
            <span class="text-success  mb-2"><i class="far fa-clock"></i> @isset($booking) {{$booking->time_radio}} @endisset</span>
            @isset($booking)  <input type="hidden" id="totalSeats" value="{{$booking->seatcheck}}">  @endisset  
           
        </div>
    </div>
</section>
<section class="seatlayout_area">
    <div class="container">
       <div class="seatcontainer">
            <form action="" method="POST" id="bookSeat">
                @csrf
                <div class="text-center">
                    <img src="{{asset('images/screen2.png')}}" alt="" class="img-fluid w-50 mb-3 mx-auto">
                </div>
                @php  $x = 0; @endphp
                @foreach ($ticket as $item)
                    {{-- @if ($item->ticket_type == 1) --}}
                    <div class="seatrow {{$item->ticket_type == 1 ? "first_row" : ($item->ticket_type == 2 ? "second_row" : ($item->ticket_type == 3 ? "third_row" : ""))}}">
                        <h6>{{$item->name}}:  
                        @if ($item->discount_type == "FLAT")
                        ₹{{$item->price - $item->discount_amount }}
                        @else
                        ₹{{($item->price) - ($item->discount_amount * $item->price)/100 }}
                        @endif
                    </h6>
                        @php 
                        $rows = json_decode($item->ticket_row);
                        $aplhabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                        @endphp
                        @for ($i = 0; $i < count($rows) ; $i++)
                            <div class="d-flex justify-content-center">
                                <span class="rowtitle">{{$aplhabet[$x]}}</span>
                                <ul class="radio-pannel list-unstyled">
                                    @for ($j = 1; $j <= $rows[$i] ; $j++)
                                    <li>
                                        <label class="radio-label" for="a{{$item->ticket_type}}seatcheckbox{{$i}}{{$j}}">
                                        <input type="checkbox" name="seatChecked[]" value='["{{$aplhabet[$x]}}",{{$j}},{{$item->id}}]' data-id="{{$item->id}}" id="a{{$item->ticket_type}}seatcheckbox{{$i}}{{$j}}" 
                                        @foreach ($item->childOrder as $orderTicketed)
                                            @if ($orderTicketed->ticket_date == $timeDate && $orderTicketed->ticket_slot == $timeSlot )
                                                {{$aplhabet[$x].$j == $orderTicketed->prasada_address ? "disabled" : ""}}    
                                            @endif
                                        @endforeach >
                                        <span class="
                                        @foreach ($item->childOrder as $orderTicketed)
                                            @if ($orderTicketed->ticket_date == $timeDate && $orderTicketed->ticket_slot == $timeSlot )
                                                {{$aplhabet[$x].$j == $orderTicketed->prasada_address ? 'disabled' : ''}}
                                            @endif
                                        @endforeach 
                                        ">{{$j}}</span>
                                        </label>
                                    </li>
                                    @endfor
                                </ul>
                                <span></span>
                            </div>
                            @php $x = $x+1; @endphp
                        @endfor
                    </div>
                    <div class="walking-area">
                            <span>Walking Area</span>
                    </div>
                @endforeach
                <div class="text-center mt-3">
                    <button type="submit" id="continueSeat" class="btn btn-primary w-100 hidden">Continue to Book Show <i class="fas fa-hand-point-right"></i></button>
                </div>
            </form>
       </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
    $checkRow = true;
    $(document).ready(function(){
        $(document).on('click','input[type="checkbox"]',function(e){
            // alert($('input:checked').length);
            $allowedSeat  = $('#totalSeats').val();
          
            // $j = 0;
            // for (let $i = 1; $i < $allowedSeat; $i++) {
            //     if($(":checkbox").eq($index+$i).attr('disabled') == true){
            //         $(":checkbox").eq($index+$i).prop("checked", false)
            //         $j = $j++;
            //     }else{
            //         $(":checkbox").eq($index+$i+$j).prop("checked", true);
            //     }
            // }

            if($('input:checked').length > $allowedSeat){
                $('input:checked').prop("checked", false);
                $(this).prop("checked", true);
                $index = $('input[type="checkbox"]').index(this);
            }

            if($('input:checked').length != $allowedSeat){
                $('#continueSeat').hide();
            }else{
                $('#continueSeat').show();
            }
        })
    })

    $(document).ready(function(){
        $(document).on('click','#continueSeat',function(e){
            $allowedSeat  = $('#totalSeats').val();
            if($('input:checked').length != $allowedSeat){
                e.preventDefault();
                alert('Please Select The Seats');
            }
            $('#bookSeat').submit();
        })
    })
</script>
@endpush