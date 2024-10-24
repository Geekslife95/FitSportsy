<?php

namespace App\Http\Controllers\User;
use App\Helpers\Common;
use App\Http\Controllers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\TempCourtBooking;
use App\Services\Category;
use App\Services\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoachBookingController extends Controller
{
    private function lastcoachBookDataByUserId(int $userId)
    {
        return TempCourtBooking::where(['created_by'=>$userId,'book_type'=>Common::TYPE_COACH_BOOK])->orderBy('id', 'desc')->first();
    }

    public function coachBookingList(){
        $data['coachData'] = Coach::select('id','coaching_title','venue_name','poster_image','venue_area','venue_city')->where(['created_by'=>Auth::id(),'is_active'=>Coach::ACTIVE])->orderBy('id','DESC')->paginate(50);
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

}
