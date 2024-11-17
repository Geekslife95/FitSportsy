@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Privacy Policy'))
@push('styles')
<style>
    
    .policy-content  h1 {
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
@section('content')
<section class="policy-area section-area">
    <div class="container">
        <div class="row justify-content-center">
           
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow-sm rounded border-0">
                    <div class="card-body policy-content">
                        <h1>Privacy Policy</h1>
    <p><strong>Last Updated:</strong> 15-11-2024</p>

    <p>This Privacy Policy describes how FitSportsy, owned and operated by Geeks Life Technology Solutions PVT LTD, collects, uses, discloses, and protects your information when you use our services, including our website and mobile applications (collectively, the “Platform”). By accessing or using FitSportsy, you agree to this Privacy Policy.</p>

    <h2>1. Information We Collect</h2>
    <p>When you use FitSportsy to access sports coaching services or purchase sports products, we collect several types of information to provide and improve our services, including:</p>
    <ul>
        <li><strong>Personal Information:</strong> Information that identifies you, such as your name, email address, phone number, and billing details.</li>
        <li><strong>Account Information:</strong> Information related to your account on FitSportsy, including your username, password, and preferences.</li>
        <li><strong>Activity Data:</strong> Details on your activity within the Platform, such as booking history, purchase history, and interactions with coaching services.</li>
        <li><strong>Location Information:</strong> With your consent, we may collect your location information to help recommend nearby sports facilities or events.</li>
        <li><strong>Device and Usage Information:</strong> Information about your device, including IP address, browser type, operating system, and interactions with the Platform.</li>
    </ul>

    <h2>2. How We Use Your Information</h2>
    <p>We use the information we collect to:</p>
    <ul>
        <li>Provide, personalize, and improve our Platform services, including sports coaching and product recommendations.</li>
        <li>Process bookings, transactions, and payments.</li>
        <li>Communicate with you about your account, transactions, and promotional offers.</li>
        <li>Analyze trends and user activity to improve and develop new features.</li>
        <li>Ensure Platform security and detect and prevent fraud or abuse.</li>
    </ul>

    <h2>3. Sharing Your Information</h2>
    <p>We may share your information in the following circumstances:</p>
    <ul>
        <li><strong>With Service Providers:</strong> We work with third-party providers to perform services on our behalf, such as payment processing, data analytics, and customer support. These providers have access to your information as needed to perform their functions but are not permitted to use it for other purposes.</li>
        <li><strong>With Sports Coaches and Partners:</strong> When you book a coaching session or purchase a product through FitSportsy, we may share necessary details with the coaches or partner organizations involved to facilitate the service.</li>
        <li><strong>Legal and Regulatory Purposes:</strong> We may disclose your information as required by law, such as to comply with a legal process or protect our rights and property.</li>
    </ul>

    <h2>4. Security of Your Information</h2>
    <p>Geeks Life Technology Solutions PVT LTD is committed to protecting your personal information. We employ industry-standard security measures to safeguard your data. However, no method of transmission over the internet or method of electronic storage is 100% secure, and we cannot guarantee absolute security.</p>

    <h2>5. Your Choices and Rights</h2>
    <p>You have choices regarding the information we collect and how it’s used:</p>
    <ul>
        <li><strong>Access and Update:</strong> You may access and update your personal information directly within your account settings.</li>
        <li><strong>Marketing Preferences:</strong> You may opt out of receiving promotional communications from us by following the unsubscribe instructions provided in those emails.</li>
        <li><strong>Data Deletion:</strong> You may request the deletion of your account or data by contacting our support team at <a href="mailto:support@fitsportsy.in">support@fitsportsy.in</a>.</li>
    </ul>

    <h2>6. Children’s Privacy</h2>
    <p>FitSportsy does not knowingly collect personal information from children under the age of 13. If you become aware that a child has provided us with personal information, please contact us, and we will take steps to delete such information.</p>

    <h2>7. Changes to This Privacy Policy</h2>
    <p>We may update this Privacy Policy to reflect changes in our practices or for other operational, legal, or regulatory reasons. We will notify you of any changes by updating the "Last Updated" date at the top of this page. We encourage you to review this Privacy Policy periodically.</p>

    <h2>8. Contact Us</h2>
    <div class="contact-info">
        <p>If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at:</p>
        <p><strong>Geeks Life Technology Solutions PVT LTD</strong><br>
        CV Raman Nagar, Bangalore-56693<br>
        Email: <a href="mailto:support@fitsportsy.in">support@fitsportsy.in</a><br>
        Phone: +91 9686314018</p>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection