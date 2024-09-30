<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AppUserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventDescriptionController;
use App\Http\Controllers\EventParentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\EventGalleryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\SubscriptionController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OrganizationApiController;
use App\Http\Controllers\PopupController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/login',function(){
    if (Auth::check()) {
        return redirect('/admin/home');
    }
    return view('auth.login');
})->name('login');

Route::post('/admin/login', [LicenseController::class, 'adminLogin']);
Route::get('/scanner-login', [LicenseController::class, 'scannerLogin']);
Route::post('/scanner-login', [LicenseController::class, 'postScannerLogin']);

Route::get('/logout', [LicenseController::class, 'adminLogout'])->name('logout123');
Route::post('/saveEnvData', [LicenseController::class, 'saveEnvData']);
Route::post('/saveAdminData', [LicenseController::class, 'saveAdminData']);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/order-invoice-print/{id}', [OrderController::class, 'orderInvoicePrint']);
Route::get('/change-language/{lang}', [UserController::class, 'changeLanguage']);
Route::get('/maintain', [SettingController::class, 'maintain']);
Route::get('/send-mail/{id}', [OrderController::class, 'sendMail']);
Route::any('installer', [LicenseController::class, 'installer'])->name('installer');

Route::any('get-event-galleries', [EventController::class, 'getEventGalleries']);

Route::group(['middleware' => ['auth']], function () {


    Route::get('/location-wise-popup',[PopupController::class,'allData']);
    Route::get('/add-popup',[PopupController::class,'createPopup']);
    Route::post('/add-popup',[PopupController::class,'addNew']);
    Route::get('/delete-popup/{id}',[PopupController::class,'destroy']);

    Route::get('/update-volunteer/{id}',[UserController::class,'showSingleRecord']);
    Route::post('/update-spiritualVolunteers',[UserController::class,'updatespiritualVolunteers']);
    Route::get('/create-volunteer',[UserController::class, 'viewspiritualVolunteers']);
    Route::post('/create-volunteer',[UserController::class, 'createspiritualVolunteers']);
    Route::get('/admin/spiritual-volunteers', [UserController::class, 'spiritualVolunteers']);


    Route::get('/organizer-bank-details',[OrganizationApiController::class,'bankDetailShow']);
    Route::post('/submit-organizer-bank-details',[OrganizationApiController::class,'submitBankDetails']);
    Route::get('/organizer-bank-details/{id}',[OrganizationApiController::class,'getOrgBankDetails']);

    Route::get('/admin/home', [UserController::class, 'adminDashboard']);

    Route::get('/admin/create-subscription', [SubscriptionController::class, 'createSubscription']);
    Route::post('/admin/create-subscription', [SubscriptionController::class, 'postcreateSubscription']);
    Route::get('/admin/edit-subscription', [SubscriptionController::class, 'editSubscription']);
    Route::post('/admin/edit-subscription', [SubscriptionController::class, 'posteditSubscription']);
    Route::get('/admin/update-status-subscription', [SubscriptionController::class, 'updateStatusSubscription']);
    Route::get('/admin/view-subscription', [SubscriptionController::class, 'viewAllSubscription']);


    Route::get('/organization/home', [UserController::class, 'organizationDashboard']);
    Route::get('/scanner/home', [UserController::class, 'scannerDashboard']);
    Route::get('/scanner/scan/', [UserController::class, 'scanQrCode']);

    Route::post('/scan-order-details', [UserController::class,'showTicketDetails']);
    Route::get('/update-scaned-user',[UserController::class,'updateScanDetails']);

    Route::get('/{id}/{name}/tickets', [TicketController::class, 'index']);
    Route::get('/book-ticket', [UserController::class, 'bookTicket']);
    Route::get('/organizer/{id}/{name}', [UserController::class, 'organizerEventDetails']);
    Route::get('/organizerCheckout/{id}', [UserController::class, 'organizerCheckout']);
    Route::post('/organizerCreateOrder', [UserController::class, 'organizerCreateOrder']);
    Route::delete('/deleteTickets/{id}', [TicketController::class, 'deleteTickets']);
    Route::get('/{id}/ticket/create', [TicketController::class, 'create']);
    Route::post('/ticket/create', [TicketController::class, 'store']);
    Route::get('/ticket/edit/{id}', [TicketController::class, 'edit']);
    Route::post('/ticket/update/{id}', [TicketController::class, 'update']);
    Route::get('/block-user/{id}', [AppUserController::class, 'blockUser']);
    Route::get('/user_delete/{id}', [AppUserController::class, 'user_delete']);
    Route::get('/main_user_block/{id}', [UserController::class, 'main_user_block']);
    Route::get('/block-scanner/{id}', [UserController::class, 'blockScanner']);
    Route::get('/admin-setting', [SettingController::class, 'index']);
    Route::get('/license-setting', [LicenseController::class, 'licenseSetting']);
    Route::post('/save-license-setting', [LicenseController::class, 'saveLicenseSetting']);
    Route::post('/save-general-setting', [SettingController::class, 'store']);
    Route::post('/maintenance-setting', [SettingController::class, 'maintenanceMode']);
    Route::post('/save-mail-setting', [SettingController::class, 'saveMailSetting']);
    Route::post('/save-verification-setting', [SettingController::class, 'saveVerificationSetting']);
    Route::post('/save-organization-setting', [SettingController::class, 'saveOrganizationSetting']);
    Route::post('/save-pushNotification-setting', [SettingController::class, 'saveOnesignalSetting']);
    Route::post('/save-sms-setting', [SettingController::class, 'saveSmsSetting']);
    Route::post('/additional-setting', [SettingController::class, 'additionalSetting']);
    Route::post('/support-setting', [SettingController::class, 'supportSetting']);
    Route::post('/save-payment-setting', [SettingController::class, 'savePaymentSetting']);
    Route::post('/socialmedialinks', [SettingController::class, 'socialmedialinks']);
    Route::post('/appuser-privacy-policy',[SettingController::class,'appuserPrivacyPolicy']);
    Route::get('/profile', [UserController::class, 'viewProfile']);
    Route::post('/edit-profile', [UserController::class, 'editProfile']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order_id}/{id}', [OrderController::class, 'show']);
    Route::get('/order-invoice/{id}', [OrderController::class, 'orderInvoice']);
    Route::post('/order/changestatus', [OrderController::class, 'changeStatus']);
    Route::post('/order/changepaymentstatus', [OrderController::class, 'changePaymentStatus']);
    Route::get('/user-review', [OrderController::class, 'userReview']);
    Route::get('/event-review', [OrderController::class, 'eventReports']);
    Route::get('/event-reports', [OrderController::class, 'eventReports']);
    Route::get('/change-review-status/{id}', [OrderController::class, 'changeReviewStatus']);
    Route::get('/delete-review/{id}', [OrderController::class, 'deleteReview']);
    Route::post('/get-month-event', [EventController::class, 'getMonthEvent']);
    Route::get('/event-gallery/{id}', [EventController::class, 'eventGallery']);
    Route::post('/add-event-gallery', [EventController::class, 'addEventGallery']);
    Route::get('/remove-image/{image}/{id}', [EventController::class, 'removeEventImage']);
    Route::get('/scanner', [UserController::class, 'scanner']);
    Route::get('/scanner/create', [UserController::class, 'scannerCreate']);
    Route::post('/scanner', [UserController::class, 'addScanner']);
    Route::get('/getScanner/{id}', [UserController::class, 'getScanner']);
    Route::get('/organization-report/customer', [OrderController::class, 'customerReport']);
    Route::post('/organization-report/customer', [OrderController::class, 'customerReport']);
    Route::get('/organization-report/orders', [OrderController::class, 'ordersReport']);
    Route::post('/organization-report/orders', [OrderController::class, 'ordersReport']);
    Route::get('/organization-report/revenue', [OrderController::class, 'orgRevenueReport']);
    Route::post('/organization-report/revenue', [OrderController::class, 'orgRevenueReport']);
    Route::get('/admin-report/customer', [OrderController::class, 'adminCustomerReport']);
    Route::post('/admin-report/customer', [OrderController::class, 'adminCustomerReport']);
    Route::get('/admin-report/organization', [OrderController::class, 'adminOrgReport']);
    Route::post('/admin-report/organization', [OrderController::class, 'adminOrgReport']);
    Route::get('/admin-report/revenue', [OrderController::class, 'adminRevenueReport']);
    Route::post('/admin-report/revenue', [OrderController::class, 'adminRevenueReport']);
    Route::get('/getStatistics/{month}', [OrderController::class, 'getStatistics']);
    Route::get('/admin-report/settlement', [OrderController::class, 'settlementReport']);
    Route::get('/view-user/{id}', [AppUserController::class, 'userDetail']);
    Route::post('/pay-to-org', [OrderController::class, 'payToUser']);
    Route::post('/pay-to-organization', [OrderController::class, 'payToOrganization']);
    Route::get('/view-settlement/{id}', [OrderController::class, 'viewSettlement']);
    Route::get('get-code/{code}', [OrderController::class, 'getQrCode']);
    Route::get('/language/download_sample_file', [LanguageController::class, 'download_sample_file']);
    Route::get('/check-email',[UserController::class,'check_email']);
    Route::post('/about_us',[SettingController::class,'aboutUs']);
    Route::get('/event/create',[EventController::class,'create']);
    Route::get('/app_users_edit/{id}',[UserController::class,'editAppUser']);
    Route::post('/update_appuser',[UserController::class,'updateAppUser']);
    Route::get('/organization/income',[UserController::class,'orgincome']);
    Route::post('/change-payment-status',[ProductController::class,'changePaymentStatus']);
    Route::get('/view-order-details',[ProductController::class,'viewOrderDetails']);
    Route::get('/events-bulk-upload',[EventController::class,'eventsBulkUpload']);
    Route::post('/store-event-bulk-upload',[EventController::class,'storeEventBulkUpload']);


    Route::resources([

        'roles' => RoleController::class,
        'tax' => TaxController::class,
        'faq' => FaqController::class,
        'banner' => BannerController::class,
        'app-user' => AppUserController::class,
        'users' =>  UserController::class,
        'blog' =>  BlogController::class,
        'feedback' =>  FeedbackController::class,
        'coupon' =>  CouponController::class,
        'category' =>  CategoryController::class,
        'location' =>  LocationController::class,
        'events' =>  EventController::class,
        'events-parent' =>  EventParentController::class,
        'eventss-description' =>  EventDescriptionController::class,
        'upload-gallery' =>  EventGalleryController::class,
        'notification-template' =>  NotificationTemplateController::class,
        'language' => LanguageController::class,
        'products'=>ProductController::class,
        'user-product-orders'=>ProductOrderController::class
    ]);




});

Route::get('/notification', [NotificationTemplateController::class, 'notification']);
Route::get('/markAllAsRead', [NotificationTemplateController::class, 'markAllAsRead']);
Route::get('/get-notification', [NotificationTemplateController::class, 'getNotification']);
Route::post('/send-notification', [NotificationTemplateController::class, 'sendNotification']);
Route::get('/delete-notification/{id}', [NotificationTemplateController::class, 'deleteNotification']);

Route::get('/create-payment/{id}', [UserController::class, 'makePayment']);
Route::any('/payment/{id}', [UserController::class, 'initialize'])->name('pay');
Route::get('/rave/callback/{id}', [UserController::class, 'callback'])->name('callback');

Route::get('FlutterWavepayment/{id}', [UserController::class, 'FlutterWavepayment']);
Route::get('transction_verify/{id}', [UserController::class, 'transction_verify']);

Route::get('all-products', [ProductController::class, 'allProducts']);

