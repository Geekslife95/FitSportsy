@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Privacy Policy'))
@section('content')
<section class="policy-area section-area">
    <div class="container">
        <div class="row justify-content-center">
           
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow-sm rounded border-0">
                    <div class="card-body policy-content">
                        <h1 class="h3">Cancellation and Refund Policy for BookMyAdventureQuest</h1>
                        <hr>
                        <h4>Cancellation Policy:</h4>
                        <br>
                        <h5>1. Cancellations by Customers:</h5>
                        <ul>
                            <li>Customers can cancel their adventure quest booking by logging into their account or contacting our customer support team.</li>
                            <li>Cancellation requests made more than 3 days before the scheduled adventure will receive a full refund.</li>
                            <li>Cancellation requests made between 2 and 3 days before the scheduled adventure will be eligible for a partial refund (a percentage of the booking amount).</li>
                           <li>Cancellation requests made within 1 day of the scheduled adventure are not eligible for a refund.</li>
                        </ul>
                        <h5>2. Cancellations due to Unforeseen Circumstances:</h5>
                        <ul>
                            <li>In cases where an adventure quest cannot proceed due to factors beyond the control of the customer (e.g., weather-related issues, safety concerns), we will provide a full refund or reschedule the adventure.</li>
                        </ul>
                        <h4>Refund Policy:</h4>
                        <br>
                        <h5>1. Refund Processing:</h5>
                        <ul>
                            <li> Refunds for eligible cancellations will be processed within 7 business days from the date of the cancellation request.</li>
                            <li> Refunds will be issued using the same payment method used for the original booking.</li>
                        </ul>
                        <h5>2. Non-Refundable Fees:</h5>
                      
                        <ul>
                            <li> Any non-refundable fees (e.g., booking fees, permit fees) will be clearly stated during the booking process.</li>

                        </ul>
                        <h5>3. Refund for Partial Cancellations:</h5>
                      
                        <ul>
                            <li> For group bookings or multi-day adventures, the refund amount for partial cancellations will be adjusted based on the number of participants or remaining days of the adventure.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection