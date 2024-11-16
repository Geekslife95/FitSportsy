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
                    <p class="mb-1"><span>Coaching Name </span>: {{$orderData->coachingPackage->coaching->coaching_title}}</p>
                    <p class="mb-1"><span>Venue </span>: {{$orderData->coachingPackage->coaching->venue_name}}</p>
                    <p class="mb-1"><span>Actual Amount </span>: ₹{{$orderData->actual_amount + 0}}</p>
                    <p class="mb-1"><span>Amount Paid </span>: ₹{{$orderData->paid_amount + 0}}</p>
                    <p class="mb-1"><span>Package </span>: {{ $orderData->coachingPackage->package_name }}</p>
                   
                    <p class="mb-1"><span>Payment </span>: Paid Online</p>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-5 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>Address</p>
                            </div>
                            <div class="invoice-body">
                                <p><i class="fas fa-map-marker-alt pr-2"></i> {{$orderData->coachingPackage->coaching->venue_area}}, {{$orderData->coachingPackage->coaching->venue_address}}, {{$orderData->coachingPackage->coaching->venue_city}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>Session</p>
                            </div>
                            <div class="invoice-body ">
                                <p class="mb-1">{!! $orderData->coachingPackage->description !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>QR Code</p>
                            </div>
                            <div class="invoice-body text-center p-1">
                                {!! QrCode::size(170)->generate($orderData->booking_id) !!}
                                <span class="avalable-tickets ">{{$orderData->booking_id}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="invoice-slot">
                            <div class="invoice-header">
                                <p>Organizer Name</p>
                            </div>
                            <div class="invoice-body">
                                <p><i class="fas fa-user pr-2"></i> {{$userData->first_name.' '.$userData->last_name}}</p>
                            </div>
                        </div>
                    </div>
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