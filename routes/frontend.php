<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AppUserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\EventDashboard;


Route::get("/stancer-payment",[SocialLoginController::class,'payment']);
Route::post("/set-u-location",[EventController::class,'setULocation']);
Route::get("/stancer-payment-success",[SocialLoginController::class,'paymentSuccess']);


Route::group(['middleware' => ['mode', 'XSS']], function () {

    
    Route::get('/spiritual-volunteers',[BookController::class,'spritualVolunteer']);
    Route::get('/spiritual-volunteers-details/{id}',[BookController::class,'volunteersDetails']);
    Route::get('/create-spiritual-volunteers',[BookController::class,'createspritualVolunteer']);
    Route::post('/create-spiritual-volunteers',[BookController::class,'insertspritualVolunteer']);
    Route::post('/filter-spiritual-volunteers',[BookController::class,'filterspritualVolunteer']);
    Route::get('/filter-spiritual-volunteers',[BookController::class,'spritualVolunteer']);


    Route::get('/', [FrontendController::class, 'home'])->name('home');
    Route::post('/send-to-admin', [FrontendController::class, 'sentMessageToAdmin']);
    // Route::get('/privacy_policy', [FrontendController::class, 'privacypolicy']);

    Route::get('/terms-and-conditions', [FrontendController::class, 'termsAndConditions']);
    Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy']);
    Route::get('/cancellation-policy', [FrontendController::class, 'cancellatioPolicy']);


    Route::get('/list-your-event',[FrontendController::class,'listYourEvent']);


    Route::get('/FAQ', [FaqController::class, 'show']);
    // Route::get('/appuser-privacy-policy', [FrontendController::class, 'appuserPrivacyPolicyShow']);
    Route::get('/show-details/{id}', [OrderController::class, 'showTicket']);
    Route::get('/events_details/{id}',[EventController::class,'show']);

    Route::post('/store-book-ticket-razor',[BookController::class,'storeBookTicketRazor']);
    Route::post('/store-book-seat-ticket-razor',[BookController::class,'storeBookSeatTicketRazor']);
    Route::get('/razor-event-book-payment-failed',[BookController::class,'razorEventBookPaymentFailed']);
    Route::get('/all-events',[BookController::class,'allEvents']);

    Route::get('/event-city',[BookController::class,'eventCity']);


  


    Route::get('/user-login',[AuthController::class,'userLogin']);
    Route::post('/user-login',[AuthController::class,'checkUserLogin']);

    Route::get('/organizer-login',[AuthController::class,'organizerLogin']);
    Route::post('/organizer-login',[AuthController::class,'checkOrganizerLogin']);
    Route::get('/organizer-register',[AuthController::class,'organizerRegsiter']);
    Route::post('/organizer-register',[AuthController::class,'postOrganizerRegister']);

    Route::get('/user-register',[AuthController::class,'userRegister']);
    Route::post('/user-register',[AuthController::class,'postUserRegister']);
    Route::get('/logout-user', [AuthController::class, 'logoutUser']);

    Route::get('/search-all-events', [AppUserController::class, 'searchAllEvents']);

    Route::get('/product/{slug}', [ProductsController::class, 'productDetails']);
    Route::get('/buy-product/{slug}', [ProductsController::class, 'buyProduct']);
    Route::get('/my-cart', [ProductsController::class, 'myCart']);
    Route::get('/remove-from-cart', [ProductsController::class, 'removeFromCart']);
    Route::post('/add-quantity-to-cart', [ProductsController::class, 'addQuantityToCart']);
    Route::get('/cart-checkout', [ProductsController::class, 'cartCheckout']);
    Route::post('/get-rzr-total-product-pay', [ProductsController::class, 'getRzrTotalProductPay']);
    Route::post('/store-payment-details', [ProductsController::class, 'storePaymentDetails']);
    Route::get('/user-order-details', [ProductsController::class, 'userOrderDetails']);

    Route::get('/login-with-google', [SocialLoginController::class, 'loginWithGoogle']);
    Route::get('/google-auth-login', [SocialLoginController::class, 'googleAuthLogin']);


    // Route::get('/all-events', [FrontendController::class, 'allEvents']);
    // Route::post('/all-events', [FrontendController::class, 'allEvents']);
    Route::get('/events-category/{id}/{name}', [FrontendController::class, 'categoryEvents']);
    Route::get('/event-type/{type}', [FrontendController::class, 'eventType']);
    Route::get('/event/{id}/{name}', [FrontendController::class, 'eventDetail']);
    Route::get('/events/{id}', [FrontendController::class, 'eventDetail']);
    Route::get('/organization/{id}/{name}', [FrontendController::class, 'orgDetail']);
    Route::post('/report-event', [FrontendController::class, 'reportEvent']);
    Route::get('/all-category', [FrontendController::class, 'allCategory']);
    Route::get('/all-blogs', [FrontendController::class, 'blogs']);
    Route::get('/blog-detail/{id}/{name}', [FrontendController::class, 'blogDetail']);
    Route::get('/contact', [FrontendController::class, 'contact']);

    Route::get('/book-event-ticket',[BookController::class,'bookEventTicket']);
    Route::post('/get-tickets-d-events',[BookController::class,'getTicketsDEvents']);

    // Get event list according to date & location via fetch
    Route::post('/get-event-list', [BookController::class, 'getEventList'])->name('get-event-list');

    // Ticket Checkout
    Route::post('/set-ticket-checkout',[BookController::class, 'setTicketCheckout'])->name('set-ticket-checkout');
    Route::get('/event-ticket-checkout',[BookController::class, 'eventTicketCheckout'])->name('event-ticket-checkout');


    Route::post('/get-ticket-counts',[BookController::class,'getTicketCounts']);
    Route::post('/save-ticket-bookings',[BookController::class,'saveTicketBookings']);
    
    Route::get('/confirm-ticket-book',[BookController::class,'confirmTicketBook']);
    
    Route::get('/get-promo-discount',[BookController::class,'getPromoDiscount']);
    Route::post('/calculate-book-amount',[BookController::class,'calculateBookAmount']);
    Route::get('/booked-ticket-details',[BookController::class,'bookedTicketDetails']);
    
    Route::post('/post-book-ticket',[BookController::class,'postbookTicket']);
    Route::get('/book-ticket-seat',[BookController::class,'bookTicketSeat']);
    Route::post('/book-ticket-seat',[BookController::class,'postbookTicketSeat']);
    Route::get('/buy-book-tickets',[BookController::class,'buyBookTicket']);
    Route::get('/book-ticket-slot',[BookController::class,'bookTicketSlots']);
    Route::post('/book-ticket-slot',[BookController::class,'postbookTicketSlots']);


    Route::get('/organizer-code-scan/{userId}',[QRController::class,'organizerCodeScan']);
    Route::post('/get-events-by-category',[QRController::class,'getEventsByCategory']);
    Route::post('/store-orn-code-scan-sel',[QRController::class,'storeOrnCodeScanSel']);
    Route::get('/qr-event-details',[QRController::class,'qrEventDetails']);
    Route::get('/book-qr-event-ticket',[QRController::class,'bookQrEventTicket']);

    


    
    // Route::get('/privacy-policy',[QRController::class,'PrivacyPolicy']);



    Route::group(['middleware'=>'appuser'],function(){
        Route::get('/my-orders', [ProductsController::class, 'myOrders']);
        Route::get('user/my-tickets',[AuthController::class,'myTickets']);
        Route::get('user/my-profile',[AuthController::class,'myProfile']);
        Route::post('user/update-profile',[AuthController::class,'updateProfile']);
        Route::get('user/account-settings',[AuthController::class,'accountSettings']);
        Route::post('user/update-user-password',[AuthController::class,'updateUserPassword']);
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('/VerificationConfirm/{id}', [FrontendController::class, 'LoginByMail']);
        // Route::get('/register', [FrontendController::class, 'register']);
        // Route::post('/register', [FrontendController::class, 'userRegister']);
        Route::get('login', [FrontendController::class, 'login']);
        Route::post('/login', [FrontendController::class, 'userLogin']);
        
        Route::get('/resetPassword', [FrontendController::class, 'resetPassword']);
        Route::post('/resetPassword', [FrontendController::class, 'userResetPassword']);

        Route::get('/forgot-password',[FrontendController::class,'orgForgetPass']);
        Route::post('/forgot-password',[FrontendController::class,'postOrgForgetPass']);

        // Route::get('/org-register', [FrontendController::class, 'orgRegister']);
        // Route::post('/org-register', [FrontendController::class, 'organizerRegister']);
        // Route::get('/logout', [LicenseController::class, 'adminLogout'])->name('logout');
        Route::get('/logoutuser', [FrontendController::class, 'userLogout'])->name('logoutUser');
        // Route::post('/search_event',[FrontendController::class,'searchEvent']);
        // Route::get('/tag/{tagname}',[FrontendController::class,'eventsByTag']);
        // Route::get('/blog-tag/{tagname}',[FrontendController::class,'blogByTag']);
        Route::get('/FAQs',[FrontendController::class,'Faqs']);
    });
    // Route::group(['middleware' => 'checkStatus'], function () {


    Route::group(['middleware' => 'appuser'], function () {
        Route::get('email/verify/{id}/{token}', [FrontendController::class, 'emailVerify']);
        Route::get('/checkout/{id}', [FrontendController::class, 'checkout']);
        Route::post('/applyCoupon', [FrontendController::class, 'applyCoupon']);
        Route::post('/createOrder', [FrontendController::class, 'createOrder']);
        Route::get('/user/profile', [FrontendController::class, 'userTickets']);
        Route::get('/add-favorite/{id}/{type}', [FrontendController::class, 'addFavorite']);
        Route::get('/add-followList/{id}', [FrontendController::class, 'addFollow']);
        Route::post('/add-bio', [FrontendController::class, 'addBio']);
        Route::get('/change-password', [FrontendController::class, 'changePassword']);
        Route::post('/user-change-password', [FrontendController::class, 'changeUserPassword']);
        Route::post('/upload-profile-image', [FrontendController::class, 'uploadProfileImage']);
        Route::get('/my-tickets', [FrontendController::class, 'userTickets']);
        Route::get('/my-ticket/{id}', [FrontendController::class, 'userOrderTicket']);

        Route::get('/update_profile', [FrontendController::class, 'update_profile']);
        Route::post('/update_user_profile', [FrontendController::class, 'update_user_profile']);
        Route::get('/getOrder/{id}', [FrontendController::class, 'getOrder']);
        Route::post('/add-review', [FrontendController::class, 'addReview']);
        Route::get('/web/create-payment/{id}', [FrontendController::class, 'makePayment']);
        Route::post('/web/payment/{id}', [FrontendController::class, 'initialize'])->name('frontendPay');
        Route::get('/web/rave/callback/{id}', [FrontendController::class, 'callback'])->name('frontendCallback');
    });
    // });
});



Route::group(['middleware' => ['organiser']], function () {

    // New Dashboard
    Route::get('/dashboard',[EventDashboard::class,'dashboard']);

    // Step 1
    Route::get('/dashboard-events',[EventDashboard::class,'dashboardEvents']);
    Route::post('/dashboard-events',[EventDashboard::class,'postdashboardEvents']);

    // Step 2
    Route::get('/dashboard-event-location',[EventDashboard::class,'dashboardEventlocation']);
    Route::post('/dashboard-event-location',[EventDashboard::class,'postdashboardEventlocation']);

    // Step 3
    Route::get('/dashboard-event-description',[EventDashboard::class,'dashboardEventdescription']);
    Route::post('/dashboard-event-description',[EventDashboard::class,'postdashboardEventdescription']);

    // Step 4
    Route::get('/dashboard-event-photos',[EventDashboard::class,'dashboardEventphotos']);
    Route::post('/dashboard-event-photos',[EventDashboard::class,'postdashboardEventphotos']);

    // Ticket
    Route::get('/dashboard-add-basic-ticket',[EventDashboard::class,'dashboardAddticket']);
    Route::post('/dashboard-add-basic-ticket',[EventDashboard::class,'postTicketListing']);

    Route::get('/dashboard-add-advance-ticket',[EventDashboard::class,'dashboardAddticketAdvance']);
    Route::post('/dashboard-add-advance-ticket',[EventDashboard::class,'postdashboardAddticketAdvance']);

    Route::get('/dashboard-ticket-listing',[EventDashboard::class,'dashboardTicketListing']);
    Route::get('/dashboard-ticket-subscription',[EventDashboard::class,'dashboardTicketSubscription']);
    Route::post('/get-subscription-amount',[EventDashboard::class,'getSubscriptionAmount']);
    Route::post('/buy-subscripton',[EventDashboard::class,'storeEventSubscription']);
    Route::get('/thankyou-subscriber',[EventDashboard::class,'thankyouSubscriber']);


    // Logout
    Route::get('/dashboard-logout',[EventDashboard::class,'logout']);

});