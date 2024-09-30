@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Booked Event Tickets'))
@push('styles')
    <style>
        @media print {
        @page { margin: 0; }
        * {
    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
    color-adjust: exact !important;                 /* Firefox 48 – 96 */
    print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
}
         header,footer,#print_ticket,.bottom-location{
            display: none;
        }
      }
      .invoice-box{
            border: 1px solid #323545;
            box-shadow: none!important;
        }
    </style>
@endpush
@section('content')
<section class="section-area invoice-area">
    <div class="container">
        <div class="card invoice-box shadow-sm">
            <div class="card-header">
                <img src="{{asset("images/upload/".Common::siteGeneralSettings()->logo)}}" alt="" class="img-fluid"  />
            </div>
            <div class="card-body">
                {{-- <h3 class="mb-3 text-center">Puja Seva Ticket - ({{$orderData->ticket->ticket_number}})</h3> --}}
                <hr>
                {{-- @php
                    dd($orderData);
                @endphp --}}
                <div class="mb-4">
                    <p class="mb-1"><span>Event Name </span>: {{$orderData->event->name}}</p>
                    <p class="mb-1"><span>Event Place </span>: {{$orderData->event->temple_name}}</p>
                    <p class="mb-1"><span>No. of Tickets </span>: {{$orderData->quantity}}</p>
                    <p class="mb-1"><span>Amount Paid </span>: ₹{{$orderData->payment+0}}</p>
                    @if ($orderData->book_seats != NULL)
                        <p class="mb-1"><span>Seat Number </span>: 
                        @php
                            $seatNum = json_decode($orderData->book_seats);
                        @endphp
                        @foreach ($seatNum as $item)
                        @if ($loop->last) {{$item}} @else {{$item.','}} @endif
                        @endforeach    
                    </p>
                    @endif
                    <p class="mb-1"><span>Payment </span>: {{$orderData->payment_type=='COD' ? 'Pay At Event Place' : 'Paid Online'}}</p>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-5 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>Event Address</p>
                            </div>
                            <div class="invoice-body">
                                <p><i class="fas fa-map-marker-alt pr-2"></i>{{$orderData->event->temple_name.' ('.$orderData->event->address.', '.$orderData->event->city_name.')'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>Timing</p>
                            </div>
                            <div class="invoice-body ">
                                @if($orderData->event->event_type=='Recurring')
                                    <p class="mb-1"><i class="fas fa-calendar-alt pr-2"></i>{{date("d M Y",strtotime($orderData->ticket_date))}}</p>
                                    <p class="mb-1"><i class="fas fa-clock pr-2"></i>{{$orderData->ticket_slot}}</p>
                                @elseif($orderData->event->event_type=='Particular')
                                    <p class="mb-1"><i class="fas fa-calendar-alt pr-2"></i>{{date("d M Y",strtotime($orderData->event->start_time))}}</p>
                                    <p class="mb-1"><i class="fas fa-clock pr-2"></i>{{date("h:i A",strtotime($orderData->event->start_time))}}</p>
                                @else
                                    <p class="mb-1"><i class="fas fa-clock pr-2"></i>Organizer will confirm the timings</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>QR Code</p>
                            </div>
                            <div class="invoice-body text-center p-1">
                                {!! QrCode::size(170)->generate($orderData->order_id) !!}
                                <span class="avalable-tickets ">{{$orderData->order_id}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>Organizer Name</p>
                            </div>
                            <div class="invoice-body">
                                <p><i class="fas fa-user pr-2"></i> {{ucwords($orderData->organization->name.' '.$orderData->organization->last_name)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <h5 class="mb-3 font-weight-normal">Devotee Details</h5>
                </div>
                <div class="table-responsive  mb-3">
                    <table class="table border small">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Number</th>
                                <th scope="col">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $devoteeData = json_decode($orderData->orderchildC->devotee_persons,true);
                                $cnt=1;
                            @endphp
                                <tr>
                                    <th scope="row"> {{$cnt}}</th>
                                    <td>
                                        {{ucwords($devoteeData['prasada_name'])}} 
                                    </td>
                                    <td>
                                        {{$devoteeData['prasada_email'] ?? '-'}}
                                    </td>
                                    <td>
                                        {{$devoteeData['prasada_mobile'] ?? '-'}}
                                    </td>
                                    <td>
                                        {{$devoteeData['prasada_address'] ?? '-'}}
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                      <button class="btn default-btn" id="print_ticket"><i class="fas fa-print"></i> Print Ticket</button>
                </div>
              
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        $("#print_ticket").click(function () {
            window.print();
        });
    </script>
@endpush