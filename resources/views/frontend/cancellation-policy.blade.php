@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Terms & Conditions'))
@section('content')
<section class="policy-area section-area">
    <div class="container">
        <div class="row justify-content-center">
           
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow-sm rounded border-0">
                    <div class="card-body policy-content">
                        <h1 class="h3">Cancellation and Refund Policy for Supershows</h1>
                        <hr>
                        <h4>Cancellation Policy:</h4>
                        <br>
                        <h5>1. Cancellations by Customers:</h5>
                        <ul>
                            <li>Customers can cancel their events service booking by contacting our customer support team or through their online account.</li>
                            <li>Cancellation requests made more than 48 hours before the scheduled events will receive a full refund.</li>
                            <li>Cancellation requests made between 24 and 48 hours before the scheduled events will be eligible for a partial refund up to 70% of the booking amount.</li>
                           <li>Cancellation requests made less than 24 hours before the scheduled events are not eligible for a refund.</li>
                        </ul>
                        <h5>2. Cancellations due to Unforeseen Circumstances:</h5>
                        <ul>
                            <li>In cases where the events cannot be conducted due to unforeseen circumstances (e.g., natural disasters, pandemics, venue unavailability), we will provide a full refund or reschedule the events at the customer's convenience.</li>
                        </ul>
                        <h4>Refund Policy:</h4>
                        <br>
                        <h5>1. Refund Processing:</h5>
                        <ul>
                            <li> Refunds for eligible cancellations will be processed within 5 to 7 business days from the date of the cancellation request.</li>
                            <li> Refunds will be issued using the same payment method used for the original booking.</li>
                        </ul>
                        <h5>2. Non-Refundable Fees:</h5>
                      
                        <ul>
                            <li>Any non-refundable fees (e.g., administrative fees) will be clearly stated during the booking process.</li>

                        </ul>
                        <h5>3. Refund for Partial Cancellations:</h5>
                      
                        <ul>
                            <li> For partial cancellations of multi-events bookings, the refund amount will be adjusted accordingly.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection