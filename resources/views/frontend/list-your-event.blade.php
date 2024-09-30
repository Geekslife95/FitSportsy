@extends('frontend.master', ['activePage' => 'blog'])
@section('title', __('Our Latest Blog'))
@section('content')
    <section class="section-area list-banner p-1">
        <div class="container-fluid px-0">
            <img src="{{asset('images/list-event1.png')}}" alt="" class="img-fluid w-100" >
        </div>
   </section>
  



   <section class="feature-area section-area">
    <div class="container">
        <div class="event-setup-container">
            <h2 class="list-title">5 Steps</h2>
            <h3 class="list-subtitle">Steps to Ensure Your Event Setup Success</h3>
        </div>
        
        <!-- Step 1 -->
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-12 order-1 order-md-1"> <!-- Image first on all screens -->
                <img src="{{asset('images/step1.png')}}" alt="Step 1" class="feature-icon">
            </div>
            <div class="col-lg-8 col-md-8 col-12 order-2 order-md-2"> <!-- Text second on all screens -->
                <div class="step-number">01</div>
                <h3 class="feature-title">Eventer Signup</h3>
                <p class="feature-description">
                    Set up your Event Organizer account by just entering your mobile number, name, and basic details.
                </p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-8 col-12 order-2 order-md-1"> <!-- Text first on mobile, second on larger screens -->
                <div class="step-number">02</div>
                <h3 class="feature-title">Create an Event</h3>
                <p class="feature-description">
                    Create and list your event in just 10 minutes. Our platform helps you easily sell tickets, host the event, track your progress, and collect payments—all in one place.
                </p>
            </div>
            <div class="col-lg-4 col-md-4 col-12 order-1 order-md-2"> <!-- Image second on mobile, first on larger screens -->
                <img src="{{asset('images/step2.png')}}" alt="Step 2" class="feature-icon">
            </div>
        </div>

        <!-- Step 3 -->
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-12 order-1 order-md-1"> <!-- Image first on all screens -->
                <img src="{{asset('images/step3.png')}}" alt="Step 3" class="feature-icon">
            </div>
            <div class="col-lg-8 col-md-8 col-12 order-2 order-md-2"> <!-- Text second on all screens -->
                <div class="step-number">03</div>
                <h3 class="feature-title">Easy Ticketing Setup</h3>
                <p class="feature-description">
                    Manage attendees and guest lists seamlessly. Our event ticketing system includes automated reminders for ticket buyers.
                </p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-8 col-12 order-2 order-md-1"> <!-- Text first on mobile, second on larger screens -->
                <div class="step-number">04</div>
                <h3 class="feature-title">Wide Reach of Event</h3>
                <p class="feature-description">
                    Your events are automatically listed and reach our network of over 10 million on our platform.
                </p>
            </div>
            <div class="col-lg-4 col-md-4 col-12 order-1 order-md-2"> <!-- Image second on mobile, first on larger screens -->
                <img src="{{asset('images/step4.png')}}" alt="Step 4" class="feature-icon">
            </div>
        </div>

        <!-- Step 5 -->
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-12 order-1 order-md-1"> <!-- Image first on all screens -->
                <img src="{{asset('images/step5.png')}}" alt="Step 5" class="feature-icon">
            </div>
            <div class="col-lg-8 col-md-8 col-12 order-2 order-md-2"> <!-- Text second on all screens -->
                <div class="step-number">05</div>
                <h3 class="feature-title">Monitor the Success of Your Event</h3>
                <p class="feature-description">
                    Get live updates on your event's sales, daily ticket trends, traffic sources, and more in real-time.
                </p>
            </div>
        </div>
    </div>
</section>



<section class="section-area counter-area" style="background-image: url('{{asset('images/counter-events.jpg')}}')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 col-12">
        <div class="counter-item">
          <div class="icon-container">
            <i class="fas fa-ticket-alt"></i>
          </div>
          <span class="count-number" data-count="17">0</span>
          <p class="counter-text">Tickets Sold</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12">
        <div class="counter-item">
          <div class="icon-container">
            <i class="fas fa-laptop"></i>
          </div>
          <span class="count-number" data-count="32">0</span>
          <p class="counter-text">Digital Events</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12">
        <div class="counter-item">
          <div class="icon-container">
            <i class="fas fa-handshake"></i>
          </div>
          <span class="count-number" data-count="100">0</span>
          <p class="counter-text">Events Partnered</p>
        </div>
      </div>
    </div>
  </div>
</section>


  <section class="event-service section-area">
    <div class="container">
      

        <div class="event-setup-container">
          <h2 class="list-title">Features </h2>
          <h3 class="list-subtitle">Explore our key features below</h3>
      </div>

      
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="service-title">Event Planning</h3>
                    <p class="service-description">Comprehensive planning from start to finish for your event, ensuring everything runs smoothly.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="service-title">Venue Selection</h3>
                    <p class="service-description">We help you find the perfect venue that matches your event's style and capacity needs.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="service-title">Catering Services</h3>
                    <p class="service-description">Delicious and customizable menus to satisfy your guests, with attention to detail and quality.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <h3 class="service-title">Entertainment</h3>
                    <p class="service-description">Engaging entertainment options including live music, DJs, and performances for all event sizes.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h3 class="service-title">Photography & Videography</h3>
                    <p class="service-description">Professional photography and videography to capture your event's most important moments.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="service-title">Lighting & Decor</h3>
                    <p class="service-description">Customized lighting and decor to create the perfect ambiance for your event.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="suitable-for-everyone section-area">
  <div class="container">
    <div class="event-setup-container text-center">
      <h2 class="list-title">Features</h2>
      <h3 class="list-subtitle">Explore our key features below</h3>
    </div>

    <div class="row card-grid">
      <!-- Card 1 -->
      <div class="col-lg-3 col-md-6 col-12">
        <div class="info-card">
          <img src="https://content.jdmagicbox.com/comp/jodhpur/y5/0291px291.x291.190625190601.e8y5/catalogue/rise-vision-pratap-nagar-jodhpur-event-organisers-dwjs9sfm1q.jpg?clr=" alt="Event Planning" class="info-image">
          <h3 class="info-title">Event Planning</h3>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-lg-3 col-md-6 col-12">
        <div class="info-card">
          <img src="https://content.jdmagicbox.com/comp/jodhpur/y5/0291px291.x291.190625190601.e8y5/catalogue/rise-vision-pratap-nagar-jodhpur-event-organisers-dwjs9sfm1q.jpg?clr=" alt="Venue Selection" class="info-image">
          <h3 class="info-title">Venue Selection</h3>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-lg-3 col-md-6 col-12">
        <div class="info-card">
          <img src="https://content.jdmagicbox.com/comp/jodhpur/y5/0291px291.x291.190625190601.e8y5/catalogue/rise-vision-pratap-nagar-jodhpur-event-organisers-dwjs9sfm1q.jpg?clr=" alt="Catering Services" class="info-image">
          <h3 class="info-title">Catering Services</h3>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-lg-3 col-md-6 col-12">
        <div class="info-card">
          <img src="https://content.jdmagicbox.com/comp/jodhpur/y5/0291px291.x291.190625190601.e8y5/catalogue/rise-vision-pratap-nagar-jodhpur-event-organisers-dwjs9sfm1q.jpg?clr=" alt="Event Promotion" class="info-image">
          <h3 class="info-title">Event Promotion</h3>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="pricing-section section-area">
  <div class="container">
    <div class="event-setup-container">
      <h2 class="list-title">Our Pricing Plans</h2>
      <h3 class="list-subtitle">Choose a plan that suits your needs</h3>
    </div>

    <div class="row pricing-grid">
      <!-- Basic Plan -->
      <div class="col-lg-4 col-md-6 col-12">
        <div class="pricing-card">
          <h3 class="pricing-title">Basic Plan</h3>
          <div class="pricing-price">
            <span class="currency">$</span>19<span class="duration">/month</span>
          </div>
          <ul class="pricing-features">
            <li>5 Event Listings</li>
            <li>Email Support</li>
            <li>Basic Promotion</li>
            <li>1 Custom Banner</li>
            <li>Access to Free Templates</li>
          </ul>
          <a href="#" class="btn pricing-btn">Choose Plan</a>
        </div>
      </div>

      <!-- Standard Plan -->
      <div class="col-lg-4 col-md-6 col-12">
        <div class="pricing-card popular">
          <h3 class="pricing-title">Standard Plan</h3>
          <div class="pricing-price">
            <span class="currency">$</span>49<span class="duration">/month</span>
          </div>
          <ul class="pricing-features">
            <li>Unlimited Event Listings</li>
            <li>Priority Support</li>
            <li>Advanced Promotion Tools</li>
            <li>5 Custom Banners</li>
            <li>Access to Premium Templates</li>
            <li>Google Analytics Integration</li>
          </ul>
          <a href="#" class="btn pricing-btn">Choose Plan</a>
        </div>
      </div>

      <!-- Premium Plan -->
      <div class="col-lg-4 col-md-6 col-12">
        <div class="pricing-card">
          <h3 class="pricing-title">Premium Plan</h3>
          <div class="pricing-price">
            <span class="currency">$</span>99<span class="duration">/month</span>
          </div>
          <ul class="pricing-features">
            <li>Unlimited Event Listings</li>
            <li>24/7 Support</li>
            <li>Event Promotion & Ads</li>
            <li>Unlimited Custom Banners</li>
            <li>Premium Email Marketing Tools</li>
            <li>Priority Google Ads Integration</li>
            <li>Dedicated Account Manager</li>
          </ul>
          <a href="#" class="btn pricing-btn">Choose Plan</a>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="section-area video-section" style="background-image: url('https://www.eventsindustryforum.co.uk/images/articles/about_the_eif.jpg');">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12 col-md-12 col-12 text-center">
        <h2 class="video-title">Watch Our Event Highlight</h2>
        <p class="video-subtitle">Get a glimpse of how we create unforgettable events. Watch this short video to learn more about our services and how we can help you plan your next big event.</p>
        <div class="video-thumbnail text-center">
          <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="video-play-button">
            <i class="fas fa-play"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="resources-section section-area">
  <div class="container">
    <div class="event-setup-container text-center">
      <h2 class="list-title">Resources</h2>
      <h3 class="list-subtitle">Explore our valuable resources below</h3>
    </div>

    <div class="row card-grid">
      <!-- Card 1: Tutorials -->
      <div class="col-lg-4 col-md-6 col-12">
        <div class="resource-card">
          <div class="resource-icon">
            <i class="fas fa-chalkboard-teacher"></i>
          </div>
          <h3 class="resource-title">Tutorials</h3>
          <p class="resource-description">
            Our tutorials offer detailed, step-by-step guides to help you learn and master event management, covering everything from beginner concepts to advanced strategies. Whether you're new to event planning or looking to refine your skills, these tutorials will provide you with actionable insights and practical advice.
          </p>
        </div>
      </div>

      <!-- Card 2: Case Studies -->
      <div class="col-lg-4 col-md-6 col-12">
        <div class="resource-card">
          <div class="resource-icon">
            <i class="fas fa-file-alt"></i>
          </div>
          <h3 class="resource-title">Case Studies</h3>
          <p class="resource-description">
            Discover real-world examples of successful event planning through our in-depth case studies. Learn how leading event organizers overcame challenges, optimized their strategies, and delivered exceptional attendee experiences. These case studies highlight key takeaways that you can apply to your own events.
          </p>
        </div>
      </div>

      <!-- Card 3: E-books -->
      <div class="col-lg-4 col-md-6 col-12">
        <div class="resource-card">
          <div class="resource-icon">
            <i class="fas fa-book"></i>
          </div>
          <h3 class="resource-title">E-books</h3>
          <p class="resource-description">
            Download comprehensive e-books on the latest trends, strategies, and best practices in the event industry. Our e-books provide you with in-depth knowledge on various topics, including event marketing, logistics, and technology integration, helping you stay ahead in a competitive landscape.
          </p>
          
        </div>
      </div>
    </div>
  </div>
</section>



<section class="faq-section section-area">
  <div class="container">
    <div class="event-setup-container">
      <h2 class="list-title">FAQ</h2>
      <h3 class="list-subtitle">Frequently Asked Questions</h3>
    </div>

    <div id="faqAccordion" class="accordion">
      <!-- FAQ Item 1 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading1">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
              What services do you offer for event planning?
            </button>
          </h5>
        </div>

        <div id="faqCollapse1" class="collapse" aria-labelledby="faqHeading1" data-parent="#faqAccordion">
          <div class="faq-body">
            We provide comprehensive event planning services that cover everything from concept development and venue selection to catering, entertainment, and event promotion.
          </div>
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading2">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
              How do I get started with organizing my event?
            </button>
          </h5>
        </div>

        <div id="faqCollapse2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faqAccordion">
          <div class="faq-body">
            Getting started is easy! Just sign up on our platform, enter your event details, and we’ll guide you through every step of the event creation and promotion process.
          </div>
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading3">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
              Can you help with venue selection?
            </button>
          </h5>
        </div>

        <div id="faqCollapse3" class="collapse" aria-labelledby="faqHeading3" data-parent="#faqAccordion">
          <div class="faq-body">
            Yes, we help you find the perfect venue that matches the size, style, and tone of your event. Our venue selection services ensure that your event happens in the right place.
          </div>
        </div>
      </div>

      <!-- FAQ Item 4 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading4">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
              Do you offer catering services?
            </button>
          </h5>
        </div>

        <div id="faqCollapse4" class="collapse" aria-labelledby="faqHeading4" data-parent="#faqAccordion">
          <div class="faq-body">
            Absolutely! We offer a range of catering options tailored to your event, ensuring your guests enjoy a delicious and customizable menu.
          </div>
        </div>
      </div>

      <!-- FAQ Item 5 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading5">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
              Can I manage event ticket sales through your platform?
            </button>
          </h5>
        </div>

        <div id="faqCollapse5" class="collapse" aria-labelledby="faqHeading5" data-parent="#faqAccordion">
          <div class="faq-body">
            Yes, our platform provides seamless ticketing services where you can manage event ticket sales, track attendance, and automate reminders for ticket holders.
          </div>
        </div>
      </div>

      <!-- FAQ Item 6 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading6">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse6" aria-expanded="false" aria-controls="faqCollapse6">
              What are the pricing plans for your event services?
            </button>
          </h5>
        </div>

        <div id="faqCollapse6" class="collapse" aria-labelledby="faqHeading6" data-parent="#faqAccordion">
          <div class="faq-body">
            We offer different pricing plans depending on the services you choose. Contact our sales team for detailed information and custom quotes tailored to your event needs.
          </div>
        </div>
      </div>

      <!-- FAQ Item 7 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading7">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse7" aria-expanded="false" aria-controls="faqCollapse7">
              How do I promote my event through your platform?
            </button>
          </h5>
        </div>

        <div id="faqCollapse7" class="collapse" aria-labelledby="faqHeading7" data-parent="#faqAccordion">
          <div class="faq-body">
            Our platform offers multiple promotional tools to increase your event’s visibility, such as social media integration, email marketing, and event listing on relevant directories.
          </div>
        </div>
      </div>

      <!-- FAQ Item 8 -->
      <div class="faq">
        <div class="faq-header" id="faqHeading8">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faqCollapse8" aria-expanded="false" aria-controls="faqCollapse8">
              Do you offer event analytics and tracking?
            </button>
          </h5>
        </div>

        <div id="faqCollapse8" class="collapse" aria-labelledby="faqHeading8" data-parent="#faqAccordion">
          <div class="faq-body">
            Yes, we provide live analytics and reporting tools that allow you to track ticket sales, attendee demographics, and engagement metrics to measure your event’s success in real-time.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>



@endsection

<!-- jQuery CounterUp Plugin -->
<!-- jQuery Library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery CounterUp Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="https://cdn.rawgit.com/bfintal/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize counter
    $('.count-number').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).data('count')
        }, {
            duration: 3000, // Duration of the counter animation
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now).toLocaleString()); // Add thousands separator
            }
        });
    });

    // Optional: Only trigger counting when the section is in view
    $('.count-number').waypoint(function() {
        $(this).counterUp({
            delay: 10,
            time: 1000
        });
    }, { offset: '100%' });
});

</script>