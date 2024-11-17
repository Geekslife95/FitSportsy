@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Terms & Conditions'))
@section('content')
@push('styles')
<style>
    
    .policy-content h1 {
        text-align: center;
        color: #fff;
    }
    .policy-content h2 {
        color: #fff;
        margin-top: 20px;
    }
    .policy-content p {
        margin: 10px 0;
    }
    .policy-content ul {
        margin: 10px 0 10px 20px;
    }
    .policy-content .contact-info {
        margin-top: 20px;
    }
</style>
@endpush
<section class="policy-area section-area">
    <div class="container">
        <div class="row justify-content-center">
           
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow-sm rounded border-0">
                    <div class="card-body policy-content">
                        <h1>FitSportsy Refund and Cancellation Policy</h1>

                        <h2>1. General Cancellation Policy</h2>
                        <p>Cancellations on FitSportsy are subject to the specific policy established by each merchant partner (e.g., sports facility, coaching provider). Before making a booking or purchase, you can review the cancellation terms on the merchant’s information page. These policies are also included with your booking ticket in your order history for easy reference.</p>
                    
                        <h2>2. Initiating a Cancellation</h2>
                        <ul>
                            <li><strong>Self-Service Cancellations:</strong> Users can initiate cancellations directly through their booking ticket in the FitSportsy app or website.</li>
                            <li><strong>Displayed Refund Amount:</strong> The refund amount due, if applicable, will be displayed before confirming the cancellation. This allows you to review the amount that will be refunded based on the merchant's cancellation terms.</li>
                        </ul>
                    
                        <h2>3. Refund Process</h2>
                        <ul>
                            <li><strong>Credit to Original Payment Source:</strong> Refunds will be credited back to the original payment method used at the time of booking.</li>
                            <li><strong>Processing Time:</strong> After cancellation is initiated, refunds are typically processed within 5-7 business days.</li>
                        </ul>
                    
                        <h2>4. Coaching-Specific Cancellation and Refund Policy</h2>
                        <p>For sports coaching bookings, cancellations and refunds are governed by the coach’s specific policies. Please review the coach's cancellation policy before booking to understand any potential fees or conditions. Some coaching sessions may not be eligible for refunds if canceled within a certain timeframe.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection