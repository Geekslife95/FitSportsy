<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\TempCourtBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use stdClass;
use Symfony\Component\HttpFoundation\Response;
class CourtBookingController extends Controller
{
    private function lastCourtBookDataByUserId(int $userId){
        return TempCourtBooking::where('created_by',$userId)->orderBy('id','desc')->first();
    }

    public function courtBooking(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $tempData = [];
        if(!$courtBookData){
            $tempData['venue_name'] = '';
            $tempData['venue_area'] = '';
            $tempData['venue_address'] = '';
            $tempData['venue_city'] = '';
        }else{
            $tempData = json_decode($courtBookData->basic_information);
        }
        
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        return view('user.court-booking.court-booking',$data);
    }


    public function postCourtBooking(Request $request){
        // dd($request->all());                        
        $request->validate([
            'venue_name'=>'required',
            'venue_area'=>'required',
            'venue_address'=>'required',
            'venue_city'=>'required',
        ]);
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $data = $request->except('_token');
        if($courtBookData){
            TempCourtBooking::where('id',$courtBookData->id)->update([
                'basic_information'=>json_encode($data),
            ]);
        }else{
            $courtBookObj = new TempCourtBooking();
            $courtBookObj->basic_information = json_encode($data);
            $courtBookObj->court_information = null;
            $courtBookObj->description = null;
            $courtBookObj->created_by = Auth::id();
            $courtBookObj->save();
        }
        return redirect('user/court-information')->with('success','Basic information added successfully...');
    }

    public function courtInformation(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        if(!$courtBookData){
            return redirect('user/court-booking');
        }
        $tempData = [];
        if(is_null($courtBookData->court_information)){
            $tempData[] = [
                "court_name" => "",
                "schedule_data"=>[
                    [
                    "from_date" => "",
                    "to_date" => "",
                    "from_time" => "",
                    "to_time" => "",
                    "duration" => "",
                    "duration_amount"=>""
                    ]
                ]
            ];
        }else{
            $tempData = json_decode($courtBookData->court_information);
        }
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        return view('user.court-booking.court-information',$data);
    }

    public function postCourtInformation(Request $request){
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        $data = [];
        foreach($request->court_name as $k=>$court){
             foreach($request->from_date[$k]  as $key=> $val){
                if(!empty($val) && !empty($request->to_date[$k][$key]) && !empty($request->from_time[$k][$key]) && !empty($request->to_time[$k][$key]) && !empty($request->duration[$k][$key]) && !empty($request->duration_amount[$k][$key])){
                    $data[$k]['schedule_data'][] = [
                        'from_date'=>$val,
                        'to_date'=>$request->to_date[$k][$key],
                        'from_time'=>$request->from_time[$k][$key],
                        'to_time'=>$request->to_time[$k][$key],
                        'duration'=>$request->duration[$k][$key],
                        'duration_amount'=>$request->duration_amount[$k][$key],
                    ];
                    $data[$k]['court_name'] = $court;
                }
             }
        }
        if(empty($data)){
            return redirect()->back()->with('error','Court details are require');
        }
        TempCourtBooking::where('id',$courtBookData->id)->update([
            'court_information'=>json_encode($data),
        ]);
        return redirect('user/court-book-description')->with('success','Court details added successfully...');
    }

    public function courtBookDescription(){
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        if(!$courtBookData){
            return redirect('user/court-booking');
        }
        if(is_null($courtBookData->court_information)){
            return redirect('user/court-information');
        }
        $tempData = [];
        if(is_null($courtBookData->description)){
            $tempData = [
                "sports_available" => [],
                "amenities"=>[],
                "description"=>""
            ];
        }else{
            $tempData = json_decode($courtBookData->description);
        }
        $data['bookData'] = is_array($tempData) ? json_decode(json_encode($tempData), FALSE) : $tempData;
        return view('user.court-booking.court-book-description',$data);
    }

    public function postCourtBookDescription(Request $request){
        $request->validate([
            'description'=>'required'
        ]);
        $courtBookData = $this->lastCourtBookDataByUserId(Auth::id());
        TempCourtBooking::where('id',$courtBookData->id)->update([
            'description'=>json_encode([
                'sports_available'=>!empty($request->sports_available) ? $request->sports_available : [],
                'amenities'=>!empty($request->amenities) ? $request->amenities : [],
                'description'=>$request->description
            ]),
        ]);
        return redirect('user/court-book-images')->with('success','Court description added successfully...');
    }

    public function courtBookImages(){
        return view('user.court-booking.court-book-images');
    }

    public function storeCourtBookImages(Request $request){
       dd('in progres'); 
       echo (new AppHelper)->saveImageWithPath($request->image,'court-booking');
    }
}

