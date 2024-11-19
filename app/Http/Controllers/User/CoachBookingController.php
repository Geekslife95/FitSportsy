<?php

namespace App\Http\Controllers\User;
use App\Helpers\Common;
use App\Http\Controllers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\CoachingPackage;
use App\Models\CoachingPackageBooking;
use App\Models\TempCourtBooking;
use App\Services\Category;
use App\Services\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use DB, stdClass;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoachBookingController extends Controller
{
    private function lastcoachBookDataByUserId(int $userId)
    {
        return TempCourtBooking::where(['created_by'=>$userId,'book_type'=>Common::TYPE_COACH_BOOK])->orderBy('id', 'desc')->first();
    }

    public function coachBookingList(){
        $organiserId = Auth::user()->id;
       
        $coachData = Coach::select('id','coaching_title','venue_name','poster_image','venue_area','venue_city')->where(['is_active'=>Coach::ACTIVE]);
        if(!Auth::user()->hasRole('admin')){
            $coachData->where(function($q) use($organiserId){
                $q->where('organiser_id', $organiserId);
                $q->orWhere('created_by', Auth::id());
            });
        }        
        $coachData = $coachData->orderBy('id','DESC')->paginate(50);
        $data['coachData'] = $coachData;
        return view('user.coach-booking.coach-booking-list',$data);
    }

    public function coachBook(Category $category){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coachBookData = $this->lastcoachBookDataByUserId(Auth::id());
        $tempData = [];
        if (!$coachBookData) {
            $tempData['venue_name'] = '';
            $tempData['venue_area'] = '';
            $tempData['venue_address'] = '';
            $tempData['venue_city'] = '';
            $tempData['coaching_title'] = '';
            $tempData['category_id'] = '';
            $tempData['age_group'] = '';
            $tempData['free_demo_session'] = '';
            $tempData['organiser_id'] = '';
            $tempData['skill_level'] = '';
            $tempData['bring_own_equipment'] = '';
        } else {
            $tempData = json_decode($coachBookData->basic_information);
        }
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        $data['category'] = $category->getActiveCategories();
        if(Auth::user()->hasRole('admin')){
            $data['users'] = User::getOrganisers();
        }
        return view("user.coach-booking.coach-book",$data);
    }

    public function postCoachBook(Request $request){
         $request->validate([
            'venue_name' => 'required',
            'venue_area' => 'required',
            'venue_address' => 'required',
            'venue_city' => 'required',
            'coaching_title' => 'required',
            'category_id' => 'required',
            'age_group' => 'required',
            'free_demo_session' => 'required',
            'bring_own_equipment' => 'required',
        ]);
        $coachBookData = $this->lastcoachBookDataByUserId(Auth::id());
        $data = $request->except('_token');
        $data['skill_level'] = !empty($request->skill_level) ? json_encode($request->skill_level): '';
        if ($coachBookData) {
            TempCourtBooking::where('id', $coachBookData->id)->update([
                'basic_information' => json_encode($data),
            ]);
        } else {
            $coachBookObj = new TempCourtBooking();
            $coachBookObj->basic_information = json_encode($data);
            $coachBookObj->court_information = null;
            $coachBookObj->description = null;
            $coachBookObj->book_type = Common::TYPE_COACH_BOOK;
            $coachBookObj->created_by = Auth::id();
            $coachBookObj->save();
        }
        return redirect('user/coach-book-information')->with('success', 'Basic information added successfully...');
    }

    public function coachBookInformation(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coachBookData = $this->lastcoachBookDataByUserId(Auth::id());
        if (!$coachBookData) {
            return redirect('user/coach-book');
        }
        if (is_null($coachBookData->basic_information)) {
            return redirect('user/coach-book');
        }
        $tempData = [];
        if (is_null($coachBookData->description)) {
            $tempData = [
                "sports_available" => [],
                "amenities" => [],
                "description" => ""
            ];
        } else {
            $tempData = json_decode($coachBookData->description);
        }
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        return view('user.coach-booking.coach-book-information',$data);
    }

    public function postCoachBookInformation(Request $request){
        $request->validate([
            'description' => 'required'
        ]);
        $coachBookData = $this->lastcoachBookDataByUserId(Auth::id());
        TempCourtBooking::where('id', $coachBookData->id)->update([
            'description' => json_encode([
                'sports_available' => !empty($request->sports_available) ? $request->sports_available : [],
                'amenities' => !empty($request->amenities) ? $request->amenities : [],
                'description' => $request->description
            ]),
        ]);
        return redirect('user/coach-book-session')->with('success', 'Description added successfully...');
    }

    public function coachBookSession(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coachBookData = $this->lastcoachBookDataByUserId(Auth::id());
        if (!$coachBookData) {
            return redirect('user/coach-book');
        }
        $basicInfo = json_decode($coachBookData->basic_information);

        if (is_null($coachBookData->description)) {
            return redirect('user/coach-book');
        }
        $tempData = [];
        if (is_null($coachBookData->court_information)) {
            $tempData = [
                'session_duration'=>'',
                'activities'=>[
                    [
                        'activity'=>'',
                        'activity_duration'=>''
                    ]
                ],
                'calories'=>'',
                'intensity'=>'',
                'benefits'=>[]
            ];
        } else {
            $tempData = json_decode($coachBookData->court_information);
        }
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        $data['categoryId'] = $basicInfo->category_id;
        // dd($data['bookData']);
        return view('user.coach-booking.coach-book-session',$data);
    }

    public function postCoachBookSession(Request $request){
        $request->validate([
            'session_duration'=>'required',
            'calories'=>'required',
            'intensity'=>'required',
            'benefits'=>'required',
        ]);
        if(empty($request->activity) || empty($request->benefits)){
            return redirect()->back()->with('warning','All fields are required');
        }
        $coachBookData = $this->lastcoachBookDataByUserId(Auth::id());
        $activityData = [];
        foreach($request->activity as $kk=>$act){
            $activityData[] = [
                'activity'=>$act,
                'activity_duration'=>$request->time[$kk]
            ];
        }
        TempCourtBooking::where('id', $coachBookData->id)->update([
            'court_information' => json_encode([
                'session_duration' => $request->session_duration,
                'calories' => $request->calories,
                'intensity' => $request->intensity,
                'benefits'=>$request->benefits,
                'activities'=>$activityData
            ]),
        ]);
        return redirect('user/coach-book-media')->with('success', 'Session duration added successfully...');
    }

    public function coachBookMedia(){
        return view('user.coach-booking.coach-book-media');
    }

    public function storeCoachBookMedia(Request $request){
        $coachBookData = $this->lastcoachBookDataByUserId(Auth::id());
        $basicInfo = json_decode($coachBookData->basic_information);
        $description = json_decode($coachBookData->description);
        // dd($description);
        try {
            DB::beginTransaction();
            $coachesData = [];
            foreach ($request->gallery_image as $k=>$file) {
                $coachesData[] = [
                    'image'=>(new AppHelper)->saveImageWithPath($file, 'coach-booking'),
                    'name'=>$request->coach_name[$k],
                    'age'=>$request->coach_age[$k],
                    'experience'=>$request->coach_experience[$k]
                ];
            }
            $courtObj = new Coach();
            $courtObj->coaching_title = $basicInfo->coaching_title;
            $courtObj->category_id = $basicInfo->category_id;
            $courtObj->age_group = $basicInfo->age_group;
            $courtObj->free_demo_session = $basicInfo->free_demo_session;
            $courtObj->skill_level = !empty($basicInfo->skill_level) ? $basicInfo->skill_level : json_encode([]);
            $courtObj->bring_own_equipment = $basicInfo->bring_own_equipment;
            $courtObj->venue_name = $basicInfo->venue_name;
            $courtObj->venue_area = $basicInfo->venue_area;
            $courtObj->venue_address = $basicInfo->venue_address;
            $courtObj->venue_city = $basicInfo->venue_city;
            $courtObj->sports_available = json_encode($description->sports_available);
            $courtObj->ameneties = json_encode($description->amenities);
            $courtObj->description = $description->description;
            $courtObj->poster_image = (new AppHelper)->saveImageWithPath($request->image, 'coach-booking');
            $courtObj->description_image = (new AppHelper)->saveImageWithPath($request->desc_page_img, 'coach-booking');
            $courtObj->coaches_info = json_encode($coachesData);
            $courtObj->session_duration = $coachBookData->court_information;
            $courtObj->organiser_id = !empty($basicInfo->organiser_id) ? $basicInfo->organiser_id : Auth::id();
            $courtObj->created_by = Auth::id();
            $courtObj->is_active = Coach::ACTIVE;
            $courtObj->save();
            TempCourtBooking::where('id', $coachBookData->id)->delete();
            DB::commit();
            return redirect('/user/coach-booking-list')->with('success', 'Court Booking data added successfully...');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            exit('SOMETHING WENT WRONG...');
        }
    }

    private function coachBookDataById(int $coachId)
    {
        return Coach::findorfail($coachId);
    }

    public function editCoachBook(Category $category){
        $coachId = $this->memberObj['coaching_id'];
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coachBookData = $this->coachBookDataById($coachId);
        $data['bookData'] = $coachBookData;

        $data['category'] = $category->getActiveCategories();
        if(Auth::user()->hasRole('admin')){
            $data['users'] = User::getOrganisers();
        }
        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id='.$coachId;
        $inputObj->url = url('user/update-coach-book');
        $encLink = Common::encryptLink($inputObj);
        $data['updateLink'] = $encLink;
        return view("user.coach-booking.edit-coach-book",$data);
    }

    public function updateCoachBook(Request $request){
        $coachId = $this->memberObj['coaching_id'];

        $request->validate([
            'venue_name' => 'required',
            'venue_area' => 'required',
            'venue_address' => 'required',
            'venue_city' => 'required',
            'coaching_title' => 'required',
            'category_id' => 'required',
            'age_group' => 'required',
            'free_demo_session' => 'required',
            'bring_own_equipment' => 'required',
        ]);

        $skillLevel = !empty($request->skill_level) ? json_encode($request->skill_level): null;
        
        $coachBookObj = $this->coachBookDataById($coachId);
        $coachBookObj->venue_name = $request->venue_name;
        $coachBookObj->venue_area = $request->venue_area;
        $coachBookObj->venue_address = $request->venue_address;
        $coachBookObj->venue_city = $request->venue_city;
        $coachBookObj->coaching_title = $request->coaching_title;
        $coachBookObj->category_id = $request->category_id;
        $coachBookObj->age_group = $request->age_group;
        $coachBookObj->free_demo_session = $request->free_demo_session;
        $coachBookObj->bring_own_equipment = $request->bring_own_equipment;
        $coachBookObj->skill_level = $skillLevel;
        $coachBookObj->updated_at = date("Y-m-d H:i:s");
        $coachBookObj->save();

        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id='.$coachId;
        $inputObj->url = url('user/edit-coach-book-information');
        $encLink = Common::encryptLink($inputObj);
        
        return redirect($encLink)->with('success', 'Basic information added successfully...');        
    }

    public function editCoachBookInformation(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coachId = $this->memberObj['coaching_id'];
        $coachBookData = $this->coachBookDataById($coachId);
        if (!$coachBookData) {
            return redirect('user/coach-book');
        }
        $data['bookData'] = $coachBookData;
        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id='.$coachId;
        $inputObj->url = url('user/update-coach-book-information');
        $encLink = Common::encryptLink($inputObj);

        $data['updateLink'] = $encLink;
        return view('user.coach-booking.edit-coach-book-information',$data);
    }

    public function updateCoachBookInformation(Request $request){
        $coachId = $this->memberObj['coaching_id'];
        $request->validate([
            'description' => 'required'
        ]);

        $coachBookData = $this->coachBookDataById($coachId);
        $coachBookData->sports_available = !empty($request->sports_available) ? json_encode($request->sports_available) : json_encode([]);
        $coachBookData->ameneties = !empty($request->amenities) ? json_encode($request->amenities) : json_encode([]);
        $coachBookData->description = $request->description;
        $coachBookData->updated_at = date("Y-m-d H:i:s");
        $coachBookData->save();

        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id='.$coachId;
        $inputObj->url = url('user/edit-coach-book-session');
        $encLink = Common::encryptLink($inputObj);
        return redirect($encLink)->with('success','Description added successfully');
    }

    public function editCoachBookSession(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coachId = $this->memberObj['coaching_id'];
        $coachBookData = $this->coachBookDataById($coachId);
        if (!$coachBookData) {
            return redirect('user/coach-book');
        }
        $data['bookData'] = $coachBookData;
        $data['bookDataSD'] = json_decode($coachBookData->session_duration);
        // dd($data['bookData']);
        $data['categoryId'] = $coachBookData->category_id;
        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id='.$coachId;
        $inputObj->url = url('user/update-coach-book-session');
        $encLink = Common::encryptLink($inputObj);
        // dd($coachBookData);
        $data['updateLink'] = $encLink;
        return view('user.coach-booking.edit-coach-book-session',$data);
    }

    public function updateCoachBookSession(Request $request)
    {
        $request->validate([
            'session_duration'=>'required',
            'calories'=>'required',
            'intensity'=>'required',
            'benefits'=>'required',
        ]);
        if(empty($request->activity) || empty($request->benefits)){
            return redirect()->back()->with('warning','All fields are required');
        }
        $coachId = $this->memberObj['coaching_id'];

        $activityData = [];
        foreach($request->activity as $kk=>$act){
            $activityData[] = [
                'activity'=>$act,
                'activity_duration'=>$request->time[$kk]
            ];
        }

        $courtObj = $this->coachBookDataById($coachId);

        $courtObj->session_duration = json_encode([
            'session_duration' => $request->session_duration,
            'calories' => $request->calories,
            'intensity' => $request->intensity,
            'benefits'=>$request->benefits,
            'activities'=>$activityData
        ]);
        $courtObj->updated_at = date("Y-m-d H:i:s");
        $courtObj->save();

        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id='.$coachId;
        $inputObj->url = url('user/edit-coach-book-media');
        $encLink = Common::encryptLink($inputObj);

        return redirect($encLink)->with('success', 'Session duration added successfully...');
    }

    public function editCoachBookMedia()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coachId = $this->memberObj['coaching_id'];
        $coachBookData = $this->coachBookDataById($coachId);
        if (!$coachBookData) {
            return redirect('user/coach-book');
        }
        $data['bookData'] = $coachBookData;

        $inputObj = new stdClass();
        $inputObj->params = 'coaching_id='.$coachId;
        $inputObj->url = url('user/update-coach-book-media');
        $encLink = Common::encryptLink($inputObj);
        $data['updateLink'] = $encLink;

        return view('user.coach-booking.edit-coach-book-media', $data);
    }

    public function updateCoachBookMedia(Request $request)
    {
        $coachId = $this->memberObj['coaching_id'];

        // dd($request->all());

        $coachesData = [];
        // foreach ($request->gallery_image as $k=>$file) {
        foreach ($request->coach_name as $k=>$coach) {
            if(isset($request->gallery_image[$k])){
                $image = (new AppHelper)->saveImageWithPath($request->gallery_image[$k], 'coach-booking');
            }else{
                $image = $request->gallery_image_old[$k];
            }

            $coachesData[] = [
                'image'=>$image,
                'name'=>$coach,
                'age'=>$request->coach_age[$k],
                'experience'=>$request->coach_experience[$k]
            ];
        }

        $courtObj = $this->coachBookDataById($coachId);
        if($request->hasFile('image')){
            $courtObj->poster_image = (new AppHelper)->saveImageWithPath($request->image, 'coach-booking');
        }

        if($request->hasFile('desc_page_img')){
            $courtObj->description_image = (new AppHelper)->saveImageWithPath($request->desc_page_img, 'coach-booking');
        }

        $courtObj->coaches_info = json_encode($coachesData);
        $courtObj->save();
        return redirect('user/coach-booking-list')->with('success','Data updated successfully...');   
    }

    public function removeCoachBook()
    {
        $coachId = $this->memberObj['coaching_id'];
        Coach::where('id', $coachId)->update(['is_active' => Coach::INACTIVE]);
        return redirect('user/coach-booking-list')->with('success','Coaching Data removed successfully...');   
    }

    public function coachingBookings()
    {
        $packageId = isset($this->memberObj['package_id']) ? $this->memberObj['package_id'] : 0;

        $organiserId = Auth::user()->id;

        $bookingData = CoachingPackageBooking::select('booking_id','package_name','coaching_title','full_name','email','mobile_number','transaction_id','paid_amount','expiry_date','coaching_package_bookings.created_at','coaching_package_bookings.id','payment_type')->join('coaching_packages as pc','pc.id','coaching_package_bookings.coaching_package_id')->join('coaches as c','c.id','pc.coach_id');
        if($packageId > 0){
            $bookingData->where('coaching_package_id', $packageId);
        }
        if(!Auth::user()->hasRole('admin')){
            $bookingData->where(function($q) use($organiserId){
                $q->where('organiser_id', $organiserId);
                $q->orWhere('created_by', Auth::id());
            });
        }
        $bookingData = $bookingData->orderBy('coaching_package_bookings.id','DESC')->paginate(50);
        $data['bookingData'] = $bookingData;
        
        
        return view('user.coach-booking.coaching-bookings', $data);
    }

    public function bookingsAtCenter(){
        $coachingData = Coach::select('id', 'coaching_title', 'venue_name');
        if(!Auth::user()->hasRole('admin')){
            $coachingData->where(function($q){
                $q->where('organiser_id', Auth::id());
                $q->orWhere('created_by', Auth::id());
            });
        }
        $coachingData = $coachingData->get();
        $data['coachingData'] = $coachingData;
        return view('user.coach-booking.bookings-at-center', $data);
    }

    public function getPackagesByCoachId(Request $request){
        $coachId = $request->coachId;
        $coachPackageData = CoachingPackage::select('id', 'package_name', 'package_price', 'discount_percent', 'description', 'package_duration')->where(['coach_id' => $coachId, 'is_active' => CoachingPackage::STATUS_ACTIVE])->get();
        $data = [];
        foreach($coachPackageData as $k => $package){
            $data[$k] = $package;
            $realPrice = $package->package_price;
            $afterDiscountPrice = $package->package_price;
            if($package->discount_percent > 0 && $package->discount_percent <= 100){
                $perc = ($realPrice * $package->discount_percent) / 100;
                $afterDiscountPrice = round($realPrice - $perc, 2);
            }
            $data[$k]['final_price'] = "₹".round($afterDiscountPrice,2);
            $inputObj = new stdClass();
            $inputObj->params = 'id='.$package->id;
            $inputObj->url = url('user/book-offline');
            $data[$k]['book_link'] = Common::encryptLink($inputObj);
        }
        return response()->json(['data' => $data]); 
    }

    public function bookOffline(){
        $packageId = $this->memberObj['id'];
        $data['packageData'] = CoachingPackage::find($packageId);
        $inputObj = new stdClass();
        $inputObj->params = 'id='.$data['packageData']->id;
        $inputObj->url = url('user/store-book-offline');
        $data['book_link'] = Common::encryptLink($inputObj);
        return view('user.coach-booking.book-offline', $data);
    }

    public function storeBookOffline(Request $request){
        $packageId = $this->memberObj['id'];
        $packageData = CoachingPackage::find($packageId);
        $orderId = CoachingPackageBooking::insertGetId([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'address' => 'NA',
            'booking_id' => Common::randomMerchantId(1),
            'transaction_id' => !empty($request->transaction_id) ? $request->transaction_id : 'NA',
            'coaching_package_id' => $packageId,
            'user_id' => 0,
            'actual_amount' => $request->amount,
            'paid_amount' => $request->amount,
            'expiry_date' => date("Y-m-d H:i:s", strtotime("+".$packageData->package_duration)),
            'is_active' => CoachingPackageBooking::STATUS_ACTIVE,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
        ]);
        return redirect()->back()->with('success', 'Coaching booked successfully...');
    }

}
