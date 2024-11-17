
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
    .contact-info {
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
                        <h1>Terms and Conditions of Use</h1>
                        <p><strong>Last Updated:</strong> 15-11-2024</p>
                    
                        <p>Welcome to FitSportsy, operated by Geeks Life Technology Solutions PVT LTD. By accessing or using FitSportsy (the “Platform”), you agree to be bound by these Terms of Service (“Terms”). If you do not agree to these Terms, you may not use the Platform.</p>
                    
                        <h2>1. Platform Overview</h2>
                        <p>FitSportsy provides users access to sports coaching services and sports products (collectively, the “Services”). The Platform enables users to browse, book, and participate in various sports activities and purchase products through partner facilities and coaches.</p>
                    
                        <h2>2. Eligibility</h2>
                        <p>To use FitSportsy, you must be at least 18 years of age or, if under 18, have permission from a parent or guardian. By using the Platform, you confirm that you meet these eligibility requirements.</p>
                    
                        <h2>3. Account Registration and Security</h2>
                        <ul>
                            <li><strong>Account Creation:</strong> To access certain features of FitSportsy, you may need to create an account, providing accurate and complete information. You are responsible for maintaining the confidentiality of your account details.</li>
                            <li><strong>Account Usage:</strong> You agree not to share your account or password with others and to notify FitSportsy of any unauthorized use.</li>
                            <li><strong>Account Termination:</strong> FitSportsy reserves the right to suspend or terminate your account for any violation of these Terms.</li>
                        </ul>
                    
                        <h2>4. Use of the Platform</h2>
                        <p>You agree to use FitSportsy solely for lawful purposes and as permitted by these Terms. Prohibited actions include:</p>
                        <ul>
                            <li><strong>Unauthorized Use:</strong> You may not use the Platform in a manner that could interfere with, disrupt, or negatively affect other users’ experience.</li>
                            <li><strong>Intellectual Property:</strong> You may not copy, modify, distribute, sell, or lease any part of the Platform or Services without prior written permission from FitSportsy.</li>
                            <li><strong>Prohibited Activities:</strong> Any attempt to hack, disrupt, or compromise the Platform’s security features is strictly forbidden.</li>
                        </ul>
                    
                        <h2>5. Payments and Fees</h2>
                        <ul>
                            <li><strong>Service Fees:</strong> Charges for bookings, coaching services, or products purchased through the Platform are as specified on FitSportsy. You agree to pay all applicable fees associated with your use of the Platform.</li>
                            <li><strong>Refunds:</strong> Refund policies are available within FitSportsy’s guidelines. Please refer to the refund policy for specific conditions on cancellations and refunds.</li>
                            <li><strong>Third-Party Payment Processing:</strong> Payments may be processed by third-party providers. FitSportsy is not liable for any issues arising from third-party transactions.</li>
                        </ul>
                    
                        <h2>6. Cancellations and Refunds</h2>
                        <p>Users may cancel bookings as per the cancellation policy outlined on the Platform. FitSportsy reserves the right to modify its refund and cancellation policy at any time.</p>
                    
                        <h2>7. Liability and Disclaimer</h2>
                        <ul>
                            <li><strong>Platform Use:</strong> You acknowledge that FitSportsy does not control the quality or safety of services provided by third-party coaches or vendors. FitSportsy makes no guarantees about the availability, suitability, or quality of any services accessed through the Platform.</li>
                            <li><strong>Limitation of Liability:</strong> To the maximum extent permitted by law, FitSportsy, its affiliates, and employees are not liable for any damages arising from your use of the Platform or participation in any services or events organized through FitSportsy.</li>
                            <li><strong>Indemnity:</strong> You agree to indemnify and hold harmless FitSportsy from any claims, losses, liabilities, and expenses arising from your use of the Platform or violation of these Terms.</li>
                        </ul>
                    
                        <h2>8. Intellectual Property</h2>
                        <p>All content on the Platform, including text, graphics, logos, and software, is the property of FitSportsy or its licensors. You may not use or reproduce any intellectual property from FitSportsy without explicit permission.</p>
                    
                        <h2>9. Privacy</h2>
                        <p>Our use of your personal data is governed by the FitSportsy Privacy Policy, which can be found <a href="{{url('/privacy-policy')}}">here</a>.</p>
                    
                        <h2>10. Modifications to the Terms</h2>
                        <p>FitSportsy reserves the right to modify these Terms at any time. Changes will be posted on the Platform, and your continued use of the Platform after changes are made constitutes your acceptance of the revised Terms.</p>
                    
                        <h2>11. Governing Law</h2>
                        <p>These Terms are governed by and construed in accordance with the laws of [jurisdiction]. Any disputes arising from these Terms shall be subject to the exclusive jurisdiction of the courts in [jurisdiction].</p>
                    
                        <h2>12. Contact Us</h2>
                        <p>For questions about these Terms, please contact us at:</p>
                        <p><strong>Geeks Life Technology Solutions PVT LTD</strong><br>
                        CV Raman Nagar, Bangalore-56693<br>
                        Email: <a href="mailto:support@fitsportsy.in">support@fitsportsy.in</a><br>
                        Phone: +91 9686314018</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection