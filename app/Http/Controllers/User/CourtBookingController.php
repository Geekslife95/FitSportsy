<?php

namespace App\Http\Controllers\User;

use App\Helpers\Common;
use App\Http\Controllers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\CourtSlot;
use App\Models\TempCourtBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use DB;
use Symfony\Component\HttpFoundation\Response;

class CourtBookingController extends Controller
{
    private function lastCourtBookDataByUserId(int $userId)
    {
        return TempCourtBooking::where(['created_by'=>$userId,'book_type'=>Common::TYPE_COURT_BOOK])->orderBy('id', 'desc')->first();
    }

    public function CourtBookingList(){
        $data['courtData'] = Court::select('id','venue_name','poster_image','venue_area','venue_city','sports_available')->where(['created_by'=>Auth::id(),'is_active'=>Court::ACTIVE])->orderBy('id','DESC')->paginate(50);
        return view('user.court-booking.court-booking-list',$data);
    }

    public function courtBooking()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $tempData = [];
        if (!$courtBookData) {
            $tempData['venue_name'] = '';
            $tempData['venue_area'] = '';
            $tempData['venue_address'] = '';
            $tempData['venue_city'] = '';
        } else {
            $tempData = json_decode($courtBookData->basic_information);
        }

        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        return view('user.court-booking.court-booking', $data);
    }


    public function postCourtBooking(Request $request)
    {
        // dd($request->all());                        
        $request->validate([
            'venue_name' => 'required',
            'venue_area' => 'required',
            'venue_address' => 'required',
            'venue_city' => 'required',
        ]);
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $data = $request->except('_token');
        if ($courtBookData) {
            TempCourtBooking::where('id', $courtBookData->id)->update([
                'basic_information' => json_encode($data),
            ]);
        } else {
            $courtBookObj = new TempCourtBooking();
            $courtBookObj->basic_information = json_encode($data);
            $courtBookObj->court_information = null;
            $courtBookObj->description = null;
            $courtBookObj->created_by = Auth::id();
            $courtBookObj->book_type = Common::TYPE_COURT_BOOK;
            $courtBookObj->save();
        }
        return redirect('user/court-information')->with('success', 'Basic information added successfully...');
    }

    public function courtInformation()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        if (!$courtBookData) {
            return redirect('user/court-booking');
        }
        $tempData = [];
        if (is_null($courtBookData->court_information)) {
            $tempData[] = [
                "court_name" => "",
                "schedule_data" => [
                    [
                        "from_date" => "",
                        "to_date" => "",
                        "from_time" => "",
                        "to_time" => "",
                        "duration" => "",
                        "duration_amount" => ""
                    ]
                ]
            ];
        } else {
            $tempData = json_decode($courtBookData->court_information);
        }
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        return view('user.court-booking.court-information', $data);
    }

    public function postCourtInformation(Request $request)
    {
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $data = [];
        foreach ($request->court_name as $k => $court) {
            foreach ($request->from_date[$k]  as $key => $val) {
                if (!empty($val) && !empty($request->to_date[$k][$key]) && !empty($request->from_time[$k][$key]) && !empty($request->to_time[$k][$key]) && !empty($request->duration[$k][$key]) && !empty($request->duration_amount[$k][$key])) {
                    $data[$k]['schedule_data'][] = [
                        'from_date' => $val,
                        'to_date' => $request->to_date[$k][$key],
                        'from_time' => $request->from_time[$k][$key],
                        'to_time' => $request->to_time[$k][$key],
                        'duration' => $request->duration[$k][$key],
                        'duration_amount' => $request->duration_amount[$k][$key],
                    ];
                    $data[$k]['court_name'] = $court;
                }
            }
        }
        if (empty($data)) {
            return redirect()->back()->with('error', 'Court details are require');
        }
        TempCourtBooking::where('id', $courtBookData->id)->update([
            'court_information' => json_encode($data),
        ]);
        return redirect('user/court-book-description')->with('success', 'Court details added successfully...');
    }

    public function courtBookDescription()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        if (!$courtBookData) {
            return redirect('user/court-booking');
        }
        if (is_null($courtBookData->court_information)) {
            return redirect('user/court-information');
        }
        $tempData = [];
        if (is_null($courtBookData->description)) {
            $tempData = [
                "sports_available" => [],
                "amenities" => [],
                "description" => ""
            ];
        } else {
            $tempData = json_decode($courtBookData->description);
        }
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        return view('user.court-booking.court-book-description', $data);
    }

    public function postCourtBookDescription(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        TempCourtBooking::where('id', $courtBookData->id)->update([
            'description' => json_encode([
                'sports_available' => !empty($request->sports_available) ? $request->sports_available : [],
                'amenities' => !empty($request->amenities) ? $request->amenities : [],
                'description' => $request->description
            ]),
        ]);
        return redirect('user/court-book-images')->with('success', 'Court description added successfully...');
    }

    public function courtBookImages()
    {
        return view('user.court-booking.court-book-images');
    }

    public function storeCourtBookImages(Request $request)
    {
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $basicInfo = json_decode($courtBookData->basic_information);
        $courtInfo = json_decode($courtBookData->court_information);
        $description = json_decode($courtBookData->description);
        try {
            DB::beginTransaction();
            $galleryImages = [];
            foreach ($request->gallery_image as $file) {
                $galleryImages[] = (new AppHelper)->saveImageWithPath($file, 'court-booking');
            }
            $courtObj = new Court();
            $courtObj->venue_name = $basicInfo->venue_name;
            $courtObj->venue_area = $basicInfo->venue_area;
            $courtObj->venue_address = $basicInfo->venue_address;
            $courtObj->venue_city = $basicInfo->venue_city;
            $courtObj->sports_available = json_encode($description->sports_available);
            $courtObj->ameneties = json_encode($description->amenities);
            $courtObj->description = $description->description;
            $courtObj->poster_image = (new AppHelper)->saveImageWithPath($request->image, 'court-booking');
            $courtObj->gallery_images = json_encode($galleryImages);
            $courtObj->created_by = Auth::id();
            $courtObj->is_active = Court::ACTIVE;
            $courtObj->save();
            $courtId = $courtObj->id;

            foreach ($courtInfo as $court) {
                $token = Common::generateCourtToken();
                $data = [];
                foreach ($court->schedule_data as $slot) {
                    $data[] = [
                        'court_id' => $courtId,
                        'court_name' => $court->court_name,
                        'from_date' => $slot->from_date,
                        'to_date' => $slot->to_date,
                        'from_time' => $slot->from_time,
                        'to_time' => $slot->to_time,
                        'slot_duration' => $slot->duration,
                        'slot_amount' => $slot->duration_amount,
                        'slot_token' => $token,
                        'is_active' => CourtSlot::ACTIVE,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ];
                }
                if ($data) {
                    CourtSlot::insert($data);
                }
            }
            TempCourtBooking::where('id', $courtBookData->id)->delete();
            DB::commit();
            return redirect('/user/court-booking-list')->with('success', 'Court Booking data added successfully...');
        } catch (\Exception $e) {
            DB::rollback();
            exit('SOMETHING WENT WRONG...');
        }
    }
}
